# Location Module Documentation

## Overview

The Location module serves as the geographic foundation for the entire Eco Travel platform. It manages countries, cities, and airports in a hierarchical structure that supports all travel-related services.

## Module Structure

```
app-modules/location/
├── src/
│   ├── Models/
│   │   ├── Country.php
│   │   ├── City.php
│   │   └── Airport.php
│   ├── Http/Controllers/
│   │   ├── CountryController.php
│   │   ├── CityController.php
│   │   └── AirportController.php
│   └── Providers/
│       └── LocationServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Countries Table
```sql
CREATE TABLE countries (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(2) NOT NULL UNIQUE,      -- ISO 2-letter code (BD, US)
    code_3 VARCHAR(3) NOT NULL UNIQUE,    -- ISO 3-letter code (BGD, USA)
    phone_code VARCHAR(10),               -- +880, +1
    currency_code VARCHAR(3),             -- BDT, USD
    currency_symbol VARCHAR(10),          -- ৳, $
    flag_url VARCHAR(255),                -- Flag image URL
    latitude DECIMAL(8,6),                -- Geographic coordinates
    longitude DECIMAL(9,6),
    is_active BOOLEAN DEFAULT true,
    position INTEGER DEFAULT 0,           -- Display order
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Cities Table
```sql
CREATE TABLE cities (
    id BIGINT PRIMARY KEY,
    country_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    state_province VARCHAR(255),          -- State/Division/Province
    latitude DECIMAL(8,6),
    longitude DECIMAL(9,6),
    timezone VARCHAR(255),                -- Asia/Dhaka
    population INTEGER,
    is_active BOOLEAN DEFAULT true,
    is_capital BOOLEAN DEFAULT false,     -- Capital city flag
    is_popular BOOLEAN DEFAULT false,     -- Popular destination
    position INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (country_id) REFERENCES countries(id)
);
```

### Airports Table
```sql
CREATE TABLE airports (
    id BIGINT PRIMARY KEY,
    country_id BIGINT NOT NULL,
    city_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(3) NOT NULL UNIQUE,      -- IATA code (DAC, JFK)
    icao_code VARCHAR(4),                 -- ICAO code (VGHS, KJFK)
    description TEXT,
    latitude DECIMAL(8,6),
    longitude DECIMAL(9,6),
    elevation INTEGER,                    -- Feet above sea level
    timezone VARCHAR(255),
    is_active BOOLEAN DEFAULT true,
    is_international BOOLEAN DEFAULT false,
    position INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (country_id) REFERENCES countries(id),
    FOREIGN KEY (city_id) REFERENCES cities(id)
);
```

## Model Relationships

### Country Model
```php
class Country extends Model
{
    // Relationships
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
    
    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }
    
    // Accessors
    public function getStatusBadgeAttribute()
    {
        // Returns HTML badge for status
    }
}
```

### City Model
```php
class City extends Model
{
    // Relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }
    
    public function scopeCapital($query)
    {
        return $query->where('is_capital', true);
    }
    
    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name . ', ' . $this->country->name;
    }
}
```

### Airport Model
```php
class Airport extends Model
{
    // Relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeInternational($query)
    {
        return $query->where('is_international', true);
    }
}
```

## Controllers

### Country Controller Features
- **Index**: DataTables listing with filtering and search
- **Create/Store**: Form validation and creation
- **Show**: Detailed view with related cities and airports
- **Edit/Update**: Form-based editing
- **Delete**: Soft delete with confirmation

### City Controller Features
- **Index**: Filterable by country and status
- **Create/Store**: Country selection and location data
- **Show**: Airport listings and quick actions
- **Edit/Update**: Full CRUD operations

### Airport Controller Features
- **Index**: Advanced filtering by country, city, status
- **Create/Store**: Hierarchical location selection
- **Show**: Detailed airport information
- **Edit/Update**: Complete airport management

## Admin Interface

### Countries Management
```php
// DataTables columns
- ID
- Country Name (with flag if available)
- ISO Codes (2-letter and 3-letter)
- Phone Code (+880)
- Currency (BDT - ৳)
- Cities Count
- Status Badge
- Created Date
- Actions (View, Edit, Delete)
```

### Cities Management
```php
// DataTables columns
- ID
- City Name
- Country
- Airports Count
- Status Badge (Active/Inactive)
- Special Badges (Capital, Popular)
- Created Date
- Actions (View, Edit, Delete)
```

### Airports Management
```php
// DataTables columns
- ID
- Airport Name
- IATA Code
- City
- Country
- Type (International/Domestic)
- Status Badge
- Created Date
- Actions (View, Edit, Delete)
```

## API Endpoints

### Countries API
```php
GET    /api/countries              // List all countries
GET    /api/countries/{id}         // Get country details
GET    /api/countries/{id}/cities  // Get cities in country
POST   /api/countries              // Create country (admin only)
PUT    /api/countries/{id}         // Update country (admin only)
DELETE /api/countries/{id}         // Delete country (admin only)
```

### Cities API
```php
GET    /api/cities                 // List all cities
GET    /api/cities/{id}            // Get city details
GET    /api/cities/{id}/airports   // Get airports in city
POST   /api/cities                 // Create city (admin only)
PUT    /api/cities/{id}            // Update city (admin only)
DELETE /api/cities/{id}            // Delete city (admin only)
```

### Airports API
```php
GET    /api/airports               // List all airports
GET    /api/airports/{id}          // Get airport details
GET    /api/airports/search        // Search airports by code/name
POST   /api/airports               // Create airport (admin only)
PUT    /api/airports/{id}          // Update airport (admin only)
DELETE /api/airports/{id}          // Delete airport (admin only)
```

## Data Seeding

### Sample Data Structure
```php
// Countries (10 records)
- Bangladesh (BD, BGD, +880, BDT, ৳)
- India (IN, IND, +91, INR, ₹)
- United States (US, USA, +1, USD, $)
- United Kingdom (GB, GBR, +44, GBP, £)
- Thailand (TH, THA, +66, THB, ฿)
- Singapore (SG, SGP, +65, SGD, S$)
- Malaysia (MY, MYS, +60, MYR, RM)
- Indonesia (ID, IDN, +62, IDR, Rp)
- Japan (JP, JPN, +81, JPY, ¥)
- South Korea (KR, KOR, +82, KRW, ₩)

// Cities (15 records)
- Dhaka, Bangladesh (Capital, Popular)
- Chittagong, Bangladesh
- Sylhet, Bangladesh (Popular)
- New Delhi, India (Capital)
- Mumbai, India (Popular)
- Bangkok, Thailand (Capital, Popular)
- Singapore, Singapore (Capital, Popular)
- Kuala Lumpur, Malaysia (Capital)
- New York, United States (Popular)
- London, United Kingdom (Capital, Popular)
- Tokyo, Japan (Capital, Popular)
- Seoul, South Korea (Capital)
- Jakarta, Indonesia (Capital)
- Denpasar, Indonesia (Popular)
- Phuket, Thailand (Popular)

// Airports (8 records)
- Hazrat Shahjalal International Airport (DAC) - Dhaka
- Shah Amanat International Airport (CGP) - Chittagong
- Osmani International Airport (ZYL) - Sylhet
- Suvarnabhumi Airport (BKK) - Bangkok
- Changi Airport (SIN) - Singapore
- Kuala Lumpur International Airport (KUL) - Kuala Lumpur
- John F. Kennedy International Airport (JFK) - New York
- Heathrow Airport (LHR) - London
```

## Usage in Other Modules

### Flight Module Integration
```php
// Flights operate between airports
Flight::where('departure_airport_id', $airportId)
      ->where('arrival_airport_id', $destinationId)
      ->get();

// Airlines are based in countries
Airline::where('country_id', $countryId)->get();
```

### Hotel Module Integration
```php
// Hotels are located in cities
Hotel::where('city_id', $cityId)->get();

// Search hotels by country
Hotel::whereHas('city', function($query) use ($countryId) {
    $query->where('country_id', $countryId);
})->get();
```

### Tour Module Integration
```php
// Tours visit specific destinations
Tour::whereHas('destinations', function($query) use ($cityId) {
    $query->where('city_id', $cityId);
})->get();
```

## Performance Considerations

### Database Indexing
```sql
-- Performance indexes
CREATE INDEX idx_cities_country_id ON cities(country_id);
CREATE INDEX idx_cities_active ON cities(is_active);
CREATE INDEX idx_airports_city_id ON airports(city_id);
CREATE INDEX idx_airports_code ON airports(code);
CREATE INDEX idx_countries_active ON countries(is_active);
```

### Caching Strategy
```php
// Cache frequently accessed data
Cache::remember('active_countries', 3600, function () {
    return Country::active()->ordered()->get();
});

Cache::remember('popular_cities', 3600, function () {
    return City::popular()->with('country')->get();
});
```

## Validation Rules

### Country Validation
```php
'name' => 'required|string|max:255',
'code' => 'required|string|size:2|unique:countries,code',
'code_3' => 'required|string|size:3|unique:countries,code_3',
'phone_code' => 'nullable|string|max:10',
'currency_code' => 'nullable|string|size:3',
'latitude' => 'nullable|numeric|between:-90,90',
'longitude' => 'nullable|numeric|between:-180,180',
```

### City Validation
```php
'country_id' => 'required|exists:countries,id',
'name' => 'required|string|max:255',
'latitude' => 'nullable|numeric|between:-90,90',
'longitude' => 'nullable|numeric|between:-180,180',
'population' => 'nullable|integer|min:0',
```

### Airport Validation
```php
'country_id' => 'required|exists:countries,id',
'city_id' => 'required|exists:cities,id',
'name' => 'required|string|max:255',
'code' => 'required|string|size:3|unique:airports,code',
'icao_code' => 'nullable|string|size:4',
'elevation' => 'nullable|integer',
```

## Testing

### Feature Tests
```php
// Test country creation
test('can create country with valid data');
test('validates required fields');
test('ensures unique codes');

// Test city relationships
test('city belongs to country');
test('can filter cities by country');

// Test airport operations
test('airport requires valid city and country');
test('airport code must be unique');
```

## Next Steps

- **[Flight Module](./03-flight-module.md)** - Flight operations using airports
- **[Hotel Module](./04-hotel-module.md)** - Hotels in cities
- **[Tour Module](./05-tour-module.md)** - Tours visiting destinations

---

**Related Documentation:**
- [Architecture Overview](./01-architecture-overview.md)
- [Database Schema](./08-database-schema.md)
- [Admin Interface](./10-admin-interface.md)