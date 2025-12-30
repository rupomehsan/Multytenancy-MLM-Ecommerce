<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateReturnPolicy
{
    public static function execute(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'return_policy' => $request->return,
            'updated_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Return Policy Updated'];
    }
}
