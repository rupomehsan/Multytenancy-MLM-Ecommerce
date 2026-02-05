<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class GetSubcategoryFormData
{
    public static function execute(Request $request)
    {
        $category = Category::getDropDownList('name');

        return [
            'status' => 'success',
            'view' => 'create',
            'category' => $category
        ];
    }
}
