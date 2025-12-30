<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;

class UpdateUnit
{
    public static function execute(Request $request)
    {
        Unit::where('id', $request->flag_slug)->update([
            'name' => $request->name,
            'status' => $request->flag_status,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Updated successfully.'
        ];
    }
}
