<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Users table migration with MLM referral system support.
 * 
 * Includes optimized indexes for:
 * - Referral tree traversal and lookups
 * - User type and status filtering
 * - Combined MLM query patterns
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary identification
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('password')->nullable();

            // OAuth/Social login
            $table->string('provider_name')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();

            // User classification
            $table->tinyInteger('user_type')->comment("1=>Admin; 2=>User/Shop; 3=>Customer")->default(3);
            $table->longText('address')->nullable();
            $table->double('balance')->comment("In BDT")->default(0);

            // MLM Referral system
            $table->string('referral_code')->nullable()->unique();
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->decimal('wallet_balance', 16, 2)->default(0)->comment('Wallet balance in BDT');

            // Account deletion
            $table->tinyInteger('delete_request_submitted')->comment("0=>No; 1=>Yes")->default(0);
            $table->dateTime('delete_request_submitted_at')->nullable();

            // Status
            $table->tinyInteger('status')->comment("1=>Active; 0=>Inactive")->default(1);

            // Timestamps
            $table->timestamps();

            // Indexes for MLM performance optimization
            $table->index('referred_by', 'idx_referred_by'); // Quick child lookup
            $table->index(['user_type', 'status'], 'idx_user_type_status'); // Filter active customers
            $table->index(['referred_by', 'user_type', 'status'], 'idx_referral_tree_lookup'); // Optimized MLM queries
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
