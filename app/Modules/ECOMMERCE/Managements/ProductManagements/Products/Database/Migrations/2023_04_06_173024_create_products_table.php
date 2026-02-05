<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('childcategory_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('name')->nullable();
            $table->string('product_type')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();
            $table->string('multiple_images')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('size_chart')->nullable();
            $table->string('chest')->nullable();
            $table->string('length')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('waist')->nullable();
            $table->string('weight')->nullable();
            $table->string('size_ratio')->nullable();
            $table->text('fabrication')->nullable();
            $table->string('fabrication_gsm_ounce')->nullable();
            $table->string('contact_number')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('warrenty_policy')->nullable();
            $table->double('price')->default(0);
            $table->double('discount_price')->default(0);
            $table->double('stock')->default(0);
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('low_stock')->nullable();
            $table->unsignedBigInteger('reward_points')->nullable();
            $table->string('tags')->nullable();
            $table->string('video_url')->nullable();
            $table->tinyInteger('warrenty_id')->nullable();
            $table->tinyInteger('is_product_qty_multiply')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('flag_id')->nullable();
            $table->decimal('avg_cost_price', 10, 2)->default(0)->comment('Average cost price of the product');
            $table->decimal('last_purchase_price', 10, 2)->nullable()->comment('Last purchase price of the product');
            $table->decimal('average_costing_price', 10, 2)->nullable()->comment('Weighted average costing price');

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->tinyInteger('status')->default(1)->comment("1=>Active; 0=>Inactive");
            $table->tinyInteger('has_variant')->default(0)->comment("0=>No Variant; 1=>Product Has variant based on Colors, Region etc.");
            $table->tinyInteger('is_demo')->default(0)->comment("0=>original; 1=>Demo");
            $table->tinyInteger('is_package')->default(0);
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
        Schema::dropIfExists('products');
    }
}
