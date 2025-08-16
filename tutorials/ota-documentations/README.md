# Eco Travel - OTA Platform Documentation

Welcome to the comprehensive documentation for the Eco Travel Online Travel Agency (OTA) platform. This documentation covers all modules, their relationships, and how they work together to create a complete travel booking system.

## 📚 Documentation Structure

This documentation is organized into the following sections:

1. **[Architecture Overview](./01-architecture-overview.md)** - System architecture and module relationships
2. **[Location Module](./02-location-module.md)** - Countries, cities, and airports management
3. **[Flight Module](./03-flight-module.md)** - Airlines, flights, and schedules
4. **[Hotel Module](./04-hotel-module.md)** - Hotels, rooms, and inventory management
5. **[Tour Module](./05-tour-module.md)** - Tour packages and itineraries
6. **[Booking Module](./06-booking-module.md)** - Central booking management
7. **[Payment Module](./07-payment-module.md)** - Payment processing and transactions
8. **[Database Schema](./08-database-schema.md)** - Complete database structure
9. **[API Documentation](./09-api-documentation.md)** - REST API endpoints
10. **[Admin Interface](./10-admin-interface.md)** - Backend management features

## 🚀 Quick Start

The Eco Travel platform is built using Laravel with a modular architecture using the InterNACHI/Modular package. Each module is self-contained with its own:

- Models and relationships
- Controllers and business logic
- Views and frontend components
- Database migrations and seeders
- Service providers and configuration

## 🏗️ Core Technologies

- **Framework**: Laravel 11
- **Architecture**: Modular (InterNACHI/Modular)
- **Database**: MySQL
- **Frontend**: Blade templates with Tailwind CSS
- **Admin Interface**: DataTables integration
- **Localization**: Multi-language support (English/Bengali)

## 📋 Module Overview

| Module | Purpose | Key Features |
|--------|---------|--------------|
| Location | Geographic data management | Countries, cities, airports with hierarchical relationships |
| Flight | Flight operations | Airlines, flight schedules, seat inventory |
| Hotel | Accommodation services | Hotels, room types, availability management |
| Tour | Package tours | Tour packages, itineraries, activities |
| Booking | Central booking system | Multi-service bookings, customer management |
| Payment | Financial transactions | Payment processing, transaction history |

## 🔗 Quick Navigation

- [System Architecture](./01-architecture-overview.md) - Understand how modules interact
- [Getting Started](./02-location-module.md) - Start with location data setup
- [Database Schema](./08-database-schema.md) - Complete database structure
- [Admin Guide](./10-admin-interface.md) - Backend management

## 📞 Support

For technical support or questions about this documentation, please refer to the individual module documentation or contact the development team.

---

**Last Updated**: {{ date('Y-m-d') }}  
**Version**: 1.0  
**Platform**: Eco Travel OTA