<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class DeleteStorage
{
    public static function execute(Request $request, $id): array
    {
        try {
            StorageType::where('id', $id)->delete();

            return [
                'status' => 'success',
                'message' => 'StorageType deleted successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
