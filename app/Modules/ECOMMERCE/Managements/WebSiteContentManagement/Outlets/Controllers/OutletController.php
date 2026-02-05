<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions\SaveNewOutlet;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions\ViewAllOutlet;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions\GetOutletForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions\UpdateOutlet;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Actions\DeleteOutlet;

class OutletController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/Outlets');
    }

    public function addNewOutlet()
    {
        return view('create');
    }

    public function saveNewOutlet(Request $request)
    {
        $result = SaveNewOutlet::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllOutlet(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllOutlet::execute($request);
        }
        return view('view');
    }

    public function editOutlet($slug)
    {
        $result = GetOutletForEdit::execute($slug);
        return view('edit')->with($result);
    }

    public function updateOutlet(Request $request)
    {
        $result = UpdateOutlet::execute($request);
        Toastr::success($result['message'], 'Success!');
        return view('edit')->with(['data' => $result['data']]);
    }

    public function deleteOutlet($slug)
    {
        $result = DeleteOutlet::execute($slug);
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
