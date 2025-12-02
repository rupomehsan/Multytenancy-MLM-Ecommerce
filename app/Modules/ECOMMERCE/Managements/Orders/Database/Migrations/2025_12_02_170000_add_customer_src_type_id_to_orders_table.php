<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerSrcTypeIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_src_type_id')->nullable();

            // add foreign key if the table exists
            if (Schema::hasTable('customer_source_types')) {
                $table->foreign('customer_src_type_id')
                    ->references('id')
                    ->on('customer_source_types')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'customer_src_type_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $platform = $sm->getDatabasePlatform();

                // drop foreign if exists
                try {
                    $table->dropForeign(['customer_src_type_id']);
                } catch (Exception $e) {
                    // ignore if foreign doesn't exist
                }

                $table->dropColumn('customer_src_type_id');
            }
        });
    }
}
