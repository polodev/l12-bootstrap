<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Module Production Seeders
use Modules\Option\Database\Seeders\OptionSeederProduction;
use Modules\Documentation\Database\Seeders\DocumentationSeederProudction;
use Modules\Blog\Database\Seeders\BlogSeederProduction;
use Modules\Page\Database\Seeders\PageSeederProduction;
use Modules\Location\Database\Seeders\CountrySeederProduction;
use Modules\Location\Database\Seeders\CitySeederProduction;

class DatabaseProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeederProduction::class,
            OptionSeederProduction::class,
            DocumentationSeederProudction::class,
            BlogSeederProduction::class,
            PageSeederProduction::class,

            // Location Module - Must run first (dependencies)
            // CountrySeederProduction::class,
            // CitySeederProduction::class,

           
        ]);

    }
}
