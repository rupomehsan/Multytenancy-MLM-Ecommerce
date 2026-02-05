<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class GetSubcategoryForEdit
{
    public static function execute(Request $request, $slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->first();

        if (!$subcategory) {
            return [
                'status' => 'error',
                'message' => 'Subcategory not found'
            ];
        }

        $category = Category::getDropDownList('name', $subcategory->category_id);

        return [
            'status' => 'success',
            'view' => 'update',
            'subcategory' => $subcategory,
            'category' => $category
        ];
    }
}
