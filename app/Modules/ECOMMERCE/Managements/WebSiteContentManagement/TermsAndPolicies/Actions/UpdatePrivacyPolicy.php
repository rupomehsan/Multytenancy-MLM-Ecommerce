<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdatePrivacyPolicy
{
    public static function execute(Request $request)
    {
        $privacy = TermsAndPolicies::firstOrNew(['id' => 1]);
        $privacy->privacy_policy = $request->privacy;
        
        // Handle background image upload
        if ($request->hasFile('privacy_policy_bg')) {
            // Delete old image if exists
            if ($privacy->privacy_policy_bg && File::exists(public_path($privacy->privacy_policy_bg))) {
                File::delete(public_path($privacy->privacy_policy_bg));
            }
            
            $image = $request->file('privacy_policy_bg');
            $imageName = 'privacy_policy_bg_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/policies'), $imageName);
            $privacy->privacy_policy_bg = 'uploads/policies/' . $imageName;
        }
        
        $privacy->updated_at = Carbon::now();
        $privacy->save();

        return ['status' => 'success', 'message' => 'Privacy Policy Updated'];
    }
}
