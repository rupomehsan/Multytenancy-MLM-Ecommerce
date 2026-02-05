<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Sim;

class UpdateSimInfo
{
    public static function execute(Request $request): array
    {
        try {
            Sim::where('id', $request->sim_id)->update([
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
