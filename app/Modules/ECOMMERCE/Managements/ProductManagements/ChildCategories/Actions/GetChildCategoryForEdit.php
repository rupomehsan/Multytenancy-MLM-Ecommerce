<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class GetChildCategoryForEdit
{
    public static function execute(Request $request, $slug)
    {
        $childcategory = ChildCategory::where('slug', $slug)->first();

        if (!$childcategory) {
            return [
                'status' => 'error',
                'message' => 'Child Category not found'
            ];
        }

        $subcategories = Subcategory::where('category_id', $childcategory->category_id)
            ->select('name', 'id')
            ->orderBy('name', 'asc')
            ->get();

        $category = Category::getDropDownList('name', $childcategory->category_id);

        return [
            'status' => 'success',
            'view' => 'update',
            'childcategory' => $childcategory,
            'subcategories' => $subcategories,
            'category' => $category
        ];
    }
}
