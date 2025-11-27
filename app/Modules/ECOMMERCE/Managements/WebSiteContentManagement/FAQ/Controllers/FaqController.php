<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models\Faq;


use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/FAQ');
    }
    public function viewAllFaqs(Request $request)
    {
        if ($request->ajax()) {

            $data = Faq::orderBy('id', 'desc')->get();

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
                    $btn = ' <a href="' . url('edit/faq') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon'])
                ->make(true);
        }
        return view('view');
    }

    public function addNewFaq()
    {
        return view('create');
    }

    public function saveFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => 1,
            'slug' => str::random(5) . time(),
            'created_at' => Carbon::now()
        ]);

        Toastr::success('FAQ has been Added', 'Success');
        return back();
    }

    public function deleteFaq($slug)
    {
        Faq::where('slug', $slug)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function editFaq($slug)
    {
        $data = Faq::where('slug', $slug)->first();
        return view('update', compact('data'));
    }

    public function updateFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
            'status' => 'required',
        ]);

        Faq::where('slug', $request->slug)->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        Toastr::success('FAQ has been Updated', 'Success');
        return redirect('/view/all/faqs');
    }
}
