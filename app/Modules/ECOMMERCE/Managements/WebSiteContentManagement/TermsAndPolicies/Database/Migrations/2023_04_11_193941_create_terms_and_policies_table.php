<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsAndPoliciesTable extends Migration
{
    /**
     * Run the migrations.
      php artisan migrate --path=app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/TermsAndPolicies/Database/Migrations/2023_04_11_193941_create_terms_and_policies_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms_and_policies', function (Blueprint $table) {
            $table->id();
            $table->longText('terms')->nullable();
            $table->string('terms_bg')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->string('privacy_policy_bg')->nullable();
            $table->longText('shipping_policy')->nullable();
            $table->string('shipping_policy_bg')->nullable();
            $table->longText('return_policy')->nullable();
            $table->string('return_policy_bg')->nullable();
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
        Schema::dropIfExists('terms_and_policies');
    }
}
