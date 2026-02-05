<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class ToggleBrandFeature
{
    public static function execute(Request $request, $id): array
    {
        try {
            $data = Brand::where('id', $id)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found.'
                ];
            }

            $data->featured = $data->featured == 0 ? 1 : 0;
            $data->save();

            return [
                'status' => 'success',
                'message' => 'Brand Featured Status Changed Successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
