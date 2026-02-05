<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class DeleteCategory
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

            if ($data->icon && file_exists(public_path($data->icon))) {
                unlink(public_path($data->icon));
            }

            if ($data->banner_image && file_exists(public_path($data->banner_image))) {
                unlink(public_path($data->banner_image));
            }

            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Category deleted successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
