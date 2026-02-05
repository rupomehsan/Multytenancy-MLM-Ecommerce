<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class ViewAllFlags
{
    public static function execute(Request $request)
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

        return [
            'status' => 'success',
            'view' => 'flag'
        ];
    }
}
