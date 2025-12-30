<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Models\Sim;

class DeleteSim
{
    public static function execute(Request $request, $id): array
    {
        try {
            Sim::where('id', $id)->delete();

            return [
                'status' => 'success',
                'message' => 'Deleted successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
