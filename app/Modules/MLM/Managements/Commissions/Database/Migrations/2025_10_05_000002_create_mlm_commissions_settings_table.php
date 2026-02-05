<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create with:
  php artisan migrate --path=app/Modules/Managements/MLM/Settings/Database/Migrations/2025_10_05_000002_create_mlm_commissions_settings_table.php
 * Delete with:
 php artisan migrate:rollback --path=app/Modules/Managements/MLM/Settings/Database/Migrations/2025_10_05_000002_create_mlm_commissions_settings_table.php
 */

return new class extends Migration {

    public function up(): void
    {
        Schema::create('mlm_commissions_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('level_1_percentage', 5, 2)->default(10.00);
            $table->decimal('level_2_percentage', 5, 2)->default(5.00);
            $table->decimal('level_3_percentage', 5, 2)->default(2.00);
            $table->decimal('minimum_withdrawal', 10, 2)->default(100.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mlm_commissions_settings');
    }
};
