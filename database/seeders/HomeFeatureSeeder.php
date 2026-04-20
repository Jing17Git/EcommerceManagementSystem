<?php

namespace Database\Seeders;

use App\Models\HomeFeature;
use Illuminate\Database\Seeder;

class HomeFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title' => 'Trusted Sellers',
                'description' => 'Every seller is verified to ensure authentic products and reliable service.',
                'icon' => 'fas fa-store',
                'bg_color' => 'bg-orange-100',
                'icon_color' => 'text-orange-600',
                'position' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Quality Guaranteed',
                'description' => 'Each product is carefully curated to meet our quality standards.',
                'icon' => 'fas fa-medal',
                'bg_color' => 'bg-green-100',
                'icon_color' => 'text-green-600',
                'position' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Fast Shipping',
                'description' => 'Quick delivery across the Philippines and beyond.',
                'icon' => 'fas fa-shipping-fast',
                'bg_color' => 'bg-blue-100',
                'icon_color' => 'text-blue-600',
                'position' => 3,
                'is_active' => true,
            ],
            [
                'title' => '24/7 Support',
                'description' => "We're here to help anytime you need assistance.",
                'icon' => 'fas fa-headset',
                'bg_color' => 'bg-purple-100',
                'icon_color' => 'text-purple-600',
                'position' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            HomeFeature::updateOrCreate(
                ['title' => $feature['title']],
                $feature
            );
        }
    }
}

