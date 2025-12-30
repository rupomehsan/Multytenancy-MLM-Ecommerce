<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;

class SaveNewOutlet
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required'],
        ]);

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $get_image) {
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $relativeDir = 'uploads/outletImages/';
                $location = public_path($relativeDir);

                if (!File::exists($location)) {
                    File::makeDirectory($location, 0755, true);
                }

                if (strtolower($get_image->getClientOriginalExtension()) == 'svg') {
                    $get_image->move($location, $image_name);
                } else {
                    Image::make($get_image)->save($location . $image_name, 60);
                }

                $images[] = $relativeDir . $image_name;
            }
        }

        Outlet::create([
            'title' => $request->title,
            'address' => $request->address,
            'image' => json_encode($images, JSON_UNESCAPED_SLASHES),
            'opening' => $request->opening,
            'contact_number_1' => $request->contact_number_1,
            'contact_number_2' => $request->contact_number_2,
            'contact_number_3' => $request->contact_number_3,
            'map' => $request->map,
            'description' => $request->description,
            'creator' => auth()->user()->id,
            'slug' => Str::slug($request->title) . time(),
            'status' => 'active',
            'created_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Added successfully!'];
    }
}
