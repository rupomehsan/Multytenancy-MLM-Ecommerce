<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateShippingPolicy
{
    public static function execute(Request $request)
    {
        TermsAndPolicies::where('id', 1)->update([
            'shipping_policy' => $request->shipping,
            'updated_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Shipping Policy Updated'];
    }
}
