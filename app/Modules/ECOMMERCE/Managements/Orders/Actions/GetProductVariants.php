<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class GetProductVariants
{
    public static function execute($request)
    {
        $productInfo = Product::where('id', $request->product_id)->first();

        if ($productInfo->has_variant == 1) {
            $data = DB::table('product_variants')
                ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')
                ->leftJoin('product_sizes', 'product_variants.size_id', '=', 'product_sizes.id')
                ->leftJoin('country', 'product_variants.region_id', '=', 'country.id')
                ->leftJoin('sims', 'product_variants.sim_id', '=', 'sims.id')
                ->leftJoin('storage_types', 'product_variants.storage_type_id', '=', 'storage_types.id')
                ->leftJoin('product_warrenties', 'product_variants.warrenty_id', '=', 'product_warrenties.id')
                ->leftJoin('device_conditions', 'product_variants.device_condition_id', '=', 'device_conditions.id')
                ->leftJoin('products', 'product_variants.product_id', '=', 'products.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->select('product_variants.id', 'product_variants.color_id', 'product_variants.size_id', 'product_variants.storage_type_id', 'product_variants.region_id', 'product_variants.sim_id', 'product_variants.warrenty_id', 'product_variants.device_condition_id', 'product_variants.discounted_price', 'product_variants.price', 'product_variants.stock as variant_stock', 'colors.name as color_name', 'product_sizes.name as size_name', 'country.name as region_name', 'sims.name as sim_name', 'storage_types.ram', 'storage_types.rom', 'product_warrenties.name as warrrenty', 'device_conditions.name as device_condition', 'units.name as unit_name', 'units.id as unit_id')
                ->where('product_variants.product_id', $request->product_id)
                ->where('product_variants.stock', '>', 0)
                ->orderBy('product_variants.id', 'asc')
                ->get();

            return response()->json($data);
        } else {
            $productInfo = DB::table('products')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->select('products.*', 'units.name as unit_name')
                ->where('products.id', $request->product_id)
                ->first();

            return response()->json($productInfo);
        }
    }
}
