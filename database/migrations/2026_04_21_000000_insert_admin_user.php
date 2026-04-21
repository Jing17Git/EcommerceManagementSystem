<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!DB::table('users')->where('email', 'richarddbautista1@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name'              => 'Richard Bautista',
                'email'             => 'richarddbautista1@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$o6dSlStDmAA5QlshaqnlxOcrOj5oI/6OGTXBI1BFd.Su4OKw.sutS',
                'role'              => 'administrator',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'richarddbautista1@gmail.com')->delete();
    }
};
