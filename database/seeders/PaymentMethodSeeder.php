<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'GCash',
                'type' => 'gcash',
                'instructions' => 'Send payment to the GCash number below and upload proof of payment.',
                'account_name' => 'Store Owner',
                'account_number' => '09123456789',
                'is_active' => true,
            ],
            [
                'name' => 'PayMaya',
                'type' => 'paymaya',
                'instructions' => 'Send payment to the PayMaya number below and upload proof of payment.',
                'account_name' => 'Store Owner',
                'account_number' => '09123456789',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Transfer - BDO',
                'type' => 'bank',
                'instructions' => 'Transfer to BDO account below and upload deposit slip or screenshot.',
                'account_name' => 'Store Owner',
                'account_number' => '1234567890',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Transfer - BPI',
                'type' => 'bank',
                'instructions' => 'Transfer to BPI account below and upload deposit slip or screenshot.',
                'account_name' => 'Store Owner',
                'account_number' => '0987654321',
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
