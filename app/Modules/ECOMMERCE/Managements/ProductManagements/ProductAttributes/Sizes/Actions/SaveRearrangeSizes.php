<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class SaveRearrangeSizes
{
    public static function execute(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            ProductSize::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }

        return [
            'status' => 'success',
            'message' => 'Product Sizes are Rearranged'
        ];
    }
}
