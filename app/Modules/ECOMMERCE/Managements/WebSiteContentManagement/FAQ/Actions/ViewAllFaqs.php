<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;

class ViewAllFaqs
{
    public static function execute(Request $request)
    {
        $data = Faq::orderBy('id', 'desc')->get();

        return DataTables::of($data)
            ->editColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = ' <a href="' . url('edit/faq') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'icon'])
            ->make(true);
    }
}
