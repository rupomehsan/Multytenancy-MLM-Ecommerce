<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewAllChildCategories
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('child_categories')
                ->join('categories', 'child_categories.category_id', '=', 'categories.id')
                ->join('subcategories', 'child_categories.subcategory_id', '=', 'subcategories.id')
                ->select('child_categories.*', 'categories.name as category_name', 'subcategories.name as subcategory_name')
                ->orderBy('child_categories.id', 'desc')
                ->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('edit/childcategory') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return [
            'status' => 'success',
            'view' => 'view'
        ];
    }
}
