<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductQuestionAnswer;

class SubmitAnswerOfQuestion
{
    public static function execute(Request $request)
    {
        ProductQuestionAnswer::where('id', $request->question_answer_id)->update([
            'answer' => $request->answer,
            'status' => 1,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Replied Successfully.'
        ];
    }
}
