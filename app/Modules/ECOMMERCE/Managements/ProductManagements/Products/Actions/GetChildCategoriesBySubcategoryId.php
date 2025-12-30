<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class GetChildCategoriesBySubcategoryId
{
    public static function execute(Request $request)
    {
        $data = ChildCategory::where("subcategory_id", $request->subcategory_id)
            ->where('status', 1)
            ->select('name', 'id')
            ->get();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
