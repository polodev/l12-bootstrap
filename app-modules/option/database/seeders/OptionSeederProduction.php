<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Option\Models\Option;

class OptionSeederProduction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSocialMediaSettings();
        // TODO: Add production option seeding logic
    }
    private function seedSocialMediaSettings(): void
    {
        // Social links as separate batch
        Option::setBatch('social_links', [
            'facebook_link' => [
                'value' => 'https://facebook.com/myapp',
                'type' => 'string',
                'description' => 'Facebook profile URL',
                'position' => 0
            ],
            'twitter_link' => [
                'value' => 'https://twitter.com/myapp',
                'type' => 'string',
                'description' => 'Twitter profile URL',
                'position' => 1
            ],
            'linkedin_link' => [
                'value' => 'https://linkedin.com/company/myapp',
                'type' => 'string',
                'description' => 'LinkedIn company page URL',
                'position' => 2
            ],
            'instagram_link' => [
                'value' => 'https://instagram.com/myapp',
                'type' => 'string',
                'description' => 'Instagram profile URL',
                'position' => 3
            ]
        ]);
    }
}