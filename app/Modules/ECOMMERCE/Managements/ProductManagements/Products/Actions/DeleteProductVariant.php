<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;

class DeleteProductVariant
{
    public static function execute(Request $request, $id)
    {
        $variant = ProductVariant::where('id', $id)->first();

        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        $variant->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ];
    }
}
