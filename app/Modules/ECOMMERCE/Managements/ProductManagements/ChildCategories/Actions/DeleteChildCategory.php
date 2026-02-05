<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class DeleteChildCategory
{
    public static function execute(Request $request, $slug)
    {
        $data = ChildCategory::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Child Category not found',
                'data' => 0
            ];
        }

        $used = Product::where('childcategory_id', $data->id)->count();

        if ($used > 0) {
            return [
                'status' => 'error',
                'message' => 'Cannot be deleted',
                'data' => 0
            ];
        }

        ChildCategory::where('slug', $slug)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.',
            'data' => 1
        ];
    }
}
