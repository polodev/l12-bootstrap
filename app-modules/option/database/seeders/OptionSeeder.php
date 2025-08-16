<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing options (optional - remove if you want to preserve existing data)
        // Option::truncate();

        $this->seedGeneralSettings();
        $this->seedThemeSettings();
        $this->seedApiConfiguration();
        $this->seedSocialMediaSettings();
        $this->seedEmailSettings();
        $this->seedSeoSettings();
        $this->seedSystemSettings();
        $this->seedFeatureFlags();
        $this->seedDataTypeExamples();
        $this->seedPerformanceSettings();
    }

    /**
     * Seed general application settings
     */
    private function seedGeneralSettings(): void
    {
        Option::setBatch('general', [
            'site_name' => [
                'value' => 'My Laravel Application',
                'type' => 'string',
                'description' => 'The name of the website/application',
                'is_autoload' => true,
                'position' => 0
            ],
            'site_description' => [
                'value' => 'A powerful Laravel application with modular architecture',
                'type' => 'string',
                'description' => 'Brief description of the website/application',
                'position' => 1
            ],
            'site_logo' => [
                'value' => '/images/logo.png',
                'type' => 'string',
                'description' => 'Path to the site logo image',
                'position' => 2
            ],
            'maintenance_mode' => [
                'value' => false,
                'type' => 'boolean',
                'description' => 'Enable/disable site maintenance mode',
                'is_autoload' => true,
                'position' => 3
            ],
            'max_file_upload_size' => [
                'value' => 10,
                'type' => 'integer',
                'description' => 'Maximum file upload size in MB',
                'position' => 4
            ],
            'timezone' => [
                'value' => 'UTC',
                'type' => 'string',
                'description' => 'Default application timezone',
                'is_autoload' => true,
                'position' => 5
            ]
        ]);
    }

    /**
     * Seed theme and appearance settings
     */
    private function seedThemeSettings(): void
    {
        Option::setBatch('theme', [
            'primary_color' => [
                'value' => '#1e40af',
                'type' => 'string',
                'description' => 'Primary brand color (hex)'
            ],
            'secondary_color' => [
                'value' => '#10b981',
                'type' => 'string', 
                'description' => 'Secondary brand color (hex)'
            ],
            'dark_mode_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable dark mode support'
            ],
            'default_theme' => [
                'value' => 'light',
                'type' => 'string',
                'description' => 'Default theme (light/dark/system)'
            ],
            'font_family' => [
                'value' => 'Inter, sans-serif',
                'type' => 'string',
                'description' => 'Default font family'
            ],
            'custom_css' => [
                'value' => '/* Custom CSS styles */\n.custom-header { margin-top: 20px; }',
                'type' => 'string',
                'description' => 'Custom CSS to be injected into pages'
            ]
        ]);
    }

    /**
     * Seed API configuration settings
     */
    private function seedApiConfiguration(): void
    {
        Option::setBatch('api_config', [
            'api_rate_limit' => [
                'value' => 100,
                'type' => 'integer',
                'description' => 'API requests per minute limit'
            ],
            'api_timeout' => [
                'value' => 30.5,
                'type' => 'float',
                'description' => 'API request timeout in seconds'
            ],
            'allowed_origins' => [
                'value' => ['https://example.com', 'https://app.example.com', 'http://localhost:3000'],
                'type' => 'array',
                'description' => 'CORS allowed origins list'
            ],
            'api_keys' => [
                'value' => [
                    'stripe' => 'sk_test_example_key',
                    'paypal' => 'sb_test_example',
                    'google_maps' => 'AIza_example_key'
                ],
                'type' => 'json',
                'description' => 'External API keys configuration'
            ],
            'webhook_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable webhook functionality'
            ]
        ]);
    }

    /**
     * Seed social media integration settings
     */
    private function seedSocialMediaSettings(): void
    {
        Option::setBatch('social_media', [
            'facebook_app_id' => [
                'value' => '1234567890123456',
                'type' => 'string',
                'description' => 'Facebook App ID for social login'
            ],
            'twitter_handle' => [
                'value' => '@myapp',
                'type' => 'string',
                'description' => 'Official Twitter handle'
            ],
            'social_sharing_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable social sharing buttons'
            ]
        ]);

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

    /**
     * Seed email configuration settings
     */
    private function seedEmailSettings(): void
    {
        Option::setBatch('email', [
            'from_email' => [
                'value' => 'noreply@example.com',
                'type' => 'string',
                'description' => 'Default from email address',
                'is_autoload' => true
            ],
            'from_name' => [
                'value' => 'My Laravel App',
                'type' => 'string',
                'description' => 'Default from name for emails',
                'is_autoload' => true
            ],
            'email_templates' => [
                'value' => [
                    'welcome' => 'emails.welcome',
                    'reset_password' => 'emails.reset-password',
                    'notification' => 'emails.notification'
                ],
                'type' => 'json',
                'description' => 'Email template mappings'
            ],
            'email_queue_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable email queueing'
            ],
            'daily_email_limit' => [
                'value' => 1000,
                'type' => 'integer',
                'description' => 'Maximum emails to send per day'
            ]
        ]);
    }

    /**
     * Seed SEO and meta settings
     */
    private function seedSeoSettings(): void
    {
        Option::setBatch('seo', [
            'meta_description' => [
                'value' => 'A comprehensive Laravel application built with modern best practices',
                'type' => 'string',
                'description' => 'Default meta description for pages'
            ],
            'meta_keywords' => [
                'value' => 'laravel, php, web application, modern',
                'type' => 'string',
                'description' => 'Default meta keywords'
            ],
            'og_image' => [
                'value' => '/images/og-image.jpg',
                'type' => 'string',
                'description' => 'Default Open Graph image'
            ],
            'google_analytics_id' => [
                'value' => 'GA-XXXXXXXXX-X',
                'type' => 'string',
                'description' => 'Google Analytics tracking ID'
            ],
            'structured_data' => [
                'value' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebApplication',
                    'name' => 'My Laravel App',
                    'url' => 'https://example.com'
                ],
                'type' => 'json',
                'description' => 'Structured data for search engines'
            ]
        ]);
    }

    /**
     * Seed system-level settings (protected)
     */
    private function seedSystemSettings(): void
    {
        Option::setBatch('system', [
            'app_version' => [
                'value' => '1.0.0',
                'type' => 'string',
                'description' => 'Current application version',
                'is_system' => true,
                'is_autoload' => true
            ],
            'database_version' => [
                'value' => '2025.01.28',
                'type' => 'string',
                'description' => 'Database schema version',
                'is_system' => true
            ],
            'last_backup' => [
                'value' => '2025-01-28 10:30:00',
                'type' => 'string',
                'description' => 'Timestamp of last system backup',
                'is_system' => true
            ],
            'system_health' => [
                'value' => [
                    'status' => 'healthy',
                    'uptime' => '99.9%',
                    'last_check' => '2025-01-28T10:30:00Z',
                    'services' => [
                        'database' => 'online',
                        'cache' => 'online',
                        'queue' => 'online'
                    ]
                ],
                'type' => 'json',
                'description' => 'System health monitoring data',
                'is_system' => true
            ]
        ]);
    }

    /**
     * Seed feature flags for A/B testing and gradual rollouts
     */
    private function seedFeatureFlags(): void
    {
        Option::setBatch('features', [
            'new_dashboard_enabled' => [
                'value' => false,
                'type' => 'boolean',
                'description' => 'Enable new dashboard interface'
            ],
            'beta_features_enabled' => [
                'value' => false,
                'type' => 'boolean',
                'description' => 'Enable beta features for testing'
            ],
            'experimental_api' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable experimental API endpoints'
            ],
            'feature_rollout_percentage' => [
                'value' => 25.5,
                'type' => 'float',
                'description' => 'Percentage of users to show new features'
            ],
            'enabled_modules' => [
                'value' => ['user-management', 'file-upload', 'notifications', 'analytics'],
                'type' => 'array',
                'description' => 'List of enabled application modules'
            ]
        ]);
    }

    /**
     * Seed examples of all data types (for reference)
     */
    private function seedDataTypeExamples(): void
    {
        Option::setBatch('examples', [
            'string_example' => [
                'value' => 'This is a simple string value',
                'type' => 'string',
                'description' => 'Example of string data type'
            ],
            'integer_example' => [
                'value' => 42,
                'type' => 'integer',
                'description' => 'Example of integer data type'
            ],
            'float_example' => [
                'value' => 3.14159,
                'type' => 'float',
                'description' => 'Example of float data type'
            ],
            'boolean_true_example' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Example of boolean (true) data type'
            ],
            'boolean_false_example' => [
                'value' => false,
                'type' => 'boolean',
                'description' => 'Example of boolean (false) data type'
            ],
            'array_example' => [
                'value' => ['apple', 'banana', 'cherry', 'date'],
                'type' => 'array',
                'description' => 'Example of array data type (simple list)'
            ],
            'json_object_example' => [
                'value' => [
                    'name' => 'John Doe',
                    'age' => 30,
                    'city' => 'New York',
                    'hobbies' => ['reading', 'gaming', 'cooking'],
                    'active' => true
                ],
                'type' => 'json',
                'description' => 'Example of JSON object data type'
            ],
            'json_nested_example' => [
                'value' => [
                    'user' => [
                        'profile' => [
                            'basic' => ['name' => 'Jane', 'email' => 'jane@example.com'],
                            'preferences' => ['theme' => 'dark', 'notifications' => true]
                        ],
                        'settings' => [
                            'privacy' => 'private',
                            'language' => 'en'
                        ]
                    ]
                ],
                'type' => 'json',
                'description' => 'Example of nested JSON structure'
            ]
        ]);
    }

    /**
     * Seed performance and caching settings
     */
    private function seedPerformanceSettings(): void
    {
        Option::setBatch('performance', [
            'cache_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable application caching',
                'is_autoload' => true
            ],
            'cache_ttl' => [
                'value' => 3600,
                'type' => 'integer',
                'description' => 'Default cache TTL in seconds'
            ],
            'compression_enabled' => [
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable response compression'
            ],
            'cdn_settings' => [
                'value' => [
                    'enabled' => true,
                    'base_url' => 'https://cdn.example.com',
                    'assets' => ['css', 'js', 'images'],
                    'cache_headers' => [
                        'max-age' => 31536000,
                        'public' => true
                    ]
                ],
                'type' => 'json',
                'description' => 'CDN configuration settings'
            ],
            'database_query_cache' => [
                'value' => 900,
                'type' => 'integer',
                'description' => 'Database query cache duration in seconds'
            ]
        ]);

        // Add some individual options without batch
        Option::set(
            'global_announcement',
            'Welcome to our new and improved platform!',
            'string',
            'Global announcement message displayed site-wide',
            true // autoload
        );

        Option::set(
            'debug_mode',
            false,
            'boolean',
            'Enable debug mode for development',
            true, // autoload
            null // no batch
        );

        Option::set(
            'contact_email',
            'contact@example.com',
            'string',
            'Main contact email address',
            true // autoload
        );
    }
}