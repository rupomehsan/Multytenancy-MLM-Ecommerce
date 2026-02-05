<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;



use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class ViewAllCategory
{


    public static function execute($request)
    {
        try {

            $data = Category::orderBy('serial', 'asc')->get();
            return DataTables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span style="color:green; font-weight: 600">Active</span>';
                    } else {
                        return '<span style="color:#DF3554; font-weight: 600">Inactive</span>';
                    }
                })
                ->editColumn('icon', function ($data) {
                    if ($data->icon && file_exists(public_path($data->icon))) {
                        return $data->icon;
                    }
                })
                ->editColumn('banner_image', function ($data) {
                    if ($data->banner_image && file_exists(public_path($data->banner_image))) {
                        return $data->banner_image;
                    }
                })
                ->editColumn('featured', function ($data) {
                    if ($data->featured == 0) {
                        return '<span class="badge badge-pill p-2 badge-danger" style="font-size: 11px; border-radius: 4px;">Not Featured</span>';
                    } else {
                        return '<span class="badge badge-pill p-2 badge-success" style="font-size: 11px; border-radius: 4px;">Featured</span>';
                    }
                })
                ->editColumn('show_on_navbar', function ($data) {
                    if ($data->show_on_navbar == 1) {
                        return '<span class="badge badge-pill p-2 badge-success" style="font-size: 11px; border-radius: 4px;">Yes</span>';
                    } else {
                        return '<span class="badge badge-pill p-2 badge-danger" style="font-size: 11px; border-radius: 4px;">No</span>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('EditCategory', $data->slug) . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';

                    // if($data->featured == 0){
                    //     $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->slug.'" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn"><i class="feather-chevrons-up"></i></a>';
                    // } else {
                    //     $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->slug.'" title="Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn"><i class="feather-chevrons-down"></i></a>';
                    // }

                    return $btn;
                })
                ->rawColumns(['action', 'icon', 'featured', 'show_on_navbar', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
