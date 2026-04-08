# Payment Integration Setup Guide

## Overview
Your e-commerce system now supports **Bank Transfer**, **GCash**, and **PayMaya** payment methods with proof of payment upload.

## Features Implemented

### 1. Payment Methods
- ✅ GCash
- ✅ PayMaya  
- ✅ Bank Transfer (BDO, BPI, etc.)
- ✅ Multiple payment accounts support
- ✅ Active/Inactive status toggle

### 2. Buyer Features
- ✅ Select payment method during checkout
- ✅ View payment instructions (account name, number, amount)
- ✅ Upload payment proof (screenshot/photo)
- ✅ Order tracking with payment status

### 3. Admin Features
- ✅ Manage payment methods (Create, Edit, Delete)
- ✅ Configure account details
- ✅ Set custom instructions
- ✅ Enable/disable payment methods
- ✅ View payment proofs from orders

## Installation Steps

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create:
- `payment_methods` table
- Add `payment_method` and `payment_proof` columns to `orders` table

### Step 2: Seed Payment Methods
```bash
php artisan db:seed --class=PaymentMethodSeeder
```

This creates default payment methods:
- GCash (09123456789)
- PayMaya (09123456789)
- Bank Transfer - BDO (1234567890)
- Bank Transfer - BPI (0987654321)

### Step 3: Configure Storage
```bash
php artisan storage:link
```

This creates a symbolic link for payment proof uploads.

### Step 4: Update .env (Optional)
Add these if you want to customize:
```env
FILESYSTEM_DISK=public
```

## How It Works

### Buyer Checkout Flow

1. **Add items to cart**
   - Browse products
   - Click "Add to Cart"

2. **Go to Cart** (`/buyer/cart`)
   - Review items
   - Enter shipping address
   - Select payment method (GCash/PayMaya/Bank)
   - View payment instructions
   - Upload payment proof (screenshot)
   - Click "Place Order"

3. **Order Created**
   - Order status: `pending` or `processing`
   - Payment status: `initiated`
   - Payment proof stored in `storage/app/public/payment_proofs/`

4. **Seller/Admin Reviews**
   - Verify payment proof
   - Accept or decline order
   - Update payment status to `captured`

### Admin Management

**Access Payment Methods:**
- URL: `/admin/payment-methods`
- Menu: Admin Dashboard → Payment Methods

**Add New Payment Method:**
1. Click "Add Payment Method"
2. Fill in:
   - Name (e.g., "GCash - Main Account")
   - Type (gcash/paymaya/bank)
   - Account Name
   - Account Number
   - Instructions
   - Status (Active/Inactive)
3. Click "Create Payment Method"

**Edit Payment Method:**
1. Click "Edit" on any payment method
2. Update details
3. Click "Update Payment Method"

**Delete Payment Method:**
1. Click "Delete" on any payment method
2. Confirm deletion

## File Structure

```
app/
├── Models/
│   └── PaymentMethod.php
├── Http/Controllers/
│   ├── BuyerController.php (updated)
│   └── Admin/
│       └── PaymentMethodController.php

database/
├── migrations/
│   ├── 2026_04_04_000001_add_payment_method_to_orders_table.php
│   └── 2026_04_04_000002_create_payment_methods_table.php
└── seeders/
    └── PaymentMethodSeeder.php

resources/views/
├── buyer/
│   └── cart.blade.php (updated)
└── admin/
    └── payment-methods/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php

storage/app/public/
└── payment_proofs/ (auto-created)
```

## Database Schema

### payment_methods table
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Display name (e.g., "GCash") |
| type | string | gcash/paymaya/bank |
| instructions | text | Payment instructions |
| account_name | string | Account holder name |
| account_number | string | Account/mobile number |
| qr_code | string | QR code path (future) |
| is_active | boolean | Active status |

### orders table (new columns)
| Column | Type | Description |
|--------|------|-------------|
| payment_method | string | Selected payment method name |
| payment_proof | string | Path to uploaded proof |

### payments table (updated)
| Column | Type | Description |
|--------|------|-------------|
| provider | string | gcash/paymaya/bank |
| status | enum | initiated/captured/failed/refunded |
| meta | json | Includes payment_proof path |

## Usage Examples

### Example 1: Update GCash Account
1. Go to `/admin/payment-methods`
2. Click "Edit" on GCash
3. Update account number to your GCash number
4. Update account name to your name
5. Save

### Example 2: Add New Bank Account
1. Go to `/admin/payment-methods`
2. Click "Add Payment Method"
3. Fill in:
   - Name: "Bank Transfer - Metrobank"
   - Type: bank
   - Account Name: "Your Name"
   - Account Number: "1234567890123"
   - Instructions: "Transfer to Metrobank account and upload receipt"
4. Click "Create"

### Example 3: Disable PayMaya
1. Go to `/admin/payment-methods`
2. Click "Edit" on PayMaya
3. Uncheck "Active"
4. Save

## Viewing Payment Proofs

Payment proofs are stored in `storage/app/public/payment_proofs/`

**To view in browser:**
```
http://localhost:8000/storage/payment_proofs/filename.jpg
```

**To add to order view:**
```blade
@if($order->payment_proof)
    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Payment Proof">
@endif
```

## Security Notes

1. **File Validation**: Only JPG, PNG images up to 2MB
2. **Storage**: Files stored in `storage/app/public/` (not web-accessible directly)
3. **Access Control**: Only authenticated buyers can upload
4. **Verification**: Admin/seller must verify payment proofs

## Customization

### Change Upload Limits
In `BuyerController.php`:
```php
'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], // 5MB
```

### Add More Payment Types
In migration and validation:
```php
'type' => 'required|in:gcash,paymaya,bank,cod,credit_card',
```

### Auto-Approve Payments
In `BuyerController.php` checkout method:
```php
'status' => 'captured', // Instead of 'initiated'
'paid_at' => now(),
```

## Troubleshooting

### Issue: Payment methods not showing
**Solution:** Run seeder
```bash
php artisan db:seed --class=PaymentMethodSeeder
```

### Issue: Upload fails
**Solution:** Check storage permissions
```bash
php artisan storage:link
chmod -R 775 storage/
```

### Issue: Image not displaying
**Solution:** Verify symbolic link
```bash
ls -la public/storage
```

## Next Steps (Optional Enhancements)

1. **QR Code Support**: Add QR code upload for GCash/PayMaya
2. **Payment Verification**: Add admin approval workflow
3. **Email Notifications**: Send payment instructions via email
4. **Payment History**: Track all payment attempts
5. **Refund System**: Handle payment refunds
6. **API Integration**: Connect to actual GCash/PayMaya APIs

## Support

For issues or questions:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify migrations: `php artisan migrate:status`
- Clear cache: `php artisan cache:clear`

---

**Payment Integration Complete! 🎉**

Your system now supports Philippine payment methods with manual verification.
