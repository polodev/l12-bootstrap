# Project Information for Claude

## Development Environment
- **Local Development**: Laravel Herd
- **Project URL**: http://l12-bootstrap.test/
- **Project Path**: /Users/polodev/sites/l12-bootstrap
- **Git Repository**: Yes (clean working tree)
- **Current Branch**: main

## Project Architecture
This is a Laravel application with modular architecture implementing multi-language support and separate layout modules for different user contexts.

## CSS Framework
- **Primary CSS Framework**: Tailwind CSS
- **Usage**: All layouts and components use Tailwind CSS utility classes
- **Dark Mode**: Implemented using Tailwind's dark mode classes (dark:*)
- **Responsive Design**: Mobile-first approach with Tailwind's responsive prefixes (sm:, md:, lg:, xl:)
- **Important**: Do NOT use Bootstrap classes - all styling should use Tailwind CSS utilities

## Installed Packages
- `mcamara/laravel-localization` - Multi-language support (English & Bengali)
- `internachi/modular` - Modular architecture for separation of concerns

## Localization Configuration
- **Supported Languages**: English (en), Bengali (bn)
- **Default Language**: English (no URL prefix - clean URLs)
- **Bengali URLs**: Use `/bn` prefix
- **Configuration**: `/config/laravellocalization.php`
  - `hideDefaultLocaleInURL` = true (English has no prefix)
  - Excluded routes: dashboard, admin, auth routes
- **Translation Files**:
  - `/resources/lang/en/messages.php` - 80+ English translations
  - `/resources/lang/bn/messages.php` - 80+ Bengali translations

## Modular Layout System
Located in `/app-modules/` directory with 4 modules:

### 1. Admin Dashboard Layout (`admin-dashboard-layout`)
- **Component**: `<x-admin-dashboard-layout::layout>`
- **Purpose**: Backend/admin interface
- **Features**: Admin sidebar, user dropdown, admin-specific styling
- **Not localized** (English only for admin)
- **Modular Structure**: Organized into logical partials for easy maintenance
  - `partials/_head.blade.php` - HTML head contents (meta, title, scripts, styles)
  - `partials/_header.blade.php` - Admin header navigation bar with user dropdown
  - `partials/_sidebar.blade.php` - Admin navigation sidebar with nested menus
  - `partials/_footer.blade.php` - Scripts stack (before closing body)
  - `partials/_scripts.blade.php` - DataTables, Flatpickr, and common scripts
  - Main content area integrated directly in layout with status messages and slot

### 2. Customer Frontend Layout (`customer-frontend-layout`)
- **Component**: `<x-customer-frontend-layout::layout>`
- **Purpose**: Public frontend pages
- **Features**: 
  - Responsive navigation with hamburger menu
  - Services dropdown (Web Development, Mobile Apps, Consulting, Support)
  - Mobile controls: language switcher, theme switcher, auth buttons
  - Desktop theme switcher with Light/Dark/System options
  - Alpine.js state management: `x-data="{ mobileMenuOpen: false }"`
- **Modular Structure**: Organized into logical partials for easy maintenance
  - `partials/_head.blade.php` - HTML head contents (meta, title, theme script, styles)
  - `partials/_header.blade.php` - Main header container with logo and navigation
  - `partials/_mobile-controls.blade.php` - Mobile language, theme, auth, and menu controls
  - `partials/_desktop-navigation.blade.php` - Desktop navigation links and dropdowns
  - `partials/_mobile-menu.blade.php` - Mobile navigation menu with collapsible services
  - `partials/_footer.blade.php` - Site footer with copyright
  - `partials/_status-message.blade.php` - Fixed position success/status messages
  - `partials/_scripts.blade.php` - Scripts stack (before closing body)
  - Main content area integrated directly in layout with responsive container

### 3. Customer Account Layout (`customer-account-layout`)
- **Component**: `<x-customer-account-layout::layout>`
- **Purpose**: Customer account/profile pages
- **Features**:
  - Extended version of customer frontend layout
  - Account sidebar with: Profile, Orders, Wishlist, Support, Settings
  - Mobile-friendly with account sidebar toggle
  - Alpine.js state: `x-data="{ accountSidebarOpen: false }"`
  - Auto-show sidebar on desktop: `x-init="if (window.innerWidth >= 1024) accountSidebarOpen = true"`

### 4. Test Module (`test`)
- **Purpose**: Comprehensive testing of all layout components
- **Routes**: All test routes support localization
- **Views**: Detailed test pages for each layout with feature demonstrations

## Theme System
- **Modes**: Light, Dark, System (follows OS preference)
- **Implementation**: JavaScript function `setAppearance(appearance)`
- **Storage**: localStorage for user preference
- **CSS**: Tailwind CSS dark mode classes

## Routes Structure
```php
// Localized routes (English no prefix, Bengali /bn prefix)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    // Public and customer routes
});

// Non-localized routes (admin, dashboard, auth)
// These remain English-only
```

## Test Routes Available
- **Main Test Index**: http://l12-bootstrap.test/test (http://l12-bootstrap.test/bn/test for Bengali)
- **Admin Layout Test**: http://l12-bootstrap.test/test/admin-dashboard (no localization)
- **Frontend Layout Test**: http://l12-bootstrap.test/test/customer-frontend (http://l12-bootstrap.test/bn/test/customer-frontend)
- **Account Layout Test**: http://l12-bootstrap.test/test/customer-account (http://l12-bootstrap.test/bn/test/customer-account)

## Mobile Navigation Features
- **Always Visible Mobile Controls**: Language switcher, theme switcher, auth buttons, hamburger menu
- **Responsive Design**: Mobile-first approach with proper breakpoints
- **Alpine.js Integration**: Proper state management for dropdowns and toggles
- **Service Dropdowns**: Both desktop and mobile versions with test items

## Key Configuration Files
- `/config/laravellocalization.php` - Localization settings
- `/routes/web.php` - Main route definitions with localization
- `/app-modules/*/routes/*.php` - Module-specific routes
- `/app-modules/*/app/Providers/*ServiceProvider.php` - Module service providers

## Common Commands
- `php artisan route:clear` - Clear route cache after module changes
- `php artisan config:clear` - Clear config cache
- `php artisan view:clear` - Clear view cache

## Error Fixes Applied
1. **Auth Header Error**: Fixed "Call to a member function initials() on null" by creating separate public layouts
2. **Alpine.js Errors**: Fixed by properly structuring `x-data` attributes and using `x-show` instead of `$refs`
3. **Route Localization**: Implemented proper Laravel Localization middleware instead of manual approach
4. **Mobile Navigation**: Fixed hamburger menu functionality with correct Alpine.js state management

## Asset Management
### Third-Party Asset Organization
- **Location**: `/public/vendor/` directory for all third-party libraries
- **Organization Pattern**: Library-based structure where each third-party library gets its own folder

### Standard Library Structure
```
public/vendor/library-name/
├── css/                       # Stylesheets (.css, .min.css)
├── js/                        # JavaScript files (.js, .min.js)
├── images/                    # Library-specific images
├── themes/                    # Theme variations (if applicable)
├── plugins/                   # Extension plugins (if applicable)
└── fonts/                     # Font files (.woff, .ttf, etc.)
```

### Supported Asset Types
- **CSS**: Stylesheets and minified versions
- **JavaScript**: Scripts and minified versions  
- **Fonts**: Icon fonts and custom typefaces (.woff, .ttf, .eot, .svg)
- **Images**: Icons, backgrounds, UI elements (.png, .jpg, .gif)
- **Maps**: Source maps for debugging (.map files)
- **Documentation**: README, LICENSE, and HTML docs

### Common Third-Party Libraries
- **CSS Frameworks**: Bootstrap, Tailwind CSS, Bulma
- **JavaScript Libraries**: jQuery, Alpine.js, Select2, Choices.js
- **UI Components**: DataTables, Owl Carousel, Magnific Popup
- **Date/Time**: Flatpickr date picker
- **Alerts/Modals**: SweetAlert, SweetAlert2
- **Icons**: Flaticon, FontAwesome
- **Laravel Packages**: Telescope, Log Viewer, Media Library



## Development Notes
- All layouts implement consistent dark mode support
- Mobile-first responsive design throughout
- Comprehensive translation system for customer-facing content
- Modular architecture allows easy extension and maintenance
- Test module provides complete layout testing capabilities
- Third-party assets organized in vendor directory for maintainability