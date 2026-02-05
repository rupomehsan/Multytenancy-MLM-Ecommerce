<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->integer('division_id');
            $table->string('name', 25);
            $table->string('bn_name', 25)->nullable();
            $table->string('lat', 15)->nullable();
            $table->string('lon', 15)->nullable();
            $table->string('url', 50)->nullable();
            $table->double('delivery_charge', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
