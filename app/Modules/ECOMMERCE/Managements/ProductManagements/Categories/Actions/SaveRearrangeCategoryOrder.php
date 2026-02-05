<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class SaveRearrangeCategoryOrder
{
    public static function execute(Request $request): array
    {
        try {
            $sl = 1;
            foreach ($request->slug as $slug) {
                Category::where('slug', $slug)->update([
                    'serial' => $sl
                ]);
                $sl++;
            }

            return [
                'status' => 'success',
                'message' => 'Category has been Rerranged'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
