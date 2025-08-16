<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Page\Models\Page;
use App\Models\User;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create Terms of Service page (with template)
        Page::create([
            'english_title' => 'Terms of Service',
            'slug' => 'terms-of-service',
            'title' => [
                'en' => 'Terms of Service',
                'bn' => 'সার্ভিসের শর্তাবলী'
            ],
            'content' => null, // Content is now managed in template files
            'template' => 'legal.terms-of-service.terms-of-service',
            'meta_title' => [
                'en' => 'Terms of Service - Eco Travel',
                'bn' => 'সার্ভিসের শর্তাবলী - ইকো ট্রাভেল'
            ],
            'meta_description' => [
                'en' => 'Read Eco Travel\'s terms of service for travel bookings, flights, hotels, and holiday packages. Understand our booking policies and conditions.',
                'bn' => 'ভ্রমণ বুকিং, ফ্লাইট, হোটেল এবং হলিডে প্যাকেজের জন্য ইকো ট্রাভেলের সার্ভিসের শর্তাবলী পড়ুন। আমাদের বুকিং নীতি ও শর্তাবলী বুঝুন।'
            ],
            'keywords' => [
                'en' => 'eco travel terms, travel booking terms, flight booking conditions, hotel booking policy, holiday package terms',
                'bn' => 'ইকো ট্রাভেল শর্তাবলী, ভ্রমণ বুকিং শর্ত, ফ্লাইট বুকিং নিয়ম, হোটেল বুকিং নীতি, হলিডে প্যাকেজ শর্ত'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 1,
            'user_id' => 1,
        ]);

        // Create Privacy Policy page (with template)
        Page::create([
            'english_title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'title' => [
                'en' => 'Privacy Policy',
                'bn' => 'গোপনীয়তার নীতি'
            ],
            'content' => null, // Content is now managed in template files
            'template' => 'legal.privacy-policy.privacy-policy',
            'meta_title' => [
                'en' => 'Privacy Policy - Eco Travel',
                'bn' => 'গোপনীয়তার নীতি - ইকো ট্রাভেল'
            ],
            'meta_description' => [
                'en' => 'Learn how Eco Travel collects, uses, and protects your personal and travel information. Read our comprehensive privacy policy for travel bookings.',
                'bn' => 'ইকো ট্রাভেল কীভাবে আপনার ব্যক্তিগত ও ভ্রমণ তথ্য সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখে তা জানুন। ভ্রমণ বুকিংয়ের জন্য আমাদের বিস্তৃত গোপনীয়তার নীতি পড়ুন।'
            ],
            'keywords' => [
                'en' => 'eco travel privacy, travel data protection, booking privacy policy, travel information security, passenger data protection',
                'bn' => 'ইকো ট্রাভেল গোপনীয়তা, ভ্রমণ ডেটা সুরক্ষা, বুকিং গোপনীয়তা নীতি, ভ্রমণ তথ্য নিরাপত্তা, যাত্রী ডেটা সুরক্ষা'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 2,
            'user_id' => 1,
        ]);

        // Create FAQ page (no template - default content)
        Page::create([
            'english_title' => 'Frequently Asked Questions',
            'slug' => 'faq',
            'title' => [
                'en' => 'Frequently Asked Questions',
                'bn' => 'প্রায়শই জিজ্ঞাসিত প্রশ্নাবলী'
            ],
            'content' => [
                'en' => "Here are answers to some of the most commonly asked questions about our services:\n\nQ: What services do you offer?\nA: We offer web development, mobile app development, consulting services, and technical support to help businesses grow their digital presence.\n\nQ: How can I get started with your services?\nA: Simply contact us through our contact form or give us a call. We'll schedule a consultation to discuss your needs and provide a customized solution.\n\nQ: What is your typical project timeline?\nA: Project timelines vary depending on complexity and scope. Simple websites typically take 2-4 weeks, while complex applications may take 2-6 months. We'll provide a detailed timeline during our initial consultation.\n\nQ: Do you provide ongoing support?\nA: Yes, we offer comprehensive support and maintenance packages to ensure your website or application continues to perform optimally.\n\nQ: What technologies do you work with?\nA: We work with modern technologies including Laravel, React, Vue.js, Node.js, PHP, Python, and various database systems. We choose the best technology stack for each project.\n\nQ: How do you handle project communication?\nA: We maintain regular communication through email, project management tools, and scheduled meetings. You'll have a dedicated project manager as your primary point of contact.\n\nQ: What are your payment terms?\nA: We typically work with a 50% upfront payment and 50% upon completion. For larger projects, we can arrange milestone-based payments.\n\nQ: Do you offer SEO services?\nA: Yes, we provide SEO optimization as part of our web development services, including on-page SEO, performance optimization, and search engine friendly structure.\n\nQ: Can you help with website maintenance?\nA: Absolutely! We offer various maintenance packages including security updates, content updates, performance monitoring, and regular backups.\n\nQ: How do I get a quote for my project?\nA: Contact us with your project details, and we'll provide a free consultation and detailed quote within 24-48 hours.",
                'bn' => "আমাদের সেবা সম্পর্কে সবচেয়ে সাধারণভাবে জিজ্ঞাসিত কিছু প্রশ্নের উত্তর এখানে রয়েছে:\n\nপ্রশ্ন: আপনারা কী সেবা প্রদান করেন?\nউত্তর: আমরা ওয়েব ডেভেলপমেন্ট, মোবাইল অ্যাপ ডেভেলপমেন্ট, পরামর্শ সেবা এবং প্রযুক্তিগত সহায়তা প্রদান করি ব্যবসার ডিজিটাল উপস্থিতি বৃদ্ধিতে সহায়তা করতে।\n\nপ্রশ্ন: আমি কীভাবে আপনাদের সেবা নিয়ে শুরু করতে পারি?\nউত্তর: আমাদের যোগাযোগ ফর্মের মাধ্যমে বা ফোন করে যোগাযোগ করুন। আমরা আপনার প্রয়োজন নিয়ে আলোচনা করতে এবং কাস্টমাইজড সমাধান প্রদান করতে একটি পরামর্শের সময় নির্ধারণ করব।\n\nপ্রশ্ন: আপনাদের সাধারণ প্রকল্পের সময়সীমা কী?\nউত্তর: জটিলতা এবং পরিধির উপর নির্ভর করে প্রকল্পের সময়সীমা পরিবর্তিত হয়। সাধারণ ওয়েবসাইট সাধারণত ২-৪ সপ্তাহ সময় নেয়, জটিল অ্যাপ্লিকেশনের ক্ষেত্রে ২-৬ মাস লাগতে পারে।\n\nপ্রশ্ন: আপনারা কি চলমান সহায়তা প্রদান করেন?\nউত্তর: হ্যাঁ, আমরা আপনার ওয়েবসাইট বা অ্যাপ্লিকেশন সর্বোত্তমভাবে কাজ করতে নিশ্চিত করতে ব্যাপক সহায়তা এবং রক্ষণাবেক্ষণ প্যাকেজ অফার করি।\n\nপ্রশ্ন: আপনারা কোন প্রযুক্তির সাথে কাজ করেন?\nউত্তর: আমরা Laravel, React, Vue.js, Node.js, PHP, Python এবং বিভিন্ন ডেটাবেস সিস্টেম সহ আধুনিক প্রযুক্তির সাথে কাজ করি।\n\nপ্রশ্ন: আমি আমার প্রকল্পের জন্য কোটেশন কীভাবে পেতে পারি?\nউত্তর: আপনার প্রকল্পের বিবরণ সহ আমাদের সাথে যোগাযোগ করুন, এবং আমরা ২৪-৪৮ ঘন্টার মধ্যে একটি বিনামূল্যে পরামর্শ এবং বিস্তারিত কোটেশন প্রদান করব।"
            ],
            'template' => null, // No template - use default
            'meta_title' => [
                'en' => 'FAQ - Frequently Asked Questions',
                'bn' => 'প্রায়শই জিজ্ঞাসিত প্রশ্নাবলী'
            ],
            'meta_description' => [
                'en' => 'Find answers to frequently asked questions about our web development, mobile app development, and consulting services.',
                'bn' => 'আমাদের ওয়েব ডেভেলপমেন্ট, মোবাইল অ্যাপ ডেভেলপমেন্ট এবং পরামর্শ সেবা সম্পর্কে প্রায়শই জিজ্ঞাসিত প্রশ্নের উত্তর খুঁজুন।'
            ],
            'keywords' => [
                'en' => 'FAQ, questions, answers, web development, support, services, help',
                'bn' => 'প্রশ্নোত্তর, প্রশ্ন, উত্তর, ওয়েব ডেভেলপমেন্ট, সহায়তা, সেবা, সাহায্য'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 2,
            'user_id' => 2,
        ]);

        // Create Refund Policy page (with template)
        Page::create([
            'english_title' => 'Refund Policy',
            'slug' => 'refund-policy',
            'title' => [
                'en' => 'Refund Policy',
                'bn' => 'রিফান্ড নীতি'
            ],
            'content' => null, // Content is now managed in template files
            'template' => 'legal.refund-policy.refund-policy',
            'meta_title' => [
                'en' => 'Refund Policy - Eco Travel',
                'bn' => 'রিফান্ড নীতি - ইকো ট্রাভেল'
            ],
            'meta_description' => [
                'en' => 'Understand Eco Travel\'s refund policy for flight bookings, hotel reservations, and holiday packages. Learn about refund procedures, timelines, and conditions.',
                'bn' => 'ফ্লাইট বুকিং, হোটেল রিজার্ভেশন এবং হলিডে প্যাকেজের জন্য ইকো ট্রাভেলের রিফান্ড নীতি বুঝুন। রিফান্ড প্রক্রিয়া, সময়সীমা এবং শর্তাবলী সম্পর্কে জানুন।'
            ],
            'keywords' => [
                'en' => 'eco travel refund policy, travel refund, flight cancellation refund, hotel booking refund, holiday package refund, refund process, refund timeline',
                'bn' => 'ইকো ট্রাভেল রিফান্ড নীতি, ভ্রমণ রিফান্ড, ফ্লাইট বাতিল রিফান্ড, হোটেল বুকিং রিফান্ড, হলিডে প্যাকেজ রিফান্ড, রিফান্ড প্রক্রিয়া, রিফান্ড সময়সীমা'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 3,
            'user_id' => 1,
        ]);

    }
}