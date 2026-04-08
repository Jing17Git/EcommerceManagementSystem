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
        Schema::create('behavior_baselines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('behavior_type'); // login_pattern, shopping_pattern, seller_activity
            $table->json('baseline_data'); // Stores statistical data: avg, std_dev, percentiles, etc.
            $table->timestamp('learned_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'behavior_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_baselines');
    }
};
