<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Seeder\Seeder as UserSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\LocationSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\ConfigSetupSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\EmailConfigureSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\PaymentGatewaySeeder;
use App\Modules\MLM\Managements\Commissions\Database\Seeder\CommissionSettingsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Seeder\Seeder as ProductCategoriesSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Seeder\Seeder as ProductSubcategoriesSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Seeder\Seeder as ProductChildcategoriesSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Seeder\Seeder as BrandsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Seeder\Seeder as ColorsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Seeder\Seeder as FlagsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Seeder\Seeder as ProductModelsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Seeder\Seeder as SizesSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Seeder\Seeder as UnitsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Seeder\Seeder as ProductsSeeder;
use App\Modules\ECOMMERCE\Managements\ProductManagements\PackageProducts\Database\Seeder\Seeder as PackageProductsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call complete account groups seeder (creates account_types, groups, subsidiaries)
        $this->call([
            ProductCategoriesSeeder::class,
            ProductSubcategoriesSeeder::class,
            ProductChildcategoriesSeeder::class,
            BrandsSeeder::class,
            ColorsSeeder::class,
            FlagsSeeder::class,
            SizesSeeder::class,
            UnitsSeeder::class,
            ProductModelsSeeder::class,
            ProductsSeeder::class,
            PackageProductsSeeder::class,
            UserSeeder::class,
            LocationSeeder::class,
            ConfigSetupSeeder::class,
            EmailConfigureSeeder::class,
            PaymentGatewaySeeder::class,
            //mlm
            CommissionSettingsSeeder::class,
            //accounts
            // CompleteAccountGroupsSeeder::class,
            ChartOfAccountSeeder::class,
            // AccountGroupsSeeder::class,
            // AccountsConfigurationSeeder::class,

        ]);
    }
}
