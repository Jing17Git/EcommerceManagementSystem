<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Welcome Page - Hero
            ['page' => 'welcome', 'section' => 'hero', 'key' => 'title', 'value' => 'Welcome to ShopHub!'],
            ['page' => 'welcome', 'section' => 'hero', 'key' => 'subtitle', 'value' => 'Discover quality products from trusted sellers. Every purchase comes with our satisfaction guarantee.'],
            
            // Welcome Page - Banner Features
            ['page' => 'welcome', 'section' => 'banner_features', 'key' => 'feature1', 'value' => 'Quality Guaranteed'],
            ['page' => 'welcome', 'section' => 'banner_features', 'key' => 'feature2', 'value' => 'Secure Payment'],
            ['page' => 'welcome', 'section' => 'banner_features', 'key' => 'feature3', 'value' => 'Fast Shipping'],
            ['page' => 'welcome', 'section' => 'banner_features', 'key' => 'feature4', 'value' => '24/7 Support'],
            
            // Welcome Page - Why Choose Us
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'title', 'value' => 'Why Choose ShopHub?'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature1_title', 'value' => 'Trusted Sellers'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature1_desc', 'value' => 'Every seller is verified to ensure authentic products and reliable service.'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature2_title', 'value' => 'Quality Guaranteed'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature2_desc', 'value' => 'Each product is carefully curated to meet our quality standards.'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature3_title', 'value' => 'Fast Shipping'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature3_desc', 'value' => 'Quick delivery across the Philippines and beyond.'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature4_title', 'value' => '24/7 Support'],
            ['page' => 'welcome', 'section' => 'why_choose', 'key' => 'feature4_desc', 'value' => 'We\'re here to help anytime you need assistance.'],
            
            // Buyer Dashboard - Hero
            ['page' => 'buyer-dashboard', 'section' => 'hero', 'key' => 'title', 'value' => 'Discover Amazing Products'],
            ['page' => 'buyer-dashboard', 'section' => 'hero', 'key' => 'subtitle', 'value' => 'Find quality products at great prices'],
            ['page' => 'buyer-dashboard', 'section' => 'hero', 'key' => 'cta_text', 'value' => 'Shop Now'],
            
            // Buyer Dashboard - Banner Features
            ['page' => 'buyer-dashboard', 'section' => 'banner_features', 'key' => 'feature1', 'value' => 'Quality Guaranteed'],
            ['page' => 'buyer-dashboard', 'section' => 'banner_features', 'key' => 'feature2', 'value' => 'Secure Payment'],
            ['page' => 'buyer-dashboard', 'section' => 'banner_features', 'key' => 'feature3', 'value' => 'Fast Shipping'],
            ['page' => 'buyer-dashboard', 'section' => 'banner_features', 'key' => 'feature4', 'value' => '24/7 Support'],
            
            // Buyer Dashboard - Why Choose Us
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'title', 'value' => 'Why Choose ShopHub?'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature1_title', 'value' => 'Trusted Sellers'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature1_desc', 'value' => 'Every seller is verified to ensure authentic products and reliable service.'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature2_title', 'value' => 'Quality Guaranteed'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature2_desc', 'value' => 'Each product is carefully curated to meet our quality standards.'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature3_title', 'value' => 'Fast Shipping'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature3_desc', 'value' => 'Quick delivery across the Philippines and beyond.'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature4_title', 'value' => '24/7 Support'],
            ['page' => 'buyer-dashboard', 'section' => 'why_choose', 'key' => 'feature4_desc', 'value' => 'We\'re here to help anytime you need assistance.'],
            
            // Footer
            ['page' => 'footer', 'section' => 'company', 'key' => 'name', 'value' => 'ShopHub'],
            ['page' => 'footer', 'section' => 'company', 'key' => 'tagline', 'value' => 'Your Trusted Online Shop'],
            ['page' => 'footer', 'section' => 'company', 'key' => 'description', 'value' => 'Discover quality products from trusted sellers. Every purchase comes with our satisfaction guarantee.'],
            ['page' => 'footer', 'section' => 'contact', 'key' => 'address', 'value' => 'Philippines'],
            ['page' => 'footer', 'section' => 'contact', 'key' => 'phone', 'value' => '+63 912 345 6789'],
            ['page' => 'footer', 'section' => 'contact', 'key' => 'hours', 'value' => 'Mon - Sat: 9AM - 7PM'],
            ['page' => 'footer', 'section' => 'social', 'key' => 'facebook', 'value' => '#'],
            ['page' => 'footer', 'section' => 'social', 'key' => 'twitter', 'value' => '#'],
            ['page' => 'footer', 'section' => 'social', 'key' => 'instagram', 'value' => '#'],
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                ['page' => $content['page'], 'section' => $content['section'], 'key' => $content['key']],
                ['value' => $content['value']]
            );
        }
    }
}
