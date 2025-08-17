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
        
        $userSubscription = null;
        if (Auth::check()) {
            $userSubscription = UserSubscription::forUser(Auth::id())
                ->with('subscriptionPlan')
                ->active()
                ->first();
        }

        return view('subscription::pricing', compact('plans', 'userSubscription'));
    }

    /**
     * Show subscription purchase form
     */
    public function purchase(SubscriptionPlan $plan)
    {
        // Check if user is already subscribed
        if (Auth::check()) {
            $activeSubscription = UserSubscription::forUser(Auth::id())
                ->active()
                ->first();
            
            if ($activeSubscription) {
                return redirect()->route('subscription.pricing')
                    ->with('error', 'You already have an active subscription.');
            }
        }

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

        // Check if user already has active subscription
        $activeSubscription = UserSubscription::forUser($user->id)
            ->active()
            ->first();
        
        if ($activeSubscription) {
            return back()->with('error', 'You already have an active subscription.');
        }

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

            // Create subscription record (pending until payment is confirmed)
            $startsAt = now();
            $endsAt = $startsAt->copy()->addMonths($plan->duration_months);

            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'payment_id' => $payment->id,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => 'pending',
                'paid_amount' => $finalAmount,
                'currency' => 'BDT',
                'coupon_id' => $couponId,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
            ]);

            // Store subscription ID in payment for easy reference
            $payment->update(['subscription_id' => $subscription->id]);

            DB::commit();

            // Redirect to SSL Commerz payment gateway
            return redirect()->route('payment::sslcommerz.process', $payment->id);

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