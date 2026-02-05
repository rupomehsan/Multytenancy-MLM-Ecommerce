<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;

class ViewRearrangeWarrenty
{
    public static function execute(Request $request): array
    {
        try {
            $warrenties = ProductWarrenty::orderBy('serial', 'asc')->get();

            return [
                'status' => 'success',
                'warrenties' => $warrenties,
                'view' => 'rearrangeWarrenty'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
