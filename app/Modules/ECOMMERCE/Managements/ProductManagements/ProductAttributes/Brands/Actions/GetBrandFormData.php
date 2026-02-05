<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class GetBrandFormData
{
    public static function execute(Request $request): array
    {
        try {
            $category = Category::getDropDownList('name');
            $subcategory = Subcategory::getDropDownList('name');
            $childcategory = ChildCategory::getDropDownList('name');

            return [
                'status' => 'success',
                'category' => $category,
                'subcategory' => $subcategory,
                'childcategory' => $childcategory,
                'view' => 'create'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
