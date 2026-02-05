<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions\SaveCustomPage;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions\ViewCustomPages;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions\DeleteCustomPage;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions\GetCustomPageForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions\UpdateCustomPage;

class CustomPageController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/CustomPages');
    }

    public function createNewPage()
    {
        return view('create');
    }

    public function saveCustomPage(Request $request)
    {
        $result = SaveCustomPage::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewCustomPages(Request $request)
    {
        if ($request->ajax()) {
            return ViewCustomPages::execute($request);
        }
        return view('view');
    }

    public function deleteCustomPage($slug)
    {
        $result = DeleteCustomPage::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editCustomPage($slug)
    {
        $result = GetCustomPageForEdit::execute($slug);
        return view('update')->with($result);
    }

    public function updateCustomPage(Request $request)
    {
        $result = UpdateCustomPage::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewCustomPages');
    }
}
