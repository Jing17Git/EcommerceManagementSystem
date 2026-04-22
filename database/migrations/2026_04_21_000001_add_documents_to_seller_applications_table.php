<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->string('business_permit')->nullable()->after('documents');
            $table->date('permit_expiry_date')->nullable()->after('business_permit');
            $table->string('id_card')->nullable()->after('permit_expiry_date');
            $table->string('id_card_name')->nullable()->after('id_card');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->dropColumn(['business_permit', 'permit_expiry_date', 'id_card', 'id_card_name', 'rejection_reason']);
        });
    }
};
