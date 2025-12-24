<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create mlm_user_wallet_balances table
 * 
 * Purpose: Track current wallet balance for each user in the MLM system.
 * This table maintains the real-time balance calculated from wallet transactions.
 */
class CreateMlmUserWalletBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlm_user_wallet_balances', function (Blueprint $table) {
            $table->id();

            // User reference
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Balance tracking
            $table->decimal('total_balance', 12, 2)->default(0.00)->comment('Current available balance');
            $table->decimal('pending_withdrawal', 12, 2)->default(0.00)->comment('Amount locked in pending withdrawal requests');
            $table->decimal('total_earned', 12, 2)->default(0.00)->comment('Lifetime earnings (commissions)');
            $table->decimal('total_withdrawn', 12, 2)->default(0.00)->comment('Total amount withdrawn');

            // Timestamps
            $table->timestamp('last_transaction_at')->nullable()->comment('Last transaction timestamp');
            $table->timestamps();

            // Indexes for performance
            $table->index('total_balance');
            $table->index('pending_withdrawal');
            $table->index('last_transaction_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlm_user_wallet_balances');
    }
}
