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
            'en' => "- **Unlimited Projects** - Create as many projects as you need\n- **Priority Support** - Get help faster with dedicated support\n- **Advanced Analytics** - Detailed insights and reporting\n- **Export Functionality** - Download your data in multiple formats\n- **Team Collaboration** - Invite team members to collaborate\n- **API Access** - Integrate with third-party services\n- **Custom Branding** - White-label solutions available\n- **Advanced Security** - Enhanced protection for your data",
            'bn' => "- **সীমাহীন প্রকল্প** - যতখুশি প্রকল্প তৈরি করুন\n- **অগ্রাধিকার সহায়তা** - দ্রুত সাহায্য পান ডেডিকেটেড সাপোর্টের মাধ্যমে\n- **উন্নত বিশ্লেষণ** - বিস্তারিত অন্তর্দৃষ্টি এবং রিপোর্টিং\n- **এক্সপোর্ট কার্যকারিতা** - একাধিক ফরম্যাটে ডেটা ডাউনলোড করুন\n- **টিম সহযোগিতা** - সহযোগিতার জন্য টিম সদস্যদের আমন্ত্রণ জানান\n- **API অ্যাক্সেস** - তৃতীয় পক্ষের সেবার সাথে সংযোগ করুন\n- **কাস্টম ব্র্যান্ডিং** - হোয়াইট-লেবেল সমাধান উপলব্ধ\n- **উন্নত নিরাপত্তা** - আপনার ডেটার জন্য বর্ধিত সুরক্ষা"
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