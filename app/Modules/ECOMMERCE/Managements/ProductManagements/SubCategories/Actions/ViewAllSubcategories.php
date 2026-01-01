<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewAllSubcategories
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('subcategories')
                ->join('categories', 'subcategories.category_id', '=', 'categories.id')
                ->select('subcategories.*', 'categories.name as category_name')
                ->orderBy('subcategories.id', 'desc')
                ->get();

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
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Not Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn">Not Featured</a>';
                    } else {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn">Featured</a>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('EditSubcategory', $data->slug) . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'featured'])
                ->make(true);
        }

        return [
            'status' => 'success',
            'view' => 'view'
        ];
    }
}
