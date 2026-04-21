<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('email', 'richarddbautista1@gmail.com')
            ->update(['password' => Hash::make('shophubph123')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Password reset cannot be deterministically reversed.
        // No action taken on rollback.
    }
};
