<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for Order Activity Logs
 * 
 * Tracks all order-related activities including status changes,
 * updates, and system actions.
 * 
 * Create with:
 * php artisan migrate --path=database/migrations/2025_12_24_000001_create_order_logs_table.php
 * 
 * Rollback with:
 * php artisan migrate:rollback --path=database/migrations/2025_12_24_000001_create_order_logs_table.php
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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();

            // Order reference
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            // Activity details
            $table->enum('activity_type', [
                'status_change',
                'created',
                'updated',
                'cancelled',
                'delivered',
                'payment_update',
                'commission_distributed',
                'commission_reversed',
                'other'
            ])->default('other');

            // Status information (for status changes)
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50)->nullable();

            // User who performed the action (nullable for system actions)
            $table->unsignedBigInteger('performed_by')->nullable()->comment('User ID who performed action');
            $table->foreign('performed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Action source
            $table->enum('action_source', [
                'admin',
                'customer',
                'system',
                'api',
                'observer',
                'manual'
            ])->default('system');

            // Description and details
            $table->string('title', 255)->nullable()->comment('Short description');
            $table->text('description')->nullable()->comment('Detailed description');

            // Additional metadata (JSON for flexibility)
            $table->json('metadata')->nullable()->comment('Additional data like IP, browser, etc.');

            // IP address of user (if applicable)
            $table->string('ip_address', 45)->nullable();

            // User agent
            $table->string('user_agent', 500)->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index('order_id');
            $table->index('activity_type');
            $table->index('performed_by');
            $table->index('action_source');
            $table->index('created_at');
            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_logs');
    }
};
