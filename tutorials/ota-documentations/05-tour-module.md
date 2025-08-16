# Tour Module Documentation

## Overview

The Tour module manages package tours, itineraries, and activities. It provides comprehensive tour booking capabilities with detailed itinerary management, activity scheduling, and capacity tracking for group tours and individual packages.

## Module Structure

```
app-modules/tour/
├── src/
│   ├── Models/
│   │   ├── Tour.php
│   │   ├── TourItinerary.php
│   │   └── TourActivity.php
│   ├── Http/Controllers/
│   │   ├── TourController.php
│   │   ├── TourItineraryController.php
│   │   └── TourActivityController.php
│   └── Providers/
│       └── TourServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Tours Table
```sql
CREATE TABLE tours (
    id BIGINT PRIMARY KEY,
    destination_city_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    description TEXT,
    short_description VARCHAR(500),
    
    -- Tour details
    duration_days INTEGER NOT NULL,
    duration_nights INTEGER NOT NULL,
    max_participants INTEGER NOT NULL,
    min_participants INTEGER DEFAULT 1,
    difficulty_level ENUM('easy', 'moderate', 'challenging', 'extreme') DEFAULT 'easy',
    tour_type ENUM('cultural', 'adventure', 'wildlife', 'beach', 'city', 'historical', 'religious', 'culinary') NOT NULL,
    
    -- Pricing
    price_per_person DECIMAL(10,2) NOT NULL,
    child_price DECIMAL(10,2),              -- Price for children (if different)
    single_supplement DECIMAL(10,2),        -- Additional cost for single occupancy
    group_discount_threshold INTEGER,       -- Minimum group size for discount
    group_discount_percentage DECIMAL(5,2), -- Discount percentage for groups
    
    -- Inclusions/Exclusions
    inclusions JSON,                        -- ["accommodation", "meals", "transport"]
    exclusions JSON,                        -- ["airfare", "visa", "insurance"]
    
    -- Tour features
    languages JSON,                         -- ["english", "bengali", "thai"]
    pickup_locations JSON,                  -- ["hotel", "airport", "city_center"]
    
    -- Booking policies
    advance_booking_days INTEGER DEFAULT 7, -- Minimum advance booking required
    cancellation_policy TEXT,
    refund_policy TEXT,
    
    -- Physical requirements
    min_age INTEGER DEFAULT 0,
    max_age INTEGER,
    fitness_requirements TEXT,
    medical_restrictions TEXT,
    
    -- Seasonal availability
    available_months JSON,                  -- [1,2,3,4,5,6,7,8,9,10,11,12] (months)
    best_time_to_visit VARCHAR(255),
    
    -- Status and ratings
    is_active BOOLEAN DEFAULT true,
    is_featured BOOLEAN DEFAULT false,
    average_rating DECIMAL(3,2) DEFAULT 0.00,
    total_reviews INTEGER DEFAULT 0,
    total_bookings INTEGER DEFAULT 0,
    
    -- SEO and marketing
    meta_title VARCHAR(255),
    meta_description TEXT,
    featured_image VARCHAR(255),
    gallery_images JSON,                    -- Array of image URLs
    
    -- Management
    position INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (destination_city_id) REFERENCES cities(id),
    
    INDEX idx_destination (destination_city_id),
    INDEX idx_type_difficulty (tour_type, difficulty_level),
    INDEX idx_duration (duration_days),
    INDEX idx_price (price_per_person),
    INDEX idx_featured (is_featured, is_active),
    FULLTEXT KEY ft_search (name, description, short_description)
);
```

### Tour Itineraries Table
```sql
CREATE TABLE tour_itineraries (
    id BIGINT PRIMARY KEY,
    tour_id BIGINT NOT NULL,
    day_number INTEGER NOT NULL,
    title VARCHAR(255) NOT NULL,            -- "Day 1: Arrival in Bangkok"
    description TEXT,
    location VARCHAR(255),                  -- "Bangkok, Thailand"
    
    -- Accommodation
    accommodation_type VARCHAR(100),        -- "Hotel", "Resort", "Guesthouse"
    accommodation_name VARCHAR(255),
    accommodation_rating INTEGER,           -- 1-5 stars
    
    -- Meals
    breakfast_included BOOLEAN DEFAULT false,
    lunch_included BOOLEAN DEFAULT false,
    dinner_included BOOLEAN DEFAULT false,
    special_meals TEXT,                     -- "Vegetarian available"
    
    -- Transportation
    transport_mode VARCHAR(100),            -- "Bus", "Flight", "Train", "Boat"
    transport_details TEXT,
    
    -- Activity summary
    estimated_walking_distance INTEGER,     -- in kilometers
    activity_level ENUM('low', 'moderate', 'high') DEFAULT 'moderate',
    
    -- Timing
    start_time TIME,
    end_time TIME,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_tour_day (tour_id, day_number),
    INDEX idx_tour_day (tour_id, day_number)
);
```

### Tour Activities Table
```sql
CREATE TABLE tour_activities (
    id BIGINT PRIMARY KEY,
    tour_itinerary_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    activity_type ENUM('sightseeing', 'cultural', 'adventure', 'relaxation', 'shopping', 'dining', 'transport') NOT NULL,
    
    -- Location details
    location VARCHAR(255),
    address TEXT,
    latitude DECIMAL(8,6),
    longitude DECIMAL(9,6),
    
    -- Timing
    start_time TIME,
    end_time TIME,
    duration_minutes INTEGER,               -- Estimated duration
    
    -- Requirements
    entrance_fee DECIMAL(8,2),             -- If applicable
    is_optional BOOLEAN DEFAULT false,      -- Can tourists skip this?
    booking_required BOOLEAN DEFAULT false, -- Advance booking needed?
    min_participants INTEGER DEFAULT 1,
    max_participants INTEGER,
    
    -- Accessibility
    wheelchair_accessible BOOLEAN DEFAULT false,
    child_friendly BOOLEAN DEFAULT true,
    
    -- Weather dependency
    weather_dependent BOOLEAN DEFAULT false,
    indoor_activity BOOLEAN DEFAULT false,
    
    -- Additional info
    difficulty_level ENUM('easy', 'moderate', 'challenging') DEFAULT 'easy',
    equipment_provided BOOLEAN DEFAULT false,
    equipment_needed TEXT,                  -- "Comfortable walking shoes"
    what_to_bring TEXT,                     -- "Camera, sunscreen, water"
    
    -- Order within the day
    sort_order INTEGER DEFAULT 0,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (tour_itinerary_id) REFERENCES tour_itineraries(id) ON DELETE CASCADE,
    
    INDEX idx_itinerary_order (tour_itinerary_id, sort_order),
    INDEX idx_activity_type (activity_type),
    INDEX idx_location (latitude, longitude)
);
```

## Model Relationships

### Tour Model
```php
class Tour extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'destination_city_id', 'name', 'slug', 'description', 'short_description',
        'duration_days', 'duration_nights', 'max_participants', 'min_participants',
        'difficulty_level', 'tour_type', 'price_per_person', 'child_price',
        'single_supplement', 'group_discount_threshold', 'group_discount_percentage',
        'inclusions', 'exclusions', 'languages', 'pickup_locations',
        'advance_booking_days', 'cancellation_policy', 'refund_policy',
        'min_age', 'max_age', 'fitness_requirements', 'medical_restrictions',
        'available_months', 'best_time_to_visit', 'is_active', 'is_featured',
        'average_rating', 'total_reviews', 'total_bookings',
        'meta_title', 'meta_description', 'featured_image', 'gallery_images', 'position'
    ];

    protected $casts = [
        'price_per_person' => 'decimal:2',
        'child_price' => 'decimal:2',
        'single_supplement' => 'decimal:2',
        'group_discount_percentage' => 'decimal:2',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'languages' => 'array',
        'pickup_locations' => 'array',
        'available_months' => 'array',
        'gallery_images' => 'array',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
    
    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number');
    }
    
    public function activities(): HasManyThrough
    {
        return $this->hasManyThrough(TourActivity::class, TourItinerary::class);
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
    
    public function scopeByType($query, string $type)
    {
        return $query->where('tour_type', $type);
    }
    
    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }
    
    public function scopeByDuration($query, int $minDays, int $maxDays = null)
    {
        $query->where('duration_days', '>=', $minDays);
        
        if ($maxDays) {
            $query->where('duration_days', '<=', $maxDays);
        }
        
        return $query;
    }
    
    public function scopeAvailableInMonth($query, int $month)
    {
        return $query->whereJsonContains('available_months', $month);
    }
    
    // Methods
    public function calculatePrice(int $adults, int $children = 0, bool $singleRoom = false): array
    {
        $adultPrice = $this->price_per_person * $adults;
        $childPrice = $this->child_price ? ($this->child_price * $children) : 0;
        $singleSupplement = $singleRoom ? $this->single_supplement : 0;
        
        $subtotal = $adultPrice + $childPrice + $singleSupplement;
        
        // Apply group discount if applicable
        $totalParticipants = $adults + $children;
        if ($this->group_discount_threshold && $totalParticipants >= $this->group_discount_threshold) {
            $discount = $subtotal * ($this->group_discount_percentage / 100);
            $subtotal -= $discount;
        }
        
        return [
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'single_supplement' => $singleSupplement,
            'subtotal' => $subtotal,
            'group_discount' => $discount ?? 0,
            'total' => $subtotal,
        ];
    }
    
    public function isAvailableForBooking(Carbon $date): bool
    {
        // Check if tour is active
        if (!$this->is_active) {
            return false;
        }
        
        // Check advance booking requirement
        if ($date->diffInDays(now()) < $this->advance_booking_days) {
            return false;
        }
        
        // Check seasonal availability
        if (!in_array($date->month, $this->available_months ?? [])) {
            return false;
        }
        
        return true;
    }
    
    // Accessors
    public function getDurationDisplayAttribute(): string
    {
        if ($this->duration_nights > 0) {
            return "{$this->duration_days} Days / {$this->duration_nights} Nights";
        }
        
        return "{$this->duration_days} Days";
    }
    
    public function getDifficultyBadgeAttribute(): string
    {
        $colors = [
            'easy' => 'green',
            'moderate' => 'yellow',
            'challenging' => 'orange',
            'extreme' => 'red'
        ];
        
        $color = $colors[$this->difficulty_level];
        $label = ucfirst($this->difficulty_level);
        
        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
    
    public function getTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->tour_type));
    }
}
```

### TourItinerary Model
```php
class TourItinerary extends Model
{
    protected $fillable = [
        'tour_id', 'day_number', 'title', 'description', 'location',
        'accommodation_type', 'accommodation_name', 'accommodation_rating',
        'breakfast_included', 'lunch_included', 'dinner_included', 'special_meals',
        'transport_mode', 'transport_details', 'estimated_walking_distance',
        'activity_level', 'start_time', 'end_time'
    ];

    protected $casts = [
        'breakfast_included' => 'boolean',
        'lunch_included' => 'boolean',
        'dinner_included' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relationships
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
    
    public function activities(): HasMany
    {
        return $this->hasMany(TourActivity::class)->orderBy('sort_order');
    }
    
    // Methods
    public function getMealsIncludedAttribute(): array
    {
        $meals = [];
        if ($this->breakfast_included) $meals[] = 'Breakfast';
        if ($this->lunch_included) $meals[] = 'Lunch';
        if ($this->dinner_included) $meals[] = 'Dinner';
        
        return $meals;
    }
    
    public function getTotalEstimatedDurationAttribute(): int
    {
        return $this->activities->sum('duration_minutes');
    }
    
    public function getAccommodationDisplayAttribute(): string
    {
        if (!$this->accommodation_name) {
            return 'No accommodation';
        }
        
        $display = $this->accommodation_name;
        
        if ($this->accommodation_rating) {
            $stars = str_repeat('★', $this->accommodation_rating);
            $display .= " ({$stars})";
        }
        
        return $display;
    }
}
```

### TourActivity Model
```php
class TourActivity extends Model
{
    protected $fillable = [
        'tour_itinerary_id', 'name', 'description', 'activity_type',
        'location', 'address', 'latitude', 'longitude',
        'start_time', 'end_time', 'duration_minutes', 'entrance_fee',
        'is_optional', 'booking_required', 'min_participants', 'max_participants',
        'wheelchair_accessible', 'child_friendly', 'weather_dependent',
        'indoor_activity', 'difficulty_level', 'equipment_provided',
        'equipment_needed', 'what_to_bring', 'sort_order'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'entrance_fee' => 'decimal:2',
        'is_optional' => 'boolean',
        'booking_required' => 'boolean',
        'wheelchair_accessible' => 'boolean',
        'child_friendly' => 'boolean',
        'weather_dependent' => 'boolean',
        'indoor_activity' => 'boolean',
        'equipment_provided' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relationships
    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(TourItinerary::class, 'tour_itinerary_id');
    }
    
    // Scopes
    public function scopeOptional($query)
    {
        return $query->where('is_optional', true);
    }
    
    public function scopeMandatory($query)
    {
        return $query->where('is_optional', false);
    }
    
    public function scopeByType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }
    
    // Accessors
    public function getTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->activity_type));
    }
    
    public function getDurationDisplayAttribute(): string
    {
        if (!$this->duration_minutes) {
            return 'Duration not specified';
        }
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }
    
    public function getAccessibilityInfoAttribute(): array
    {
        return [
            'wheelchair_accessible' => $this->wheelchair_accessible,
            'child_friendly' => $this->child_friendly,
            'indoor_activity' => $this->indoor_activity,
            'weather_dependent' => $this->weather_dependent,
        ];
    }
}
```

## Controllers

### Tour Controller Features
```php
class TourController extends Controller
{
    // Admin CRUD operations
    public function index()           // DataTables listing
    public function indexJson()       // AJAX data for DataTables
    public function create()          // Create form with destination selection
    public function store()           // Save new tour
    public function show()            // Tour details with itinerary
    public function edit()            // Edit form
    public function update()          // Update tour
    public function destroy()         // Delete tour
    public function duplicate()       // Duplicate tour
    
    // Status management
    public function toggleFeatured()  // Toggle featured status
    public function toggleActive()    // Toggle active status
    
    // Public API
    public function search()          // Tour search with filters
    public function details()         // Public tour details
    public function availability()    // Check tour availability
    
    // AJAX helpers
    public function getCitiesByCountry() // Dynamic city loading
}
```

### TourItinerary Controller Features
```php
class TourItineraryController extends Controller
{
    // Itinerary management
    public function index()           // List itineraries for tour
    public function indexJson()       // AJAX data
    public function create()          // Create itinerary form
    public function store()           // Save new itinerary
    public function show()            // Itinerary details with activities
    public function edit()            // Edit itinerary
    public function update()          // Update itinerary
    public function destroy()         // Delete itinerary
    
    // Bulk operations
    public function reorderDays()     // Reorder day numbers
    public function duplicateDay()    // Duplicate itinerary day
}
```

### TourActivity Controller Features
```php
class TourActivityController extends Controller
{
    // Activity management
    public function index()           // List activities for itinerary
    public function indexJson()       // AJAX data
    public function create()          // Create activity form
    public function store()           // Save new activity
    public function show()            // Activity details
    public function edit()            // Edit activity
    public function update()          // Update activity
    public function destroy()         // Delete activity
    
    // Organization
    public function reorderActivities() // Reorder activities within day
}
```

## Admin Interface

### Tours Management
```php
// DataTables columns
- ID
- Tour Name (with featured badge)
- Destination (City, Country)
- Type & Difficulty (Cultural - Easy)
- Duration (5 Days / 4 Nights)
- Price (From $599/person)
- Participants (2-20 people)
- Rating (4.5/5 - 23 reviews)
- Status Badge (Active/Inactive)
- Actions (View, Edit, Manage Itinerary, Duplicate, Delete)

// Advanced filters
- Destination (Country/City)
- Tour type (Cultural, Adventure, etc.)
- Difficulty level
- Duration range (days)
- Price range
- Featured tours only
- Active/Inactive status
- Available months
```

### Itinerary Management
```php
// Day-by-day itinerary interface
- Sortable day cards
- Day title and description
- Accommodation details
- Meal inclusions
- Transportation info
- Activity summary
- Estimated walking distance
- Quick edit functionality

// Bulk operations
- Add multiple days
- Copy day to another tour
- Reorder days
- Import from template
```

### Activities Management
```php
// Activity listing within each day
- Activity name and type
- Duration and timing
- Location with map integration
- Requirements and restrictions
- Entrance fees
- Optional/Mandatory status
- Drag-and-drop reordering

// Activity details
- Full description
- Accessibility information
- Equipment requirements
- Weather dependency
- Booking requirements
```

## API Endpoints

### Tours API
```php
GET    /api/tours                 // List tours with filters
GET    /api/tours/{id}            // Get tour details
GET    /api/tours/search          // Advanced search
GET    /api/tours/{id}/itinerary  // Get full itinerary
GET    /api/tours/{id}/pricing    // Calculate pricing
POST   /api/tours                 // Create tour (admin)
PUT    /api/tours/{id}            // Update tour (admin)
DELETE /api/tours/{id}            // Delete tour (admin)
```

### Itineraries API
```php
GET    /api/itineraries           // List itineraries
GET    /api/itineraries/{id}      // Get itinerary details
GET    /api/itineraries/{id}/activities // Get day activities
POST   /api/itineraries           // Create itinerary (admin)
PUT    /api/itineraries/{id}      // Update itinerary (admin)
DELETE /api/itineraries/{id}      // Delete itinerary (admin)
```

### Activities API
```php
GET    /api/activities            // List activities
GET    /api/activities/{id}       // Get activity details
POST   /api/activities            // Create activity (admin)
PUT    /api/activities/{id}       // Update activity (admin)
DELETE /api/activities/{id}       // Delete activity (admin)
```

## Business Logic

### Tour Search Service
```php
class TourSearchService
{
    public function searchTours(array $criteria): Collection
    {
        return Tour::query()
            ->with(['destinationCity.country', 'itineraries.activities'])
            ->when($criteria['destination'] ?? null, function ($query, $destination) {
                $query->where('destination_city_id', $destination);
            })
            ->when($criteria['tour_type'] ?? null, function ($query, $type) {
                $query->where('tour_type', $type);
            })
            ->when($criteria['difficulty'] ?? null, function ($query, $difficulty) {
                $query->where('difficulty_level', $difficulty);
            })
            ->when($criteria['duration_min'] ?? null, function ($query, $min) {
                $query->where('duration_days', '>=', $min);
            })
            ->when($criteria['duration_max'] ?? null, function ($query, $max) {
                $query->where('duration_days', '<=', $max);
            })
            ->when($criteria['price_max'] ?? null, function ($query, $maxPrice) {
                $query->where('price_per_person', '<=', $maxPrice);
            })
            ->when($criteria['month'] ?? null, function ($query, $month) {
                $query->whereJsonContains('available_months', (int) $month);
            })
            ->where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('average_rating', 'desc')
            ->get();
    }
}
```

### Tour Booking Service
```php
class TourBookingService
{
    public function checkAvailability(Tour $tour, Carbon $startDate, int $participants): array
    {
        // Check if tour is available for booking
        if (!$tour->isAvailableForBooking($startDate)) {
            return [
                'available' => false,
                'reason' => 'Tour not available for selected date'
            ];
        }
        
        // Check participant limits
        if ($participants > $tour->max_participants) {
            return [
                'available' => false,
                'reason' => "Maximum participants: {$tour->max_participants}"
            ];
        }
        
        if ($participants < $tour->min_participants) {
            return [
                'available' => false,
                'reason' => "Minimum participants: {$tour->min_participants}"
            ];
        }
        
        // Check existing bookings (if capacity tracking is implemented)
        $existingBookings = $this->getExistingBookings($tour, $startDate);
        $availableCapacity = $tour->max_participants - $existingBookings;
        
        if ($participants > $availableCapacity) {
            return [
                'available' => false,
                'reason' => "Only {$availableCapacity} spots available"
            ];
        }
        
        return [
            'available' => true,
            'available_capacity' => $availableCapacity,
            'pricing' => $tour->calculatePrice($participants)
        ];
    }
}
```

## Data Seeding

### Sample Tours Data
```php
// Tours (3 comprehensive examples)
$tours = [
    [
        'name' => 'Cox\'s Bazar Beach Paradise',
        'destination_city_id' => 2, // Chittagong (closest to Cox's Bazar)
        'tour_type' => 'beach',
        'difficulty_level' => 'easy',
        'duration_days' => 4,
        'duration_nights' => 3,
        'price_per_person' => 299.99,
        'max_participants' => 25,
        'description' => 'Experience the world\'s longest natural sea beach...',
        'inclusions' => ['accommodation', 'breakfast', 'transport', 'guide'],
        'exclusions' => ['lunch', 'dinner', 'personal_expenses'],
        'available_months' => [10, 11, 12, 1, 2, 3], // Oct-Mar (dry season)
    ],
    [
        'name' => 'Mystical Sylhet Tea Gardens',
        'destination_city_id' => 3, // Sylhet
        'tour_type' => 'cultural',
        'difficulty_level' => 'moderate',
        'duration_days' => 3,
        'duration_nights' => 2,
        'price_per_person' => 199.99,
        'max_participants' => 15,
        'description' => 'Explore the rolling tea gardens and spiritual sites...',
        'inclusions' => ['accommodation', 'all_meals', 'transport', 'guide', 'activities'],
        'exclusions' => ['airfare', 'personal_expenses'],
        'available_months' => [1, 2, 3, 4, 11, 12], // Winter months
    ],
    [
        'name' => 'Bangkok Grand Cultural Tour',
        'destination_city_id' => 6, // Bangkok
        'tour_type' => 'cultural',
        'difficulty_level' => 'easy',
        'duration_days' => 5,
        'duration_nights' => 4,
        'price_per_person' => 599.99,
        'max_participants' => 20,
        'description' => 'Discover the temples, palaces, and culture of Bangkok...',
        'inclusions' => ['accommodation', 'breakfast', 'guided_tours', 'transfers'],
        'exclusions' => ['flights', 'lunch', 'dinner', 'shopping'],
        'available_months' => [1, 2, 3, 11, 12], // Cool season
    ],
];
```

### Sample Itineraries (Cox's Bazar Example)
```php
$itineraries = [
    [
        'tour_id' => 1,
        'day_number' => 1,
        'title' => 'Arrival & Beach Relaxation',
        'description' => 'Arrive in Cox\'s Bazar, check into beachfront resort, evening at leisure on the beach',
        'accommodation_name' => 'Ocean Paradise Hotel',
        'accommodation_rating' => 4,
        'breakfast_included' => false,
        'lunch_included' => false,
        'dinner_included' => true,
    ],
    [
        'tour_id' => 1,
        'day_number' => 2,
        'title' => 'Beach Activities & Sunset Point',
        'description' => 'Beach activities, visit Laboni Beach, Sunset at Inani Beach',
        'breakfast_included' => true,
        'lunch_included' => true,
        'dinner_included' => false,
        'estimated_walking_distance' => 3,
    ],
    // ... more days
];
```

## Integration with Other Modules

### Location Module Integration
```php
// Tours are located in cities
$tour = Tour::with('destinationCity.country')->find($id);

// Search tours by location
$tours = Tour::whereHas('destinationCity', function ($query) use ($countryId) {
    $query->where('country_id', $countryId);
})->get();
```

### Booking Module Integration
```php
// Bookings can include tours
class Booking extends Model
{
    public function tours()
    {
        return $this->morphToMany(Tour::class, 'bookable')
                   ->withPivot(['start_date', 'participants', 'unit_price', 'total_price']);
    }
}
```

## Performance Considerations

### Database Indexing
```sql
-- Tour search optimization
CREATE INDEX idx_tours_destination_type ON tours(destination_city_id, tour_type);
CREATE INDEX idx_tours_duration_price ON tours(duration_days, price_per_person);
CREATE INDEX idx_tours_featured_active ON tours(is_featured, is_active);
CREATE INDEX idx_itineraries_tour_day ON tour_itineraries(tour_id, day_number);
CREATE INDEX idx_activities_itinerary_order ON tour_activities(tour_itinerary_id, sort_order);
```

### Caching Strategy
```php
// Cache popular tours
Cache::remember('featured_tours', 3600, function () {
    return Tour::featured()->with(['destinationCity', 'itineraries'])->get();
});

// Cache tour types
Cache::remember('tour_types', 7200, function () {
    return Tour::distinct()->pluck('tour_type');
});
```

## Validation Rules

### Tour Validation
```php
'destination_city_id' => 'required|exists:cities,id',
'name' => 'required|string|max:255',
'tour_type' => 'required|in:cultural,adventure,wildlife,beach,city,historical,religious,culinary',
'difficulty_level' => 'required|in:easy,moderate,challenging,extreme',
'duration_days' => 'required|integer|min:1|max:30',
'duration_nights' => 'required|integer|min:0|max:29',
'price_per_person' => 'required|numeric|min:0',
'max_participants' => 'required|integer|min:1|max:100',
'min_participants' => 'required|integer|min:1|lte:max_participants',
```

### Itinerary Validation
```php
'tour_id' => 'required|exists:tours,id',
'day_number' => 'required|integer|min:1',
'title' => 'required|string|max:255',
'accommodation_rating' => 'nullable|integer|between:1,5',
'estimated_walking_distance' => 'nullable|integer|min:0',
```

### Activity Validation
```php
'tour_itinerary_id' => 'required|exists:tour_itineraries,id',
'name' => 'required|string|max:255',
'activity_type' => 'required|in:sightseeing,cultural,adventure,relaxation,shopping,dining,transport',
'duration_minutes' => 'nullable|integer|min:0|max:1440',
'entrance_fee' => 'nullable|numeric|min:0',
'min_participants' => 'nullable|integer|min:1',
'max_participants' => 'nullable|integer|gte:min_participants',
```

## Next Steps

- **[Booking Module](./06-booking-module.md)** - Central booking management
- **[Payment Module](./07-payment-module.md)** - Tour payment processing
- **[Database Schema](./08-database-schema.md)** - Complete database structure

---

**Related Documentation:**
- [Location Module](./02-location-module.md)
- [Hotel Module](./04-hotel-module.md)
- [API Documentation](./09-api-documentation.md)