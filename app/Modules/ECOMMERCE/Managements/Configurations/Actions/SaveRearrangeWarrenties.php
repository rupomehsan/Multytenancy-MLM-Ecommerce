<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;

class SaveRearrangeWarrenties
{
    public static function execute(Request $request): array
    {
        try {
            $sl = 1;
            foreach ($request->id as $id) {
                ProductWarrenty::where('id', $id)->update([
                    'serial' => $sl
                ]);
                $sl++;
            }

            return [
                'status' => 'success',
                'message' => 'Product Warrenties are Rerranged'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
