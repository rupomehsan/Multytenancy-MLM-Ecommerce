<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;

class SubmitReplyOfProductReview
{
    public static function execute(Request $request)
    {
        ProductReview::where('id', $request->review_id)->update([
            'reply' => $request->reply,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Replied Successfully.'
        ];
    }
}
