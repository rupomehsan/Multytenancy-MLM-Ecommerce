<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use DB;


use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;


class FlagController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Flags');
    }
    // falg methods
    public function viewAllFlags(Request $request)
    {
        if ($request->ajax()) {

            $data = Flag::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->editColumn('featured', function ($data) {
                    if ($data->featured == 0) {
                        return '<button class="btn btn-sm btn-danger rounded">Not Featured</button>';
                    } else {
                        return '<button class="btn btn-sm btn-success rounded">Featured</button>';
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('icon', function ($data) {
                    if ($data->icon && file_exists(public_path($data->icon)))
                        return $data->icon;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';

                    if ($data->featured == 0) {
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn"><i class="feather-chevrons-up"></i></a>';
                    } else {
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn"><i class="feather-chevrons-down"></i></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'featured'])
                ->make(true);
        }
        return view('flag');
    }

    public function deleteFlag($slug)
    {
        Flag::where('slug', $slug)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getFlagInfo($slug)
    {
        $data = Flag::where('slug', $slug)->first();
        return response()->json($data);
    }

    public function updateFlagInfo(Request $request)
    {

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name)); //remove all non alpha numeric
        $slug = preg_replace('!\s+!', '-', $clean);

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/');
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $flagIconsDir = public_path('uploads/flag_icons/');
        if (!file_exists($flagIconsDir)) {
            mkdir($flagIconsDir, 0777, true);
        }

        $icon = Flag::where('slug', $request->flag_slug)->first()->icon;
        if ($request->hasFile('icon')) {
            $get_image = $request->file('icon');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/flag_icons/');
            $get_image->move($location, $image_name);
            $icon = "uploads/flag_icons/" . $image_name;
        }

        Flag::where('slug', $request->flag_slug)->update([
            'name' => $request->name,
            'icon' => $icon,
            'slug' => $slug . "-" . str::random(5) . "-" . time(),
            'status' => $request->flag_status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function createNewFlag(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
        ]);

        // Ensure uploads directory exists
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
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/flag_icons/');
            $get_image->move($location, $image_name);
            $icon = "uploads/flag_icons/" . $image_name;
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name)); //remove all non alpha numeric
        $slug = preg_replace('!\s+!', '-', $clean);

        Flag::insert([
            'name' => $request->name,
            'icon' => $icon,
            'slug' => $slug . "-" . str::random(5) . "-" . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Updated successfully.']);
    }

    public function featureFlag($id)
    {
        $data = Flag::where('id', $id)->first();
        if ($data->featured == 0) {
            $data->featured = 1;
            $data->save();
        } else {
            $data->featured = 0;
            $data->save();
        }
        return response()->json(['success' => 'Satatus Changed successfully.']);
    }
}
