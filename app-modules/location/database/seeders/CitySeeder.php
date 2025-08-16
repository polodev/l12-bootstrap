<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Bangladesh Cities
            [
                'country_code' => 'BD',
                'name' => 'Dhaka',
                'state_province' => 'Dhaka Division',
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'timezone' => 'Asia/Dhaka',
                'population' => 9000000,
                'is_active' => true,
                'is_capital' => true,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'BD',
                'name' => 'Chittagong',
                'state_province' => 'Chittagong Division',
                'latitude' => 22.3569,
                'longitude' => 91.7832,
                'timezone' => 'Asia/Dhaka',
                'population' => 2600000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 2,
            ],
            [
                'country_code' => 'BD',
                'name' => 'Cox\'s Bazar',
                'state_province' => 'Chittagong Division',
                'latitude' => 21.4272,
                'longitude' => 92.0058,
                'timezone' => 'Asia/Dhaka',
                'population' => 223000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 3,
            ],
            [
                'country_code' => 'BD',
                'name' => 'Sylhet',
                'state_province' => 'Sylhet Division',
                'latitude' => 24.8949,
                'longitude' => 91.8687,
                'timezone' => 'Asia/Dhaka',
                'population' => 500000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 4,
            ],

            // India Cities
            [
                'country_code' => 'IN',
                'name' => 'New Delhi',
                'state_province' => 'Delhi',
                'latitude' => 28.6139,
                'longitude' => 77.2090,
                'timezone' => 'Asia/Kolkata',
                'population' => 30000000,
                'is_active' => true,
                'is_capital' => true,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'IN',
                'name' => 'Mumbai',
                'state_province' => 'Maharashtra',
                'latitude' => 19.0760,
                'longitude' => 72.8777,
                'timezone' => 'Asia/Kolkata',
                'population' => 20000000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 2,
            ],
            [
                'country_code' => 'IN',
                'name' => 'Kolkata',
                'state_province' => 'West Bengal',
                'latitude' => 22.5726,
                'longitude' => 88.3639,
                'timezone' => 'Asia/Kolkata',
                'population' => 15000000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 3,
            ],

            // USA Cities
            [
                'country_code' => 'US',
                'name' => 'New York',
                'state_province' => 'New York',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'timezone' => 'America/New_York',
                'population' => 8500000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'US',
                'name' => 'Los Angeles',
                'state_province' => 'California',
                'latitude' => 34.0522,
                'longitude' => -118.2437,
                'timezone' => 'America/Los_Angeles',
                'population' => 4000000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 2,
            ],

            // UK Cities
            [
                'country_code' => 'GB',
                'name' => 'London',
                'state_province' => 'England',
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'timezone' => 'Europe/London',
                'population' => 9000000,
                'is_active' => true,
                'is_capital' => true,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'GB',
                'name' => 'Manchester',
                'state_province' => 'England',
                'latitude' => 53.4808,
                'longitude' => -2.2426,
                'timezone' => 'Europe/London',
                'population' => 2700000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 2,
            ],

            // Thailand Cities
            [
                'country_code' => 'TH',
                'name' => 'Bangkok',
                'state_province' => 'Bangkok Metropolitan Region',
                'latitude' => 13.7563,
                'longitude' => 100.5018,
                'timezone' => 'Asia/Bangkok',
                'population' => 10500000,
                'is_active' => true,
                'is_capital' => true,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'TH',
                'name' => 'Phuket',
                'state_province' => 'Phuket Province',
                'latitude' => 7.8804,
                'longitude' => 98.3923,
                'timezone' => 'Asia/Bangkok',
                'population' => 400000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 2,
            ],

            // UAE Cities
            [
                'country_code' => 'AE',
                'name' => 'Dubai',
                'state_province' => 'Dubai',
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'timezone' => 'Asia/Dubai',
                'population' => 3400000,
                'is_active' => true,
                'is_capital' => false,
                'is_popular' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'AE',
                'name' => 'Abu Dhabi',
                'state_province' => 'Abu Dhabi',
                'latitude' => 24.4539,
                'longitude' => 54.3773,
                'timezone' => 'Asia/Dubai',
                'population' => 1500000,
                'is_active' => true,
                'is_capital' => true,
                'is_popular' => true,
                'position' => 2,
            ],
        ];

        foreach ($cities as $cityData) {
            $country = Country::where('code', $cityData['country_code'])->first();
            
            if ($country) {
                $cityData['country_id'] = $country->id;
                unset($cityData['country_code']);
                
                City::create($cityData);
            }
        }
    }
}