<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;

class DeleteUnit
{
    public static function execute(Request $request, $id)
    {
        Unit::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
