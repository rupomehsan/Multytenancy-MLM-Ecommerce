<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for MLM Commission Records
 * 
 * Stores individual commission records for each referral level
 * when an order is delivered.
 *
 * Create with (module path):
 * php artisan migrate --path=app/Modules/MLM/Managements/Commissions/Database/Migrations/2025_12_23_100001_create_mlm_commissions_table.php
 *
 * Rollback with (module path):
 * php artisan migrate:rollback --path=app/Modules/MLM/Managements/Commissions/Database/Migrations/2025_12_23_100001_create_mlm_commissions_table.php
 */

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlm_commissions', function (Blueprint $table) {
            $table->id();

            // Order reference
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            // Buyer (the person who placed the order)
            $table->unsignedBigInteger('buyer_id');
            $table->foreign('buyer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Referrer (the person receiving the commission)
            $table->unsignedBigInteger('referrer_id');
            $table->foreign('referrer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Referral level (1, 2, or 3)
            $table->tinyInteger('level')->comment('1=Direct, 2=Second Level, 3=Third Level');

            // Commission amount in BDT
            $table->decimal('commission_amount', 10, 2)->default(0.00);

            // Commission status
            // pending = Commission recorded but not paid
            // approved = Commission approved, ready to be credited
            // paid = Commission credited to wallet
            // rejected = Commission rejected (e.g., order cancelled/refunded)
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');

            // Optional: Store the percentage used at the time of calculation
            $table->decimal('percentage_used', 5, 2)->nullable()->comment('Percentage at time of calculation');

            // Notes for admin
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Soft delete for audit trail

            // Indexes for performance
            $table->index('order_id');
            $table->index('buyer_id');
            $table->index('referrer_id');
            $table->index('status');
            $table->index('level');

            // Unique constraint: Prevent duplicate commissions for same order, referrer, and level
            $table->unique(['order_id', 'referrer_id', 'level'], 'unique_commission_per_order_referrer_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlm_commissions');
    }
};
