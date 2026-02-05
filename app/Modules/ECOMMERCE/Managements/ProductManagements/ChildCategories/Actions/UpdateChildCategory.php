<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class UpdateChildCategory
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $duplicateChildCategoryExists = ChildCategory::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->first();

        if ($duplicateChildCategoryExists) {
            return [
                'status' => 'error',
                'message' => 'Duplicate Child Category Exists'
            ];
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        ChildCategory::where('slug', $request->slug)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => $slug . "-" . time() . "-" . Str::random(5),
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Child Category has been Updated'
        ];
    }
}
