<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions;

use Illuminate\Http\Request;
use DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;

class ViewAllOutlet
{
    public static function execute(Request $request)
    {
        $data = Outlet::orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->editColumn('status', function ($data) {
                return $data->status == 'active' ? 'Active' : 'Inactive';
            })
            ->editColumn('image', function ($row) {
                $images = json_decode($row->image, true);
                $firstImage = !empty($images) ? $images[0] : 'uploads/default.png';
                return asset($firstImage);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('edit/outlet') . '/' . $data->slug . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }
}
