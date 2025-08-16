# Flight Module Documentation

## Overview

The Flight module manages airline operations, flight schedules, and seat inventory. It provides comprehensive flight booking capabilities with real-time availability tracking and pricing management.

## Module Structure

```
app-modules/flight/
├── src/
│   ├── Models/
│   │   ├── Airline.php
│   │   ├── Flight.php
│   │   └── FlightSchedule.php
│   ├── Http/Controllers/
│   │   ├── AirlineController.php
│   │   ├── FlightController.php
│   │   └── FlightScheduleController.php
│   └── Providers/
│       └── FlightServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Airlines Table
```sql
CREATE TABLE airlines (
    id BIGINT PRIMARY KEY,
    country_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    iata_code VARCHAR(2) UNIQUE,          -- BG, AA, BA
    icao_code VARCHAR(3) UNIQUE,          -- BBC, AAL, BAW
    callsign VARCHAR(255),                -- "Biman Bangladesh"
    logo_url VARCHAR(255),                -- Airline logo
    website VARCHAR(255),
    headquarters VARCHAR(255),
    fleet_size INTEGER DEFAULT 0,
    founded_year INTEGER,
    description TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (country_id) REFERENCES countries(id)
);
```

### Flights Table
```sql
CREATE TABLE flights (
    id BIGINT PRIMARY KEY,
    airline_id BIGINT NOT NULL,
    departure_airport_id BIGINT NOT NULL,
    arrival_airport_id BIGINT NOT NULL,
    flight_number VARCHAR(10) NOT NULL,   -- BG101, AA123
    aircraft_type VARCHAR(100),           -- Boeing 737, Airbus A320
    duration_minutes INTEGER NOT NULL,    -- Flight duration
    distance_km INTEGER,                  -- Distance in kilometers
    base_price DECIMAL(10,2) NOT NULL,   -- Base ticket price
    business_price DECIMAL(10,2),        -- Business class price
    first_price DECIMAL(10,2),           -- First class price
    total_seats INTEGER NOT NULL,
    business_seats INTEGER DEFAULT 0,
    first_seats INTEGER DEFAULT 0,
    meal_service BOOLEAN DEFAULT false,
    wifi_available BOOLEAN DEFAULT false,
    entertainment BOOLEAN DEFAULT false,
    baggage_allowance INTEGER DEFAULT 20, -- kg
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (airline_id) REFERENCES airlines(id),
    FOREIGN KEY (departure_airport_id) REFERENCES airports(id),
    FOREIGN KEY (arrival_airport_id) REFERENCES airports(id),
    
    UNIQUE KEY unique_flight (airline_id, flight_number)
);
```

### Flight Schedules Table
```sql
CREATE TABLE flight_schedules (
    id BIGINT PRIMARY KEY,
    flight_id BIGINT NOT NULL,
    departure_date DATE NOT NULL,
    departure_time TIME NOT NULL,
    arrival_date DATE NOT NULL,
    arrival_time TIME NOT NULL,
    departure_terminal VARCHAR(10),       -- Terminal 1, 2, etc.
    arrival_terminal VARCHAR(10),
    gate VARCHAR(10),                     -- Gate A12, B5
    status ENUM('scheduled', 'boarding', 'departed', 'arrived', 'delayed', 'cancelled') DEFAULT 'scheduled',
    delay_minutes INTEGER DEFAULT 0,
    available_seats INTEGER NOT NULL,
    available_business INTEGER DEFAULT 0,
    available_first INTEGER DEFAULT 0,
    current_price DECIMAL(10,2) NOT NULL,
    business_current_price DECIMAL(10,2),
    first_current_price DECIMAL(10,2),
    booking_deadline DATETIME,            -- Last booking time
    check_in_deadline DATETIME,           -- Check-in deadline
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (flight_id) REFERENCES flights(id),
    
    INDEX idx_departure_date (departure_date),
    INDEX idx_status (status),
    INDEX idx_routes (flight_id, departure_date)
);
```

## Model Relationships

### Airline Model
```php
class Airline extends Model
{
    protected $fillable = [
        'country_id', 'name', 'iata_code', 'icao_code', 'callsign',
        'logo_url', 'website', 'headquarters', 'fleet_size',
        'founded_year', 'description', 'is_active'
    ];

    // Relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->iata_code ? "{$this->name} ({$this->iata_code})" : $this->name;
    }
}
```

### Flight Model
```php
class Flight extends Model
{
    protected $fillable = [
        'airline_id', 'departure_airport_id', 'arrival_airport_id',
        'flight_number', 'aircraft_type', 'duration_minutes',
        'distance_km', 'base_price', 'business_price', 'first_price',
        'total_seats', 'business_seats', 'first_seats',
        'meal_service', 'wifi_available', 'entertainment',
        'baggage_allowance', 'is_active'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'business_price' => 'decimal:2',
        'first_price' => 'decimal:2',
        'meal_service' => 'boolean',
        'wifi_available' => 'boolean',
        'entertainment' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }
    
    public function departureAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }
    
    public function arrivalAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }
    
    public function schedules(): HasMany
    {
        return $this->hasMany(FlightSchedule::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeRoute($query, $departure, $arrival)
    {
        return $query->where('departure_airport_id', $departure)
                    ->where('arrival_airport_id', $arrival);
    }
    
    // Accessors
    public function getFullFlightNumberAttribute()
    {
        return $this->airline->iata_code . $this->flight_number;
    }
    
    public function getRouteNameAttribute()
    {
        return $this->departureAirport->code . ' → ' . $this->arrivalAirport->code;
    }
    
    public function getDurationHoursAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        return sprintf('%dh %02dm', $hours, $minutes);
    }
}
```

### FlightSchedule Model
```php
class FlightSchedule extends Model
{
    protected $fillable = [
        'flight_id', 'departure_date', 'departure_time',
        'arrival_date', 'arrival_time', 'departure_terminal',
        'arrival_terminal', 'gate', 'status', 'delay_minutes',
        'available_seats', 'available_business', 'available_first',
        'current_price', 'business_current_price', 'first_current_price',
        'booking_deadline', 'check_in_deadline'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'arrival_date' => 'date',
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'current_price' => 'decimal:2',
        'business_current_price' => 'decimal:2',
        'first_current_price' => 'decimal:2',
        'booking_deadline' => 'datetime',
        'check_in_deadline' => 'datetime',
    ];

    // Relationships
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
    
    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('available_seats', '>', 0)
                    ->where('status', 'scheduled')
                    ->where('booking_deadline', '>', now());
    }
    
    public function scopeUpcoming($query)
    {
        return $query->where('departure_date', '>=', today());
    }
    
    // Methods
    public function isBookable(): bool
    {
        return $this->available_seats > 0 
            && $this->status === 'scheduled' 
            && $this->booking_deadline > now();
    }
    
    public function updateAvailability(string $class, int $seats): void
    {
        switch ($class) {
            case 'economy':
                $this->decrement('available_seats', $seats);
                break;
            case 'business':
                $this->decrement('available_business', $seats);
                break;
            case 'first':
                $this->decrement('available_first', $seats);
                break;
        }
    }
}
```

## Controllers

### Airline Controller Features
```php
class AirlineController extends Controller
{
    // Admin CRUD operations
    public function index()           // DataTables listing
    public function indexJson()       // AJAX data for DataTables
    public function create()          // Create form
    public function store()           // Save new airline
    public function show()            // Airline details with flights
    public function edit()            // Edit form
    public function update()          // Update airline
    public function destroy()         // Delete airline
    public function toggleActive()    // Toggle active status
}
```

### Flight Controller Features
```php
class FlightController extends Controller
{
    // Admin CRUD operations
    public function index()           // DataTables listing
    public function indexJson()       // AJAX data with filters
    public function create()          // Create form with dropdowns
    public function store()           // Save new flight
    public function show()            // Flight details with schedules
    public function edit()            // Edit form
    public function update()          // Update flight
    public function destroy()         // Delete flight
    public function duplicate()       // Duplicate flight
    
    // AJAX endpoints
    public function getAirportsByCountry() // Dynamic airport loading
}
```

### FlightSchedule Controller Features
```php
class FlightScheduleController extends Controller
{
    // Schedule management
    public function index()           // Schedule listing
    public function indexJson()       // AJAX data with date filters
    public function create()          // Create schedule form
    public function store()           // Save new schedule
    public function show()            // Schedule details
    public function edit()            // Edit schedule
    public function update()          // Update schedule
    public function destroy()         // Delete schedule
    public function updateStatus()    // Update flight status
    
    // Availability management
    public function checkAvailability() // Check seat availability
    public function updatePricing()     // Dynamic pricing updates
}
```

## Admin Interface

### Airlines Management
```php
// DataTables columns
- ID
- Airline Name (with logo)
- IATA/ICAO Codes (BG/BBC)
- Country
- Fleet Size
- Flights Count
- Status Badge
- Actions (View, Edit, Toggle Status, Delete)

// Filters
- Country filter
- Active/Inactive status
- Founded year range
- Search by name/code
```

### Flights Management
```php
// DataTables columns
- Flight Number (BG101)
- Airline
- Route (DAC → BKK)
- Aircraft Type
- Duration (2h 30m)
- Base Price ($299)
- Total Seats
- Status Badge
- Actions (View, Edit, Duplicate, Delete)

// Advanced filters
- Airline filter
- Route filters (departure/arrival airports)
- Aircraft type
- Price range
- Active/Inactive status
```

### Flight Schedules Management
```php
// DataTables columns
- Schedule ID
- Flight Number
- Route
- Departure Date/Time
- Arrival Date/Time
- Status (Scheduled, Boarding, Departed, etc.)
- Available Seats
- Current Price
- Actions (View, Edit, Update Status, Delete)

// Date-based filters
- Date range picker
- Status filter
- Route filter
- Availability filter
```

## API Endpoints

### Airlines API
```php
GET    /api/airlines               // List airlines
GET    /api/airlines/{id}          // Get airline details
GET    /api/airlines/{id}/flights  // Get airline flights
POST   /api/airlines               // Create airline (admin)
PUT    /api/airlines/{id}          // Update airline (admin)
DELETE /api/airlines/{id}          // Delete airline (admin)
```

### Flights API
```php
GET    /api/flights                // List flights with filters
GET    /api/flights/{id}           // Get flight details
GET    /api/flights/search         // Search flights by route/date
GET    /api/flights/{id}/schedules // Get flight schedules
POST   /api/flights                // Create flight (admin)
PUT    /api/flights/{id}           // Update flight (admin)
DELETE /api/flights/{id}           // Delete flight (admin)
```

### Flight Schedules API
```php
GET    /api/flight-schedules             // List schedules
GET    /api/flight-schedules/{id}        // Get schedule details
POST   /api/flight-schedules/availability // Check availability
POST   /api/flight-schedules             // Create schedule (admin)
PUT    /api/flight-schedules/{id}        // Update schedule (admin)
PATCH  /api/flight-schedules/{id}/status // Update status (admin)
DELETE /api/flight-schedules/{id}        // Delete schedule (admin)
```

## Business Logic

### Flight Search Algorithm
```php
class FlightSearchService
{
    public function searchFlights(array $criteria): Collection
    {
        return FlightSchedule::query()
            ->with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
            ->whereHas('flight', function ($query) use ($criteria) {
                $query->where('departure_airport_id', $criteria['departure_airport'])
                      ->where('arrival_airport_id', $criteria['arrival_airport'])
                      ->where('is_active', true);
            })
            ->where('departure_date', $criteria['departure_date'])
            ->where('available_seats', '>=', $criteria['passengers'])
            ->where('status', 'scheduled')
            ->where('booking_deadline', '>', now())
            ->orderBy('departure_time')
            ->get();
    }
}
```

### Dynamic Pricing
```php
class FlightPricingService
{
    public function calculatePrice(FlightSchedule $schedule, string $class = 'economy'): float
    {
        $basePrice = $this->getBasePrice($schedule, $class);
        
        // Demand-based pricing
        $demandMultiplier = $this->getDemandMultiplier($schedule);
        
        // Time-based pricing (closer to departure = higher price)
        $timeMultiplier = $this->getTimeMultiplier($schedule);
        
        // Seasonal pricing
        $seasonMultiplier = $this->getSeasonMultiplier($schedule);
        
        return $basePrice * $demandMultiplier * $timeMultiplier * $seasonMultiplier;
    }
    
    private function getDemandMultiplier(FlightSchedule $schedule): float
    {
        $occupancyRate = 1 - ($schedule->available_seats / $schedule->flight->total_seats);
        
        if ($occupancyRate > 0.8) return 1.5;
        if ($occupancyRate > 0.6) return 1.3;
        if ($occupancyRate > 0.4) return 1.1;
        
        return 1.0;
    }
}
```

### Inventory Management
```php
class FlightInventoryService
{
    public function reserveSeats(FlightSchedule $schedule, int $seats, string $class = 'economy'): bool
    {
        return DB::transaction(function () use ($schedule, $seats, $class) {
            $schedule->refresh(); // Ensure latest data
            
            if (!$this->hasAvailability($schedule, $seats, $class)) {
                return false;
            }
            
            $schedule->updateAvailability($class, $seats);
            
            // Log inventory change
            $this->logInventoryChange($schedule, $seats, $class);
            
            return true;
        });
    }
    
    private function hasAvailability(FlightSchedule $schedule, int $seats, string $class): bool
    {
        switch ($class) {
            case 'economy':
                return $schedule->available_seats >= $seats;
            case 'business':
                return $schedule->available_business >= $seats;
            case 'first':
                return $schedule->available_first >= $seats;
            default:
                return false;
        }
    }
}
```

## Data Seeding

### Sample Airlines Data
```php
// Airlines (6 records)
$airlines = [
    [
        'name' => 'Biman Bangladesh Airlines',
        'iata_code' => 'BG',
        'icao_code' => 'BBC',
        'country_id' => 1, // Bangladesh
        'fleet_size' => 18,
        'founded_year' => 1972,
    ],
    [
        'name' => 'Thai Airways',
        'iata_code' => 'TG',
        'icao_code' => 'THA',
        'country_id' => 5, // Thailand
        'fleet_size' => 103,
        'founded_year' => 1960,
    ],
    // ... more airlines
];
```

### Sample Flights Data
```php
// Flights (8 records)
$flights = [
    [
        'airline_id' => 1, // Biman
        'flight_number' => '101',
        'departure_airport_id' => 1, // DAC
        'arrival_airport_id' => 4,   // BKK
        'duration_minutes' => 150,
        'base_price' => 299.99,
        'total_seats' => 180,
        'aircraft_type' => 'Boeing 737-800',
    ],
    // ... more flights
];
```

## Integration with Other Modules

### Location Module Integration
```php
// Flights use airports from Location module
$flight = Flight::with([
    'departureAirport.city.country',
    'arrivalAirport.city.country'
])->find($id);
```

### Booking Module Integration
```php
// Bookings can include flight schedules
class Booking extends Model
{
    public function flightSchedules()
    {
        return $this->morphToMany(FlightSchedule::class, 'bookable');
    }
}
```

## Performance Considerations

### Database Indexing
```sql
-- Flight search optimization
CREATE INDEX idx_flights_route ON flights(departure_airport_id, arrival_airport_id);
CREATE INDEX idx_flights_airline ON flights(airline_id);
CREATE INDEX idx_schedules_search ON flight_schedules(departure_date, status, available_seats);
CREATE INDEX idx_schedules_flight_date ON flight_schedules(flight_id, departure_date);
```

### Caching Strategy
```php
// Cache popular routes
Cache::remember('popular_routes', 1800, function () {
    return Flight::select('departure_airport_id', 'arrival_airport_id')
                 ->groupBy('departure_airport_id', 'arrival_airport_id')
                 ->orderByRaw('COUNT(*) DESC')
                 ->limit(10)
                 ->get();
});

// Cache airline data
Cache::remember('active_airlines', 3600, function () {
    return Airline::active()->with('country')->get();
});
```

## Validation Rules

### Airline Validation
```php
'name' => 'required|string|max:255',
'iata_code' => 'nullable|string|size:2|unique:airlines,iata_code',
'icao_code' => 'nullable|string|size:3|unique:airlines,icao_code',
'country_id' => 'required|exists:countries,id',
'fleet_size' => 'nullable|integer|min:0',
'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
```

### Flight Validation
```php
'airline_id' => 'required|exists:airlines,id',
'departure_airport_id' => 'required|exists:airports,id',
'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
'flight_number' => 'required|string|max:10',
'duration_minutes' => 'required|integer|min:30|max:1440',
'base_price' => 'required|numeric|min:0',
'total_seats' => 'required|integer|min:1|max:850',
```

### Schedule Validation
```php
'flight_id' => 'required|exists:flights,id',
'departure_date' => 'required|date|after_or_equal:today',
'departure_time' => 'required|date_format:H:i',
'arrival_date' => 'required|date|after_or_equal:departure_date',
'arrival_time' => 'required|date_format:H:i',
'available_seats' => 'required|integer|min:0',
'current_price' => 'required|numeric|min:0',
```

## Next Steps

- **[Hotel Module](./04-hotel-module.md)** - Accommodation services
- **[Booking Module](./06-booking-module.md)** - Integration with bookings
- **[Payment Module](./07-payment-module.md)** - Flight payment processing

---

**Related Documentation:**
- [Location Module](./02-location-module.md)
- [Database Schema](./08-database-schema.md)
- [API Documentation](./09-api-documentation.md)