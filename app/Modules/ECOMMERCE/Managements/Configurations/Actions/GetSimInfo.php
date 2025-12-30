<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Models\Sim;

class GetSimInfo
{
    public static function execute(Request $request, $id)
    {
        try {
            $data = Sim::where('id', $id)->first();

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
