<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateTermsAndCondition
{
    public static function execute(Request $request)
    {
        $terms = TermsAndPolicies::firstOrNew(['id' => 1]);
        $terms->terms = $request->terms;
        $terms->updated_at = Carbon::now();
        $terms->save();

        return ['status' => 'success', 'message' => 'Terms & Condition Updated'];
    }
}
