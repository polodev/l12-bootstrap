<x-mail::message>
# Email Verification

Hello {{ $user->name }},

Thank you for creating an account with {{ config('app.name') }}. To complete your registration and secure your account, please verify your email address by clicking the button below.

<x-mail::button :url="$verificationUrl" color="primary">
Verify Email Address
</x-mail::button>

This verification link will expire in 60 minutes for security purposes.

If you did not create an account with us, please ignore this email.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
