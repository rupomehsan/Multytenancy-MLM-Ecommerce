<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class ViewTermsAndCondition
{
    public static function execute(Request $request)
    {
        $data = TermsAndPolicies::where('id', 1)->select('terms','terms_bg')->first() ?? new TermsAndPolicies();
        return ['data' => $data];
    }
}
