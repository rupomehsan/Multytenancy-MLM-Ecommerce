<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\ViewTermsAndCondition;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\UpdateTermsAndCondition;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\ViewPrivacyPolicy;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\UpdatePrivacyPolicy;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\ViewShippingPolicy;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\UpdateShippingPolicy;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\ViewReturnPolicy;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions\UpdateReturnPolicy;

class TermsAndPolicyController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/TermsAndPolicies');
    }

    public function viewTermsAndCondition()
    {
        $result = ViewTermsAndCondition::execute(request());
        return view('terms')->with($result);
    }

    public function updateTermsAndCondition(Request $request)
    {
        $result = UpdateTermsAndCondition::execute($request);
        Toastr::success($result['message'], 'Updated Successfully');
        return back();
    }

    public function viewPrivacyPolicy()
    {
        $result = ViewPrivacyPolicy::execute(request());
        return view('privacy')->with($result);
    }

    public function updatePrivacyPolicy(Request $request)
    {
        $result = UpdatePrivacyPolicy::execute($request);
        Toastr::success($result['message'], 'Updated Successfully');
        return back();
    }

    public function viewShippingPolicy()
    {
        $result = ViewShippingPolicy::execute(request());
        return view('shipping')->with($result);
    }

    public function updateShippingPolicy(Request $request)
    {
        $result = UpdateShippingPolicy::execute($request);
        Toastr::success($result['message'], 'Updated Successfully');
        return back();
    }

    public function viewReturnPolicy()
    {
        $result = ViewReturnPolicy::execute(request());
        return view('return')->with($result);
    }

    public function updateReturnPolicy(Request $request)
    {
        $result = UpdateReturnPolicy::execute($request);
        Toastr::success($result['message'], 'Updated Successfully');
        return back();
    }
}
