<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;

class UpdateOutlet
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required'],
        ]);

        $data = Outlet::where('id', $request->outlet_id)->first();

        $images = [];

        if ($request->hasFile('images')) {
            // Remove existing images
            if (!empty($data->image)) {
                $oldImages = json_decode($data->image, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        if (file_exists(public_path($oldImage))) {
                            unlink(public_path($oldImage));
                        }
                    }
                }
            }

            // Add new images
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

        $data->title = $request->title ?? $data->title;
        $data->address = $request->address ?? $data->address;
        $data->opening = $request->opening ?? $data->opening;
        $data->contact_number_1 = $request->contact_number_1 ?? $data->contact_number_1;
        $data->contact_number_2 = $request->contact_number_2 ?? $data->contact_number_2;
        $data->contact_number_3 = $request->contact_number_3 ?? $data->contact_number_3;
        $data->map = $request->map ?? $data->map;
        $data->description = $request->description ?? $data->description;
        $data->image = !empty($images) ? json_encode($images, JSON_UNESCAPED_SLASHES) : $data->image;

        if ($data->title != $request->title) {
            $data->slug = Str::slug($request->title) . time();
        }

        $data->status = $request->status ?? $data->status;
        $data->updated_at = Carbon::now();
        $data->save();

        return ['status' => 'success', 'message' => 'Updated Successfully', 'data' => $data];
    }
}
