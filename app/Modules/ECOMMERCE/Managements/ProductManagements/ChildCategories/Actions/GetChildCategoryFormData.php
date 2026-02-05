<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class GetChildCategoryFormData
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
