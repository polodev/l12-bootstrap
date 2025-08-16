# Hotel Module Documentation

## Overview

The Hotel module manages accommodation services including hotels, room types, and inventory management. It provides comprehensive hotel booking capabilities with real-time availability tracking, pricing management, and amenity handling.

## Module Structure

```
app-modules/hotel/
├── src/
│   ├── Models/
│   │   ├── Hotel.php
│   │   ├── Room.php
│   │   └── RoomInventory.php
│   ├── Http/Controllers/
│   │   ├── HotelController.php
│   │   ├── RoomController.php
│   │   └── RoomInventoryController.php
│   └── Providers/
│       └── HotelServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Hotels Table
```sql
CREATE TABLE hotels (
    id BIGINT PRIMARY KEY,
    city_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    description TEXT,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(255),
    website VARCHAR(255),
    latitude DECIMAL(8,6),
    longitude DECIMAL(9,6),
    star_rating INTEGER CHECK (star_rating >= 1 AND star_rating <= 5),
    check_in_time TIME DEFAULT '14:00',
    check_out_time TIME DEFAULT '12:00',
    total_rooms INTEGER DEFAULT 0,
    
    -- Amenities (stored as JSON or separate pivot table)
    amenities JSON,                       -- ["wifi", "pool", "gym", "spa"]
    
    -- Policies
    pet_policy ENUM('allowed', 'not_allowed', 'charges_apply') DEFAULT 'not_allowed',
    smoking_policy ENUM('allowed', 'not_allowed', 'designated_areas') DEFAULT 'not_allowed',
    cancellation_policy TEXT,
    
    -- Ratings and reviews
    average_rating DECIMAL(3,2) DEFAULT 0.00,
    total_reviews INTEGER DEFAULT 0,
    
    -- Status and visibility
    is_active BOOLEAN DEFAULT true,
    is_featured BOOLEAN DEFAULT false,
    position INTEGER DEFAULT 0,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (city_id) REFERENCES cities(id),
    
    INDEX idx_city_id (city_id),
    INDEX idx_star_rating (star_rating),
    INDEX idx_featured (is_featured),
    FULLTEXT KEY ft_name_description (name, description)
);
```

### Rooms Table
```sql
CREATE TABLE rooms (
    id BIGINT PRIMARY KEY,
    hotel_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,            -- "Deluxe Ocean View"
    type ENUM('standard', 'deluxe', 'suite', 'presidential', 'family', 'connecting') NOT NULL,
    description TEXT,
    size_sqm INTEGER,                      -- Room size in square meters
    max_occupancy INTEGER NOT NULL,        -- Maximum guests
    bed_type VARCHAR(100),                 -- "King", "Queen", "Twin"
    bed_count INTEGER DEFAULT 1,
    
    -- Room features
    has_balcony BOOLEAN DEFAULT false,
    has_sea_view BOOLEAN DEFAULT false,
    has_city_view BOOLEAN DEFAULT false,
    has_mountain_view BOOLEAN DEFAULT false,
    has_wifi BOOLEAN DEFAULT true,
    has_ac BOOLEAN DEFAULT true,
    has_tv BOOLEAN DEFAULT true,
    has_minibar BOOLEAN DEFAULT false,
    has_safe BOOLEAN DEFAULT false,
    has_bathtub BOOLEAN DEFAULT false,
    has_shower BOOLEAN DEFAULT true,
    
    -- Pricing
    base_price DECIMAL(10,2) NOT NULL,     -- Base price per night
    weekend_price DECIMAL(10,2),           -- Weekend surcharge
    holiday_price DECIMAL(10,2),           -- Holiday pricing
    
    -- Room management
    room_count INTEGER NOT NULL,           -- Number of this room type
    is_active BOOLEAN DEFAULT true,
    position INTEGER DEFAULT 0,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (hotel_id) REFERENCES hotels(id),
    
    INDEX idx_hotel_type (hotel_id, type),
    INDEX idx_occupancy (max_occupancy),
    INDEX idx_price_range (base_price)
);
```

### Room Inventory Table
```sql
CREATE TABLE room_inventories (
    id BIGINT PRIMARY KEY,
    room_id BIGINT NOT NULL,
    date DATE NOT NULL,
    available_rooms INTEGER NOT NULL,
    booked_rooms INTEGER DEFAULT 0,
    blocked_rooms INTEGER DEFAULT 0,       -- Maintenance/cleaning
    current_price DECIMAL(10,2) NOT NULL,
    min_stay_nights INTEGER DEFAULT 1,
    max_stay_nights INTEGER DEFAULT 30,
    rate_plan ENUM('room_only', 'standard', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive') DEFAULT 'standard',
    
    -- Booking restrictions
    booking_deadline DATETIME,             -- Last booking time
    cancellation_deadline DATETIME,       -- Free cancellation deadline
    
    -- Special rates
    is_non_refundable BOOLEAN DEFAULT false,
    early_bird_discount DECIMAL(5,2) DEFAULT 0.00,
    last_minute_discount DECIMAL(5,2) DEFAULT 0.00,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (room_id) REFERENCES rooms(id),
    
    UNIQUE KEY unique_room_date (room_id, date),
    INDEX idx_date_availability (date, available_rooms),
    INDEX idx_room_date_range (room_id, date)
);
```

## Model Relationships

### Hotel Model
```php
class Hotel extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'city_id', 'name', 'slug', 'description', 'address',
        'phone', 'email', 'website', 'latitude', 'longitude',
        'star_rating', 'check_in_time', 'check_out_time', 'total_rooms',
        'amenities', 'pet_policy', 'smoking_policy', 'cancellation_policy',
        'average_rating', 'total_reviews', 'is_active', 'is_featured', 'position'
    ];

    protected $casts = [
        'amenities' => 'array',
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
    ];

    // Relationships
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    
    public function activeRooms(): HasMany
    {
        return $this->hasMany(Room::class)->where('is_active', true);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    public function scopeByStarRating($query, int $rating)
    {
        return $query->where('star_rating', $rating);
    }
    
    public function scopeInCity($query, int $cityId)
    {
        return $query->where('city_id', $cityId);
    }
    
    // Methods
    public function getLowestPrice(Carbon $checkIn, Carbon $checkOut): ?float
    {
        return $this->rooms()
                   ->with(['inventories' => function ($query) use ($checkIn, $checkOut) {
                       $query->whereBetween('date', [$checkIn, $checkOut])
                             ->where('available_rooms', '>', 0);
                   }])
                   ->get()
                   ->flatMap->inventories
                   ->min('current_price');
    }
    
    public function hasAvailability(Carbon $checkIn, Carbon $checkOut, int $rooms = 1): bool
    {
        return $this->rooms()
                   ->whereHas('inventories', function ($query) use ($checkIn, $checkOut, $rooms) {
                       $query->whereBetween('date', [$checkIn, $checkOut])
                             ->where('available_rooms', '>=', $rooms);
                   })
                   ->exists();
    }
    
    // Accessors
    public function getStarRatingBadgeAttribute(): string
    {
        $stars = str_repeat('★', $this->star_rating);
        $empty = str_repeat('☆', 5 - $this->star_rating);
        return "<span class='text-yellow-500'>{$stars}</span><span class='text-gray-300'>{$empty}</span>";
    }
    
    public function getStatusBadgeAttribute(): string
    {
        $color = $this->is_active ? 'green' : 'red';
        $status = $this->is_active ? 'Active' : 'Inactive';
        return "<span class='badge badge-{$color}'>{$status}</span>";
    }
}
```

### Room Model
```php
class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'name', 'type', 'description', 'size_sqm',
        'max_occupancy', 'bed_type', 'bed_count',
        'has_balcony', 'has_sea_view', 'has_city_view', 'has_mountain_view',
        'has_wifi', 'has_ac', 'has_tv', 'has_minibar', 'has_safe',
        'has_bathtub', 'has_shower', 'base_price', 'weekend_price',
        'holiday_price', 'room_count', 'is_active', 'position'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'weekend_price' => 'decimal:2',
        'holiday_price' => 'decimal:2',
        'has_balcony' => 'boolean',
        'has_sea_view' => 'boolean',
        'has_city_view' => 'boolean',
        'has_mountain_view' => 'boolean',
        'has_wifi' => 'boolean',
        'has_ac' => 'boolean',
        'has_tv' => 'boolean',
        'has_minibar' => 'boolean',
        'has_safe' => 'boolean',
        'has_bathtub' => 'boolean',
        'has_shower' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function inventories(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
    
    public function scopeByOccupancy($query, int $occupancy)
    {
        return $query->where('max_occupancy', '>=', $occupancy);
    }
    
    // Methods
    public function getAvailabilityForPeriod(Carbon $checkIn, Carbon $checkOut): Collection
    {
        return $this->inventories()
                   ->whereBetween('date', [$checkIn, $checkOut])
                   ->where('available_rooms', '>', 0)
                   ->get();
    }
    
    public function calculatePrice(Carbon $checkIn, Carbon $checkOut): float
    {
        $totalPrice = 0;
        $currentDate = $checkIn->copy();
        
        while ($currentDate->lt($checkOut)) {
            $inventory = $this->inventories()
                             ->where('date', $currentDate->toDateString())
                             ->first();
            
            $price = $inventory ? $inventory->current_price : $this->base_price;
            
            // Apply weekend/holiday pricing if no inventory
            if (!$inventory) {
                if ($currentDate->isWeekend() && $this->weekend_price) {
                    $price = $this->weekend_price;
                }
                // Add holiday pricing logic here
            }
            
            $totalPrice += $price;
            $currentDate->addDay();
        }
        
        return $totalPrice;
    }
    
    // Accessors
    public function getTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }
    
    public function getViewTypesAttribute(): array
    {
        $views = [];
        if ($this->has_sea_view) $views[] = 'Sea View';
        if ($this->has_city_view) $views[] = 'City View';
        if ($this->has_mountain_view) $views[] = 'Mountain View';
        
        return $views;
    }
    
    public function getAmenitiesListAttribute(): array
    {
        $amenities = [];
        if ($this->has_wifi) $amenities[] = 'WiFi';
        if ($this->has_ac) $amenities[] = 'Air Conditioning';
        if ($this->has_tv) $amenities[] = 'TV';
        if ($this->has_minibar) $amenities[] = 'Minibar';
        if ($this->has_safe) $amenities[] = 'Safe';
        if ($this->has_balcony) $amenities[] = 'Balcony';
        if ($this->has_bathtub) $amenities[] = 'Bathtub';
        
        return $amenities;
    }
}
```

### RoomInventory Model
```php
class RoomInventory extends Model
{
    protected $fillable = [
        'room_id', 'date', 'available_rooms', 'booked_rooms', 'blocked_rooms',
        'current_price', 'min_stay_nights', 'max_stay_nights', 'rate_plan',
        'booking_deadline', 'cancellation_deadline', 'is_non_refundable',
        'early_bird_discount', 'last_minute_discount'
    ];

    protected $casts = [
        'date' => 'date',
        'current_price' => 'decimal:2',
        'early_bird_discount' => 'decimal:2',
        'last_minute_discount' => 'decimal:2',
        'booking_deadline' => 'datetime',
        'cancellation_deadline' => 'datetime',
        'is_non_refundable' => 'boolean',
    ];

    // Relationships
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    
    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('available_rooms', '>', 0)
                    ->where('booking_deadline', '>', now());
    }
    
    public function scopeForDateRange($query, Carbon $start, Carbon $end)
    {
        return $query->whereBetween('date', [$start, $end]);
    }
    
    // Methods
    public function isBookable(int $rooms = 1): bool
    {
        return $this->available_rooms >= $rooms 
            && $this->booking_deadline > now();
    }
    
    public function reserveRooms(int $count): bool
    {
        if (!$this->isBookable($count)) {
            return false;
        }
        
        $this->decrement('available_rooms', $count);
        $this->increment('booked_rooms', $count);
        
        return true;
    }
    
    public function getEffectivePrice(): float
    {
        $price = $this->current_price;
        
        // Apply early bird discount
        if ($this->early_bird_discount > 0) {
            $price *= (1 - $this->early_bird_discount / 100);
        }
        
        // Apply last minute discount
        if ($this->last_minute_discount > 0 && $this->date->diffInDays(now()) <= 7) {
            $price *= (1 - $this->last_minute_discount / 100);
        }
        
        return $price;
    }
}
```

## Controllers

### Hotel Controller Features
```php
class HotelController extends Controller
{
    // Admin CRUD operations
    public function index()           // DataTables listing
    public function indexJson()       // AJAX data for DataTables
    public function create()          // Create form with city selection
    public function store()           // Save new hotel
    public function show()            // Hotel details with rooms
    public function edit()            // Edit form
    public function update()          // Update hotel
    public function destroy()         // Delete hotel
    
    // Public API
    public function search()          // Hotel search with filters
    public function availability()    // Check availability for dates
    public function details()         // Public hotel details
}
```

### Room Controller Features
```php
class RoomController extends Controller
{
    // Admin CRUD operations
    public function index()           // Rooms by hotel
    public function indexJson()       // AJAX data
    public function create()          // Create room form
    public function store()           // Save new room
    public function show()            // Room details with inventory
    public function edit()            // Edit room
    public function update()          // Update room
    public function destroy()         // Delete room
    
    // Inventory management
    public function manageInventory() // Bulk inventory management
    public function updatePricing()   // Bulk pricing updates
}
```

### RoomInventory Controller Features
```php
class RoomInventoryController extends Controller
{
    // Inventory management
    public function index()           // Calendar view of inventory
    public function indexJson()       // AJAX data for calendar
    public function bulkUpdate()      // Update multiple dates
    public function generateInventory() // Auto-generate future inventory
    
    // Availability operations
    public function checkAvailability() // Real-time availability check
    public function blockDates()        // Block dates for maintenance
    public function openDates()         // Open blocked dates
}
```

## Admin Interface

### Hotels Management
```php
// DataTables columns
- ID
- Hotel Name (with star rating)
- City, Country
- Star Rating (★★★★☆)
- Total Rooms
- Average Rating (4.2/5.0)
- Status Badge (Active/Inactive)
- Featured Badge
- Actions (View, Edit, Manage Rooms, Delete)

// Advanced filters
- City/Country filter
- Star rating filter (1-5 stars)
- Featured hotels only
- Active/Inactive status
- Price range filter
- Amenities filter (WiFi, Pool, Gym, etc.)
```

### Rooms Management
```php
// DataTables columns
- Room ID
- Room Name & Type
- Hotel Name
- Max Occupancy (2 adults)
- Base Price ($120/night)
- Room Count (5 rooms)
- Features (Sea View, Balcony, WiFi)
- Status Badge
- Actions (View, Edit, Manage Inventory, Delete)

// Filters
- Hotel filter
- Room type filter
- Occupancy filter
- Price range
- View type (Sea, City, Mountain)
- Active/Inactive status
```

### Inventory Management
```php
// Calendar interface showing:
- Monthly/weekly calendar view
- Available rooms per date
- Current pricing per date
- Booking status indicators
- Quick edit functionality
- Bulk operations (pricing, availability)

// Bulk operations
- Set pricing for date ranges
- Block/unblock dates
- Copy inventory patterns
- Generate future inventory
- Import/export inventory data
```

## API Endpoints

### Hotels API
```php
GET    /api/hotels                 // List hotels with filters
GET    /api/hotels/{id}            // Get hotel details
GET    /api/hotels/search          // Advanced hotel search
GET    /api/hotels/{id}/rooms      // Get hotel rooms
GET    /api/hotels/{id}/availability // Check availability
POST   /api/hotels                 // Create hotel (admin)
PUT    /api/hotels/{id}            // Update hotel (admin)
DELETE /api/hotels/{id}            // Delete hotel (admin)
```

### Rooms API
```php
GET    /api/rooms                  // List rooms with filters
GET    /api/rooms/{id}             // Get room details
GET    /api/rooms/{id}/inventory   // Get room inventory
GET    /api/rooms/{id}/pricing     // Get pricing for dates
POST   /api/rooms                  // Create room (admin)
PUT    /api/rooms/{id}             // Update room (admin)
DELETE /api/rooms/{id}             // Delete room (admin)
```

### Inventory API
```php
GET    /api/inventory              // Get inventory data
GET    /api/inventory/availability // Check availability
POST   /api/inventory/reserve      // Reserve rooms
POST   /api/inventory              // Create/update inventory (admin)
PUT    /api/inventory/{id}         // Update inventory (admin)
DELETE /api/inventory/{id}         // Delete inventory (admin)
```

## Business Logic

### Hotel Search Service
```php
class HotelSearchService
{
    public function searchHotels(array $criteria): Collection
    {
        return Hotel::query()
            ->with(['city.country', 'rooms'])
            ->when($criteria['city_id'] ?? null, function ($query, $cityId) {
                $query->where('city_id', $cityId);
            })
            ->when($criteria['star_rating'] ?? null, function ($query, $rating) {
                $query->where('star_rating', '>=', $rating);
            })
            ->when($criteria['amenities'] ?? null, function ($query, $amenities) {
                foreach ($amenities as $amenity) {
                    $query->whereJsonContains('amenities', $amenity);
                }
            })
            ->when($criteria['price_range'] ?? null, function ($query, $priceRange) {
                $query->whereHas('rooms.inventories', function ($q) use ($priceRange) {
                    $q->whereBetween('current_price', [$priceRange['min'], $priceRange['max']]);
                });
            })
            ->where('is_active', true)
            ->get()
            ->filter(function ($hotel) use ($criteria) {
                if (isset($criteria['check_in']) && isset($criteria['check_out'])) {
                    return $hotel->hasAvailability(
                        Carbon::parse($criteria['check_in']),
                        Carbon::parse($criteria['check_out']),
                        $criteria['rooms'] ?? 1
                    );
                }
                return true;
            });
    }
}
```

### Inventory Management Service
```php
class InventoryManagementService
{
    public function generateInventory(Room $room, Carbon $startDate, Carbon $endDate): int
    {
        $generated = 0;
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $existing = RoomInventory::where('room_id', $room->id)
                                   ->where('date', $currentDate->toDateString())
                                   ->exists();
            
            if (!$existing) {
                RoomInventory::create([
                    'room_id' => $room->id,
                    'date' => $currentDate->toDateString(),
                    'available_rooms' => $room->room_count,
                    'current_price' => $this->calculatePrice($room, $currentDate),
                    'booking_deadline' => $currentDate->copy()->subHours(2),
                    'cancellation_deadline' => $currentDate->copy()->subHours(24),
                ]);
                
                $generated++;
            }
            
            $currentDate->addDay();
        }
        
        return $generated;
    }
    
    private function calculatePrice(Room $room, Carbon $date): float
    {
        $basePrice = $room->base_price;
        
        // Weekend pricing
        if ($date->isWeekend() && $room->weekend_price) {
            return $room->weekend_price;
        }
        
        // Holiday pricing
        if ($this->isHoliday($date) && $room->holiday_price) {
            return $room->holiday_price;
        }
        
        // Seasonal adjustments
        return $basePrice * $this->getSeasonalMultiplier($date);
    }
}
```

### Pricing Service
```php
class HotelPricingService
{
    public function calculateTotalPrice(Room $room, Carbon $checkIn, Carbon $checkOut, int $rooms = 1): array
    {
        $nights = $checkIn->diffInDays($checkOut);
        $roomPrice = $room->calculatePrice($checkIn, $checkOut);
        $subtotal = $roomPrice * $rooms;
        
        // Calculate taxes
        $taxes = $this->calculateTaxes($subtotal, $room->hotel->city);
        
        // Calculate fees
        $fees = $this->calculateFees($subtotal, $rooms, $nights);
        
        $total = $subtotal + $taxes + $fees;
        
        return [
            'nights' => $nights,
            'rooms' => $rooms,
            'room_price_per_night' => $roomPrice / $nights,
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'fees' => $fees,
            'total' => $total,
            'breakdown' => $this->getPriceBreakdown($room, $checkIn, $checkOut),
        ];
    }
}
```

## Data Seeding

### Sample Hotels Data
```php
// Hotels (5 records)
$hotels = [
    [
        'name' => 'The Peninsula Dhaka',
        'city_id' => 1, // Dhaka
        'star_rating' => 5,
        'description' => 'Luxury hotel in the heart of Dhaka',
        'amenities' => ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'concierge'],
        'total_rooms' => 120,
        'is_featured' => true,
    ],
    [
        'name' => 'Bangkok Grand Palace Hotel',
        'city_id' => 6, // Bangkok
        'star_rating' => 4,
        'description' => 'Modern hotel near Grand Palace',
        'amenities' => ['wifi', 'pool', 'gym', 'restaurant', 'bar'],
        'total_rooms' => 200,
    ],
    // ... more hotels
];
```

### Sample Rooms Data
```php
// Rooms (15 records across hotels)
$rooms = [
    [
        'hotel_id' => 1,
        'name' => 'Deluxe City View',
        'type' => 'deluxe',
        'max_occupancy' => 2,
        'bed_type' => 'King',
        'base_price' => 150.00,
        'room_count' => 20,
        'has_city_view' => true,
        'has_wifi' => true,
        'has_ac' => true,
    ],
    // ... more rooms
];
```

## Integration with Other Modules

### Location Module Integration
```php
// Hotels are located in cities
$hotel = Hotel::with('city.country')->find($id);

// Search hotels by location
$hotels = Hotel::whereHas('city', function ($query) use ($countryId) {
    $query->where('country_id', $countryId);
})->get();
```

### Booking Module Integration
```php
// Bookings can include room reservations
class Booking extends Model
{
    public function hotelReservations()
    {
        return $this->morphToMany(RoomInventory::class, 'bookable')
                   ->withPivot(['quantity', 'unit_price', 'total_price']);
    }
}
```

## Performance Considerations

### Database Indexing
```sql
-- Hotel search optimization
CREATE INDEX idx_hotels_city_rating ON hotels(city_id, star_rating);
CREATE INDEX idx_hotels_featured ON hotels(is_featured, is_active);
CREATE INDEX idx_rooms_hotel_type ON rooms(hotel_id, type);
CREATE INDEX idx_inventory_date_availability ON room_inventories(date, available_rooms);
CREATE INDEX idx_inventory_room_date ON room_inventories(room_id, date);
```

### Caching Strategy
```php
// Cache hotel search results
Cache::remember("hotels_city_{$cityId}", 1800, function () use ($cityId) {
    return Hotel::inCity($cityId)->with('rooms')->get();
});

// Cache popular hotels
Cache::remember('featured_hotels', 3600, function () {
    return Hotel::featured()->with(['city', 'rooms'])->get();
});
```

## Validation Rules

### Hotel Validation
```php
'city_id' => 'required|exists:cities,id',
'name' => 'required|string|max:255',
'star_rating' => 'required|integer|between:1,5',
'check_in_time' => 'required|date_format:H:i',
'check_out_time' => 'required|date_format:H:i',
'total_rooms' => 'required|integer|min:1',
'amenities' => 'nullable|array',
'amenities.*' => 'string|in:wifi,pool,gym,spa,restaurant,bar,concierge,parking',
```

### Room Validation
```php
'hotel_id' => 'required|exists:hotels,id',
'name' => 'required|string|max:255',
'type' => 'required|in:standard,deluxe,suite,presidential,family,connecting',
'max_occupancy' => 'required|integer|min:1|max:10',
'base_price' => 'required|numeric|min:0',
'room_count' => 'required|integer|min:1',
```

### Inventory Validation
```php
'room_id' => 'required|exists:rooms,id',
'date' => 'required|date|after_or_equal:today',
'available_rooms' => 'required|integer|min:0',
'current_price' => 'required|numeric|min:0',
'min_stay_nights' => 'nullable|integer|min:1',
'max_stay_nights' => 'nullable|integer|max:365',
```

## Next Steps

- **[Tour Module](./05-tour-module.md)** - Package tours and activities
- **[Booking Module](./06-booking-module.md)** - Integration with bookings
- **[Payment Module](./07-payment-module.md)** - Hotel payment processing

---

**Related Documentation:**
- [Location Module](./02-location-module.md)
- [Database Schema](./08-database-schema.md)
- [API Documentation](./09-api-documentation.md)