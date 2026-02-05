<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateShippingPolicy
{
    public static function execute(Request $request)
    {
        $shipping = TermsAndPolicies::firstOrNew(['id' => 1]);
        $shipping->shipping_policy = $request->shipping;
        
        // Handle background image upload
        if ($request->hasFile('shipping_policy_bg')) {
            // Delete old image if exists
            if ($shipping->shipping_policy_bg && File::exists(public_path($shipping->shipping_policy_bg))) {
                File::delete(public_path($shipping->shipping_policy_bg));
            }
            
            $image = $request->file('shipping_policy_bg');
            $imageName = 'shipping_policy_bg_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/policies'), $imageName);
            $shipping->shipping_policy_bg = 'uploads/policies/' . $imageName;
        }
        
        $shipping->updated_at = Carbon::now();
        $shipping->save();

        return ['status' => 'success', 'message' => 'Shipping Policy Updated'];
    }
}
