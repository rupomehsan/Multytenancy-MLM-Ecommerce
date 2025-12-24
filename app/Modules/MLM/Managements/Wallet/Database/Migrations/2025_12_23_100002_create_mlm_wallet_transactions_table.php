<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for Wallet Transactions
 * 
 * Records all wallet balance changes including commission credits,
 * withdrawals, and reversals.
 * 
 *
 * Create with (module path):
 * php artisan migrate --path=app/Modules/MLM/Managements/Wallet/Database/Migrations/2025_12_23_100002_create_wallet_transactions_table.php
 *
 * Rollback with (module path):
 * php artisan migrate:rollback --path=app/Modules/MLM/Managements/Wallet/Database/Migrations/2025_12_23_100002_create_wallet_transactions_table.php
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
        Schema::create('mlm_wallet_transactions', function (Blueprint $table) {
            $table->id();

            // User whose wallet is affected
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Transaction type
            $table->enum('transaction_type', [
                'commission_credit',
                'withdrawal',
                'commission_reversal',
                'admin_adjustment',
                'other'
            ])->default('commission_credit');

            // Amount (positive for credit, negative for debit)
            $table->decimal('amount', 10, 2)->default(0.00);

            // Balance after this transaction
            $table->decimal('balance_after', 16, 2)->default(0.00);

            // Reference to commission record (nullable for non-commission transactions)
            $table->unsignedBigInteger('mlm_commission_id')->nullable();
            $table->foreign('mlm_commission_id')
                ->references('id')
                ->on('mlm_commissions')
                ->onDelete('set null');

            // Reference to order (for traceability)
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');

            // Description
            $table->string('description', 500)->nullable();

            // Admin notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('transaction_type');
            $table->index('mlm_commission_id');
            $table->index('order_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
