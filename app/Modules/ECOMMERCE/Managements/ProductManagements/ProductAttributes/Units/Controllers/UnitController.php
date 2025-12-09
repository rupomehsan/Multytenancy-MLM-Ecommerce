<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use DB;


use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;



class UnitController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Units');
    }



    // unit methods
    public function viewAllUnits(Request $request)
    {
        if ($request->ajax()) {

            $data = Unit::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon'])
                ->make(true);
        }
        return view('unit');
    }

    public function deleteUnit($id)
    {
        Unit::where('id', $id)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getUnitInfo($id)
    {
        $data = Unit::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateUnitInfo(Request $request)
    {
        Unit::where('id', $request->flag_slug)->update([
            'name' => $request->name,
            'status' => $request->flag_status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function createNewUnit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Unit::insert([
            'name' => $request->name,
            'status' => 1,
            'created_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }
}
