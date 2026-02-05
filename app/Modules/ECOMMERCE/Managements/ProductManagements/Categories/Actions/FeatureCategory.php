<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class FeatureCategory
{
    public static function execute(Request $request, $slug): array
    {
        try {
            $data = Category::where('slug', $slug)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Category not found.'
                ];
            }

            $data->featured = $data->featured == 0 ? 1 : 0;
            $data->save();

            return [
                'status' => 'success',
                'message' => 'Status Changed successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
