<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;


class TermsAndPolicyController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/TermsAndPolicies');
    }
    public function viewTermsAndCondition()
    {
        $data = TermsAndPolicies::where('id', 1)->select('terms')->first() ?? new TermsAndPolicies();
        return view('terms', compact('data'));
    }

    public function updateTermsAndCondition(Request $request)
    {
        $terms = TermsAndPolicies::firstOrNew(['id' => 1]);
        $terms->terms = $request->terms;
        $terms->updated_at = Carbon::now();
        $terms->save();

        Toastr::success('Terms & Condition Updated', 'Updated Successfully');
        return back();
    }

    public function viewPrivacyPolicy()
    {
        $data = TermsAndPolicies::where('id', 1)->select('privacy_policy')->first() ?? new TermsAndPolicies();
        return view('privacy', compact('data'));
    }

    public function updatePrivacyPolicy(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'privacy_policy' => $request->privacy,
            'updated_at' => Carbon::now(),
        ]);
        Toastr::success('Privacy Policy Updated', 'Updated Successfully');
        return back();
    }

    public function viewShippingPolicy()
    {
        $data = TermsAndPolicies::where('id', 1)->select('shipping_policy')->first() ?? new TermsAndPolicies();
        return view('shipping', compact('data'));
    }

    public function updateShippingPolicy(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'shipping_policy' => $request->shipping,
            'updated_at' => Carbon::now(),
        ]);
        Toastr::success('Shipping Policy Updated', 'Updated Successfully');
        return back();
    }

    public function viewReturnPolicy()
    {
        $data = TermsAndPolicies::where('id', 1)->select('return_policy')->first() ?? new TermsAndPolicies();
        return view('return', compact('data'));
    }

    public function updateReturnPolicy(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'return_policy' => $request->return,
            'updated_at' => Carbon::now(),
        ]);
        Toastr::success('Return Policy Updated', 'Updated Successfully');
        return back();
    }
}
