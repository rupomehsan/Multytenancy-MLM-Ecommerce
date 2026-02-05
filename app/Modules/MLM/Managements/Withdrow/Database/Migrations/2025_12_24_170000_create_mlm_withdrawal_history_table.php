<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create mlm_withdrawal_history table
 * 
 * Purpose: Audit trail for all withdrawal request actions and status changes.
 * Tracks every action taken on withdrawal requests for compliance and monitoring.
 */
class CreateMlmWithdrawalHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlm_withdrawal_history', function (Blueprint $table) {
            $table->id();

            // Withdrawal request reference
            $table->unsignedBigInteger('withdrawal_request_id');
            $table->foreign('withdrawal_request_id')
                ->references('id')
                ->on('mlm_withdrawal_requests')
                ->onDelete('cascade');

            // User who requested the withdrawal
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Action tracking
            $table->string('action', 50)->comment('created, approved, rejected, processing, completed, cancelled');
            $table->enum('old_status', ['pending', 'approved', 'rejected', 'processing', 'completed', 'cancelled'])->nullable();
            $table->enum('new_status', ['pending', 'approved', 'rejected', 'processing', 'completed', 'cancelled']);

            // Who performed the action (null for system actions)
            $table->unsignedBigInteger('performed_by')->nullable()->comment('Admin/System user who performed action');
            $table->foreign('performed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Action details
            $table->text('notes')->nullable()->comment('Admin notes or reason for action');
            $table->decimal('amount', 12, 2)->comment('Withdrawal amount at time of action');

            // Payment details snapshot (for completed withdrawals)
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_reference', 100)->nullable()->comment('Payment gateway reference/transaction ID');

            // Additional metadata
            $table->json('meta')->nullable()->comment('Additional data (IP address, device info, etc.)');

            $table->timestamps();

            // Indexes for performance
            $table->index('withdrawal_request_id');
            $table->index('user_id');
            $table->index('action');
            $table->index('new_status');
            $table->index('performed_by');
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
        Schema::dropIfExists('mlm_withdrawal_history');
    }
}
