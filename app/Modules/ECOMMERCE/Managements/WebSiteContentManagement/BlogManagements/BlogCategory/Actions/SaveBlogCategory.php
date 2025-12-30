<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class SaveBlogCategory
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        BlogCategory::insert([
            'name' => $request->name,
            'slug' => $slug . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Category has been Added'
        ];
    }
}
