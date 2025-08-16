# Booking Module Documentation

## Overview

The Booking module serves as the central hub for managing all travel bookings across the platform. It orchestrates reservations for flights, hotels, tours, and other services, providing a unified booking experience with customer management, payment processing, and status tracking.

## Module Structure

```
app-modules/booking/
├── src/
│   ├── Models/
│   │   ├── Booking.php
│   │   ├── BookingItem.php
│   │   └── Customer.php
│   ├── Http/Controllers/
│   │   ├── BookingController.php
│   │   ├── BookingItemController.php
│   │   └── CustomerController.php
│   └── Providers/
│       └── BookingServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Customers Table
```sql
CREATE TABLE customers (
    id BIGINT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    nationality VARCHAR(100),
    
    -- Address information
    address_line_1 VARCHAR(255),
    address_line_2 VARCHAR(255),
    city VARCHAR(100),
    state_province VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    
    -- Travel document info
    passport_number VARCHAR(50),
    passport_expiry DATE,
    passport_country VARCHAR(100),
    
    -- Preferences
    preferred_language VARCHAR(10) DEFAULT 'en',
    marketing_consent BOOLEAN DEFAULT false,
    
    -- Account status
    is_active BOOLEAN DEFAULT true,
    email_verified_at TIMESTAMP NULL,
    
    -- Loyalty program
    loyalty_points INTEGER DEFAULT 0,
    loyalty_tier ENUM('bronze', 'silver', 'gold', 'platinum') DEFAULT 'bronze',
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_name (first_name, last_name),
    INDEX idx_loyalty (loyalty_tier, loyalty_points)
);
```

### Bookings Table
```sql
CREATE TABLE bookings (
    id BIGINT PRIMARY KEY,
    customer_id BIGINT NOT NULL,
    booking_reference VARCHAR(20) UNIQUE NOT NULL, -- BK-2024-001234
    
    -- Booking details
    booking_type ENUM('single', 'package') DEFAULT 'single', -- Single service or package
    status ENUM('pending', 'confirmed', 'cancelled', 'completed', 'refunded') DEFAULT 'pending',
    
    -- Pricing
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    tax_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    service_fee DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    paid_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'USD',
    
    -- Travel details
    travel_start_date DATE,
    travel_end_date DATE,
    total_travelers INTEGER NOT NULL DEFAULT 1,
    adult_count INTEGER NOT NULL DEFAULT 1,
    child_count INTEGER NOT NULL DEFAULT 0,
    infant_count INTEGER NOT NULL DEFAULT 0,
    
    -- Contact information
    contact_email VARCHAR(255) NOT NULL,
    contact_phone VARCHAR(20),
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    
    -- Special requirements
    special_requests TEXT,
    dietary_requirements TEXT,
    accessibility_needs TEXT,
    
    -- Booking source
    booking_source ENUM('website', 'mobile_app', 'agent', 'api') DEFAULT 'website',
    booking_agent_id BIGINT NULL,           -- If booked by agent
    
    -- Payment information
    payment_status ENUM('pending', 'partial', 'paid', 'refunded', 'failed') DEFAULT 'pending',
    payment_method VARCHAR(50),             -- 'credit_card', 'bank_transfer', etc.
    payment_due_date DATETIME,
    
    -- Dates
    booking_date DATETIME NOT NULL,
    confirmation_date DATETIME NULL,
    cancellation_date DATETIME NULL,
    
    -- Cancellation information
    cancellation_reason TEXT,
    cancelled_by ENUM('customer', 'admin', 'system') NULL,
    refund_amount DECIMAL(12,2) DEFAULT 0.00,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    
    INDEX idx_customer (customer_id),
    INDEX idx_reference (booking_reference),
    INDEX idx_status (status),
    INDEX idx_travel_dates (travel_start_date, travel_end_date),
    INDEX idx_booking_date (booking_date),
    INDEX idx_payment_status (payment_status)
);
```

### Booking Items Table (Polymorphic Relationship)
```sql
CREATE TABLE booking_items (
    id BIGINT PRIMARY KEY,
    booking_id BIGINT NOT NULL,
    
    -- Polymorphic relationship to services
    bookable_type VARCHAR(255) NOT NULL,   -- 'flight_schedule', 'room_inventory', 'tour'
    bookable_id BIGINT NOT NULL,
    
    -- Item details
    item_name VARCHAR(255) NOT NULL,       -- For display purposes
    item_description TEXT,
    
    -- Quantity and passengers
    quantity INTEGER NOT NULL DEFAULT 1,   -- Number of rooms, tickets, tour spots
    adult_count INTEGER NOT NULL DEFAULT 1,
    child_count INTEGER NOT NULL DEFAULT 0,
    infant_count INTEGER NOT NULL DEFAULT 0,
    
    -- Pricing for this item
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    
    -- Service-specific data (JSON)
    service_details JSON,                  -- Store service-specific information
    
    -- Dates (can differ from main booking)
    service_date DATE,
    service_end_date DATE,                 -- For multi-day services
    
    -- Status
    item_status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    
    -- Passenger/room details
    passenger_details JSON,               -- Store passenger information
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    
    INDEX idx_booking (booking_id),
    INDEX idx_bookable (bookable_type, bookable_id),
    INDEX idx_service_date (service_date),
    INDEX idx_item_status (item_status)
);
```

## Model Relationships

### Customer Model
```php
class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'date_of_birth',
        'gender', 'nationality', 'address_line_1', 'address_line_2',
        'city', 'state_province', 'postal_code', 'country',
        'passport_number', 'passport_expiry', 'passport_country',
        'preferred_language', 'marketing_consent', 'is_active',
        'loyalty_points', 'loyalty_tier'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_expiry' => 'date',
        'marketing_consent' => 'boolean',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByLoyaltyTier($query, string $tier)
    {
        return $query->where('loyalty_tier', $tier);
    }
    
    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function getFullAddressAttribute(): string
    {
        $address = collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state_province,
            $this->postal_code,
            $this->country
        ])->filter()->implode(', ');
        
        return $address;
    }
    
    // Methods
    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
        $this->updateLoyaltyTier();
    }
    
    private function updateLoyaltyTier(): void
    {
        if ($this->loyalty_points >= 10000) {
            $this->loyalty_tier = 'platinum';
        } elseif ($this->loyalty_points >= 5000) {
            $this->loyalty_tier = 'gold';
        } elseif ($this->loyalty_points >= 1000) {
            $this->loyalty_tier = 'silver';
        } else {
            $this->loyalty_tier = 'bronze';
        }
        
        $this->save();
    }
}
```

### Booking Model
```php
class Booking extends Model
{
    protected $fillable = [
        'customer_id', 'booking_reference', 'booking_type', 'status',
        'subtotal', 'tax_amount', 'discount_amount', 'service_fee',
        'total_amount', 'paid_amount', 'currency',
        'travel_start_date', 'travel_end_date', 'total_travelers',
        'adult_count', 'child_count', 'infant_count',
        'contact_email', 'contact_phone', 'emergency_contact_name',
        'emergency_contact_phone', 'special_requests', 'dietary_requirements',
        'accessibility_needs', 'booking_source', 'booking_agent_id',
        'payment_status', 'payment_method', 'payment_due_date',
        'booking_date', 'confirmation_date', 'cancellation_date',
        'cancellation_reason', 'cancelled_by', 'refund_amount'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'travel_start_date' => 'date',
        'travel_end_date' => 'date',
        'booking_date' => 'datetime',
        'confirmation_date' => 'datetime',
        'cancellation_date' => 'datetime',
        'payment_due_date' => 'datetime',
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    // Polymorphic relationships for different services
    public function flightSchedules(): MorphToMany
    {
        return $this->morphedByMany(FlightSchedule::class, 'bookable', 'booking_items')
                   ->withPivot(['quantity', 'unit_price', 'total_price', 'passenger_details']);
    }
    
    public function roomInventories(): MorphToMany
    {
        return $this->morphedByMany(RoomInventory::class, 'bookable', 'booking_items')
                   ->withPivot(['quantity', 'unit_price', 'total_price', 'service_details']);
    }
    
    public function tours(): MorphToMany
    {
        return $this->morphedByMany(Tour::class, 'bookable', 'booking_items')
                   ->withPivot(['quantity', 'unit_price', 'total_price', 'service_date']);
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    
    public function scopeByDateRange($query, Carbon $start, Carbon $end)
    {
        return $query->whereBetween('travel_start_date', [$start, $end]);
    }
    
    // Methods
    public function generateReference(): string
    {
        $year = now()->year;
        $lastBooking = static::whereYear('created_at', $year)
                           ->orderBy('id', 'desc')
                           ->first();
        
        $number = $lastBooking ? 
            intval(substr($lastBooking->booking_reference, -6)) + 1 : 
            1;
        
        return sprintf('BK-%d-%06d', $year, $number);
    }
    
    public function calculateTotals(): void
    {
        $this->subtotal = $this->items->sum('total_price');
        $this->tax_amount = $this->subtotal * 0.10; // 10% tax
        $this->service_fee = $this->subtotal * 0.02; // 2% service fee
        $this->total_amount = $this->subtotal + $this->tax_amount + 
                             $this->service_fee - $this->discount_amount;
        $this->save();
    }
    
    public function confirm(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }
        
        // Reserve all services
        foreach ($this->items as $item) {
            if (!$this->reserveService($item)) {
                return false;
            }
        }
        
        $this->update([
            'status' => 'confirmed',
            'confirmation_date' => now()
        ]);
        
        // Award loyalty points
        $points = intval($this->total_amount / 10); // 1 point per $10
        $this->customer->addLoyaltyPoints($points);
        
        return true;
    }
    
    public function cancel(string $reason, string $cancelledBy = 'customer'): bool
    {
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }
        
        // Release reserved services
        foreach ($this->items as $item) {
            $this->releaseService($item);
        }
        
        $this->update([
            'status' => 'cancelled',
            'cancellation_date' => now(),
            'cancellation_reason' => $reason,
            'cancelled_by' => $cancelledBy
        ]);
        
        return true;
    }
    
    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'completed' => 'blue',
            'refunded' => 'gray'
        ];
        
        $color = $colors[$this->status];
        $label = ucfirst($this->status);
        
        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
    
    public function getPaymentStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'yellow',
            'partial' => 'orange',
            'paid' => 'green',
            'refunded' => 'gray',
            'failed' => 'red'
        ];
        
        $color = $colors[$this->payment_status];
        $label = ucfirst($this->payment_status);
        
        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
    
    public function getOutstandingAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }
}
```

### BookingItem Model
```php
class BookingItem extends Model
{
    protected $fillable = [
        'booking_id', 'bookable_type', 'bookable_id', 'item_name',
        'item_description', 'quantity', 'adult_count', 'child_count',
        'infant_count', 'unit_price', 'total_price', 'service_details',
        'service_date', 'service_end_date', 'item_status', 'passenger_details'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'service_details' => 'array',
        'passenger_details' => 'array',
        'service_date' => 'date',
        'service_end_date' => 'date',
    ];

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }
    
    // Methods
    public function getServiceTypeAttribute(): string
    {
        return match($this->bookable_type) {
            'App\\Modules\\Flight\\Models\\FlightSchedule' => 'Flight',
            'App\\Modules\\Hotel\\Models\\RoomInventory' => 'Hotel',
            'App\\Modules\\Tour\\Models\\Tour' => 'Tour',
            default => 'Unknown'
        };
    }
    
    public function getTotalPassengersAttribute(): int
    {
        return $this->adult_count + $this->child_count + $this->infant_count;
    }
}
```

## Controllers

### Booking Controller Features
```php
class BookingController extends Controller
{
    // Admin operations
    public function index()           // DataTables listing of all bookings
    public function indexJson()       // AJAX data for DataTables
    public function show()            // Booking details with items
    public function edit()            // Edit booking (limited fields)
    public function update()          // Update booking
    
    // Status management
    public function confirm()         // Confirm pending booking
    public function cancel()          // Cancel booking
    public function refund()          // Process refund
    
    // Customer operations
    public function customerBookings() // Customer's booking history
    public function createBooking()    // Create new booking
    public function processBooking()   // Process booking creation
    
    // Reports
    public function salesReport()     // Sales analytics
    public function bookingStats()    // Booking statistics
}
```

### Customer Controller Features
```php
class CustomerController extends Controller
{
    // Admin CRUD operations
    public function index()           // Customer listing
    public function indexJson()       // AJAX data
    public function create()          // Create customer form
    public function store()           // Save new customer
    public function show()            // Customer details with bookings
    public function edit()            // Edit customer
    public function update()          // Update customer
    
    // Customer management
    public function loyaltyHistory()  // Loyalty points history
    public function communicationHistory() // Communication log
    public function mergeCustomers()  // Merge duplicate customers
}
```

## Admin Interface

### Bookings Management
```php
// DataTables columns
- Booking Reference (BK-2024-001234)
- Customer Name (with email)
- Booking Type (Single/Package)
- Travel Dates (Dec 15-20, 2024)
- Services (Flight + Hotel + Tour)
- Total Amount ($1,299.99)
- Payment Status Badge (Paid/Pending/Partial)
- Booking Status Badge (Confirmed/Pending/Cancelled)
- Booking Date (Dec 1, 2024)
- Actions (View, Edit, Confirm, Cancel, Refund)

// Advanced filters
- Date range (booking date, travel date)
- Status filters (booking, payment)
- Customer search
- Amount range
- Service type
- Booking source
```

### Customer Management
```php
// DataTables columns
- Customer ID
- Full Name
- Email & Phone
- Nationality
- Total Bookings (5)
- Total Spent ($3,299.99)
- Loyalty Tier (Gold - 7,550 pts)
- Last Booking (Dec 1, 2024)
- Status Badge (Active/Inactive)
- Actions (View, Edit, Merge, Communications)

// Filters
- Loyalty tier
- Nationality
- Registration date range
- Booking activity
- Total spent range
```

### Booking Details View
```php
// Comprehensive booking information
- Customer details
- Contact information
- Travel dates and travelers
- Service breakdown with details
- Pricing breakdown (subtotal, taxes, fees)
- Payment history
- Status timeline
- Special requests
- Documents (tickets, vouchers)
- Communication history
```

## API Endpoints

### Bookings API
```php
GET    /api/bookings              // List bookings (admin)
GET    /api/bookings/{id}         // Get booking details
POST   /api/bookings              // Create new booking
PUT    /api/bookings/{id}         // Update booking
DELETE /api/bookings/{id}         // Cancel booking

// Status operations
POST   /api/bookings/{id}/confirm // Confirm booking
POST   /api/bookings/{id}/cancel  // Cancel booking
POST   /api/bookings/{id}/refund  // Process refund

// Customer bookings
GET    /api/customers/{id}/bookings // Customer's bookings
```

### Customers API
```php
GET    /api/customers             // List customers (admin)
GET    /api/customers/{id}        // Get customer details
POST   /api/customers             // Create customer
PUT    /api/customers/{id}        // Update customer
DELETE /api/customers/{id}        // Deactivate customer

// Customer operations
POST   /api/customers/{id}/loyalty-points // Add loyalty points
GET    /api/customers/{id}/loyalty-history // Loyalty history
```

## Business Logic

### Booking Creation Service
```php
class BookingCreationService
{
    public function createBooking(array $bookingData): Booking
    {
        return DB::transaction(function () use ($bookingData) {
            // Create or find customer
            $customer = $this->findOrCreateCustomer($bookingData['customer']);
            
            // Create booking
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'booking_reference' => $this->generateReference(),
                'booking_type' => $bookingData['type'],
                'contact_email' => $bookingData['contact_email'],
                'contact_phone' => $bookingData['contact_phone'],
                'booking_date' => now(),
                // ... other fields
            ]);
            
            // Add booking items
            foreach ($bookingData['items'] as $itemData) {
                $this->addBookingItem($booking, $itemData);
            }
            
            // Calculate totals
            $booking->calculateTotals();
            
            // Send confirmation email
            $this->sendBookingConfirmation($booking);
            
            return $booking;
        });
    }
    
    private function addBookingItem(Booking $booking, array $itemData): BookingItem
    {
        // Validate availability
        if (!$this->checkAvailability($itemData)) {
            throw new BookingException('Service not available');
        }
        
        // Create booking item
        return BookingItem::create([
            'booking_id' => $booking->id,
            'bookable_type' => $itemData['service_type'],
            'bookable_id' => $itemData['service_id'],
            'item_name' => $itemData['name'],
            'quantity' => $itemData['quantity'],
            'unit_price' => $itemData['unit_price'],
            'total_price' => $itemData['quantity'] * $itemData['unit_price'],
            'service_date' => $itemData['service_date'],
            'passenger_details' => $itemData['passengers'] ?? [],
        ]);
    }
}
```

### Booking Confirmation Service
```php
class BookingConfirmationService
{
    public function confirmBooking(Booking $booking): bool
    {
        return DB::transaction(function () use ($booking) {
            // Check if all services are still available
            foreach ($booking->items as $item) {
                if (!$this->verifyAvailability($item)) {
                    throw new BookingException("Service {$item->item_name} is no longer available");
                }
            }
            
            // Reserve all services
            foreach ($booking->items as $item) {
                $this->reserveService($item);
            }
            
            // Update booking status
            $booking->update([
                'status' => 'confirmed',
                'confirmation_date' => now()
            ]);
            
            // Generate tickets/vouchers
            $this->generateBookingDocuments($booking);
            
            // Send confirmation notifications
            $this->sendConfirmationNotifications($booking);
            
            // Award loyalty points
            $this->awardLoyaltyPoints($booking);
            
            return true;
        });
    }
    
    private function reserveService(BookingItem $item): void
    {
        match($item->bookable_type) {
            'App\\Modules\\Flight\\Models\\FlightSchedule' => 
                app(FlightInventoryService::class)->reserveSeats($item->bookable, $item->quantity),
            'App\\Modules\\Hotel\\Models\\RoomInventory' => 
                app(HotelInventoryService::class)->reserveRooms($item->bookable, $item->quantity),
            'App\\Modules\\Tour\\Models\\Tour' => 
                app(TourInventoryService::class)->reserveSpots($item->bookable, $item->quantity),
        };
    }
}
```

### Booking Analytics Service
```php
class BookingAnalyticsService
{
    public function getBookingStats(Carbon $startDate, Carbon $endDate): array
    {
        $bookings = Booking::whereBetween('booking_date', [$startDate, $endDate]);
        
        return [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->clone()->confirmed()->count(),
            'cancelled_bookings' => $bookings->clone()->where('status', 'cancelled')->count(),
            'total_revenue' => $bookings->clone()->confirmed()->sum('total_amount'),
            'average_booking_value' => $bookings->clone()->confirmed()->avg('total_amount'),
            'top_destinations' => $this->getTopDestinations($startDate, $endDate),
            'booking_sources' => $this->getBookingSourceBreakdown($startDate, $endDate),
            'service_breakdown' => $this->getServiceBreakdown($startDate, $endDate),
        ];
    }
    
    public function getCustomerInsights(): array
    {
        return [
            'total_customers' => Customer::count(),
            'new_customers_this_month' => Customer::whereMonth('created_at', now()->month)->count(),
            'loyalty_tier_distribution' => Customer::groupBy('loyalty_tier')
                                                 ->selectRaw('loyalty_tier, count(*) as count')
                                                 ->pluck('count', 'loyalty_tier'),
            'top_customers' => Customer::withSum('bookings', 'total_amount')
                                     ->orderBy('bookings_sum_total_amount', 'desc')
                                     ->limit(10)
                                     ->get(),
        ];
    }
}
```

## Data Seeding

### Sample Customers Data
```php
$customers = [
    [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1234567890',
        'nationality' => 'American',
        'loyalty_tier' => 'gold',
        'loyalty_points' => 5500,
    ],
    [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '+0987654321',
        'nationality' => 'British',
        'loyalty_tier' => 'silver',
        'loyalty_points' => 2300,
    ],
    // ... more customers
];
```

### Sample Bookings Data
```php
$bookings = [
    [
        'customer_id' => 1,
        'booking_reference' => 'BK-2024-000001',
        'booking_type' => 'package',
        'status' => 'confirmed',
        'total_amount' => 1299.99,
        'travel_start_date' => '2024-12-15',
        'travel_end_date' => '2024-12-20',
        'adult_count' => 2,
        'child_count' => 0,
    ],
    // ... more bookings with corresponding booking_items
];
```

## Integration with Other Modules

### Service Module Integration
```php
// Polymorphic relationships allow booking any service
$booking->flightSchedules; // Flight bookings
$booking->roomInventories; // Hotel bookings
$booking->tours;          // Tour bookings

// Universal booking creation
BookingItem::create([
    'booking_id' => $booking->id,
    'bookable_type' => FlightSchedule::class,
    'bookable_id' => $flightSchedule->id,
    // ... other fields
]);
```

### Payment Module Integration
```php
// Bookings trigger payment processing
class Booking extends Model
{
    public function processPayment(array $paymentData): Payment
    {
        return Payment::create([
            'booking_id' => $this->id,
            'amount' => $paymentData['amount'],
            'payment_method' => $paymentData['method'],
            'status' => 'pending',
        ]);
    }
}
```

## Performance Considerations

### Database Indexing
```sql
-- Booking search optimization
CREATE INDEX idx_bookings_customer_date ON bookings(customer_id, booking_date);
CREATE INDEX idx_bookings_travel_dates ON bookings(travel_start_date, travel_end_date);
CREATE INDEX idx_bookings_status_payment ON bookings(status, payment_status);
CREATE INDEX idx_booking_items_bookable ON booking_items(bookable_type, bookable_id);
CREATE INDEX idx_customers_email_phone ON customers(email, phone);
```

### Caching Strategy
```php
// Cache booking statistics
Cache::remember('booking_stats_today', 300, function () {
    return app(BookingAnalyticsService::class)->getTodayStats();
});

// Cache customer loyalty tiers
Cache::remember('loyalty_distribution', 1800, function () {
    return Customer::groupBy('loyalty_tier')->pluck('count', 'loyalty_tier');
});
```

## Validation Rules

### Booking Validation
```php
'customer_id' => 'required|exists:customers,id',
'booking_type' => 'required|in:single,package',
'travel_start_date' => 'required|date|after:today',
'travel_end_date' => 'required|date|after_or_equal:travel_start_date',
'adult_count' => 'required|integer|min:1|max:20',
'child_count' => 'nullable|integer|min:0|max:10',
'contact_email' => 'required|email',
'contact_phone' => 'required|string|max:20',
```

### Customer Validation
```php
'first_name' => 'required|string|max:100',
'last_name' => 'required|string|max:100',
'email' => 'required|email|unique:customers,email',
'phone' => 'nullable|string|max:20',
'date_of_birth' => 'nullable|date|before:today',
'passport_expiry' => 'nullable|date|after:today',
'nationality' => 'nullable|string|max:100',
```

## Next Steps

- **[Payment Module](./07-payment-module.md)** - Payment processing integration
- **[Database Schema](./08-database-schema.md)** - Complete database structure
- **[API Documentation](./09-api-documentation.md)** - REST API endpoints

---

**Related Documentation:**
- [Flight Module](./03-flight-module.md)
- [Hotel Module](./04-hotel-module.md)
- [Tour Module](./05-tour-module.md)