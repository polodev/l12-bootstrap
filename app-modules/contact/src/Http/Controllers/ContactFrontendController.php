<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Models\Contact;

class ContactFrontendController extends Controller
{
    public function create()
    {
        return view('contact::frontend.contact-form');
    }

    public function store(Request $request)
    {
        // Get client IP address and user agent
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        
        // Rate limiting: Check if more than 3 contacts from same IP within 2 minutes
        $recentContacts = Contact::where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();
            
        if ($recentContacts >= 3) {
            return back()->withErrors([
                'rate_limit' => __('messages.rate_limit_error')
            ])->withInput();
        }

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'organization' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'topic' => 'nullable|string|max:255',
            'department' => 'nullable|string|in:' . implode(',', array_keys(Contact::getAvailableDepartments())),
            'message' => 'required|string',
            'page' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ];

        // Add reCAPTCHA validation if enabled
        if (config('services.recaptcha.enabled', false)) {
            $validationRules['g-recaptcha-response'] = 'required|recaptcha';
        }

        $validatedData = $request->validate($validationRules, [
            'name.required' => __('messages.name_required'),
            'mobile.required' => __('messages.mobile_required'),
            'message.required' => __('messages.message_required'),
            'email.email' => __('messages.email_invalid'),
        ]);

        // Remove reCAPTCHA response from data before creating contact
        unset($validatedData['g-recaptcha-response']);

        // Add IP address and user agent to the data
        $validatedData['ip_address'] = $ipAddress;
        $validatedData['user_agent'] = $userAgent;

        // Create the contact
        $contact = Contact::create($validatedData);

        return view('contact::frontend.contact-success', compact('contact'));
    }
}