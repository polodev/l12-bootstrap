<?php

return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
    'min_score' => 0.5, // Minimum score for reCAPTCHA v3 (0.0 to 1.0)
];