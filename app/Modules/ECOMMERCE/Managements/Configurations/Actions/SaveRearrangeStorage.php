<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class SaveRearrangeStorage
{
    public static function execute(Request $request): array
    {
        try {
            $sl = 1;
            foreach ($request->slug as $slug) {
                StorageType::where('slug', $slug)->update([
                    'serial' => $sl
                ]);
                $sl++;
            }

            return [
                'status' => 'success',
                'message' => 'Storages has been Rerranged'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
