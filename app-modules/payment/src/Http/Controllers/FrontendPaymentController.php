<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Models\Payment;

class FrontendPaymentController extends Controller
{
    /**
     * Show custom payment form
     */
    public function showCustomPaymentForm()
    {
        $gatewayCharges = [
            'sslcommerz_regular' => config('global.sslcommerz_payment_gateway_charge', 2.00),
            'sslcommerz_premium' => config('global.sslcommerz_payment_gateway_charge_for_premium_card', 3.00),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];

        return view('payment::frontend.custom-payment-form', compact('gatewayCharges'));
    }

    /**
     * Submit custom payment form with reCAPTCHA validation
     */
    public function submitCustomPaymentForm(Request $request)
    {
        // Get client IP address for rate limiting
        $ipAddress = $request->ip();
        
        // Rate limiting: Check if more than 3 custom payments from same IP within 5 minutes
        // future if statement  if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'developer'])) 
        $recentPayments = Payment::where('payment_type', 'custom_payment')
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();
            
        if ($recentPayments >= 3) {
            return back()->withErrors([
                'rate_limit' => __('messages.rate_limit_error')
            ])->withInput();
        }

        // Prepare validation rules
        $rules = [
            'payment_method' => 'required|in:sslcommerz,manual_payment',
            'amount' => 'required|numeric|min:100',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'purpose' => 'nullable|string|max:500',
        ];

        $messages = [
            'amount.min' => __('messages.amount_minimum_required'),
        ];

        // Add reCAPTCHA validation if enabled
        if (env('RECAPTCHA_ENABLED', false)) {
            $rules['g-recaptcha-response'] = 'required';
            $messages['g-recaptcha-response.required'] = 'Please complete the reCAPTCHA verification.';
        }

        // Validate form input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify reCAPTCHA if enabled
        if (env('RECAPTCHA_ENABLED', false)) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $recaptchaSecret = config('services.recaptcha.secret_key');
            
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);

            $recaptchaData = $response->json();

            if (!$recaptchaData['success']) {
                return back()
                    ->withErrors(['recaptcha' => 'reCAPTCHA verification failed. Please try again.'])
                    ->withInput();
            }
        }

        try {
            // Create payment record directly with payment_type = 'custom_payment'
            $payment = Payment::create([
                'payment_type' => 'custom_payment',
                'booking_id' => null,
                'amount' => $request->amount,
                'email_address' => $request->email,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'purpose' => $request->purpose,
                'payment_method' => $request->payment_method,
                'store_name' => config('sslcommerz.default_store', 'main-store'),
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'form_data' => [
                    'name' => $request->name,
                    'email_address' => $request->email,
                    'mobile' => $request->mobile,
                    'amount' => $request->amount,
                    'purpose' => $request->purpose,
                    'currency' => 'BDT',
                    'form_type' => 'custom_payment'
                ],
                'payment_date' => now(),
            ]);

            // Redirect to payment page
            return redirect()->route('payment::payments.show', $payment->id)
                ->with('success', 'Payment request created successfully. Please complete your payment.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'An error occurred while processing your request. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show payment page
     */
    public function showPayment(Payment $payment)
    {
        // Load related data
        $payment->load(['booking']);

        // Get gateway charges
        $gatewayCharges = [
            'sslcommerz' => config('global.sslcommerz_payment_gateway_charge', 2.10),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];

        // Calculate gateway fees using trait methods
        $sslcommerzCalculation = \App\Helpers\Helpers::calculateSSLCommerzTotal($payment->amount);
        // Temporarily commented out until bKash integration
        // $bkashCalculation = \App\Helpers\Helpers::calculateBkashTotal($payment->amount);

        // Render different views based on payment method
        switch ($payment->payment_method) {
            case 'sslcommerz':
                return view('payment::frontend.payments.sslcommerz-payment', compact('payment', 'gatewayCharges', 'sslcommerzCalculation'));
            
            case 'manual_payment':
                return view('payment::frontend.payments.manual-payment', compact('payment', 'gatewayCharges', 'sslcommerzCalculation'));
            
            default:
                // Fallback to SSLCommerz for backward compatibility
                return view('payment::frontend.payments.sslcommerz-payment', compact('payment', 'gatewayCharges', 'sslcommerzCalculation'));
        }
    }

    /**
     * Process payment - redirect to appropriate payment gateway
     */
    public function processPayment(Payment $payment, Request $request)
    {
        // Route to appropriate payment gateway based on payment method
        switch ($payment->payment_method) {
            case 'sslcommerz':
                $sslController = new \Modules\Payment\Http\Controllers\SslCommerzController();
                return $sslController->processPayment($payment, $request);
                
            default:
                return back()->withErrors(['error' => __('messages.payment_method_not_supported', ['method' => $payment->payment_method])]);
        }
    }

    /**
     * Submit manual payment with proof
     */
    public function submitManualPayment(Request $request, Payment $payment)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_attachment' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:5120', // 5MB max
        ], [
            'bank_name.required' => __('messages.bank_name_required'),
            'notes.max' => __('messages.notes_too_long'),
            'payment_attachment.required' => __('messages.payment_attachment_required'),
            'payment_attachment.mimes' => __('messages.payment_attachment_invalid_format'),
            'payment_attachment.max' => __('messages.payment_attachment_too_large'),
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update payment with bank information
            $payment->update([
                'bank_name' => $request->bank_name,
                'status' => 'processing', // Change status to processing for manual verification
                'notes' => $request->notes ?: 'Manual payment submitted for verification'
            ]);

            // Handle file upload using Spatie Media Library
            if ($request->hasFile('payment_attachment')) {
                $payment->addMediaFromRequest('payment_attachment')
                    ->toMediaCollection('payment_attachment');
            }

            // Redirect with success message
            return redirect()->route('payment::payments.confirmation', $payment->id)
                ->with('success', __('messages.manual_payment_submitted_successfully'));

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => __('messages.manual_payment_submission_failed')])
                ->withInput();
        }
    }

    /**
     * Show payment confirmation page
     */
    public function showPaymentConfirmation(Payment $payment)
    {
        // Load related data
        $payment->load(['booking']);

        // Render different confirmation views based on payment method
        switch ($payment->payment_method) {
            case 'manual_payment':
                return view('payment::frontend.manual-payment-confirmation', compact('payment'));
            
            case 'sslcommerz':
                return view('payment::frontend.sslcommerz-payment-confirmation', compact('payment'));
            
            default:
                // Fallback to regular payment confirmation for other methods
                return view('payment::frontend.payment-confirmation', compact('payment'));
        }
    }
}