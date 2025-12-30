<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class DeleteSize
{
    public static function execute(Request $request, $id)
    {
        ProductSize::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
