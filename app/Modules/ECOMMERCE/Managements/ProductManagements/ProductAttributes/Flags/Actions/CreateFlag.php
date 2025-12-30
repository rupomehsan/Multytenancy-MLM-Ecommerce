<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class CreateFlag
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $uploadsDir = public_path('uploads/');
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $flagIconsDir = public_path('uploads/flag_icons/');
        if (!file_exists($flagIconsDir)) {
            mkdir($flagIconsDir, 0777, true);
        }

        $icon = null;
        if ($request->hasFile('icon')) {
            $get_image = $request->file('icon');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/flag_icons/');
            $get_image->move($location, $image_name);
            $icon = "uploads/flag_icons/" . $image_name;
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        Flag::insert([
            'name' => $request->name,
            'icon' => $icon,
            'slug' => $slug . "-" . Str::random(5) . "-" . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Created successfully.'
        ];
    }
}
