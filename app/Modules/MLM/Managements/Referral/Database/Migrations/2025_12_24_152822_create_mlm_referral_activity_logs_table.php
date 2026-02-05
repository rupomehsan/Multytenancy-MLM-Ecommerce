<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlmReferralActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates MLM referral activity logs table to track all referral-based
     * commission events generated after orders are placed.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlm_referral_activity_logs', function (Blueprint $table) {
            $table->id();

            // User relationships
            $table->unsignedBigInteger('buyer_id')->comment('User who placed the order');
            $table->unsignedBigInteger('referrer_id')->comment('User who earned the commission');
            $table->unsignedBigInteger('order_id')->nullable()->comment('Related order ID');

            // Commission details
            $table->tinyInteger('level')->comment('Referral level: 1, 2, or 3');
            $table->decimal('commission_amount', 12, 2)->default(0)->comment('Commission earned');

            // Status tracking
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])
                ->default('pending')
                ->comment('Commission status');

            // Activity type
            $table->string('activity_type', 50)
                ->comment('Event type: order_placed, commission_generated, commission_approved, commission_paid');

            // Additional metadata (JSON for flexibility)
            $table->json('meta')->nullable()->comment('Store order_total, commission_percentage, notes, etc.');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('buyer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('referrer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');

            // Performance indexes
            $table->index('buyer_id', 'idx_buyer');
            $table->index('referrer_id', 'idx_referrer');
            $table->index('level', 'idx_level');
            $table->index('status', 'idx_status');
            $table->index('created_at', 'idx_created_at');
            $table->index(['referrer_id', 'status'], 'idx_referrer_status');
            $table->index(['order_id', 'level'], 'idx_order_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlm_referral_activity_logs');
    }
}
