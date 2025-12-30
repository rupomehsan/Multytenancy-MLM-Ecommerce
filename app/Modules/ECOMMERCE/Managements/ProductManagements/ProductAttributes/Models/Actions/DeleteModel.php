<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;

class DeleteModel
{
    public static function execute(Request $request, $id)
    {
        ProductModel::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'ProductModel deleted successfully.'
        ];
    }
}
