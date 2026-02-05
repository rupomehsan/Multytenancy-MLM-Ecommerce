<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;

class UpdateProductWarrenty
{
    public static function execute(Request $request): array
    {
        try {
            ProductWarrenty::where('id', $request->product_warrenty_id)->update([
                'name' => $request->name,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Updated successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
