<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class GetProductVariantsAction
{
    public function execute(Request $request): array
    {
        $product = Product::where('id', $request->product_id)->first();

        $colors = DB::table('product_variants')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->select('colors.*')
            ->where('product_variants.product_id', $product->id)
            ->where('product_variants.stock', '>', 0)
            ->whereNotNull('product_variants.color_id')
            ->whereNotNull('colors.id')
            ->groupBy('product_variants.color_id')
            ->get();

        $sizes = DB::table('product_variants')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select('product_sizes.*')
            ->where('product_variants.product_id', $product->id)
            ->where('product_variants.stock', '>', 0)
            ->whereNotNull('product_variants.size_id')
            ->where('product_sizes.id', '!=', null)
            ->groupBy('product_variants.size_id')
            ->get()
            ->filter(function ($size) {
                return $size->id !== null;
            })
            ->values();

        return [
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
        ];
    }
}
