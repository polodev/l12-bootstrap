# Architecture Overview

## System Architecture

The Eco Travel OTA platform is built using a modular architecture that separates concerns and allows for independent development and maintenance of different travel services.

## Module Relationships

```
┌─────────────────────────────────────────────────────────────┐
│                    Eco Travel Platform                      │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────┐     │
│  │   Location  │    │   Flight    │    │    Hotel    │     │
│  │   Module    │    │   Module    │    │   Module    │     │
│  └──────┬──────┘    └──────┬──────┘    └──────┬──────┘     │
│         │                  │                  │             │
│         └──────────────────┼──────────────────┘             │
│                            │                                │
│  ┌─────────────┐    ┌──────┴──────┐    ┌─────────────┐     │
│  │    Tour     │    │   Booking   │    │   Payment   │     │
│  │   Module    │    │   Module    │    │   Module    │     │
│  └──────┬──────┘    └──────┬──────┘    └──────┬──────┘     │
│         │                  │                  │             │
│         └──────────────────┼──────────────────┘             │
│                            │                                │
│                   ┌────────┴────────┐                       │
│                   │ Admin Dashboard │                       │
│                   └─────────────────┘                       │
└─────────────────────────────────────────────────────────────┘
```

## Core Module Dependencies

### 1. Location Module (Foundation)
- **Role**: Provides geographic foundation for all other modules
- **Dependencies**: None (base module)
- **Used by**: Flight, Hotel, Tour, Booking modules

### 2. Flight Module
- **Role**: Flight operations and airline management
- **Dependencies**: Location (airports, cities, countries)
- **Relationships**: 
  - Flights operate between airports
  - Airlines are based in countries

### 3. Hotel Module
- **Role**: Accommodation services management
- **Dependencies**: Location (cities, countries)
- **Relationships**:
  - Hotels are located in cities
  - Room availability is location-specific

### 4. Tour Module
- **Role**: Package tour management
- **Dependencies**: Location (cities, countries)
- **Relationships**:
  - Tours visit specific destinations
  - Activities are location-based

### 5. Booking Module (Central Hub)
- **Role**: Central booking orchestration
- **Dependencies**: All service modules (Flight, Hotel, Tour)
- **Relationships**:
  - Aggregates multiple services into single bookings
  - Manages customer information

### 6. Payment Module
- **Role**: Financial transaction processing
- **Dependencies**: Booking module
- **Relationships**:
  - Processes payments for bookings
  - Tracks transaction history

## Data Flow Architecture

### Booking Flow
```
1. Customer Selection
   ├── Location Selection (cities, airports)
   ├── Service Selection (flights, hotels, tours)
   └── Date/Time Selection

2. Availability Check
   ├── Flight schedules and seats
   ├── Hotel room availability
   └── Tour capacity

3. Booking Creation
   ├── Customer information
   ├── Service details
   └── Pricing calculation

4. Payment Processing
   ├── Payment gateway integration
   ├── Transaction recording
   └── Confirmation generation
```

## Database Architecture

### Hierarchical Structure
```
Countries (10 records)
└── Cities (15 records)
    └── Airports (8 records)
        └── Flights
            └── Flight Schedules

Countries
└── Cities
    └── Hotels
        └── Rooms
            └── Room Inventory

Countries
└── Cities
    └── Tours
        └── Tour Activities
```

### Relationship Types

1. **One-to-Many Relationships**
   - Country → Cities
   - City → Airports
   - Hotel → Rooms
   - Tour → Activities

2. **Many-to-Many Relationships**
   - Bookings ↔ Services (polymorphic)
   - Tours ↔ Destinations

3. **Polymorphic Relationships**
   - Bookings can contain flights, hotels, or tours
   - Payments are linked to various booking types

## Module Communication

### Service Layer Pattern
Each module implements a service layer for inter-module communication:

```php
// Example: Booking service coordinating with other modules
class BookingService
{
    public function createBooking($data)
    {
        // Check availability across modules
        $flightAvailable = FlightService::checkAvailability($data['flight']);
        $hotelAvailable = HotelService::checkAvailability($data['hotel']);
        
        // Create unified booking
        return $this->processBooking($data);
    }
}
```

### Event-Driven Architecture
Modules communicate through Laravel events:

```php
// Booking created event
event(new BookingCreated($booking));

// Listeners in other modules
class UpdateInventoryListener
{
    public function handle(BookingCreated $event)
    {
        // Update flight seats, hotel rooms, tour capacity
    }
}
```

## Security Architecture

### Authentication & Authorization
- **Admin Access**: Role-based access control
- **API Access**: Token-based authentication
- **Data Protection**: Encrypted sensitive data

### Data Validation
- **Form Validation**: Laravel form requests
- **Database Constraints**: Foreign keys and indexes
- **Business Rules**: Service layer validation

## Performance Considerations

### Database Optimization
- **Indexes**: On foreign keys and search columns
- **Query Optimization**: Eager loading relationships
- **Caching**: Frequently accessed data

### Scalability
- **Modular Architecture**: Independent scaling
- **Database Partitioning**: By date/location
- **API Rate Limiting**: Prevent abuse

## Technology Stack

### Backend
- **Framework**: Laravel 11
- **Architecture**: Modular (InterNACHI/Modular)
- **Database**: MySQL with migrations
- **Authentication**: Laravel Sanctum

### Frontend
- **Templates**: Blade with Tailwind CSS
- **JavaScript**: Alpine.js for interactions
- **Data Tables**: Server-side processing
- **Responsive**: Mobile-first design

### Development Tools
- **Version Control**: Git
- **Dependency Management**: Composer
- **Asset Compilation**: Vite
- **Testing**: PHPUnit

## Deployment Architecture

### Environment Structure
```
Development → Staging → Production

Local Development:
├── Laravel Herd (Local server)
├── MySQL Database
└── File-based configuration

Production:
├── Web Server (Nginx/Apache)
├── Database Server (MySQL)
├── Cache Layer (Redis)
└── CDN for static assets
```

## Next Steps

1. **[Location Module](./02-location-module.md)** - Start with geographic data
2. **[Database Schema](./08-database-schema.md)** - Detailed table structures
3. **[Admin Interface](./10-admin-interface.md)** - Backend management

---

**Related Documentation:**
- [Database Schema](./08-database-schema.md)
- [API Documentation](./09-api-documentation.md)
- [Admin Interface](./10-admin-interface.md)