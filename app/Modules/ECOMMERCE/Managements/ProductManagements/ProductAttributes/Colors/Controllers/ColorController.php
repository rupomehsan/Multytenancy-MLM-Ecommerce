<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;


use App\Http\Controllers\Controller;

class ColorController extends Controller
{

    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Colors');
    }

    public function viewAllColors(Request $request)
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
                    // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" title="Featured" data-original-title="Featured" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'color'])
                ->make(true);
        }
        return view('color');
    }

    public function addNewColor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:colors'],
            'code' => ['required', 'string', 'max:255', 'unique:colors'],
        ]);

        Color::insert([
            'name' => $request->name,
            'code' => $request->code,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Created successfully.']);
    }

    public function deleteColor($id)
    {
        Color::where('id', $id)->delete();
        return response()->json(['success' => 'Delete Successfully.']);
    }

    public function getColorInfo($id)
    {
        $data = Color::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateColor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
        ]);

        Color::where('id', $request->color_id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
