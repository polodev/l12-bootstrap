# API Service Integration Guide

A comprehensive guide for integrating third-party flight and hotel booking APIs into your Laravel OTA application using the modular api-service architecture.

---

## 📋 **Table of Contents**

1. [Overview](#overview)
2. [Architecture Design](#architecture-design)
3. [Quick Start Guide](#quick-start-guide)
4. [Configuration Reference](#configuration-reference)
5. [API Providers](#api-providers)
6. [Implementation Examples](#implementation-examples)
7. [Deployment Strategies](#deployment-strategies)
8. [Performance Optimization](#performance-optimization)
9. [Troubleshooting](#troubleshooting)
10. [Advanced Usage](#advanced-usage)

---

## 🎯 **Overview**

The API Service module provides a **toggleable, fallback-enabled system** for integrating multiple third-party booking APIs while maintaining your existing static data functionality. Perfect for startups wanting to scale gradually from static content to live API integrations.

### **Key Features**
- ✅ **Zero-downtime deployment** - Works with existing static data
- ✅ **Multiple provider support** - Amadeus, Sabre, Expedia, Booking.com
- ✅ **Intelligent fallback** - Automatic switch to static data when APIs fail
- ✅ **Cost control** - Caching and rate limiting built-in
- ✅ **Easy toggle** - Enable/disable entire system with one setting
- ✅ **Startup-friendly** - Start free, scale when ready

---

## 🏗️ **Architecture Design**

### **Modular Separation of Concerns**

```
┌─────────────────────────────────────────────────────────────┐
│                    Laravel Application                      │
├─────────────────────────────────────────────────────────────┤
│  Flight Module              │  Hotel Module                 │
│  ├── DynamicFlightController│  ├── DynamicHotelController   │
│  ├── flight-search.blade.php│  ├── hotel-search.blade.php   │
│  └── /dynamic-flight routes │  └── /dynamic-hotel routes    │
├─────────────────────────────────────────────────────────────┤
│                   API Service Module                        │
│  ├── ApiServiceManager    (Easy service access)            │
│  ├── FlightApiService     (Flight API operations)          │
│  ├── HotelApiService      (Hotel API operations)           │
│  ├── BaseApiService       (Common API functionality)       │
│  └── Configuration        (Provider settings & toggles)    │
├─────────────────────────────────────────────────────────────┤
│              Third-Party API Providers                     │
│  Amadeus │ Sabre │ Expedia │ Booking.com │ Others          │
└─────────────────────────────────────────────────────────────┘
```

### **Design Principles**

1. **Domain Separation**: Flight/Hotel modules handle their specific business logic
2. **Service Layer**: API-service provides functional helpers only
3. **InterNACHI Compliance**: Follows the modular package conventions
4. **Fallback Strategy**: Always maintain functionality even when APIs fail
5. **Configuration-Driven**: All behavior controlled via environment variables

---

## 🚀 **Quick Start Guide**

### **Step 1: Environment Setup**

Copy the API service configuration template:
```bash
# Copy the example configuration
cp .env.api-service.example .env.api-service

# Add the configuration to your main .env file
cat .env.api-service >> .env
```

### **Step 2: Test with Static Data**

The system works immediately with your existing data:

```bash
# Visit these URLs to test the interface
http://l12-bootstrap.test//dynamic-flight
http://l12-bootstrap.test//dynamic-hotel

# Bengali versions
http://l12-bootstrap.test//bn/dynamic-flight  
http://l12-bootstrap.test//bn/dynamic-hotel
```

### **Step 3: Configure API Providers (When Ready)**

Update your `.env` file:
```env
# Enable the API service
API_SERVICE_ENABLED=true

# Configure your chosen provider
AMADEUS_ENABLED=true
AMADEUS_API_KEY=your_api_key_here
AMADEUS_API_SECRET=your_api_secret_here
```

### **Step 4: Gradual Rollout**

Enable providers one at a time:
```env
# Start with one provider
AMADEUS_ENABLED=true
SABRE_ENABLED=false
EXPEDIA_ENABLED=false

# Test thoroughly, then enable others
```

---

## ⚙️ **Configuration Reference**

### **Master Controls**

| Setting | Default | Description |
|---------|---------|-------------|
| `API_SERVICE_ENABLED` | `false` | Master switch for all API functionality |
| `API_FALLBACK_STATIC_DATA` | `true` | Use static data when APIs fail |
| `API_SHOW_ERROR_MESSAGES` | `false` | Show detailed API errors to users |

### **Provider Configuration**

#### **Amadeus (Recommended for Startups)**
```env
AMADEUS_ENABLED=false
AMADEUS_API_KEY=your_amadeus_api_key
AMADEUS_API_SECRET=your_amadeus_api_secret
AMADEUS_BASE_URL=https://api.amadeus.com
```

#### **Sabre (Enterprise)**
```env
SABRE_ENABLED=false
SABRE_CLIENT_ID=your_sabre_client_id
SABRE_CLIENT_SECRET=your_sabre_client_secret
SABRE_BASE_URL=https://api.sabre.com
```

#### **Expedia (Hotels)**
```env
EXPEDIA_ENABLED=false
EXPEDIA_API_KEY=your_expedia_api_key
EXPEDIA_BASE_URL=https://api.expedia.com
```

#### **Booking.com (Hotels)**
```env
BOOKING_COM_ENABLED=false
BOOKING_COM_API_KEY=your_booking_com_api_key
BOOKING_COM_BASE_URL=https://distribution-xml.booking.com
```

### **Performance Settings**

#### **Caching Configuration**
```env
API_CACHE_ENABLED=true
CACHE_FLIGHT_SEARCH_TTL=300     # 5 minutes
CACHE_HOTEL_SEARCH_TTL=600      # 10 minutes  
CACHE_FLIGHT_DETAILS_TTL=1800   # 30 minutes
CACHE_HOTEL_DETAILS_TTL=3600    # 1 hour
```

#### **Rate Limiting**
```env
API_RATE_LIMITING_ENABLED=true
API_REQUESTS_PER_MINUTE=60
API_BURST_LIMIT=10
```

---

## 🌐 **API Providers**

### **1. Amadeus (⭐ Recommended for Startups)**

**Why Choose Amadeus:**
- ✅ Developer-friendly with excellent documentation
- ✅ Free tier available for testing
- ✅ JSON REST APIs (easy integration)
- ✅ Good support community
- ✅ Covers both flights and hotels

**Getting Started:**
1. Visit [developers.amadeus.com](https://developers.amadeus.com)
2. Create free account
3. Get API key and secret
4. Start with test environment

### **2. Sabre (🏢 Enterprise Ready)**

**Why Choose Sabre:**
- ✅ Extensive global inventory
- ✅ Reliable GDS platform
- ✅ Strong in corporate travel
- ✅ Advanced booking features

**Considerations:**
- Higher complexity
- Enterprise-focused pricing
- More technical setup required

### **3. Expedia (🏨 Hotel Focused)**

**Why Choose Expedia:**
- ✅ Huge hotel inventory
- ✅ Real-time availability
- ✅ Competitive rates
- ✅ Strong booking conversion

### **4. Booking.com (🌍 Global Coverage)**

**Why Choose Booking.com:**
- ✅ Largest accommodation network
- ✅ Global presence
- ✅ Multiple property types
- ✅ Trusted brand

---

## 💻 **Implementation Examples**

### **Flight Search Implementation**

**Controller Usage:**
```php
// In DynamicFlightController
use Modules\ApiService\ApiServiceManager;

public function search(Request $request)
{
    // Get the flight API service
    $flightService = ApiServiceManager::flight();
    
    // Perform search (handles fallback automatically)
    $results = $flightService->searchFlights($searchParams);
    
    return view('flight::dynamic.results', compact('results'));
}
```

**Volt Component Usage:**
```php
// In flight-search.blade.php Volt component
public function search()
{
    // Use API service functionally
    $flightService = \Modules\ApiService\ApiServiceManager::flight();
    $results = $flightService->searchFlights($this->getSearchParams());
    
    // Handle results or redirect
    if (isset($results['error'])) {
        session()->flash('error', $results['error']);
        return;
    }
    
    return redirect()->route('flight::dynamic.search', $this->getSearchParams());
}
```

### **Hotel Search Implementation**

**Service Usage:**
```php
// Get hotel service
$hotelService = ApiServiceManager::hotel();

// Search with parameters
$searchParams = [
    'destination' => 'London',
    'checkin_date' => '2025-08-15',
    'checkout_date' => '2025-08-18',
    'guests' => 2,
    'rooms' => 1
];

$results = $hotelService->searchHotels($searchParams);
```

### **Custom Provider Integration**

**Extend BaseApiService:**
```php
// Create new provider service
class CustomFlightApiService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct('custom_provider');
    }
    
    protected function isConfigured(): bool
    {
        return !empty($this->config['api_key']);
    }
    
    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->config['api_key'],
            'Content-Type' => 'application/json'
        ];
    }
    
    public function transformResponse(array $response): array
    {
        // Transform provider response to standard format
        return [
            'success' => true,
            'data' => $this->standardizeFlightData($response),
            'provider' => $this->provider
        ];
    }
}
```

---

## 🚀 **Deployment Strategies**

### **Strategy 1: Gradual Migration (Recommended)**

**Phase 1: Static Foundation**
```env
API_SERVICE_ENABLED=false
API_FALLBACK_STATIC_DATA=true
```
- Deploy with existing static data
- Test new UI/UX with users
- Gather feedback and optimize

**Phase 2: API Testing**
```env
API_SERVICE_ENABLED=true
AMADEUS_ENABLED=true
# Other providers disabled
```
- Enable one provider for testing
- Monitor performance and errors
- Fine-tune caching and rate limits

**Phase 3: Full Production**
```env
# Enable multiple providers
AMADEUS_ENABLED=true
EXPEDIA_ENABLED=true
# Configure fallback priorities
```

### **Strategy 2: A/B Testing**

**Feature Flag Approach:**
```php
// In controller
if (auth()->user()->hasTestingEnabled()) {
    $useApi = true;
} else {
    $useApi = config('api-service.enabled', false);
}
```

### **Strategy 3: Staged Rollout**

**Geographic Rollout:**
```php
// Enable APIs for specific regions first
$enabledRegions = ['US', 'UK', 'CA'];
$userRegion = $request->header('CF-IPCountry');

if (in_array($userRegion, $enabledRegions)) {
    // Use API service
} else {
    // Use static data
}
```

---

## ⚡ **Performance Optimization**

### **Caching Strategy**

**Multi-Layer Caching:**
```env
# Short-term for volatile data
CACHE_FLIGHT_SEARCH_TTL=300      # 5 minutes
CACHE_HOTEL_SEARCH_TTL=600       # 10 minutes

# Medium-term for semi-static data  
CACHE_FLIGHT_DETAILS_TTL=1800    # 30 minutes
CACHE_HOTEL_DETAILS_TTL=3600     # 1 hour

# Long-term for static data
CACHE_AIRLINE_DATA_TTL=86400     # 24 hours
CACHE_LOCATION_DATA_TTL=604800   # 7 days
```

**Redis Configuration:**
```php
// In config/cache.php
'api_cache' => [
    'driver' => 'redis',
    'connection' => 'api_cache',
    'prefix' => 'api_service'
]
```

### **Queue Processing**

**Background API Calls:**
```php
// Heavy operations in background
dispatch(new ProcessHotelSearch($searchParams))
    ->onQueue('api_calls');
```

### **Rate Limiting Best Practices**

**Intelligent Rate Limiting:**
```php
// Different limits for different operations
'rate_limits' => [
    'search' => '10:1',      # 10 searches per minute
    'details' => '30:1',     # 30 detail views per minute
    'booking' => '3:1'       # 3 bookings per minute
]
```

---

## 🔧 **Troubleshooting**

### **Common Issues**

#### **APIs Not Responding**
```bash
# Check service status
php artisan api-service:status

# Test individual providers
php artisan api-service:test amadeus
php artisan api-service:test expedia
```

**Solution Steps:**
1. Verify `API_SERVICE_ENABLED=true`
2. Check provider credentials
3. Confirm provider-specific `ENABLED` flags
4. Review API rate limits
5. Check network connectivity

#### **No Fallback Data**
**Symptoms:** Empty results when APIs fail

**Solution:**
```env
# Ensure fallback is enabled
API_FALLBACK_STATIC_DATA=true

# Check static data exists
php artisan db:seed --class=FlightSeeder
php artisan db:seed --class=HotelSeeder
```

#### **Slow Response Times**
**Diagnosis:**
```bash
# Check cache hit rates
php artisan cache:stats

# Monitor API response times
tail -f storage/logs/laravel.log | grep "API_RESPONSE_TIME"
```

**Solutions:**
1. Enable Redis caching
2. Increase cache TTL values
3. Implement cache warming
4. Use CDN for static assets

#### **High API Costs**
**Cost Control Measures:**
```env
# Aggressive caching
CACHE_FLIGHT_SEARCH_TTL=900      # 15 minutes
API_REQUESTS_PER_MINUTE=30       # Reduce calls

# Smart fallback
API_TIMEOUT_FALLBACK=true        # Quick fallback on slow APIs
```

### **Debugging Tools**

#### **API Service Status Check**
```php
// Check if services are properly configured
ApiServiceManager::isEnabled();                    // Master switch
ApiServiceManager::config('providers.amadeus.enabled'); // Provider status
```

#### **Response Inspection**
```php
// Log API responses for debugging
$response = $flightService->searchFlights($params);
Log::info('Flight API Response', [
    'provider' => $response['provider'] ?? 'unknown',
    'success' => $response['success'] ?? false,
    'data_count' => count($response['data'] ?? [])
]);
```

---

## 🎓 **Advanced Usage**

### **Custom Provider Integration**

**Adding New Providers:**
1. Extend `BaseApiService`
2. Implement required abstract methods
3. Add provider configuration
4. Register in `ApiServiceManager`

### **Custom Caching Logic**

**Provider-Specific Caching:**
```php
// Custom cache keys based on search complexity
protected function getCacheKey(array $searchParams): string
{
    $complexity = $this->calculateSearchComplexity($searchParams);
    $ttl = $complexity > 5 ? 180 : 300; // Shorter cache for complex searches
    
    return 'flight_search_' . md5(serialize($searchParams)) . '_' . $ttl;
}
```

### **Multi-Provider Comparison**

**Price Comparison Logic:**
```php
// Search multiple providers simultaneously
$providers = ['amadeus', 'sabre'];
$results = [];

foreach ($providers as $provider) {
    $service = new FlightApiService($provider);
    $results[$provider] = $service->searchFlights($params);
}

// Merge and sort by price
$combinedResults = $this->mergeProviderResults($results);
```

### **Dynamic Provider Selection**

**Load Balancing:**
```php
// Route requests based on provider performance
$provider = $this->selectBestProvider([
    'amadeus' => ['response_time' => 200, 'success_rate' => 0.98],
    'sabre' => ['response_time' => 350, 'success_rate' => 0.95]
]);
```

---

## 📈 **Monitoring & Analytics**

### **Key Metrics to Track**

1. **API Performance:**
   - Response times
   - Success/failure rates
   - Cache hit ratios
   - Cost per request

2. **Business Metrics:**
   - Search-to-booking conversion
   - Provider performance comparison
   - User engagement with dynamic vs static content

3. **Technical Metrics:**
   - API quota usage
   - Error rates by provider
   - Fallback activation frequency

### **Logging Configuration**

```php
// In config/logging.php
'api_service' => [
    'driver' => 'single',
    'path' => storage_path('logs/api-service.log'),
    'level' => 'info'
]
```

---

## 🎯 **Best Practices Summary**

### **For Startups**
1. ✅ Start with static data, test UI/UX first
2. ✅ Choose one provider initially (recommend Amadeus)
3. ✅ Enable aggressive caching to control costs
4. ✅ Use fallback extensively during early stages
5. ✅ Monitor API usage and costs closely

### **For Scaling**
1. ✅ Implement multi-provider support for redundancy
2. ✅ Use Redis for high-performance caching
3. ✅ Queue heavy operations in background
4. ✅ Implement circuit breakers for failing providers
5. ✅ Set up comprehensive monitoring and alerting

### **For Production**
1. ✅ Always maintain fallback functionality
2. ✅ Implement proper error handling and user messaging
3. ✅ Use environment-specific configurations
4. ✅ Set up automated testing for API integrations
5. ✅ Plan for API provider outages and maintenance

---

## 🆘 **Support & Resources**

### **Documentation**
- Laravel Localization: Configuration and usage
- InterNACHI Modular: Module architecture
- API Provider Documentation: Links to official docs

### **Community**
- GitHub Issues: Report bugs and feature requests
- Laravel Community: General Laravel support
- API Provider Communities: Provider-specific help

### **Professional Support**
- Laravel Consulting: For complex implementations
- API Integration Services: Specialized API development
- Performance Optimization: Scaling and performance tuning

---

**📝 Last Updated:** August 2025  
**📋 Version:** 1.0  
**👥 Target Audience:** Laravel developers, OTA startups, travel tech companies

This guide provides everything needed to successfully integrate live booking APIs into your OTA platform while maintaining reliability and controlling costs. The modular architecture ensures you can scale at your own pace without compromising user experience.