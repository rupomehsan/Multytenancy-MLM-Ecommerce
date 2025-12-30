<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class ViewAllColors
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = Color::orderBy('id', 'desc')->select('colors.*', 'colors.code as color')->get();

            return Datatables::of($data)
                ->editColumn('color', function ($data) {
                    return "<span style='background-color: " . $data->color . ";color: " . $data->color . "; height:20px; width: 50px; display: inline-block; border-radius: 4px; cursor: pointer; box-shadow: 1px 1px 3px gray;'>Color</span>";
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'color'])
                ->make(true);
        }

        return [
            'status' => 'success',
            'view' => 'color'
        ];
    }
}
