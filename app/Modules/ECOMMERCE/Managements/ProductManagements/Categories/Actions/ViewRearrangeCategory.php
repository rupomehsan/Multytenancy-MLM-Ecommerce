<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class ViewRearrangeCategory
{
    public static function execute(Request $request): array
    {
        try {
            $categories = Category::orderBy('serial', 'asc')->get();

            return [
                'status' => 'success',
                'categories' => $categories,
                'view' => 'rearrange'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
