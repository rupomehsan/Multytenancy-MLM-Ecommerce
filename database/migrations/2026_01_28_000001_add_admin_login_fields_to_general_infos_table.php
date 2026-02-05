<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminLoginFieldsToGeneralInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_infos', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('general_infos', 'admin_login_bg_image')) {
                $table->string('admin_login_bg_image')->nullable()->after('about_us');
            }
            
            if (!Schema::hasColumn('general_infos', 'admin_login_bg_color')) {
                $table->string('admin_login_bg_color')->default('#0b2a44')->nullable()->after('admin_login_bg_image');
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
        Schema::table('general_infos', function (Blueprint $table) {
            if (Schema::hasColumn('general_infos', 'admin_login_bg_image')) {
                $table->dropColumn('admin_login_bg_image');
            }
            
            if (Schema::hasColumn('general_infos', 'admin_login_bg_color')) {
                $table->dropColumn('admin_login_bg_color');
            }
        });
    }
}
