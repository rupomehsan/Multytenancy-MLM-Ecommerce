<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create mlm_withdrawal_requests table
 * 
 * Purpose: Store user withdrawal requests with payment details and status tracking.
 * Admin can approve/reject requests from this table.
 */
class CreateMlmWithdrawalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlm_withdrawal_requests', function (Blueprint $table) {
            $table->id();

            // User reference
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Request details
            $table->decimal('amount', 12, 2)->comment('Withdrawal amount requested');
            $table->string('payment_method', 50)->comment('bKash, Nagad, Bank Transfer, etc.');
            $table->text('payment_details')->comment('Account number, bank details, etc.');

            // Status tracking
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'completed'])
                ->default('pending')
                ->comment('Request status');

            // Admin action tracking
            $table->unsignedBigInteger('processed_by')->nullable()->comment('Admin user ID who processed');
            $table->foreign('processed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamp('processed_at')->nullable()->comment('When processed by admin');
            $table->text('admin_notes')->nullable()->comment('Admin comments/reason for rejection');

            // Transaction reference
            $table->unsignedBigInteger('wallet_transaction_id')->nullable()
                ->comment('Link to wallet transaction when approved');
            $table->foreign('wallet_transaction_id')
                ->references('id')
                ->on('mlm_wallet_transactions')
                ->onDelete('set null');

            // Additional metadata
            $table->json('meta')->nullable()->comment('Additional data (fees, exchange rate, etc.)');

            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_method');
            $table->index('processed_by');
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
        Schema::dropIfExists('mlm_withdrawal_requests');
    }
}
