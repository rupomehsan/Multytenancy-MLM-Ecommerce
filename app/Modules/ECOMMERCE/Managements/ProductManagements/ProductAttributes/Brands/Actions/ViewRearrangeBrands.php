<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class ViewRearrangeBrands
{
    public static function execute(Request $request): array
    {
        try {
            $brands = Brand::where('status', 1)->orderBy('serial', 'asc')->get();

            return [
                'status' => 'success',
                'brands' => $brands,
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
