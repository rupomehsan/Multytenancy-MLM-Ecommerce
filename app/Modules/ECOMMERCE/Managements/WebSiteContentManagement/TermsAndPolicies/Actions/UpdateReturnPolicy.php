<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateReturnPolicy
{
    public static function execute(Request $request)
    {
        $returnPolicy = TermsAndPolicies::firstOrNew(['id' => 1]);
        $returnPolicy->return_policy = $request->return;
        
        // Handle background image upload
        if ($request->hasFile('return_policy_bg')) {
            // Delete old image if exists
            if ($returnPolicy->return_policy_bg && File::exists(public_path($returnPolicy->return_policy_bg))) {
                File::delete(public_path($returnPolicy->return_policy_bg));
            }
            
            $image = $request->file('return_policy_bg');
            $imageName = 'return_policy_bg_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/policies'), $imageName);
            $returnPolicy->return_policy_bg = 'uploads/policies/' . $imageName;
        }
        
        $returnPolicy->updated_at = Carbon::now();
        $returnPolicy->save();

        return ['status' => 'success', 'message' => 'Return Policy Updated'];
    }
}
