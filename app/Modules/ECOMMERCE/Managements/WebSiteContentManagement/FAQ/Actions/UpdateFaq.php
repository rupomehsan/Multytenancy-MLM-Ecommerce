<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;

class UpdateFaq
{
    public static function execute(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
            'status' => 'required',
        ]);

        Faq::where('slug', $request->slug)->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'FAQ has been Updated'
        ];
    }
}
