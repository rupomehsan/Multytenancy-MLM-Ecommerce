<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckProductVariantAction
{
    public function execute(Request $request): array
    {
        if ($request->color_id == '' && $request->size_id == '') {
            return ['price' => 0, 'stock' => 0];
        }

        $query = DB::table('product_variants')->where('product_id', $request->product_id);

        if ($request->color_id != '') {
            $query->where('color_id', $request->color_id);
        }

        if ($request->size_id != '') {
            $query->where('size_id', $request->size_id);
        }

        $data = $query->where('stock', '>', 0)
            ->orderBy('discounted_price', 'asc')
            ->orderBy('price', 'asc')
            ->first();

        if ($data) {
            return [
                'price' => $data->discounted_price > 0 ? $data->discounted_price : $data->price,
                'stock' => $data->stock
            ];
        }

        return ['price' => 0, 'stock' => 0];
    }
}
