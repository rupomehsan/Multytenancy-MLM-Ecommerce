<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions\ViewAllFaqs;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions\SaveFaq;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions\DeleteFaq;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions\GetFaqForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Actions\UpdateFaq;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/FAQ');
    }

    public function viewAllFaqs(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllFaqs::execute($request);
        }
        return view('view');
    }

    public function addNewFaq()
    {
        return view('create');
    }

    public function saveFaq(Request $request)
    {
        $result = SaveFaq::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function deleteFaq($slug)
    {
        $result = DeleteFaq::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editFaq($slug)
    {
        $result = GetFaqForEdit::execute($slug);
        return view('update')->with($result);
    }

    public function updateFaq(Request $request)
    {
        $result = UpdateFaq::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/faqs');
    }
}
