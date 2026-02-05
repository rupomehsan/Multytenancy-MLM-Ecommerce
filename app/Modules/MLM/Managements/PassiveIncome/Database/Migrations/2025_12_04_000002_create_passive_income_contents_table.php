<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('passive_income_contents', function (Blueprint $table) {
            $table->id();
            $table->string('header_title')->nullable();
            $table->text('header_subtitle')->nullable();
            $table->text('intro_text')->nullable();
            $table->string('what_is_title')->nullable();
            $table->text('what_is_text')->nullable();
            $table->string('how_title')->nullable();
            $table->text('how_text')->nullable();
            $table->string('seller_code_title')->nullable();
            $table->text('seller_code_text')->nullable();
            $table->string('why_title')->nullable();
            $table->text('why_text')->nullable();
            $table->string('commission_title')->nullable();
            $table->longText('commission_table_html')->nullable();
            $table->text('conclusion_text')->nullable();
            $table->string('terms_title')->nullable();
            $table->longText('terms_html')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passive_income_contents');
    }
};
