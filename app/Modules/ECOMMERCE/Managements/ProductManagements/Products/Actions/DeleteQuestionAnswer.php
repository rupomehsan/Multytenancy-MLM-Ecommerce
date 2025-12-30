<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductQuestionAnswer;

class DeleteQuestionAnswer
{
    public static function execute(Request $request, $id)
    {
        ProductQuestionAnswer::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ];
    }
}
