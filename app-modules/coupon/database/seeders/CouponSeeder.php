<?php

namespace Modules\Coupon\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Coupon\Models\Coupon;
use Modules\Subscription\Models\SubscriptionPlan;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all subscription plan IDs for reference
        $allPlanIds = SubscriptionPlan::pluck('id')->toArray();
        $quarterlyAndAbove = SubscriptionPlan::where('duration_months', '>=', 3)->pluck('id')->toArray();
        $annualOnly = SubscriptionPlan::where('duration_months', 12)->pluck('id')->toArray();

        $coupons = [
            [
                'code' => 'WELCOME10',
                'name' => 'Welcome Discount',
                'description' => '10% off for new users',
                'type' => 'percentage',
                'value' => 10.00,
                'minimum_amount' => null,
                'maximum_discount' => 50.00,
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $allPlanIds,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'SAVE25',
                'name' => 'Fixed 25 BDT Discount',
                'description' => 'Save 25 BDT on any subscription',
                'type' => 'fixed',
                'value' => 25.00,
                'minimum_amount' => 100.00,
                'maximum_discount' => null,
                'usage_limit' => 50,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $allPlanIds,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'QUARTERLY15',
                'name' => 'Quarterly Discount',
                'description' => '15% off on quarterly plans and above',
                'type' => 'percentage',
                'value' => 15.00,
                'minimum_amount' => 250.00,
                'maximum_discount' => 100.00,
                'usage_limit' => 30,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $quarterlyAndAbove,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ],
            [
                'code' => 'ANNUAL100',
                'name' => 'Annual Special',
                'description' => '100 BDT off on annual plans',
                'type' => 'fixed',
                'value' => 100.00,
                'minimum_amount' => 700.00,
                'maximum_discount' => null,
                'usage_limit' => 20,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $annualOnly,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'UNLIMITED50',
                'name' => 'Unlimited Use Coupon',
                'description' => '50 BDT off with no usage limit',
                'type' => 'fixed',
                'value' => 50.00,
                'minimum_amount' => 200.00,
                'maximum_discount' => null,
                'usage_limit' => null, // Unlimited
                'usage_limit_per_user' => 2,
                'applicable_plans' => $allPlanIds,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED20',
                'name' => 'Expired Coupon',
                'description' => 'This coupon has expired (for testing)',
                'type' => 'percentage',
                'value' => 20.00,
                'minimum_amount' => null,
                'maximum_discount' => null,
                'usage_limit' => 10,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $allPlanIds,
                'starts_at' => now()->subMonth(),
                'expires_at' => now()->subDay(),
                'is_active' => true,
            ],
            [
                'code' => 'INACTIVE25',
                'name' => 'Inactive Coupon',
                'description' => 'This coupon is inactive (for testing)',
                'type' => 'percentage',
                'value' => 25.00,
                'minimum_amount' => null,
                'maximum_discount' => null,
                'usage_limit' => 10,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $allPlanIds,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'is_active' => false,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::updateOrCreate(
                ['code' => $couponData['code']],
                $couponData
            );
        }
    }
}