<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;

class GetProductWarrentyInfo
{
    public static function execute(Request $request, $id)
    {
        try {
            $data = ProductWarrenty::where('id', $id)->first();

            return [
                'status' => 'success',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
