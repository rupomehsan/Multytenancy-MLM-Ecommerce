<?php

namespace App\Modules\MLM\Managements\Referral\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Service\ReferralTreeService;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\MLM\Managements\Referral\Actions\ViewReferralList;
use App\Modules\MLM\Managements\Referral\Actions\ViewReferralActivityLog;



class ReferralController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Referral');
    }
    public function referral_list(Request $request)
    {
        if ($request->ajax()) {
            return ViewReferralList::execute($request);
        }
        return view('referral_list');
    }

    /**
     * Display the referral tree for any user (admin view).
     * Builds a hierarchical tree structure up to 3 levels deep.
     * Can be used for admin to view any user's referral tree.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function referral_tree(Request $request)
    {
        // Get user ID from request, or default to authenticated user
        $userId = $request->get('user_id', auth()->id());

        // Get the target user
        $user = User::findOrFail($userId);

        // Initialize the ReferralTreeService
        $treeService = new ReferralTreeService();

        // Build the tree structure (max 3 levels)
        $tree = $treeService->buildTree($user);

        // Get additional network statistics
        $stats = $treeService->getNetworkStats($user);

        // Pass data to the view
        return view('referral_tree', [
            'tree' => $tree,
            'stats' => $stats,
            'rootCustomer' => $user,
        ]);
    }

    public function referral_activity_log(Request $request)
    {
        if ($request->ajax()) {
            return ViewReferralActivityLog::execute($request);
        }
        return view('referral_activity_log');
    }
}
