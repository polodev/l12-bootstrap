<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payment\Models\Payment;
use Modules\Payment\Libraries\SslCommerz\SslCommerzNotification;

class SslCommerzController extends Controller
{
    /**
     * Process SSL Commerz payment
     */
    public function processPayment(Payment $payment, Request $request)
    {
        // Validate payment method
        if ($payment->payment_method !== 'sslcommerz') {
            return back()->withErrors(['error' => 'This payment method is not currently supported.']);
        }

        try {
            \Log::info('SSLCommerz processPayment started', ['payment_id' => $payment->id, 'payment_method' => $payment->payment_method]);
            
            
            $customerName = $payment->payment_type === 'custom_payment' ? $payment->name : ($payment->name ?: 'Unknown Customer');
            $customerEmail = $payment->email ?: config('sslcommerz.fallback_email', 'noreply@example.com');
            $customerMobile = $payment->mobile ?: '01XXXXXXXXX';
            
            // Prepare SSL Commerz payment data
            $post_data = array();
            $post_data['total_amount'] = $payment->amount;
            $post_data['currency'] = config('sslcommerz.currency', 'BDT');
            $post_data['tran_id'] = $payment->id;

            // Customer information
            $post_data['cus_name'] = $customerName;
            $post_data['cus_email'] = $customerEmail; // Already has fallback from accessor
            $post_data['cus_add1'] = 'Dhaka';
            $post_data['cus_add2'] = '';
            $post_data['cus_city'] = 'Dhaka';
            $post_data['cus_state'] = 'Dhaka';
            $post_data['cus_postcode'] = '1000';
            $post_data['cus_country'] = 'Bangladesh';
            $post_data['cus_phone'] = $customerMobile;
            $post_data['cus_fax'] = '';

            // Shipment information
            $post_data['ship_name'] = $customerName;
            $post_data['ship_add1'] = 'Dhaka';
            $post_data['ship_add2'] = 'Dhaka';
            $post_data['ship_city'] = 'Dhaka';
            $post_data['ship_state'] = 'Dhaka';
            $post_data['ship_postcode'] = '1000';
            $post_data['ship_phone'] = '';
            $post_data['ship_country'] = 'Bangladesh';

            $post_data['shipping_method'] = 'NO';
            $post_data['product_name'] = $payment->purpose ?: ($payment->payment_type === 'subscription' ? 'Subscription Payment' : 'Custom Payment');
            $post_data['product_category'] = 'Services';
            $post_data['product_profile'] = 'general';

            // Initialize SSL Commerz with store
            $storeName = $payment->store_name ?: config('sslcommerz.default_store', 'main-store');
            \Log::info('SSLCommerz initialization', ['store_name' => $storeName, 'post_data' => $post_data]);
            
            $sslc = new SslCommerzNotification($storeName);
            
            // Initiate payment (redirect to SSL Commerz gateway)
            $payment_options = $sslc->makePayment($post_data, 'hosted');
            
            \Log::info('SSLCommerz makePayment result', ['payment_options' => $payment_options, 'is_array' => is_array($payment_options)]);

            if (!is_array($payment_options)) {
                // Redirect to SSL Commerz gateway
                \Log::info('Redirecting to SSLCommerz gateway', ['redirect_url' => $payment_options]);
                return redirect($payment_options);
            } else {
                \Log::error('SSLCommerz payment initialization failed', ['payment_options' => $payment_options]);
                return back()->withErrors(['error' => 'Failed to initialize payment gateway. Please try again.']);
            }

        } catch (\Exception $e) {
            \Log::error('SSLCommerz payment processing failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Payment processing failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle successful payment callback
     */
    public function success(Request $request, $store = null)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('id', $tran_id)->first();

        if (!$payment) {
            return redirect()->route('payment::custom-payment.form')->withErrors(['error' => 'Payment not found.']);
        }

        $payment_data = [
            'gateway_response' => json_encode($request->all()),
            'gateway_payment_id' => $request->input('val_id'),
            'gateway_reference' => $request->input('bank_tran_id'),
        ];

        // Initialize SSL Commerz with the specific store
        $storeName = $store ?: ($payment->store_name ?: config('sslcommerz.default_store', 'main-store'));
        $sslc = new SslCommerzNotification($storeName);

        if (in_array($payment->status, ['pending', 'failed', 'canceled'])) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $payment->amount, config('sslcommerz.currency', 'BDT'));
            
            if ($validation) {
                $payment_data['payment_date'] = now();
                $payment_data['status'] = 'completed';
                $payment->update($payment_data);
                
                // Activate subscription if this is a subscription payment
                if ($payment->payment_type === 'subscription' && $payment->subscription_id) {
                    $subscription = \Modules\Subscription\Models\UserSubscription::find($payment->subscription_id);
                    if ($subscription && $subscription->status === 'pending') {
                        $subscription->update([
                            'status' => 'active',
                            'activated_at' => now()
                        ]);
                    }
                }
                
                // SSL Commerz callback completed - no session manipulation needed
                
                return redirect()->route('payment::payments.confirmation.callback', $payment);
            } else {
                $payment_data['status'] = 'failed';
                $payment->update($payment_data);
                
                return redirect()->route('payment::payments.confirmation.callback', $payment);
            }
        } else if ($payment->status == 'completed') {
            return view('payment::frontend.payment-success', compact('payment'));
        } else {
            return redirect()->route('payment::payments.confirmation', $payment);
        }
    }

    /**
     * Handle failed payment callback
     */
    public function fail(Request $request, $store = null)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('id', $tran_id)->first();

        if (!$payment) {
            return redirect()->route('payment::custom-payment.form')->withErrors(['error' => 'Payment not found.']);
        }

        $payment_data = [
            'gateway_response' => json_encode($request->all()),
            'gateway_payment_id' => $request->input('val_id'),
            'gateway_reference' => $request->input('bank_tran_id'),
            'status' => 'failed',
            'failed_at' => now(),
        ];

        if (in_array($payment->status, ['pending', 'failed', 'canceled'])) {
            $payment->update($payment_data);
            
            // Custom payment status is already updated in the payment record above
            
            return redirect()->route('payment::payments.confirmation', $payment);
        } else if ($payment->status == 'completed') {
            return view('payment::frontend.payment-success', compact('payment'));
        } else {
            return redirect()->route('payment::payments.confirmation', $payment);
        }
    }

    /**
     * Handle cancelled payment callback
     */
    public function cancel(Request $request, $store = null)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('id', $tran_id)->first();

        if (!$payment) {
            return redirect()->route('payment::custom-payment.form')->withErrors(['error' => 'Payment not found.']);
        }

        $payment_data = [
            'gateway_response' => json_encode($request->all()),
            'gateway_payment_id' => $request->input('val_id'),
            'gateway_reference' => $request->input('bank_tran_id'),
            'status' => 'canceled',
        ];

        if (in_array($payment->status, ['pending', 'failed', 'canceled'])) {
            $payment->update($payment_data);
            
            // Custom payment status is already updated in the payment record above
            
            return redirect()->route('payment::payments.confirmation', $payment);
        } else if ($payment->status == 'completed') {
            return view('payment::frontend.payment-success', compact('payment'));
        } else {
            return redirect()->route('payment::payments.confirmation', $payment);
        }
    }

    /**
     * Handle IPN (Instant Payment Notification) callback
     */
    public function ipn(Request $request, $store = null)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');
            $payment = Payment::where('id', $tran_id)->first();

            if (!$payment) {
                return response('Payment not found', 404);
            }

            $payment_data = [
                'gateway_response' => json_encode($request->all()),
                'gateway_payment_id' => $request->input('val_id'),
                'gateway_reference' => $request->input('bank_tran_id'),
            ];

            if (in_array($payment->status, ['pending', 'failed', 'canceled'])) {
                // Initialize SSL Commerz with the specific store
                $storeName = $store ?: ($payment->store_name ?: config('sslcommerz.default_store', 'main-store'));
                $sslc = new SslCommerzNotification($storeName);
                
                $validation = $sslc->orderValidate($request->all(), $tran_id, $payment->amount, config('sslcommerz.currency', 'BDT'));

                if ($validation) {
                    // Get additional payment data
                    $validated_payment_data = $sslc->getPaymentDataByValidationID($request->input('val_id'));

                    if (is_array($validated_payment_data) && $tran_id == $validated_payment_data['tran_id']) {
                        $payment_references = [];
                        $payment_reference = json_decode($payment_data['gateway_response'], true);
                        array_push($payment_references, $payment_reference);
                        array_push($payment_references, $validated_payment_data);

                        $payment_data['gateway_response'] = json_encode($payment_references);
                    }

                    $payment_data['status'] = 'completed';
                    $payment_data['payment_date'] = now();
                    $payment->update($payment_data);

                    // Activate subscription if this is a subscription payment
                    if ($payment->payment_type === 'subscription' && $payment->subscription_id) {
                        $subscription = \Modules\Subscription\Models\UserSubscription::find($payment->subscription_id);
                        if ($subscription && $subscription->status === 'pending') {
                            $subscription->update([
                                'status' => 'active',
                                'activated_at' => now()
                            ]);
                        }
                    }

                    return response('SUCCESS', 200);
                } else {
                    $payment_data['status'] = 'failed';
                    $payment->update($payment_data);
                    
                    return response('FAILED', 400);
                }
            } else if ($payment->status == 'completed') {
                return response('ALREADY_COMPLETED', 200);
            } else {
                return response('INVALID_TRANSACTION', 400);
            }
        }

        return response('INVALID_REQUEST', 400);
    }
}