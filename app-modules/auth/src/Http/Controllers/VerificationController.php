<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class VerificationController extends Controller
{
    public function show(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('accounts.index', absolute: false))
                    : view('auth::verify-email');
    }

    public function notice(Request $request): RedirectResponse|View
    {
        return $this->show($request);
    }

    public function showMobile(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedMobile()
                    ? redirect()->intended(route('accounts.index', absolute: false))
                    : view('auth::verify-mobile');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('accounts.index', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('accounts.index', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();

            event(new Verified($user));
        }

        return redirect()->intended(route('accounts.index', absolute: false).'?verified=1');
    }

    public function showChoice(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        
        // If user already has either email or mobile verified, redirect to dashboard
        if (($user->email && $user->hasVerifiedEmail()) || ($user->mobile && $user->hasVerifiedMobile())) {
            return redirect()->intended(route('accounts.index', absolute: false));
        }
        
        return view('auth::verification-choice', compact('user'));
    }

    public function addContact(Request $request): RedirectResponse
    {
        $user = $request->user();
        $type = $request->input('type');
        
        if ($type === 'email') {
            $request->validate([
                'email' => ['required', 'email', 'unique:users,email,' . $user->id]
            ]);
            
            $user->update([
                'email' => $request->email,
                'email_verified_at' => null
            ]);
            
            $user->sendEmailVerificationNotification();
            
            return back()->with('status', 'email-added-verification-sent');
            
        } elseif ($type === 'mobile') {
            $request->validate([
                'country' => ['required', 'string', 'max:3'],
                'country_code' => ['required', 'string', 'max:5'],
                'mobile' => ['required', 'string', 'max:20']
            ]);
            
            $user->update([
                'country' => $request->country,
                'country_code' => $request->country_code,
                'mobile' => $request->mobile,
                'mobile_verified_at' => null
            ]);
            
            return back()->with('status', 'mobile-added-contact-support');
        }
        
        return back()->withErrors(['type' => 'Invalid contact type']);
    }
}
