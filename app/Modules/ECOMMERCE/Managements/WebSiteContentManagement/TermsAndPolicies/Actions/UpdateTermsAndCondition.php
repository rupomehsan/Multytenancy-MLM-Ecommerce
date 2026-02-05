<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Database\Models\TermsAndPolicies;

class UpdateTermsAndCondition
{
    public static function execute(Request $request)
    {
        $terms = TermsAndPolicies::firstOrNew(['id' => 1]);
        $terms->terms = $request->terms;
        
        // Handle background image upload
        if ($request->hasFile('terms_bg')) {
            // Delete old image if exists
            if ($terms->terms_bg && File::exists(public_path($terms->terms_bg))) {
                File::delete(public_path($terms->terms_bg));
            }
            
            $image = $request->file('terms_bg');
            $imageName = 'terms_bg_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/policies'), $imageName);
            $terms->terms_bg = 'uploads/policies/' . $imageName;
        }
        
        $terms->updated_at = Carbon::now();
        $terms->save();

        return ['status' => 'success', 'message' => 'Terms & Condition Updated'];
    }
}
