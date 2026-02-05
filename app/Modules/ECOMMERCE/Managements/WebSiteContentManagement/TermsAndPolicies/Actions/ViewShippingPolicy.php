<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class ViewShippingPolicy
{
    public static function execute(Request $request)
    {
        $data = TermsAndPolicies::where('id', 1)->select('shipping_policy','shipping_policy_bg')->first() ?? new TermsAndPolicies();
        return ['data' => $data];
    }
}
