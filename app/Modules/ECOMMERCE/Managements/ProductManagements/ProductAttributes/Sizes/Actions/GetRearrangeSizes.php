<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class GetRearrangeSizes
{
    public static function execute(Request $request)
    {
        $data = ProductSize::orderBy('serial', 'asc')->get();

        return [
            'status' => 'success',
            'view' => 'rearrangeSize',
            'data' => $data
        ];
    }
}
