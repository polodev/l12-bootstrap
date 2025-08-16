<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Contact\Models\Contact;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = array_keys(Contact::getAvailableDepartments());
        $users = User::pluck('id')->toArray();
        
        $contacts = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'mobile' => '+1234567890',
                'organization' => 'Tech Solutions Inc.',
                'designation' => 'Software Engineer',
                'topic' => 'Website Development Inquiry',
                'department' => 'sales',
                'message' => 'Hi, I am interested in developing a new website for our company. We need a modern, responsive design with e-commerce capabilities. Could you please provide more information about your services and pricing?',
                'page' => '/services/web-development',
                'has_reply' => false,
                'remarks' => null,
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@company.com',
                'mobile' => '+1987654321',
                'organization' => 'Marketing Pro Ltd.',
                'designation' => 'Marketing Manager',
                'topic' => 'Mobile App Development',
                'department' => 'technical',
                'message' => 'We are looking to develop a mobile application for both iOS and Android platforms. The app should integrate with our existing CRM system. What is your experience with React Native development?',
                'page' => '/services/mobile-apps',
                'has_reply' => true,
                'remarks' => 'Replied via email on ' . now()->subDays(2)->format('Y-m-d') . '. Sent detailed proposal.',
                'user_id' => null,
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@startup.io',
                'mobile' => '+1555987654',
                'organization' => 'StartupIO',
                'designation' => 'CTO',
                'topic' => 'Technical Consultation',
                'department' => 'support',
                'message' => 'Our startup needs technical consultation for scaling our infrastructure. We are currently handling 10k users but expect to grow to 100k in the next 6 months. Can you help us with architecture planning?',
                'page' => '/services/consulting',
                'has_reply' => false,
                'remarks' => null,
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.r@nonprofit.org',
                'mobile' => '+1555123456',
                'organization' => 'Community Health Nonprofit',
                'designation' => 'Program Director',
                'topic' => 'Website Redesign for Nonprofit',
                'department' => 'general',
                'message' => 'Our nonprofit organization needs a website redesign. We want to improve user experience and make it easier for people to donate and volunteer. Do you offer discounted rates for nonprofit organizations?',
                'page' => '/contact',
                'has_reply' => true,
                'remarks' => 'Discussed nonprofit pricing. Sent custom proposal with 25% discount.',
                'user_id' => null,
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@freelance.com',
                'mobile' => '+1444555666',
                'organization' => null,
                'designation' => 'Freelance Designer',
                'topic' => 'Partnership Opportunity',
                'department' => 'partnership',
                'message' => 'I am a freelance UI/UX designer and would like to explore partnership opportunities. I have 5+ years of experience in designing web and mobile applications. Would you be interested in collaborating on projects?',
                'page' => '/about',
                'has_reply' => false,
                'remarks' => 'Portfolio review scheduled for next week.',
                'user_id' => null,
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@ecommerce.com',
                'mobile' => '+1777888999',
                'organization' => 'ECommerce Solutions',
                'designation' => 'Operations Manager',
                'topic' => 'E-commerce Platform Migration',
                'department' => 'technical',
                'message' => 'We need to migrate our e-commerce platform from Magento to a more modern solution. Our current site has about 5000 products and 20k customers. What would be your recommended approach and timeline?',
                'page' => '/services',
                'has_reply' => true,
                'remarks' => 'Technical assessment completed. Migration plan provided.',
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'Robert Kim',
                'email' => 'robert.kim@restaurant.com',
                'mobile' => '+1222333444',
                'organization' => 'Kim\'s Restaurant Chain',
                'designation' => 'IT Manager',
                'topic' => 'POS System Integration',
                'department' => 'support',
                'message' => 'We operate a chain of 15 restaurants and need to integrate our POS systems with an online ordering platform. The system should handle inventory management and customer loyalty programs. Can you help?',
                'page' => '/contact',
                'has_reply' => false,
                'remarks' => null,
                'user_id' => null,
            ],
            [
                'name' => 'Amanda Davis',
                'email' => 'amanda.davis@agency.com',
                'mobile' => '+1555444333',
                'organization' => 'Creative Agency',
                'designation' => 'Account Manager',
                'topic' => 'Client Website Development',
                'department' => 'sales',
                'message' => 'One of our clients needs a complex website with custom CMS, multi-language support, and advanced SEO features. The project budget is around $25k. Are you available for a project of this scale?',
                'page' => '/services/web-development',
                'has_reply' => true,
                'remarks' => 'Initial meeting held. Detailed requirements gathered. Proposal in progress.',
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'James Brown',
                'email' => 'james.brown@personal.com',
                'mobile' => '+1666777888',
                'organization' => null,
                'designation' => null,
                'topic' => 'Personal Portfolio Website',
                'department' => 'general',
                'message' => 'I am a photographer and need a portfolio website to showcase my work. The site should have a gallery, blog section, and contact form. What would be the estimated cost and timeline?',
                'page' => '/services',
                'has_reply' => false,
                'remarks' => 'Waiting for portfolio samples to provide accurate quote.',
                'user_id' => null,
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@education.edu',
                'mobile' => '+1888999000',
                'organization' => 'University of Technology',
                'designation' => 'Professor',
                'topic' => 'Educational Platform Development',
                'department' => 'technical',
                'message' => 'Our university department wants to develop an online learning platform for computer science courses. The platform should support video lectures, assignments, quizzes, and student progress tracking. Do you have experience with educational technology?',
                'page' => '/services/consulting',
                'has_reply' => true,
                'remarks' => 'Educational sector expertise confirmed. Detailed technical discussion scheduled.',
                'user_id' => null,
            ],
            [
                'name' => 'Kevin Lee',
                'email' => 'kevin.lee@startup.tech',
                'mobile' => '+1111222333',
                'organization' => 'TechStartup Inc.',
                'designation' => 'Founder',
                'topic' => 'MVP Development',
                'department' => 'partnership',
                'message' => 'We are a early-stage startup looking for a technical partner to develop our MVP. The project involves a web application with real-time features and mobile app integration. Interested in equity partnership?',
                'page' => '/contact',
                'has_reply' => false,
                'remarks' => null,
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'Rachel White',
                'email' => 'rachel.white@healthcare.com',
                'mobile' => '+1333444555',
                'organization' => 'HealthCare Solutions',
                'designation' => 'Product Manager',
                'topic' => 'HIPAA Compliant Application',
                'department' => 'technical',
                'message' => 'We need to develop a HIPAA-compliant patient management system. The application should handle sensitive medical data with proper encryption and audit trails. Do you have experience with healthcare applications?',
                'page' => '/services',
                'has_reply' => true,
                'remarks' => 'HIPAA compliance expertise confirmed. Security assessment completed.',
                'user_id' => null,
            ],
            [
                'name' => 'Thomas Anderson',
                'email' => 'thomas.anderson@media.com',
                'mobile' => '+1777666555',
                'organization' => 'Digital Media Corp',
                'designation' => 'Content Director',
                'topic' => 'Content Management System',
                'department' => 'support',
                'message' => 'Our media company needs a custom CMS that can handle large video files, automated transcoding, and content distribution. The system should support multiple content creators and approval workflows.',
                'page' => '/services/web-development',
                'has_reply' => false,
                'remarks' => 'Technical requirements under review. Media handling capabilities being assessed.',
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'jennifer.martinez@finance.com',
                'mobile' => '+1999000111',
                'organization' => 'Financial Services LLC',
                'designation' => 'Technology Director',
                'topic' => 'Fintech Application Development',
                'department' => 'technical',
                'message' => 'We are developing a fintech application that requires PCI compliance, real-time transaction processing, and integration with banking APIs. The security requirements are very strict. Can you handle such projects?',
                'page' => '/services',
                'has_reply' => true,
                'remarks' => 'PCI compliance capabilities confirmed. Security protocols reviewed.',
                'user_id' => null,
            ],
            [
                'name' => 'Christopher Taylor',
                'email' => 'chris.taylor@logistics.com',
                'mobile' => '+1555666777',
                'organization' => 'Global Logistics Inc.',
                'designation' => 'Operations Manager',
                'topic' => 'Supply Chain Management System',
                'department' => 'general',
                'message' => 'We need a comprehensive supply chain management system that can track shipments, manage inventory across multiple warehouses, and provide real-time visibility to our customers. The system should integrate with major shipping carriers.',
                'page' => '/contact',
                'has_reply' => false,
                'remarks' => null,
                'user_id' => null,
            ]
        ];

        // Sample IP addresses and user agents for seeding
        $sampleIPs = [
            '192.168.1.100',
            '10.0.0.50',
            '172.16.0.25',
            '203.0.113.45',
            '198.51.100.78',
            '192.0.2.123',
            '203.0.113.89',
            '198.51.100.234'
        ];
        
        $sampleUserAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:121.0) Gecko/20100101 Firefox/121.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1'
        ];

        foreach ($contacts as $contactData) {
            Contact::create(array_merge($contactData, [
                'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                'user_agent' => $sampleUserAgents[array_rand($sampleUserAgents)],
                'created_at' => now()->subDays(rand(1, 30))->subHours(rand(1, 23)),
                'updated_at' => now()->subDays(rand(0, 15))->subHours(rand(1, 23)),
            ]));
        }
    }
}