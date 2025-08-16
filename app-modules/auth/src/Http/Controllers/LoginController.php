<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RecaptchaService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\User;
use App\Notifications\LoginCodeNotification;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth::login');
    }

    public function createEmailCode(): View
    {
        return view('auth::email-code-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];

        // Only require reCAPTCHA token if reCAPTCHA is enabled
        if (env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key')) {
            $validationRules['recaptcha_token'] = ['required', 'string'];
        }

        $request->validate($validationRules);

        // Verify reCAPTCHA only if enabled
        if (env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key')) {
            $recaptcha = new RecaptchaService();
            if (!$recaptcha->verify($request->recaptcha_token, 'login')) {
                throw ValidationException::withMessages([
                    'email' => __('Please verify that you are not a robot.'),
                ]);
            }
        }

        $this->ensureIsNotRateLimited($request);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        // Update last login timestamp
        Auth::user()->update(['last_login_at' => now()]);

        $request->session()->regenerate();

        return redirect()->intended(LaravelLocalization::localizeUrl(route('accounts.index', absolute: false)));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip());
    }

    public function sendEmailCode(Request $request): RedirectResponse
    {
        $validationRules = [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ];

        // Only require reCAPTCHA token if reCAPTCHA is enabled
        if (env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key')) {
            $validationRules['recaptcha_token'] = ['required', 'string'];
        }

        $request->validate($validationRules);

        // Verify reCAPTCHA only if enabled
        if (env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key')) {
            $recaptcha = new RecaptchaService();
            if (!$recaptcha->verify($request->recaptcha_token, 'email_code_login')) {
                throw ValidationException::withMessages([
                    'email' => __('Please verify that you are not a robot.'),
                ]);
            }
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('No account found with this email address.'),
            ]);
        }

        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10); // Code expires in 10 minutes

        $user->update([
            'email_login_code' => $code,
            'email_login_code_expires_at' => $expiresAt,
        ]);

        // Send the login code via email
        $user->notify(new LoginCodeNotification($code, '10'));

        return redirect()->back()->with([
            'status' => __('messages.email_code_sent_successfully'),
            'show_code_form' => true,
            'email' => $user->email
        ]);
    }

    public function verifyEmailCode(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('No account found with this email address.'),
            ]);
        }

        // Check if code is valid and not expired
        if ($user->email_login_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => __('messages.invalid_verification_code'),
            ]);
        }

        if ($user->email_login_code_expires_at < now()) {
            throw ValidationException::withMessages([
                'code' => __('The verification code has expired. Please request a new one.'),
            ]);
        }

        // Clear the code after successful verification and mark email as verified
        $updateData = [
            'email_login_code' => null,
            'email_login_code_expires_at' => null,
            'last_login_at' => now(),
        ];

        // If email is not verified, mark it as verified since they accessed their email
        if (is_null($user->email_verified_at)) {
            $updateData['email_verified_at'] = now();
        }

        $user->update($updateData);

        // Log the user in
        Auth::login($user, true); // true for remember me

        return redirect()->intended(LaravelLocalization::localizeUrl(route('accounts.index', absolute: false)));
    }
}
