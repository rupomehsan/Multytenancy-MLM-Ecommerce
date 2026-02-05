<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions\ViewTestimonials;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions\SaveTestimonial;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions\DeleteTestimonial;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions\GetTestimonialForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions\UpdateTestimonial;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/Testimonials');
    }

    public function viewTestimonials(Request $request)
    {
        if ($request->ajax()) {
            return ViewTestimonials::execute($request);
        }
        return view('view');
    }

    public function addTestimonial()
    {
        return view('add');
    }

    public function saveTestimonial(Request $request)
    {
        $result = SaveTestimonial::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function deleteTestimonial($slug)
    {
        $result = DeleteTestimonial::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editTestimonial($slug)
    {
        $result = GetTestimonialForEdit::execute($slug);
        return view('edit')->with($result);
    }

    public function updateTestimonial(Request $request)
    {
        $result = UpdateTestimonial::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/testimonials');
    }
}
