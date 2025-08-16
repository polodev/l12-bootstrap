<?php

namespace Modules\ApiService\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

abstract class BaseApiService
{
    protected string $provider;
    protected array $config;
    protected string $baseUrl;
    protected int $timeout;

    public function __construct(string $provider)
    {
        $this->provider = $provider;
        $this->config = config("api-service.providers.{$provider}", []);
        $this->baseUrl = $this->config['base_url'] ?? '';
        $this->timeout = $this->config['timeout'] ?? 30;
    }

    /**
     * Check if the API service is enabled and properly configured
     */
    public function isEnabled(): bool
    {
        return config('api-service.enabled', false) && 
               ($this->config['enabled'] ?? false) && 
               $this->isConfigured();
    }

    /**
     * Check if the service is properly configured
     */
    abstract protected function isConfigured(): bool;

    /**
     * Make an HTTP request to the API
     */
    protected function makeRequest(string $method, string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->{$method}($this->baseUrl . $endpoint, $data);

            if ($response->failed()) {
                Log::error("API request failed for {$this->provider}", [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return ['error' => 'API request failed', 'status' => $response->status()];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error("API request exception for {$this->provider}", [
                'method' => $method,
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get request headers for API calls
     */
    abstract protected function getHeaders(): array;

    /**
     * Cache API response
     */
    protected function cacheResponse(string $key, array $data, int $ttl): void
    {
        if (config('api-service.cache.enabled', true)) {
            Cache::put("api_service_{$this->provider}_{$key}", $data, $ttl);
        }
    }

    /**
     * Get cached response
     */
    protected function getCachedResponse(string $key): ?array
    {
        if (config('api-service.cache.enabled', true)) {
            return Cache::get("api_service_{$this->provider}_{$key}");
        }
        
        return null;
    }

    /**
     * Transform API response to standardized format
     */
    abstract public function transformResponse(array $response): array;
}