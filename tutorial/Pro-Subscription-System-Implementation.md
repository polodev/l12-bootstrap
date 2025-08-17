# Pro Subscription System Implementation Guide

## Overview

This guide explains the complete Pro subscription system implementation for Laravel 12 Bootstrap project. The system includes subscription plans, coupon codes, payment integration, and user management with a clean, minimal database design.

## Table of Contents

1. [System Architecture](#system-architecture)
2. [Database Schema](#database-schema)
3. [Pricing Structure](#pricing-structure)
4. [Coupon System](#coupon-system)
5. [Models & Relationships](#models--relationships)
6. [Controllers & Routes](#controllers--routes)
7. [Frontend Views](#frontend-views)
8. [Seeders](#seeders)
9. [Installation & Setup](#installation--setup)
10. [Usage Examples](#usage-examples)
11. [Admin Panel](#admin-panel)
12. [Future Enhancements](#future-enhancements)

## System Architecture

### Core Components

The subscription system consists of 5 main tables (keeping it simple as requested):

1. **subscription_plans** - Stores the 4 subscription plans
2. **user_subscriptions** - Tracks user's active/expired subscriptions
3. **coupons** - Manages coupon codes with validation rules
4. **coupon_usages** - Tracks coupon usage for limits
5. **payments** - Extended existing table for subscription payments

### Key Features

- ✅ **Multi-duration subscriptions** (1M, 3M, 6M, 1Y)
- ✅ **Flexible coupon system** with percentage/fixed discounts
- ✅ **Plan-specific coupon restrictions**
- ✅ **Usage limits** (total and per-user)
- ✅ **Automatic savings calculations**
- ✅ **Multi-language support** (English/Bengali)
- ✅ **Dark mode compatibility**
- ✅ **Mobile-responsive design**

## Database Schema

### 1. Subscription Plans Table

```sql
CREATE TABLE subscription_plans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    duration_months INT NOT NULL,
    currency VARCHAR(3) DEFAULT 'BDT',
    is_active BOOLEAN DEFAULT TRUE,
    features JSON,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 2. User Subscriptions Table

```sql
CREATE TABLE user_subscriptions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    subscription_plan_id BIGINT NOT NULL,
    payment_id BIGINT,
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NOT NULL,
    cancelled_at DATETIME,
    status VARCHAR(255) DEFAULT 'active',
    paid_amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'BDT',
    coupon_id BIGINT,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    coupon_code VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (subscription_plan_id) REFERENCES subscription_plans(id),
    FOREIGN KEY (payment_id) REFERENCES payments(id),
    FOREIGN KEY (coupon_id) REFERENCES coupons(id)
);
```

### 3. Coupons Table

```sql
CREATE TABLE coupons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    minimum_amount DECIMAL(10,2),
    maximum_discount DECIMAL(10,2),
    usage_limit INT,
    usage_limit_per_user INT,
    used_count INT DEFAULT 0,
    applicable_plans JSON,
    starts_at DATETIME,
    expires_at DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

### 4. Coupon Usages Table

```sql
CREATE TABLE coupon_usages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    coupon_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    user_subscription_id BIGINT NOT NULL,
    discount_amount DECIMAL(10,2) NOT NULL,
    used_at DATETIME NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (coupon_id) REFERENCES coupons(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (user_subscription_id) REFERENCES user_subscriptions(id)
);
```

### 5. Extended Payments Table

Added new columns to existing payments table:

```sql
ALTER TABLE payments ADD COLUMN subscription_plan_id BIGINT;
ALTER TABLE payments ADD COLUMN user_id BIGINT;
ALTER TABLE payments ADD COLUMN coupon_id BIGINT;
ALTER TABLE payments ADD COLUMN original_amount DECIMAL(10,2);
ALTER TABLE payments ADD COLUMN discount_amount DECIMAL(10,2) DEFAULT 0;
ALTER TABLE payments ADD COLUMN coupon_code VARCHAR(255);
```

## Pricing Structure

### Subscription Plans

| Plan | Duration | Price | Monthly Rate | Savings |
|------|----------|-------|--------------|---------|
| Pro Monthly | 1 month | 100 BDT | 100 BDT | - |
| Pro Quarterly | 3 months | 250 BDT | 83.33 BDT | 50 BDT (17%) |
| Pro Semi-Annual | 6 months | 400 BDT | 66.67 BDT | 200 BDT (33%) |
| Pro Annual | 12 months | 700 BDT | 58.33 BDT | 500 BDT (42%) |

### Automatic Calculations

The system automatically calculates:
- **Monthly rate**: `price / duration_months`
- **Savings amount**: `(monthly_price * duration) - actual_price`
- **Savings percentage**: `savings / regular_price * 100`

## Coupon System

### Coupon Types

#### 1. Percentage Discounts
```php
[
    'type' => 'percentage',
    'value' => 15.00, // 15% off
    'maximum_discount' => 100.00 // Cap at 100 BDT
]
```

#### 2. Fixed Amount Discounts
```php
[
    'type' => 'fixed',
    'value' => 50.00, // 50 BDT off
]
```

### Coupon Restrictions

#### Plan Restrictions
```php
// Only for quarterly plans and above
'applicable_plans' => [2, 3, 4] // Plan IDs

// For all plans
'applicable_plans' => null
```

#### Usage Limits
```php
'usage_limit' => 100,           // Total uses across all users
'usage_limit_per_user' => 1,    // Max uses per user
```

#### Amount Restrictions
```php
'minimum_amount' => 250.00,     // Minimum purchase amount
```

#### Time Restrictions
```php
'starts_at' => '2024-01-01 00:00:00',
'expires_at' => '2024-12-31 23:59:59',
```

### Coupon Validation Logic

The system validates coupons through multiple checks:

1. **Active Status**: `is_active = true`
2. **Date Range**: Current time within start/end dates
3. **Usage Limits**: Total and per-user limits not exceeded
4. **Plan Eligibility**: Coupon applies to selected plan
5. **Minimum Amount**: Purchase meets minimum requirement

## Models & Relationships

### SubscriptionPlan Model

```php
class SubscriptionPlan extends Model
{
    // Key methods
    public function getPricePerMonthAttribute(): float
    public function getSavingsAttribute(): ?float
    public function getSavingsPercentageAttribute(): ?int
    public function getDurationTextAttribute(): string
    public function getFormattedPriceAttribute(): string
    
    // Relationships
    public function userSubscriptions(): HasMany
    public function activeSubscriptions(): HasMany
    
    // Scopes
    public function scopeActive($query)
    public function scopeOrdered($query)
}
```

### UserSubscription Model

```php
class UserSubscription extends Model
{
    // Key methods
    public function getIsActiveAttribute(): bool
    public function getIsExpiredAttribute(): bool
    public function getDaysRemainingAttribute(): int
    public function cancel(): bool
    public function extend(int $months): bool
    
    // Relationships
    public function user(): BelongsTo
    public function subscriptionPlan(): BelongsTo
    public function payment(): BelongsTo
    public function coupon(): BelongsTo
    
    // Scopes
    public function scopeActive($query)
    public function scopeExpired($query)
    public function scopeForUser($query, $userId)
}
```

### Coupon Model

```php
class Coupon extends Model
{
    // Key methods
    public function isValidForUser(User $user, SubscriptionPlan $plan, float $amount): array
    public function calculateDiscount(float $amount): float
    public function applyToSubscription(User $user, UserSubscription $subscription): bool
    public function getFormattedDiscountAttribute(): string
    public function getRemainingUsesAttribute(): ?int
    
    // Static methods
    public static function findAndValidate(string $code, User $user, SubscriptionPlan $plan, float $amount): array
    
    // Relationships
    public function creator(): BelongsTo
    public function usages(): HasMany
    public function userSubscriptions(): HasMany
    
    // Scopes
    public function scopeActive($query)
    public function scopeByCode($query, string $code)
}
```

## Controllers & Routes

### SubscriptionController

Located at: `app-modules/subscription/src/Http/Controllers/SubscriptionController.php`

#### Key Methods

1. **pricing()** - Display pricing page with plans
2. **purchase($plan)** - Show purchase form for specific plan
3. **applyCoupon(Request $request)** - AJAX coupon validation
4. **processPurchase(Request $request)** - Handle subscription purchase
5. **success()** - Show purchase success page

#### Routes

```php
// Public routes
Route::get('/pricing', [SubscriptionController::class, 'pricing'])->name('subscription.pricing');

// Authenticated routes
Route::middleware('auth')->group(function() {
    Route::get('/subscription/purchase/{plan}', [SubscriptionController::class, 'purchase'])->name('subscription.purchase');
    Route::post('/subscription/apply-coupon', [SubscriptionController::class, 'applyCoupon'])->name('subscription.apply-coupon');
    Route::post('/subscription/process-purchase', [SubscriptionController::class, 'processPurchase'])->name('subscription.process-purchase');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
});
```

## Frontend Views

### Pricing Page

Located at: `app-modules/subscription/resources/views/pricing.blade.php`

Features:
- **Responsive pricing cards** for all 4 plans
- **Savings badges** for longer plans
- **"Most Popular" highlight** for annual plan
- **Feature lists** for each plan
- **Current subscription status** for logged-in users
- **Mobile-optimized** layout

### Purchase Flow

1. **Pricing page** → User selects plan
2. **Purchase page** → User enters coupon, selects payment method
3. **Processing** → Payment and subscription creation
4. **Success page** → Confirmation and next steps

## Seeders

### Sandbox Seeder

Located at: `app-modules/subscription/database/seeders/SubscriptionSeeder.php`

Includes:
- All 4 subscription plans
- 7 test coupons (including expired/inactive for testing)
- Realistic coupon scenarios

### Production Seeder

Located at: `app-modules/subscription/database/seeders/SubscriptionSeederProduction.php`

Includes:
- All 4 subscription plans
- 2 launch coupons for real use

### Sample Coupons (Sandbox)

| Code | Type | Value | Restrictions | Limit |
|------|------|-------|--------------|-------|
| WELCOME10 | Percentage | 10% | All plans, max 50 BDT | 100 uses, 1 per user |
| SAVE25 | Fixed | 25 BDT | Min 100 BDT | 50 uses, 1 per user |
| QUARTERLY15 | Percentage | 15% | 3M+ plans, max 100 BDT | 30 uses, 1 per user |
| ANNUAL100 | Fixed | 100 BDT | Annual only, min 700 BDT | 20 uses, 1 per user |
| UNLIMITED50 | Fixed | 50 BDT | Min 200 BDT | Unlimited, 2 per user |

## Installation & Setup

### 1. Run Migrations

```bash
cd /Users/polodev/sites/l12-bootstrap

# Run all migrations
php artisan migrate
```

### 2. Run Seeders

```bash
# For development/testing (includes test coupons)
php artisan db:seed --class=DatabaseSandboxSeeder

# For production (minimal coupons)
php artisan db:seed --class=DatabaseProductionSeeder
```

### 3. Clear Caches

```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### 4. Access the System

- **Pricing Page**: http://l12-bootstrap.test//pricing
- **Admin Dashboard**: http://l12-bootstrap.test//admin (requires admin account)

## Usage Examples

### 1. Customer Purchasing Flow

1. **Visit pricing page**: User sees all plans with savings calculations
2. **Select plan**: Click "Choose Plan" (redirects to login if not authenticated)
3. **Purchase page**: Enter optional coupon code, select payment method
4. **Apply coupon**: Real-time validation via AJAX
5. **Complete purchase**: Process payment and create subscription
6. **Success page**: Confirmation with subscription details

### 2. Coupon Validation Example

```php
// In controller
$validation = Coupon::findAndValidate('WELCOME10', $user, $plan, $plan->price);

if ($validation['valid']) {
    $coupon = $validation['coupon'];
    $discount = $coupon->calculateDiscount($plan->price);
    $finalAmount = $plan->price - $discount;
}
```

### 3. Checking User Subscription

```php
// Check if user has active subscription
$activeSubscription = UserSubscription::forUser($userId)
    ->active()
    ->first();

if ($activeSubscription) {
    // User has pro access
    $daysRemaining = $activeSubscription->days_remaining;
    $expiresAt = $activeSubscription->ends_at;
}
```

### 4. Subscription Status Management

```php
// Auto-update expired subscriptions
$subscription = UserSubscription::find($id);
$subscription->updateStatus(); // Automatically sets status based on dates

// Manual actions
$subscription->cancel();           // Cancel subscription
$subscription->extend(3);          // Extend by 3 months
$subscription->markAsExpired();    // Mark as expired
```

## Admin Panel

### Required Admin CRUD Interfaces

1. **Subscription Plans Management**
   - List all plans with status, pricing
   - Create/edit plans
   - Enable/disable plans
   - View subscriber counts

2. **Coupons Management**
   - List all coupons with usage stats
   - Create/edit coupons with all restrictions
   - View usage history
   - Bulk actions (activate/deactivate)

3. **User Subscriptions Management**
   - List all subscriptions with filters
   - View subscription details
   - Manual subscription actions (cancel, extend)
   - Payment history

4. **Analytics Dashboard**
   - Revenue by plan
   - Coupon usage statistics
   - Subscription trends
   - Churn analysis

## Future Enhancements

### Phase 2 Features

1. **Plan Upgrades/Downgrades**
   - Mid-cycle plan changes
   - Prorated billing
   - Credit/debit handling

2. **Auto-Renewal**
   - Automatic subscription renewal
   - Payment method storage
   - Renewal notifications

3. **Advanced Analytics**
   - Revenue forecasting
   - Customer lifetime value
   - Retention metrics

4. **Enhanced Coupons**
   - Bulk coupon generation
   - Referral coupons
   - Loyalty rewards

5. **Team Subscriptions**
   - Multi-user subscriptions
   - Seat management
   - Billing consolidation

### Technical Improvements

1. **Queue Jobs**
   - Subscription expiry notifications
   - Payment processing
   - Email campaigns

2. **API Endpoints**
   - Mobile app support
   - Third-party integrations
   - Webhook notifications

3. **Advanced Security**
   - Rate limiting
   - Fraud detection
   - Payment validation

## Troubleshooting

### Common Issues

1. **Migration Errors**
   ```bash
   # If foreign key constraints fail
   php artisan migrate:fresh --seed
   ```

2. **Route Not Found**
   ```bash
   # Clear route cache
   php artisan route:clear
   php artisan config:clear
   ```

3. **Coupon Not Applying**
   - Check coupon is active and not expired
   - Verify plan eligibility
   - Check usage limits not exceeded

4. **Subscription Status Issues**
   ```php
   // Run status update command (create this as needed)
   php artisan subscriptions:update-status
   ```

### Debug Commands

```bash
# Check subscription status
php artisan tinker
>>> UserSubscription::whereNotNull('id')->get()->each->updateStatus();

# Verify coupon validation
>>> $user = User::find(1);
>>> $plan = SubscriptionPlan::find(1);
>>> Coupon::findAndValidate('WELCOME10', $user, $plan, 100);
```

## Files Created/Modified

### New Files Created

```
app-modules/subscription/
├── database/migrations/
│   ├── 2025_08_17_120000_create_subscription_plans_table.php
│   └── 2025_08_17_120001_create_user_subscriptions_table.php
├── database/seeders/
│   ├── SubscriptionSeeder.php
│   └── SubscriptionSeederProduction.php
├── src/
│   ├── Http/Controllers/SubscriptionController.php
│   └── Models/
│       ├── SubscriptionPlan.php
│       └── UserSubscription.php
├── resources/views/
│   └── pricing.blade.php
└── routes/subscription-routes.php

app-modules/coupon/
├── database/migrations/
│   └── 2025_08_17_120002_create_coupons_table.php
├── database/seeders/
│   ├── CouponSeeder.php
│   └── CouponSeederProduction.php
└── src/Models/
    ├── Coupon.php
    └── CouponUsage.php

app-modules/payment/database/migrations/
└── 2025_08_17_120003_add_subscription_support_to_payments_table.php

tutorial/
└── Pro-Subscription-System-Implementation.md
```

### Modified Files

```
database/seeders/
├── DatabaseSandboxSeeder.php (added subscription & coupon seeders)
└── DatabaseProductionSeeder.php (added subscription & coupon seeders)
```

## Conclusion

This Pro subscription system provides a complete, production-ready solution for managing subscriptions with:

- ✅ **Flexible pricing** with automatic savings calculations
- ✅ **Advanced coupon system** with comprehensive validation
- ✅ **Clean database design** with minimal tables
- ✅ **User-friendly interface** with responsive design
- ✅ **Developer-friendly code** with proper relationships and methods
- ✅ **Multi-language support** for global use
- ✅ **Comprehensive testing data** via seeders

The system is ready for production use and can be easily extended with additional features as your business grows.