<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('outlet_id')->nullable();
            $table->dateTime('order_date');
            $table->date('estimated_dd')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->string('delivery_method')->comment('1=>Home Delivery; 2=>Store Pickup')->nullable();
            $table->tinyInteger('payment_method')->nullable()->comment('1=>cash_on_delivery; 2=>bkash; 3=>nagad; 4=>Card');
            $table->tinyInteger('payment_status')->nullable()->comment('0=>Unpaid; 1=>Payment Success; 2=>Payment Failed');
            $table->string('trx_id')->nullable()->comment("Created By GenericCommerceV1");
            $table->string('bank_tran_id')->nullable()->comment("KEEP THIS bank_tran_id FOR REFUNDING ISSUE");
            $table->tinyInteger('order_status')->default(0)->comment('0=>pending/processing; 1=>approved; 2=>dispatch; 3=>intransit; 4=>delivered; 5=>cancelled; 6=>returned');
            $table->double('sub_total')->default(0);
            $table->string('coupon_code')->nullable();
            $table->string('reference_code')->nullable();
            $table->unsignedBigInteger('customer_src_type_id')->nullable();
            $table->double('discount')->default(0);
            $table->double('delivery_fee')->default(0);
            $table->double('vat')->default(0);
            $table->double('tax')->default(0);
            $table->double('total')->default(0);
            $table->double('round_off')->default(0);
            $table->double('coupon_price')->default(0);
            $table->string('invoice_no')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->boolean('invoice_generated')->default(0);
            $table->unsignedTinyInteger('order_from')->nullable()->comment('1=>web;2=>app;3=>pos');
            $table->longText('order_note')->comment("Order Note By Customer")->nullable();
            $table->longText('order_remarks')->comment("Special Note By Admin")->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('complete_order')->default(0)->comment('0=>Incomplete Order (Address Missing); 1=>Complete Order (Address Given)');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add foreign key to customer_source_types if that table exists
        if (Schema::hasTable('customer_source_types')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('customer_src_type_id')
                    ->references('id')
                    ->on('customer_source_types')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
