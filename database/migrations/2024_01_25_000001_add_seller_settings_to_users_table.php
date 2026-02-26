<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Store Profile Fields
            $table->string('store_name')->nullable()->after('email');
            $table->string('store_email')->nullable()->after('store_name');
            $table->text('store_description')->nullable()->after('store_email');
            $table->string('store_phone')->nullable()->after('store_description');
            $table->string('store_address')->nullable()->after('store_phone');
            $table->string('store_logo')->nullable()->after('store_address');

            // Business Settings
            $table->boolean('auto_accept_orders')->default(true)->after('store_logo');
            $table->boolean('low_stock_alerts')->default(true)->after('auto_accept_orders');
            $table->boolean('email_notifications')->default(true)->after('low_stock_alerts');

            // Shipping Preferences
            $table->string('default_shipping_carrier')->nullable()->after('email_notifications');
            $table->string('processing_time')->default('3-5 Business Days')->after('default_shipping_carrier');
            $table->decimal('free_shipping_threshold', 10, 2)->nullable()->after('processing_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'store_name',
                'store_email',
                'store_description',
                'store_phone',
                'store_address',
                'store_logo',
                'auto_accept_orders',
                'low_stock_alerts',
                'email_notifications',
                'default_shipping_carrier',
                'processing_time',
                'free_shipping_threshold',
            ]);
        });
    }
};
