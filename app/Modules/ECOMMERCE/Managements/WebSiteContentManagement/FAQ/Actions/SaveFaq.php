<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;

class SaveFaq
{
    public static function execute(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => 1,
            'slug' => Str::random(5) . time(),
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'FAQ has been Added'
        ];
    }
}
