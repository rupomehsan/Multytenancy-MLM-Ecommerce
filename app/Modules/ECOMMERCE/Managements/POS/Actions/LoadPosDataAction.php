<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;
use App\Modules\INVENTORY\Managements\WareHouse\Database\Models\ProductWarehouse;
use App\Modules\INVENTORY\Managements\WareHouseRoom\Database\Models\ProductWarehouseRoom;
use App\Modules\INVENTORY\Managements\WareHouseRoomCartoon\Database\Models\ProductWarehouseRoomCartoon;

class LoadPosDataAction
{
    public function execute(Request $request): array
    {
        return [
            'categories' => Category::where('status', 1)->orderBy('name', 'asc')->get(),
            'brands' => Brand::where('status', 1)->orderBy('name', 'asc')->get(),
            'products' => Product::where('status', 1)
                ->where('is_package', 0)
                ->orderBy('name', 'asc')
                ->get(),
            'customers' => User::where('user_type', 3)->orderBy('name', 'asc')->get(),
            'districts' => DB::table('districts')->orderBy('name', 'asc')->get(),
            'customer_source_types' => CustomerSourceType::where('status', 'active')->get(),
            'outlets' => Outlet::where('status', 'active')->get(),
            'warehouses' => ProductWarehouse::where('status', 'active')->get(),
            'warehouse_rooms' => ProductWarehouseRoom::where('status', 'active')->get(),
            'room_cartoons' => ProductWarehouseRoomCartoon::where('status', 'active')->get(),
        ];
    }
}
