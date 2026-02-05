<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commission_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('level_1_commission', 10, 2)->default(0);
            $table->decimal('level_2_commission', 10, 2)->default(0);
            $table->decimal('level_3_commission', 10, 2)->default(0);
            $table->decimal('level_4_commission', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_rates');
    }
};
