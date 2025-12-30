<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Database\Models\SideBanner;

class ViewAllSideBanner
{
    public static function execute(Request $request)
    {
        $data = SideBanner::orderBy('id', 'desc')->get();
        return Datatables::of($data)
            ->editColumn('status', function ($data) {
                if ($data->status == 'active') {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->editColumn('banner_img', function ($data) {
                return $data->banner_img ? $data->banner_img : 'No Image';
            })
            ->editColumn('banner_link', function ($data) {
                return '<a href="' . $data->banner_link . '" target="_blank">' . $data->banner_link . '</a>';
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('edit/side-banner') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'banner_img', 'banner_link'])
            ->make(true);
    }
}
