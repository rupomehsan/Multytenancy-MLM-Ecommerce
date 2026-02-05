<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class UpdateBlogCategoryInfo
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_status' => 'required',
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        BlogCategory::where('slug', $request->category_slug)->update([
            'name' => $request->name,
            'slug' => $slug . time(),
            'status' => $request->category_status,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Data Updated successfully.'
        ];
    }
}
