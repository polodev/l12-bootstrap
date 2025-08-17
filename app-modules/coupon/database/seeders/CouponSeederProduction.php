<?php

namespace Modules\Coupon\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Coupon\Models\Coupon;
use Modules\Subscription\Models\SubscriptionPlan;

class CouponSeederProduction extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        // Get all subscription plan IDs for reference
        $allPlanIds = SubscriptionPlan::pluck('id')->toArray();
        $quarterlyAndAbove = SubscriptionPlan::where('duration_months', '>=', 3)->pluck('id')->toArray();

        $coupons = [
            [
                'code' => 'LAUNCH25',
                'name' => 'Launch Special',
                'description' => '25% off for early adopters',
                'type' => 'percentage',
                'value' => 25.00,
                'minimum_amount' => null,
                'maximum_discount' => 100.00,
                'usage_limit' => 100,
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
                'maximum_discount' => 75.00,
                'usage_limit' => 50,
                'usage_limit_per_user' => 1,
                'applicable_plans' => $quarterlyAndAbove,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
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