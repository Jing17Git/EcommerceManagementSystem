<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommerceFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_groups_items_by_seller_and_creates_order_items_and_payments(): void
    {
        $buyer = User::factory()->create([
            'role' => 'buyer',
            'current_role' => 'buyer',
            'email_verified_at' => now(),
        ]);

        $sellerOne = User::factory()->create([
            'role' => 'seller',
            'current_role' => 'seller',
            'auto_accept_orders' => true,
            'email_verified_at' => now(),
        ]);

        $sellerTwo = User::factory()->create([
            'role' => 'seller',
            'current_role' => 'seller',
            'auto_accept_orders' => false,
            'email_verified_at' => now(),
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test',
            'is_active' => true,
        ]);

        $productA = Product::create([
            'name' => 'Prod A',
            'category_id' => $category->id,
            'seller_id' => $sellerOne->id,
            'price' => 100,
            'stock' => 20,
            'is_active' => true,
        ]);

        $productB = Product::create([
            'name' => 'Prod B',
            'category_id' => $category->id,
            'seller_id' => $sellerOne->id,
            'price' => 50,
            'stock' => 20,
            'is_active' => true,
        ]);

        $productC = Product::create([
            'name' => 'Prod C',
            'category_id' => $category->id,
            'seller_id' => $sellerTwo->id,
            'price' => 200,
            'stock' => 20,
            'is_active' => true,
        ]);

        Cart::create(['user_id' => $buyer->id, 'product_id' => $productA->id, 'quantity' => 2]);
        Cart::create(['user_id' => $buyer->id, 'product_id' => $productB->id, 'quantity' => 1]);
        Cart::create(['user_id' => $buyer->id, 'product_id' => $productC->id, 'quantity' => 1]);

        $response = $this->actingAs($buyer)->post(route('buyer.cart.checkout'), [
            'shipping_address' => '123 Test Street',
            'notes' => 'Test checkout',
        ]);

        $response->assertRedirect(route('buyer.orders'));

        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('order_items', 3);
        $this->assertDatabaseCount('payments', 2);
        $this->assertDatabaseCount('order_status_histories', 2);

        $sellerOneOrder = Order::where('seller_id', $sellerOne->id)->firstOrFail();
        $sellerTwoOrder = Order::where('seller_id', $sellerTwo->id)->firstOrFail();

        $this->assertEquals('processing', $sellerOneOrder->status);
        $this->assertEquals('pending', $sellerTwoOrder->status);
        $this->assertEquals(250.00, (float) $sellerOneOrder->total_amount);
        $this->assertEquals(200.00, (float) $sellerTwoOrder->total_amount);
    }

    public function test_refund_return_updates_payment_status_to_refunded(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'current_role' => 'seller',
            'email_verified_at' => now(),
        ]);

        $buyer = User::factory()->create([
            'role' => 'buyer',
            'current_role' => 'buyer',
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $buyer->id,
            'seller_id' => $seller->id,
            'order_number' => 'ORD-TEST-1',
            'total_amount' => 500,
            'status' => 'delivered',
            'shipping_address' => 'Address',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'manual',
            'reference' => 'PAY-TEST-1',
            'amount' => 500,
            'currency' => 'PHP',
            'status' => 'captured',
            'paid_at' => now(),
        ]);

        $returnRequest = ReturnRequest::create([
            'order_id' => $order->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'reason' => 'Damaged item',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($seller)->patch(route('seller.returns.refund', $returnRequest));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('return_requests', [
            'id' => $returnRequest->id,
            'status' => 'refunded',
        ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'status' => 'refunded',
        ]);
    }
}
