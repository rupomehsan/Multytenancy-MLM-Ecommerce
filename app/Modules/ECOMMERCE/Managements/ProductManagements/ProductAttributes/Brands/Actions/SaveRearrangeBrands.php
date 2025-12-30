<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class SaveRearrangeBrands
{
    public static function execute(Request $request): array
    {
        try {
            $sl = 1;
            foreach ($request->slug as $slug) {
                Brand::where('slug', $slug)->update([
                    'serial' => $sl
                ]);
                $sl++;
            }

            return [
                'status' => 'success',
                'message' => 'Brand has been Rerranged'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
