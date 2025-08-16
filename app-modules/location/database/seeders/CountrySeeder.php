<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Location\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Bangladesh',
                'code' => 'BD',
                'code_3' => 'BGD',
                'phone_code' => '+880',
                'currency_code' => 'BDT',
                'currency_symbol' => '৳',
                'flag_url' => 'https://flagcdn.com/bd.svg',
                'latitude' => 23.684994,
                'longitude' => 90.356331,
                'is_active' => true,
                'position' => 1,
            ],
            [
                'name' => 'India',
                'code' => 'IN',
                'code_3' => 'IND',
                'phone_code' => '+91',
                'currency_code' => 'INR',
                'currency_symbol' => '₹',
                'flag_url' => 'https://flagcdn.com/in.svg',
                'latitude' => 20.593684,
                'longitude' => 78.96288,
                'is_active' => true,
                'position' => 2,
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'code_3' => 'USA',
                'phone_code' => '+1',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'flag_url' => 'https://flagcdn.com/us.svg',
                'latitude' => 37.09024,
                'longitude' => -95.712891,
                'is_active' => true,
                'position' => 3,
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'code_3' => 'GBR',
                'phone_code' => '+44',
                'currency_code' => 'GBP',
                'currency_symbol' => '£',
                'flag_url' => 'https://flagcdn.com/gb.svg',
                'latitude' => 55.378051,
                'longitude' => -3.435973,
                'is_active' => true,
                'position' => 4,
            ],
            [
                'name' => 'Pakistan',
                'code' => 'PK',
                'code_3' => 'PAK',
                'phone_code' => '+92',
                'currency_code' => 'PKR',
                'currency_symbol' => '₨',
                'flag_url' => 'https://flagcdn.com/pk.svg',
                'latitude' => 30.375321,
                'longitude' => 69.345116,
                'is_active' => true,
                'position' => 5,
            ],
            [
                'name' => 'Thailand',
                'code' => 'TH',
                'code_3' => 'THA',
                'phone_code' => '+66',
                'currency_code' => 'THB',
                'currency_symbol' => '฿',
                'flag_url' => 'https://flagcdn.com/th.svg',
                'latitude' => 15.870032,
                'longitude' => 100.992541,
                'is_active' => true,
                'position' => 6,
            ],
            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'code_3' => 'MYS',
                'phone_code' => '+60',
                'currency_code' => 'MYR',
                'currency_symbol' => 'RM',
                'flag_url' => 'https://flagcdn.com/my.svg',
                'latitude' => 4.210484,
                'longitude' => 101.975766,
                'is_active' => true,
                'position' => 7,
            ],
            [
                'name' => 'Singapore',
                'code' => 'SG',
                'code_3' => 'SGP',
                'phone_code' => '+65',
                'currency_code' => 'SGD',
                'currency_symbol' => 'S$',
                'flag_url' => 'https://flagcdn.com/sg.svg',
                'latitude' => 1.352083,
                'longitude' => 103.819836,
                'is_active' => true,
                'position' => 8,
            ],
            [
                'name' => 'United Arab Emirates',
                'code' => 'AE',
                'code_3' => 'ARE',
                'phone_code' => '+971',
                'currency_code' => 'AED',
                'currency_symbol' => 'د.إ',
                'flag_url' => 'https://flagcdn.com/ae.svg',
                'latitude' => 23.424076,
                'longitude' => 53.847818,
                'is_active' => true,
                'position' => 9,
            ],
            [
                'name' => 'Saudi Arabia',
                'code' => 'SA',
                'code_3' => 'SAU',
                'phone_code' => '+966',
                'currency_code' => 'SAR',
                'currency_symbol' => '﷼',
                'flag_url' => 'https://flagcdn.com/sa.svg',
                'latitude' => 23.885942,
                'longitude' => 45.079162,
                'is_active' => true,
                'position' => 10,
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}