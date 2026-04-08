<?php
/**
 * Update Payment Accounts via Artisan Tinker
 * 
 * Run: php artisan tinker
 * Then paste these commands one by one
 */

// Update GCash
$gcash = \App\Models\PaymentMethod::where('type', 'gcash')->first();
$gcash->account_name = 'Your Full Name';
$gcash->account_number = '09171234567';
$gcash->instructions = 'Send payment to the GCash number below and upload screenshot as proof.';
$gcash->save();

// Update PayMaya
$paymaya = \App\Models\PaymentMethod::where('type', 'paymaya')->first();
$paymaya->account_name = 'Your Full Name';
$paymaya->account_number = '09181234567';
$paymaya->instructions = 'Send payment to the PayMaya number below and upload screenshot as proof.';
$paymaya->save();

// Update BDO
$bdo = \App\Models\PaymentMethod::where('name', 'Bank Transfer - BDO')->first();
$bdo->account_name = 'Your Full Name';
$bdo->account_number = '1234567890';
$bdo->instructions = 'Transfer to BDO account below and upload deposit slip or screenshot.';
$bdo->save();

// Update BPI
$bpi = \App\Models\PaymentMethod::where('name', 'Bank Transfer - BPI')->first();
$bpi->account_name = 'Your Full Name';
$bpi->account_number = '0987654321';
$bpi->instructions = 'Transfer to BPI account below and upload deposit slip or screenshot.';
$bpi->save();

// View all to verify
\App\Models\PaymentMethod::all(['id', 'name', 'account_name', 'account_number', 'is_active']);
