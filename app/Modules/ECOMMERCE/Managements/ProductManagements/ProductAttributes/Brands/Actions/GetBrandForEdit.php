<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class GetBrandForEdit
{
    public static function execute(Request $request, $slug): array
    {
        try {
            $data = Brand::where('slug', $slug)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found.'
                ];
            }

            $categories = Category::get();
            $subcategories = Subcategory::get();
            $childcategories = ChildCategory::get();

            return [
                'status' => 'success',
                'data' => $data,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'childcategories' => $childcategories,
                'view' => 'update'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
