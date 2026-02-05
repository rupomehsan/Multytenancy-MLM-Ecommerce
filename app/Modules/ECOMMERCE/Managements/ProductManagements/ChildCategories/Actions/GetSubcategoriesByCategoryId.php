<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;

class GetSubcategoriesByCategoryId
{
    public static function execute(Request $request)
    {
        $data = Subcategory::where("category_id", $request->category_id)
            ->where('status', 1)
            ->select('name', 'id')
            ->get();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
