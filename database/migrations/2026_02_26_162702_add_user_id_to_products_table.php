<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if (!Schema::hasColumn('products', 'user_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('seller_id');
            });
        } elseif ($driver === 'mysql') {
            // Recover from partially-applied migration where user_id exists but FK failed.
            DB::statement('ALTER TABLE products MODIFY user_id BIGINT UNSIGNED NULL');
        }

        // Clean invalid references before adding FK.
        DB::statement('UPDATE products SET user_id = NULL WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT id FROM users)');

        $hasForeignKey = false;

        if ($driver === 'mysql') {
            $hasForeignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->whereRaw('TABLE_SCHEMA = DATABASE()')
                ->where('TABLE_NAME', 'products')
                ->where('COLUMN_NAME', 'user_id')
                ->whereNotNull('REFERENCED_TABLE_NAME')
                ->exists();
        }

        if (!$hasForeignKey) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (!Schema::hasColumn('products', 'user_id')) {
            return;
        }

        $hasForeignKey = false;
        if ($driver === 'mysql') {
            $hasForeignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->whereRaw('TABLE_SCHEMA = DATABASE()')
                ->where('TABLE_NAME', 'products')
                ->where('COLUMN_NAME', 'user_id')
                ->whereNotNull('REFERENCED_TABLE_NAME')
                ->exists();
        }

        if ($hasForeignKey) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
