<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;

class GetProductColorFormData
{
    public static function execute(Request $request)
    {
        return [
            'status' => 'success',
            'view' => 'create'
        ];
    }
}
