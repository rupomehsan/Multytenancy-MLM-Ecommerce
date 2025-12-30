<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class ViewAllBanners
{
    public static function execute(Request $request)
    {
        $data = Banner::where('type', 2)->orderBy('serial', 'asc')->get();
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
                $btn = ' <a href="' . url('edit/banner') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
