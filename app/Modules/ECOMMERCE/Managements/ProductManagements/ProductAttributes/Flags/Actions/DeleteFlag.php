<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class DeleteFlag
{
    public static function execute(Request $request, $slug)
    {
        Flag::where('slug', $slug)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully.'
        ];
    }
}
