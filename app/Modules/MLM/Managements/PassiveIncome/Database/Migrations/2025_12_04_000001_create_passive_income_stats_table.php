<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('passive_income_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->boolean('is_verified_seller')->default(false);
            $table->integer('level_1_count')->default(0);
            $table->integer('level_2_count')->default(0);
            $table->integer('level_3_count')->default(0);
            $table->integer('level_4_count')->default(0);
            $table->integer('delivered_orders')->default(0);
            $table->decimal('estimated_daily_commission', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passive_income_stats');
    }
};
