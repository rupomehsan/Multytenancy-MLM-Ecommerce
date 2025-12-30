<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions\SaveNewSideBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions\ViewAllSideBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions\DeleteSideBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions\GetSideBannerForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions\UpdateSideBanner;

class SideBannerController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/SideBanner');
    }

    public function addNewSideBanner()
    {
        return view('create');
    }

    public function saveNewSideBanner(Request $request)
    {
        $result = SaveNewSideBanner::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllSideBanner(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSideBanner::execute($request);
        }
        return view('view');
    }

    public function deleteSideBanner($slug)
    {
        $result = DeleteSideBanner::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editSideBanner($slug)
    {
        $result = GetSideBannerForEdit::execute($slug);
        
        if (!$result['data']) {
            Toastr::error('Side Banner not found', 'Error');
            return redirect('view/all/side-banner');
        }

        return view('update')->with($result);
    }

    public function updateSideBanner(Request $request)
    {
        $result = UpdateSideBanner::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('view/all/side-banner');
    }
}
