<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('platform_fee', 10, 2)->default(0)->after('total_amount');
            $table->decimal('seller_amount', 10, 2)->default(0)->after('platform_fee');
            $table->decimal('commission_rate', 5, 2)->default(5.00)->after('seller_amount'); // 5% default
        });

        Schema::table('users', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(5.00)->after('email_notifications')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['platform_fee', 'seller_amount', 'commission_rate']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('commission_rate');
        });
    }
};
