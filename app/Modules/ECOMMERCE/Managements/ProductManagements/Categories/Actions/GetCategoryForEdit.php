<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class GetCategoryForEdit
{
    public static function execute(Request $request, $slug): array
    {
        try {
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                return [
                    'status' => 'error',
                    'message' => 'Category not found.'
                ];
            }

            return [
                'status' => 'success',
                'category' => $category,
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
