<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailOrMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        // If user is not authenticated, redirect to login
        if (!$request->user()) {
            return redirect(route('login'));
        }

        $user = $request->user();

        // Check if user needs verification
        $needsVerification = false;
        $errorMessage = '';

        if (!$user->email && !$user->mobile) {
            // No contact methods at all
            $needsVerification = true;
            $errorMessage = 'You must add and verify either an email address or mobile number.';
        } elseif ($user->email && !$user->mobile) {
            // Has email only - must be verified
            if (!$user->hasVerifiedEmail()) {
                $needsVerification = true;
                $errorMessage = 'Your email address is not verified.';
            }
        } elseif ($user->mobile && !$user->email) {
            // Has mobile only - must be verified
            if (!$user->hasVerifiedMobile()) {
                $needsVerification = true;
                $errorMessage = 'Your mobile number is not verified.';
            }
        } elseif ($user->email && $user->mobile) {
            // Has both - at least one must be verified
            if (!$user->hasVerifiedEmail() && !$user->hasVerifiedMobile()) {
                $needsVerification = true;
                $errorMessage = 'Either your email address or mobile number must be verified.';
            }
        }

        if ($needsVerification) {
            return $request->expectsJson()
                ? abort(403, $errorMessage)
                : redirect(route('verification.choice'));
        }

        return $next($request);
    }
}