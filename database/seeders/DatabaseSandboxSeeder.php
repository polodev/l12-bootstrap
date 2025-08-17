<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Modules\Blog\Database\Seeders\BlogSeeder;
use Modules\Contact\Database\Seeders\ContactSeeder;
use Modules\Documentation\Database\Seeders\DocumentationSeeder;
use Modules\Location\Database\Seeders\CitySeeder;
use Modules\Location\Database\Seeders\CountrySeeder;
use Modules\Option\Database\Seeders\OptionSeeder;
use Modules\Page\Database\Seeders\PageSeeder;
use Modules\Subscription\Database\Seeders\SubscriptionSeeder;
use Modules\Coupon\Database\Seeders\CouponSeeder;

class DatabaseSandboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     
        $this->call([
            UserTableSeeder::class,
            OptionSeeder::class,
            DocumentationSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,

            // Location Module - Must run first (dependencies)
            CountrySeeder::class,
            CitySeeder::class,

            // Subscription & Coupon Modules
            SubscriptionSeeder::class,
            CouponSeeder::class,

            // contact
            ContactSeeder::class,
        ]);
    }
}
