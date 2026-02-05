<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewAllProducts
{
    public static function execute(Request $request)
    {
        if ($request->ajax()) {
            ini_set('memory_limit', '4096M');

            $data = DB::table('products')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('flags', 'products.flag_id', '=', 'flags.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->select('products.*', 'units.name as unit_name', 'categories.name as category_name', 'flags.name as flag_name')
                ->where('products.is_package', 0)
                ->orderBy('products.id', 'desc')
                ->get();

            return Datatables::of($data)
                ->editColumn('image', function ($data) {
                    return $data->image;
                })
                ->editColumn('status', function ($data) {
                    return $data->status;
                })
                ->editColumn('price', function ($data) {
                    return $data->price;
                })
                ->editColumn('discount_price', function ($data) {
                    return $data->discount_price;
                })
                ->editColumn('stock', function ($data) {
                    return $data->stock ?? 0;
                })
                ->editColumn('low_stock', function ($data) {
                    return $data->low_stock ?? 0;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $link = env('APP_FRONTEND_URL') . "/product/details/" . $data->slug;
                    $btn = ' <a target="_blank" href="' . $link . '" class="mb-1 btn-sm btn-success rounded d-inline-block" title="For Frontend Product View"><i class="fa fa-eye"></i></a>';
                    $btn .= ' <a href="' . route('EditProduct', $data->slug) . '" class="mb-1 btn-sm btn-warning rounded d-inline-block"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded d-inline-block deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'price', 'status'])
                ->make(true);
        }

        return [
            'status' => 'success'
        ];
    }
}
