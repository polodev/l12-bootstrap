<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected $siteKey;
    protected $secretKey;
    protected $verifyUrl;
    protected $minScore;

    public function __construct()
    {
        $this->siteKey = config('recaptcha.site_key');
        $this->secretKey = config('recaptcha.secret_key');
        $this->verifyUrl = config('recaptcha.verify_url');
        $this->minScore = config('recaptcha.min_score');
    }

    /**
     * Verify reCAPTCHA v3 token
     */
    public function verify(string $token, string $action = null): bool
    {
        if (empty($token) || empty($this->secretKey)) {
            return false;
        }

        try {
            $response = Http::asForm()->post($this->verifyUrl, [
                'secret' => $this->secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'errors' => $result['error-codes'] ?? [],
                    'token' => substr($token, 0, 10) . '...'
                ]);
                return false;
            }

            // Check score for v3
            if (isset($result['score']) && $result['score'] < $this->minScore) {
                Log::warning('reCAPTCHA score too low', [
                    'score' => $result['score'],
                    'min_score' => $this->minScore,
                    'action' => $result['action'] ?? null
                ]);
                return false;
            }

            // Check action if provided
            if ($action && isset($result['action']) && $result['action'] !== $action) {
                Log::warning('reCAPTCHA action mismatch', [
                    'expected' => $action,
                    'actual' => $result['action']
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'message' => $e->getMessage(),
                'token' => substr($token, 0, 10) . '...'
            ]);
            return false;
        }
    }

    /**
     * Get site key for frontend
     */
    public function getSiteKey(): string
    {
        return $this->siteKey ?? '';
    }
}