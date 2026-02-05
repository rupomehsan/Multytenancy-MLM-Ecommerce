<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class SearchProductsAction
{
    public function execute(Request $request)
    {
        $query = Product::where('status', 1);

        if ($request->product_name) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->product_name . '%')
                    ->orWhere('code', 'LIKE', '%' . $request->product_name . '%');
            });
        }

        if ($request->category_id) {
            $query->whereRaw("FIND_IN_SET(?, category_id)", [$request->category_id]);
        }

        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        return $query->orderBy('name', 'asc')->get();
    }
}
