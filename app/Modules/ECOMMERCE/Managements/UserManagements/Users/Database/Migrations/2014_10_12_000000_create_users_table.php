<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('password')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->tinyInteger('user_type')->comment("1=>Admin; 2=>User/Shop; 3=>Customer")->default(3);
            $table->longText('address')->nullable();
            $table->double('balance')->comment("In BDT")->default(0);

            // Referral and wallet fields
            $table->string('referral_code')->nullable()->unique();
            $table->unsignedBigInteger('referred_by')->nullable();
            $table->decimal('wallet_balance', 16, 2)->default(0)->comment('Wallet balance in BDT');

            $table->tinyInteger('delete_request_submitted')->comment("0=>No; 1=>Yes")->default(0);
            $table->dateTime('delete_request_submitted_at')->nullable();

            $table->tinyInteger('status')->comment("1=>Active; 0=>Inactive")->default(1);
            $table->timestamps();

            // Foreign key for referred_by -> users.id (nullable)
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
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
