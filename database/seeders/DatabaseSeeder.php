<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Blog\Database\Seeders\BlogSeeder;
use Modules\Contact\Database\Seeders\ContactSeeder;
use Modules\Documentation\Database\Seeders\DocumentationSeeder;
use Modules\Location\Database\Seeders\CitySeeder;
use Modules\Location\Database\Seeders\CountrySeeder;
use Modules\Option\Database\Seeders\OptionSeeder;
use Modules\Page\Database\Seeders\PageSeeder;
use Modules\Payment\Database\Seeders\PaymentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSandboxSeeder::class,
            // DatabaseProductionSeeder::class,
        ]);
    }
}
