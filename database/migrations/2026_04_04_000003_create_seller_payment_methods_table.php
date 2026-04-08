<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('method_type'); // gcash, paymaya, bank
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name')->nullable(); // For bank transfers
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_primary')->default(false); // Primary payment method
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_payment_methods');
    }
};
