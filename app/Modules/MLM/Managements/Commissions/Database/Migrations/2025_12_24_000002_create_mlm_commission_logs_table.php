<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for Commission Activity Logs
 * 
 * Tracks all commission-related activities including creation,
 * approval, rejection, and payment.
 * 
 * Create with:
 * php artisan migrate --path=database/migrations/2025_12_24_000002_create_commission_logs_table.php
 * 
 * Rollback with:
 * php artisan migrate:rollback --path=database/migrations/2025_12_24_000002_create_commission_logs_table.php
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
        Schema::create('mlm_commission_logs', function (Blueprint $table) {
            $table->id();

            // Commission reference
            $table->unsignedBigInteger('commission_id');
            $table->foreign('commission_id')
                ->references('id')
                ->on('mlm_commissions')
                ->onDelete('cascade');

            // Order reference (for quick lookup)
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');

            // Referrer (beneficiary) reference
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Activity details
            $table->enum('activity_type', [
                'created',
                'calculated',
                'approved',
                'rejected',
                'paid',
                'reversed',
                'status_changed',
                'wallet_credited',
                'wallet_debited',
                'error',
                'other'
            ])->default('other');

            // Status information
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50)->nullable();

            // Amount information
            $table->decimal('amount', 10, 2)->nullable()->comment('Commission amount');
            $table->decimal('old_wallet_balance', 16, 2)->nullable();
            $table->decimal('new_wallet_balance', 16, 2)->nullable();

            // User who performed the action
            $table->unsignedBigInteger('performed_by')->nullable()->comment('User ID who performed action');
            $table->foreign('performed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Action source
            $table->enum('action_source', [
                'admin',
                'system',
                'api',
                'observer',
                'service',
                'manual',
                'cron'
            ])->default('system');

            // Description and details
            $table->string('title', 255)->nullable()->comment('Short description');
            $table->text('description')->nullable()->comment('Detailed description');

            // Additional metadata
            $table->json('metadata')->nullable()->comment('Additional data');

            // IP address
            $table->string('ip_address', 45)->nullable();

            // User agent
            $table->string('user_agent', 500)->nullable();

            // Error information (if applicable)
            $table->text('error_message')->nullable();
            $table->text('error_trace')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index('commission_id');
            $table->index('order_id');
            $table->index('referrer_id');
            $table->index('activity_type');
            $table->index('performed_by');
            $table->index('action_source');
            $table->index('created_at');
            $table->index(['commission_id', 'created_at']);
            $table->index(['referrer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commission_logs');
    }
};
