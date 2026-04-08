# 📝 Step-by-Step Guide: Update Payment Account Details

## 🎯 Goal
Update the default payment account numbers with YOUR real GCash, PayMaya, and Bank account details.

---

## ✅ Method 1: Admin Panel (EASIEST - Recommended)

### Step 1: Login as Admin

```
1. Open browser
2. Go to: http://localhost:8000/login
3. Enter admin credentials:
   Email: admin@example.com (or your admin email)
   Password: (your admin password)
4. Click "Login"
```

### Step 2: Navigate to Payment Methods

```
Option A: Direct URL
- Go to: http://localhost:8000/admin/payment-methods

Option B: From Dashboard
- Click "Admin Dashboard" in menu
- Look for "Payment Methods" link
- Click it
```

### Step 3: You'll See This Table

```
┌────────────────────────────────────────────────────────────────┐
│ Payment Methods                        [+ Add Payment Method]  │
├────────────────────────────────────────────────────────────────┤
│ Name          │ Type    │ Account Name │ Account #   │ Actions│
│───────────────┼─────────┼──────────────┼─────────────┼────────│
│ GCash         │ GCASH   │ Store Owner  │ 09123456789 │ [Edit] │
│ PayMaya       │ PAYMAYA │ Store Owner  │ 09123456789 │ [Edit] │
│ Bank - BDO    │ BANK    │ Store Owner  │ 1234567890  │ [Edit] │
│ Bank - BPI    │ BANK    │ Store Owner  │ 0987654321  │ [Edit] │
└────────────────────────────────────────────────────────────────┘
```

### Step 4: Edit GCash

```
1. Click "Edit" button on the GCash row
2. You'll see this form:

┌────────────────────────────────────────────────────────────────┐
│ Edit Payment Method                                            │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│ Name: [GCash                                    ]              │
│                                                                │
│ Type: [gcash ▼]                                               │
│                                                                │
│ Account Name: [Store Owner                      ]              │
│               ↑ CHANGE THIS TO YOUR NAME                       │
│                                                                │
│ Account Number: [09123456789                    ]              │
│                 ↑ CHANGE THIS TO YOUR GCASH NUMBER            │
│                                                                │
│ Instructions:                                                  │
│ [Send payment to the GCash number below and    ]              │
│ [upload proof of payment.                      ]              │
│                                                                │
│ ☑ Active                                                      │
│                                                                │
│ [Update Payment Method] [Cancel]                              │
└────────────────────────────────────────────────────────────────┘

3. Update these fields:
   Account Name: Juan Dela Cruz (your name)
   Account Number: 09171234567 (your GCash number)

4. Click "Update Payment Method"
5. You'll see: ✅ "Payment method updated successfully."
```

### Step 5: Edit PayMaya

```
1. Click "Edit" on PayMaya row
2. Update:
   Account Name: Juan Dela Cruz (your name)
   Account Number: 09181234567 (your PayMaya number)
3. Click "Update Payment Method"
```

### Step 6: Edit Bank Transfer - BDO

```
1. Click "Edit" on Bank Transfer - BDO row
2. Update:
   Account Name: Juan Dela Cruz (your name)
   Account Number: 1234567890123 (your BDO account number)
3. Click "Update Payment Method"
```

### Step 7: Edit Bank Transfer - BPI

```
1. Click "Edit" on Bank Transfer - BPI row
2. Update:
   Account Name: Juan Dela Cruz (your name)
   Account Number: 0987654321098 (your BPI account number)
3. Click "Update Payment Method"

OR if you don't have BPI:
1. Click "Delete" button
2. Confirm deletion
```

### Step 8: Verify Changes

```
Go back to: http://localhost:8000/admin/payment-methods

You should now see YOUR account details:

┌────────────────────────────────────────────────────────────────┐
│ Name          │ Type    │ Account Name    │ Account #        │
│───────────────┼─────────┼─────────────────┼──────────────────│
│ GCash         │ GCASH   │ Juan Dela Cruz  │ 09171234567     │
│ PayMaya       │ PAYMAYA │ Juan Dela Cruz  │ 09181234567     │
│ Bank - BDO    │ BANK    │ Juan Dela Cruz  │ 1234567890123   │
└────────────────────────────────────────────────────────────────┘
```

---

## ✅ Method 2: Using phpMyAdmin (Alternative)

### Step 1: Open phpMyAdmin

```
1. Go to: http://localhost/phpmyadmin
2. Login (usually no password for XAMPP)
```

### Step 2: Select Database

```
1. Click on "ecommercemanagementsystem" database (left sidebar)
2. Click on "payment_methods" table
```

### Step 3: Edit Records

```
1. Click "Browse" tab
2. You'll see 4 rows
3. Click "Edit" (pencil icon) on each row
4. Update:
   - account_name: Your Full Name
   - account_number: Your Account Number
5. Click "Go" to save
6. Repeat for all 4 rows
```

### Step 4: Or Use SQL Tab

```
1. Click "SQL" tab
2. Paste this (replace with YOUR details):

UPDATE payment_methods 
SET account_name = 'Juan Dela Cruz', 
    account_number = '09171234567'
WHERE id = 1;

UPDATE payment_methods 
SET account_name = 'Juan Dela Cruz', 
    account_number = '09181234567'
WHERE id = 2;

UPDATE payment_methods 
SET account_name = 'Juan Dela Cruz', 
    account_number = '1234567890123'
WHERE id = 3;

UPDATE payment_methods 
SET account_name = 'Juan Dela Cruz', 
    account_number = '0987654321098'
WHERE id = 4;

3. Click "Go"
4. You'll see: "4 rows affected"
```

---

## ✅ Method 3: Using Command Line (Advanced)

### Option A: Artisan Tinker

```bash
# Open command prompt in project directory
cd c:\xampp\htdocs\EcommerceManagementSystem

# Start tinker
php artisan tinker

# Update GCash
$gcash = App\Models\PaymentMethod::find(1);
$gcash->account_name = 'Juan Dela Cruz';
$gcash->account_number = '09171234567';
$gcash->save();

# Update PayMaya
$paymaya = App\Models\PaymentMethod::find(2);
$paymaya->account_name = 'Juan Dela Cruz';
$paymaya->account_number = '09181234567';
$paymaya->save();

# Update BDO
$bdo = App\Models\PaymentMethod::find(3);
$bdo->account_name = 'Juan Dela Cruz';
$bdo->account_number = '1234567890123';
$bdo->save();

# Update BPI
$bpi = App\Models\PaymentMethod::find(4);
$bpi->account_name = 'Juan Dela Cruz';
$bpi->account_number = '0987654321098';
$bpi->save();

# Verify
App\Models\PaymentMethod::all(['name', 'account_name', 'account_number']);

# Exit
exit
```

### Option B: MySQL Command Line

```bash
# Open MySQL
mysql -u root -p

# Select database
USE ecommercemanagementsystem;

# Update records
UPDATE payment_methods SET account_name = 'Juan Dela Cruz', account_number = '09171234567' WHERE id = 1;
UPDATE payment_methods SET account_name = 'Juan Dela Cruz', account_number = '09181234567' WHERE id = 2;
UPDATE payment_methods SET account_name = 'Juan Dela Cruz', account_number = '1234567890123' WHERE id = 3;
UPDATE payment_methods SET account_name = 'Juan Dela Cruz', account_number = '0987654321098' WHERE id = 4;

# Verify
SELECT id, name, account_name, account_number FROM payment_methods;

# Exit
exit;
```

---

## 🎯 Quick Reference: What to Update

### For GCash:
```
Account Name: Your full name (as registered in GCash)
Account Number: Your 11-digit mobile number (09XXXXXXXXX)
Example: 09171234567
```

### For PayMaya:
```
Account Name: Your full name (as registered in PayMaya)
Account Number: Your 11-digit mobile number (09XXXXXXXXX)
Example: 09181234567
```

### For Bank Transfer - BDO:
```
Account Name: Your full name (as in bank account)
Account Number: Your BDO account number (10-13 digits)
Example: 1234567890123
```

### For Bank Transfer - BPI:
```
Account Name: Your full name (as in bank account)
Account Number: Your BPI account number (10-13 digits)
Example: 0987654321098
```

---

## ✅ Verification Checklist

After updating, verify by:

### 1. Check Admin Panel
```
✓ Go to /admin/payment-methods
✓ See your name in Account Name column
✓ See your numbers in Account Number column
✓ All methods show "Active" status
```

### 2. Test Buyer View
```
✓ Login as buyer
✓ Add item to cart
✓ Go to /buyer/cart
✓ Select a payment method
✓ Verify YOUR account details appear
✓ Check account name matches
✓ Check account number matches
```

### 3. Test Complete Flow
```
✓ Complete a test order
✓ Upload test payment proof
✓ Check order shows correct payment method
✓ Verify payment proof is stored
```

---

## 🚨 Common Issues & Solutions

### Issue 1: Can't access /admin/payment-methods
**Solution:**
```
- Make sure you're logged in as admin
- Check if routes are cached: php artisan route:clear
- Verify admin middleware is working
```

### Issue 2: Changes not showing
**Solution:**
```
- Clear browser cache (Ctrl + Shift + Delete)
- Clear Laravel cache: php artisan cache:clear
- Refresh the page (Ctrl + F5)
```

### Issue 3: Edit button not working
**Solution:**
```
- Check browser console for errors (F12)
- Verify JavaScript is enabled
- Try different browser
```

### Issue 4: Can't find payment_methods table
**Solution:**
```
- Run migrations: php artisan migrate
- Seed data: php artisan db:seed --class=PaymentMethodSeeder
```

---

## 📋 Example: Complete Update

Here's a complete example with real-looking data:

```
GCash:
- Name: GCash
- Type: gcash
- Account Name: Maria Santos
- Account Number: 09171234567
- Instructions: Send payment to the GCash number below and upload screenshot.
- Active: ✓

PayMaya:
- Name: PayMaya
- Type: paymaya
- Account Name: Maria Santos
- Account Number: 09181234567
- Instructions: Send payment to the PayMaya number below and upload screenshot.
- Active: ✓

Bank Transfer - BDO:
- Name: Bank Transfer - BDO
- Type: bank
- Account Name: Maria Santos
- Account Number: 1234567890123
- Instructions: Transfer to BDO account and upload deposit slip or screenshot.
- Active: ✓

Bank Transfer - BPI:
- Name: Bank Transfer - BPI
- Type: bank
- Account Name: Maria Santos
- Account Number: 0987654321098
- Instructions: Transfer to BPI account and upload deposit slip or screenshot.
- Active: ✓
```

---

## 🎉 You're Done!

Once updated, your payment system will show YOUR account details to buyers during checkout!

**Next:** Test the complete flow by placing a test order.

---

## 📞 Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console (F12)
3. Verify database connection
4. Clear all caches

**Recommended Method:** Use Admin Panel (Method 1) - It's the easiest and safest!
