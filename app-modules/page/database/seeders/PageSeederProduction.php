<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Page\Models\Page;

class PageSeederProduction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Terms of Service page for production
        Page::firstOrCreate(
            ['slug' => 'terms-of-service'],
            [
                'english_title' => 'Terms of Service',
                'title' => [
                    'en' => 'Terms of Service',
                    'bn' => 'সার্ভিসের শর্তাবলী'
                ],
                'content' => null, // Content is managed in template files
                'template' => 'legal.terms-of-service.terms-of-service',
                'meta_title' => [
                    'en' => 'Terms of Service - Eco Travels Bangladesh',
                    'bn' => 'সার্ভিসের শর্তাবলী - ইকো ট্রাভেলস বাংলাদেশ'
                ],
                'meta_description' => [
                    'en' => 'Read Eco Travels Bangladesh\'s terms of service for travel bookings, flights, hotels, holiday packages, and Hajj & Umrah services. Understand our booking policies and conditions.',
                    'bn' => 'ভ্রমণ বুকিং, ফ্লাইট, হোটেল, হলিডে প্যাকেজ এবং হজ ও উমরাহ সেবার জন্য ইকো ট্রাভেলস বাংলাদেশের সার্ভিসের শর্তাবলী পড়ুন। আমাদের বুকিং নীতি ও শর্তাবলী বুঝুন।'
                ],
                'keywords' => [
                    'en' => 'eco travels bangladesh terms, travel booking terms, flight booking conditions, hotel booking policy, holiday package terms, hajj umrah terms, travel agency terms',
                    'bn' => 'ইকো ট্রাভেলস বাংলাদেশ শর্তাবলী, ভ্রমণ বুকিং শর্ত, ফ্লাইট বুকিং নিয়ম, হোটেল বুকিং নীতি, হলিডে প্যাকেজ শর্ত, হজ উমরাহ শর্ত, ভ্রমণ এজেন্সি শর্ত'
                ],
                'status' => 'published',
                'published_at' => now(),
                'position' => 1,
                'user_id' => 1,
            ]
        );

        // Create Privacy Policy page for production
        Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'english_title' => 'Privacy Policy',
                'title' => [
                    'en' => 'Privacy Policy',
                    'bn' => 'গোপনীয়তার নীতি'
                ],
                'content' => null, // Content is managed in template files
                'template' => 'legal.privacy-policy.privacy-policy',
                'meta_title' => [
                    'en' => 'Privacy Policy - Eco Travels Bangladesh',
                    'bn' => 'গোপনীয়তার নীতি - ইকো ট্রাভেলস বাংলাদেশ'
                ],
                'meta_description' => [
                    'en' => 'Learn how Eco Travels Bangladesh collects, uses, and protects your personal and travel information. Read our comprehensive privacy policy for flight bookings, hotel reservations, and travel services.',
                    'bn' => 'ইকো ট্রাভেলস বাংলাদেশ কীভাবে আপনার ব্যক্তিগত ও ভ্রমণ তথ্য সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখে তা জানুন। ফ্লাইট বুকিং, হোটেল রিজার্ভেশন এবং ভ্রমণ সেবার জন্য আমাদের বিস্তৃত গোপনীয়তার নীতি পড়ুন।'
                ],
                'keywords' => [
                    'en' => 'eco travels bangladesh privacy, travel data protection, booking privacy policy, travel information security, passenger data protection, personal information policy',
                    'bn' => 'ইকো ট্রাভেলস বাংলাদেশ গোপনীয়তা, ভ্রমণ ডেটা সুরক্ষা, বুকিং গোপনীয়তা নীতি, ভ্রমণ তথ্য নিরাপত্তা, যাত্রী ডেটা সুরক্ষা, ব্যক্তিগত তথ্য নীতি'
                ],
                'status' => 'published',
                'published_at' => now(),
                'position' => 2,
                'user_id' => 1,
            ]
        );

        // Create Refund Policy page for production
        Page::firstOrCreate(
            ['slug' => 'refund-policy'],
            [
                'english_title' => 'Refund Policy',
                'title' => [
                    'en' => 'Refund Policy',
                    'bn' => 'রিফান্ড নীতি'
                ],
                'content' => null, // Content is managed in template files
                'template' => 'legal.refund-policy.refund-policy',
                'meta_title' => [
                    'en' => 'Refund Policy - Eco Travels Bangladesh',
                    'bn' => 'রিফান্ড নীতি - ইকো ট্রাভেলস বাংলাদেশ'
                ],
                'meta_description' => [
                    'en' => 'Understand Eco Travels Bangladesh\'s refund policy for flight bookings, hotel reservations, holiday packages, and Hajj & Umrah services. Learn about refund procedures, timelines, and conditions for travel bookings.',
                    'bn' => 'ফ্লাইট বুকিং, হোটেল রিজার্ভেশন, হলিডে প্যাকেজ এবং হজ ও উমরাহ সেবার জন্য ইকো ট্রাভেলস বাংলাদেশের রিফান্ড নীতি বুঝুন। ভ্রমণ বুকিংয়ের জন্য রিফান্ড প্রক্রিয়া, সময়সীমা এবং শর্তাবলী সম্পর্কে জানুন।'
                ],
                'keywords' => [
                    'en' => 'eco travels bangladesh refund policy, travel refund, flight cancellation refund, hotel booking refund, holiday package refund, hajj umrah refund, refund process, refund timeline, travel insurance',
                    'bn' => 'ইকো ট্রাভেলস বাংলাদেশ রিফান্ড নীতি, ভ্রমণ রিফান্ড, ফ্লাইট বাতিল রিফান্ড, হোটেল বুকিং রিফান্ড, হলিডে প্যাকেজ রিফান্ড, হজ উমরাহ রিফান্ড, রিফান্ড প্রক্রিয়া, রিফান্ড সময়সীমা, ভ্রমণ বীমা'
                ],
                'status' => 'published',
                'published_at' => now(),
                'position' => 3,
                'user_id' => 1,
            ]
        );
    }
}