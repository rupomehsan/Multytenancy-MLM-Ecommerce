<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;

class ToggleSubcategoryFeature
{
    public static function execute(Request $request, $id)
    {
        $data = Subcategory::where('id', $id)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Subcategory not found'
            ];
        }

        if ($data->featured == 0) {
            $data->featured = 1;
        } else {
            $data->featured = 0;
        }

        $data->save();

        return [
            'status' => 'success',
            'message' => 'Status Changed successfully.'
        ];
    }
}
