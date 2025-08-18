<?php

namespace Modules\Subscription\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Subscription\Models\SubscriptionPlan;

class SubscriptionSeederProduction extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        // Define common features for all Pro plans
        $commonFeatures = [
            'en' => "- **Unlimited Browse** - Browse without any restrictions\n- **Unlimited Collection** - Create unlimited collections\n- **Unlimited Bookmarks** - Save unlimited bookmarks",
            'bn' => "- **সীমাহীন ব্রাউজ** - কোনো সীমাবদ্ধতা ছাড়াই ব্রাউজ করুন\n- **সীমাহীন সংগ্রহ** - সীমাহীন সংগ্রহ তৈরি করুন\n- **সীমাহীন বুকমার্ক** - সীমাহীন বুকমার্ক সংরক্ষণ করুন"
        ];

        $plans = [
            [
                'name' => 'pro',
                'slug' => 'pro-monthly',
                'description' => 'Perfect for trying out Pro features',
                'plan_title' => [
                    'en' => 'Pro Monthly',
                    'bn' => 'প্রো মাসিক'
                ],
                'price' => 100.00,
                'duration_months' => 1,
                'currency' => 'BDT',
                'is_active' => true,
                'features' => $commonFeatures,
                'sort_order' => 1,
            ],
            [
                'name' => 'pro',
                'slug' => 'pro-quarterly',
                'description' => 'Great value for 3 months',
                'plan_title' => [
                    'en' => 'Pro Quarterly',
                    'bn' => 'প্রো ত্রৈমাসিক'
                ],
                'price' => 250.00,
                'duration_months' => 3,
                'currency' => 'BDT',
                'is_active' => true,
                'features' => $commonFeatures,
                'sort_order' => 2,
            ],
            [
                'name' => 'pro',
                'slug' => 'pro-semi-annual',
                'description' => 'Best value for 6 months',
                'plan_title' => [
                    'en' => 'Pro Semi-Annual',
                    'bn' => 'প্রো ছয়মাসী'
                ],
                'price' => 400.00,
                'duration_months' => 6,
                'currency' => 'BDT',
                'is_active' => true,
                'features' => $commonFeatures,
                'sort_order' => 3,
            ],
            [
                'name' => 'pro',
                'slug' => 'pro-annual',
                'description' => 'Maximum savings for a full year',
                'plan_title' => [
                    'en' => 'Pro Annual',
                    'bn' => 'প্রো বার্ষিক'
                ],
                'price' => 700.00,
                'duration_months' => 12,
                'currency' => 'BDT',
                'is_active' => true,
                'features' => $commonFeatures,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}