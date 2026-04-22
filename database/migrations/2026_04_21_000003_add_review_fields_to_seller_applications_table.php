<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('rejection_reason');
            $table->timestamp('rejected_at')->nullable()->after('approved_at');
            $table->foreignId('reviewed_by')->nullable()->after('rejected_at')->constrained('users')->nullOnDelete();
            
            // Add index for better query performance
            $table->index('status');
            $table->index('permit_expiry_date');
        });
    }

    public function down(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['permit_expiry_date']);
            $table->dropColumn(['approved_at', 'rejected_at', 'reviewed_by']);
        });
    }
};
