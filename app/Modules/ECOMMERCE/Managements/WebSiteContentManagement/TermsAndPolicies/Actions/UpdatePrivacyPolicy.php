<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdatePrivacyPolicy
{
    public static function execute(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'privacy_policy' => $request->privacy,
            'updated_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Privacy Policy Updated'];
    }
}
