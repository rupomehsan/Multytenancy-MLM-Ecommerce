<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductQuestionAnswer;

class GetQuestionAnswerInfo
{
    public static function execute(Request $request, $id)
    {
        $data = ProductQuestionAnswer::where('id', $id)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
