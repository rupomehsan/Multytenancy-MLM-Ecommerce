<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Database\Models\VideoGallery;

class ViewAllVideoGallery
{
    public static function execute(Request $request)
    {
        $data = VideoGallery::orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->editColumn('status', function ($data) {
                if ($data->status == "active") {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . route('EditVideoGallery', $data->slug)  . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['source', 'action'])
            ->make(true);
    }
}
