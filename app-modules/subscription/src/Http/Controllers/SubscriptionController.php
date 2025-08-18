<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Subscription\Models\SubscriptionPlan;
use Modules\Subscription\Models\UserSubscription;
use Modules\Coupon\Models\Coupon;
use Modules\Payment\Models\Payment;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display subscription pricing page
     */
    public function pricing()
    {
        $plans = SubscriptionPlan::active()
            ->ordered()
            ->get();

        return view('subscription::pricing', compact('plans'));
    }

    /**
     * Show subscription purchase form
     */
    public function purchase(SubscriptionPlan $plan)
    {
        // Allow users to purchase additional plans for subscription extension
        // No need to check for existing subscriptions - extensions are supported
        
        return view('subscription::purchase', compact('plan'));
    }

    /**
     * Apply coupon code and return discount info
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to apply coupon.'
            ]);
        }

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $couponValidation = Coupon::findAndValidate(
            $request->coupon_code,
            Auth::user(),
            $plan,
            $plan->price
        );

        if (!$couponValidation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $couponValidation['message']
            ]);
        }

        $coupon = $couponValidation['coupon'];
        $discountAmount = $coupon->calculateDiscount($plan->price);
        $finalAmount = $plan->price - $discountAmount;

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'data' => [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->value,
                'discount_amount' => $discountAmount,
                'original_amount' => $plan->price,
                'final_amount' => $finalAmount,
                'formatted_discount' => $coupon->formatted_discount,
                'formatted_final_amount' => number_format($finalAmount, 0) . ' BDT'
            ]
        ]);
    }

    /**
     * Process subscription purchase
     */
    public function processPurchase(Request $request)
    {
        \Log::info('ProcessPurchase started', $request->all());
        
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'required|in:sslcommerz,bkash,nagad,bank_transfer',
            'coupon_code' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to purchase subscription.');
        }

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        // Check if user can purchase (not more than 500 days remaining)
        if (!UserSubscription::canUserPurchase($user->id)) {
            $daysRemaining = UserSubscription::getDaysRemainingForUser($user->id);
            return back()->with('error', "You cannot purchase additional subscription. You have {$daysRemaining} days remaining (limit: 500 days).");
        }

        // Check if user already has active subscription
        $activeSubscription = UserSubscription::forUser($user->id)
            ->active()
            ->first();

        DB::beginTransaction();
        try {
            $originalAmount = $plan->price;
            $discountAmount = 0;
            $couponId = null;
            $couponCode = null;

            // Apply coupon if provided
            if ($request->coupon_code) {
                $couponValidation = Coupon::findAndValidate(
                    $request->coupon_code,
                    $user,
                    $plan,
                    $originalAmount
                );

                if ($couponValidation['valid']) {
                    $coupon = $couponValidation['coupon'];
                    $discountAmount = $coupon->calculateDiscount($originalAmount);
                    $couponId = $coupon->id;
                    $couponCode = $coupon->code;
                }
            }

            $finalAmount = $originalAmount - $discountAmount;

            // Create payment record
            $payment = Payment::create([
                'payment_type' => 'subscription',
                'subscription_plan_id' => $plan->id,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile ?? '01XXXXXXXXX',
                'amount' => $finalAmount,
                'original_amount' => $originalAmount,
                'discount_amount' => $discountAmount,
                'coupon_id' => $couponId,
                'coupon_code' => $couponCode,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'purpose' => $plan->getTranslation('plan_title', app()->getLocale()) ?? $plan->name,
                'description' => 'Subscription payment for ' . ($plan->getTranslation('plan_title', app()->getLocale()) ?? $plan->name),
                'currency' => 'BDT',
            ]);

            // Handle subscription creation or extension
            if ($activeSubscription) {
                // Extend existing subscription
                $startsAt = $activeSubscription->ends_at; // Start from current subscription end date
                $endsAt = $startsAt->copy()->addMonths($plan->duration_months);
                
                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'payment_id' => $payment->id,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'paid_amount' => $finalAmount,
                    'currency' => 'BDT',
                    'coupon_id' => $couponId,
                    'discount_amount' => $discountAmount,
                    'coupon_code' => $couponCode,
                ]);
            } else {
                // Create new subscription
                $startsAt = now();
                $endsAt = $startsAt->copy()->addMonths($plan->duration_months);

                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'subscription_plan_id' => $plan->id,
                    'payment_id' => $payment->id,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'paid_amount' => $finalAmount,
                    'currency' => 'BDT',
                    'coupon_id' => $couponId,
                    'discount_amount' => $discountAmount,
                    'coupon_code' => $couponCode,
                ]);
            }

            // Store subscription ID in payment for easy reference
            $payment->update(['subscription_id' => $subscription->id]);

            DB::commit();

            // For subscription payments with sslcommerz, try direct redirect to SSL Commerz gateway
            if ($request->payment_method === 'sslcommerz') {
                try {
                    $sslController = new \Modules\Payment\Http\Controllers\SslCommerzController();
                    $sslResponse = $sslController->processPayment($payment, $request);
                    
                    // If SSL Commerz returns a redirect response, use it
                    if ($sslResponse instanceof \Illuminate\Http\RedirectResponse) {
                        return $sslResponse;
                    }
                    
                    // If SSL Commerz failed, fall back to payment page with error message
                    return redirect()->route('payment::payments.show', $payment->id)
                        ->with('error', 'Payment gateway temporarily unavailable. Please try again.');
                        
                } catch (\Exception $e) {
                    \Log::error('Direct SSL Commerz redirect failed', ['error' => $e->getMessage()]);
                    // Fall back to payment page if SSL Commerz processing fails
                    return redirect()->route('payment::payments.show', $payment->id)
                        ->with('error', 'Payment gateway temporarily unavailable. Please try again.');
                }
            }
            
            // For other payment methods, redirect to payment page
            return redirect()->route('payment::payments.show', $payment->id);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Subscription success page
     */
    public function success()
    {
        $subscription = UserSubscription::forUser(Auth::id())
            ->with('subscriptionPlan')
            ->latest()
            ->first();

        if (!$subscription) {
            return redirect()->route('subscription.pricing');
        }

        return view('subscription::success', compact('subscription'));
    }
}