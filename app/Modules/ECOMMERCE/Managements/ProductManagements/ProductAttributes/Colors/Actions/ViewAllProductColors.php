<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class ViewAllProductColors
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            $data = Color::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name ? $data->name : 'N/A';
                })
                ->addColumn('code', function ($data) {
                    return $data->code ? $data->code : 'N/A';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . route('GetColorInfo', $data->id) . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href=\"javascript:void(0)\" data-toggle=\"tooltip\" data-id=\"' . $data->id . '\" data-original-title=\"Delete\" class=\"btn-sm btn-danger rounded deleteBtn\"><i class=\"fas fa-trash-alt\"></i></a>';
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
