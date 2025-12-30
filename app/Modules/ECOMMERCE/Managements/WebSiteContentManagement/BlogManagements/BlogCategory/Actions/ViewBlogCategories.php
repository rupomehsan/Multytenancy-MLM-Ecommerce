<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Database\Models\BlogCategory;

class ViewBlogCategories
{
    public static function execute(Request $request)
    {
        $data = BlogCategory::orderBy('serial', 'asc')->get();

        return DataTables::of($data)
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->editColumn('featured', function ($data) {
                if ($data->featured == 0) {
                    return '<button class="btn btn-sm btn-danger rounded">Not Featured</button>';
                } else {
                    return '<button class="btn btn-sm btn-success rounded">Featured</button>';
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Edit" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';

                if ($data->featured == 0) {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn"><i class="feather-chevrons-up"></i></a>';
                } else {
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" title="Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn"><i class="feather-chevrons-down"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['action', 'featured'])
            ->make(true);
    }
}
