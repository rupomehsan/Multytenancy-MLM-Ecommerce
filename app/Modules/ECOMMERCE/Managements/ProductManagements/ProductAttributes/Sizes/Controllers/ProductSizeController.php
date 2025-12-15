<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;


class ProductSizeController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Sizes');
    }
    // product size
    public function viewAllSizes(Request $request)
    {

        if ($request->ajax()) {

            $data = ProductSize::orderBy('serial', 'asc')->get();

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
        return view('size');
    }

    public function deleteSize($id)
    {
        ProductSize::where('id', $id)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getSizeInfo($id)
    {
        $data = ProductSize::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateSizeInfo(Request $request)
    {
        ProductSize::where('id', $request->flag_slug)->update([
            'name' => $request->name,
            'status' => $request->flag_status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function createNewSize(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        ProductSize::insert([
            'name' => $request->name,
            'status' => 1,
            'slug' => time() . str::random(5),
            'created_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function rearrangeSize(Request $request)
    {
        $data = ProductSize::orderBy('serial', 'asc')->get();
        return view('rearrangeSize', compact('data'));
    }

    public function saveRearrangedSizes(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            ProductSize::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        Toastr::success('Product Sizes are Rerranged', 'Success');
        return redirect('/view/all/sizes');
    }
}
