# Payment Integration - Visual Flow

## 🛒 Complete Buyer Journey

```
┌─────────────────────────────────────────────────────────────┐
│                    1. BROWSE & ADD TO CART                   │
│                                                              │
│  [Product Page] → Click "Add to Cart" → [Cart Icon +1]     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    2. VIEW CART & CHECKOUT                   │
│                                                              │
│  URL: /buyer/cart                                           │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Cart Items:                                          │  │
│  │ • Product 1 - ₱500 x 2 = ₱1,000                     │  │
│  │ • Product 2 - ₱300 x 1 = ₱300                       │  │
│  │                                                      │  │
│  │ Subtotal: ₱1,300                                    │  │
│  │ Total: ₱1,300                                       │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Checkout Form:                                       │  │
│  │                                                      │  │
│  │ Shipping Address: [text area]                       │  │
│  │ Notes: [optional text area]                         │  │
│  │                                                      │  │
│  │ Payment Method: *                                   │  │
│  │ ○ GCash                                             │  │
│  │ ○ PayMaya                                           │  │
│  │ ○ Bank Transfer - BDO                              │  │
│  │ ○ Bank Transfer - BPI                              │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                3. SELECT PAYMENT METHOD                      │
│                                                              │
│  User clicks: ● GCash                                       │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ 📱 Payment Instructions                              │  │
│  │                                                      │  │
│  │ Send payment to the GCash number below and          │  │
│  │ upload proof of payment.                            │  │
│  │                                                      │  │
│  │ Account Name: Store Owner                           │  │
│  │ Account Number: 09123456789                         │  │
│  │ Amount to Pay: ₱1,300.00                           │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                4. UPLOAD PAYMENT PROOF                       │
│                                                              │
│  Upload Payment Proof: [Choose File] screenshot.jpg         │
│  (Upload screenshot or photo of payment)                    │
│                                                              │
│  [Place Order Button]                                       │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    5. ORDER CREATED                          │
│                                                              │
│  ✅ Success! Your order has been placed.                    │
│                                                              │
│  Order Details:                                             │
│  • Order Number: ORD-20260404123456-ABC123                 │
│  • Status: Pending                                          │
│  • Payment Method: GCash                                    │
│  • Payment Proof: ✓ Uploaded                               │
│  • Total: ₱1,300.00                                        │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                6. VIEW ORDER STATUS                          │
│                                                              │
│  URL: /buyer/orders                                         │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Order  │ Seller │ Amount  │ Payment │ Status        │  │
│  │────────┼────────┼─────────┼─────────┼───────────────│  │
│  │ ORD-001│ Store  │ ₱1,300  │ GCash   │ Pending       │  │
│  │        │        │         │ [View]  │               │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## 🔧 Admin Management Flow

```
┌─────────────────────────────────────────────────────────────┐
│                ADMIN PAYMENT METHODS PANEL                   │
│                                                              │
│  URL: /admin/payment-methods                                │
│                                                              │
│  [+ Add Payment Method]                                     │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Name          │ Type    │ Account      │ Status      │  │
│  │───────────────┼─────────┼──────────────┼─────────────│  │
│  │ GCash         │ GCASH   │ 09123456789  │ ✓ Active   │  │
│  │               │         │              │ [Edit][Del] │  │
│  │───────────────┼─────────┼──────────────┼─────────────│  │
│  │ PayMaya       │ PAYMAYA │ 09123456789  │ ✓ Active   │  │
│  │               │         │              │ [Edit][Del] │  │
│  │───────────────┼─────────┼──────────────┼─────────────│  │
│  │ Bank - BDO    │ BANK    │ 1234567890   │ ✓ Active   │  │
│  │               │         │              │ [Edit][Del] │  │
│  │───────────────┼─────────┼──────────────┼─────────────│  │
│  │ Bank - BPI    │ BANK    │ 0987654321   │ ✓ Active   │  │
│  │               │         │              │ [Edit][Del] │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    EDIT PAYMENT METHOD                       │
│                                                              │
│  URL: /admin/payment-methods/1/edit                         │
│                                                              │
│  Name: [GCash - Main Account____________]                   │
│                                                              │
│  Type: [gcash ▼]                                            │
│                                                              │
│  Account Name: [Juan Dela Cruz__________]                   │
│                                                              │
│  Account Number: [09171234567___________]                   │
│                                                              │
│  Instructions:                                              │
│  [Send payment to the GCash number     ]                    │
│  [below and upload proof of payment.   ]                    │
│  [                                      ]                    │
│                                                              │
│  ☑ Active                                                   │
│                                                              │
│  [Update Payment Method] [Cancel]                           │
└─────────────────────────────────────────────────────────────┘
```

## 📊 Database Structure

```
┌─────────────────────────────────────────────────────────────┐
│                    payment_methods                           │
├─────────────────────────────────────────────────────────────┤
│ id              │ 1                                         │
│ name            │ "GCash"                                   │
│ type            │ "gcash"                                   │
│ instructions    │ "Send payment to..."                      │
│ account_name    │ "Store Owner"                             │
│ account_number  │ "09123456789"                             │
│ is_active       │ true                                      │
│ created_at      │ 2026-04-04 10:00:00                      │
│ updated_at      │ 2026-04-04 10:00:00                      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                         orders                               │
├─────────────────────────────────────────────────────────────┤
│ id                │ 1                                       │
│ user_id           │ 2                                       │
│ seller_id         │ 3                                       │
│ order_number      │ "ORD-20260404123456-ABC123"            │
│ total_amount      │ 1300.00                                 │
│ status            │ "pending"                               │
│ payment_method    │ "GCash"                    ← NEW        │
│ payment_proof     │ "payment_proofs/xyz.jpg"   ← NEW        │
│ shipping_address  │ "123 Main St..."                        │
│ created_at        │ 2026-04-04 12:30:00                    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                        payments                              │
├─────────────────────────────────────────────────────────────┤
│ id              │ 1                                         │
│ order_id        │ 1                                         │
│ provider        │ "gcash"                      ← UPDATED    │
│ reference       │ "PAY-20260404123456-1"                    │
│ amount          │ 1300.00                                   │
│ currency        │ "PHP"                                     │
│ status          │ "initiated"                  ← UPDATED    │
│ paid_at         │ null                         ← UPDATED    │
│ meta            │ {"payment_proof": "..."}     ← UPDATED    │
│ created_at      │ 2026-04-04 12:30:00                      │
└─────────────────────────────────────────────────────────────┘
```

## 🎯 Payment Verification Flow

```
BUYER                    SYSTEM                    ADMIN/SELLER
  │                        │                            │
  │ 1. Place Order         │                            │
  │───────────────────────>│                            │
  │                        │                            │
  │                        │ 2. Create Order            │
  │                        │    Status: pending         │
  │                        │    Payment: initiated      │
  │                        │                            │
  │                        │ 3. Store Payment Proof     │
  │                        │    /storage/payment_proofs/│
  │                        │                            │
  │                        │ 4. Notify Seller           │
  │                        │───────────────────────────>│
  │                        │                            │
  │                        │                            │ 5. View Order
  │                        │                            │    Check Proof
  │                        │                            │
  │                        │ 6. Verify Payment          │
  │                        │<───────────────────────────│
  │                        │                            │
  │                        │ 7. Update Status           │
  │                        │    Status: processing      │
  │                        │    Payment: captured       │
  │                        │                            │
  │ 8. Order Confirmed     │                            │
  │<───────────────────────│                            │
  │                        │                            │
```

## 📱 Mobile Payment Screenshots

```
┌─────────────────────────────────────────────────────────────┐
│              WHAT BUYERS SHOULD UPLOAD                       │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  GCash Screenshot:                                          │
│  ┌────────────────────────────────────────────────────┐    │
│  │ 📱 GCash                                           │    │
│  │                                                    │    │
│  │ ✓ Payment Successful                              │    │
│  │                                                    │    │
│  │ Amount: ₱1,300.00                                 │    │
│  │ To: Store Owner (09123456789)                     │    │
│  │ Reference: GC-123456789                           │    │
│  │ Date: Apr 4, 2026 12:30 PM                        │    │
│  └────────────────────────────────────────────────────┘    │
│                                                              │
│  PayMaya Screenshot:                                        │
│  ┌────────────────────────────────────────────────────┐    │
│  │ 📱 PayMaya                                         │    │
│  │                                                    │    │
│  │ Transaction Complete                               │    │
│  │                                                    │    │
│  │ Sent: ₱1,300.00                                   │    │
│  │ To: Store Owner                                    │    │
│  │ Mobile: 09123456789                                │    │
│  │ Ref: PM-987654321                                  │    │
│  └────────────────────────────────────────────────────┘    │
│                                                              │
│  Bank Transfer Receipt:                                     │
│  ┌────────────────────────────────────────────────────┐    │
│  │ 🏦 BDO Online Banking                              │    │
│  │                                                    │    │
│  │ Transfer Successful                                │    │
│  │                                                    │    │
│  │ Amount: ₱1,300.00                                 │    │
│  │ To Account: 1234567890                            │    │
│  │ Account Name: Store Owner                          │    │
│  │ Reference: BDO123456789                           │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

## ✅ Success Indicators

```
FOR BUYERS:
✓ Payment method selected
✓ Payment instructions displayed
✓ Payment proof uploaded
✓ Order placed successfully
✓ Can view payment proof in orders

FOR ADMIN:
✓ Payment methods configured
✓ Account details updated
✓ Can view payment proofs
✓ Can verify payments
✓ Can manage payment methods
```

---

**Visual Guide Complete! 🎨**

This shows the complete flow from browsing to payment verification.
