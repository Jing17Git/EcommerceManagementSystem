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
        Schema::create('anomaly_detections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('anomaly_type'); // suspicious_login, unusual_shopping, abnormal_seller_activity
            $table->string('severity'); // low, medium, high, critical
            $table->text('description');
            $table->json('detection_data'); // Details about what triggered the anomaly
            $table->string('status')->default('pending'); // pending, reviewed, resolved, false_positive
            $table->timestamp('detected_at');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'anomaly_type', 'status']);
            $table->index('detected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anomaly_detections');
    }
};
