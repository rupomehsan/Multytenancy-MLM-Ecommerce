<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use App\Mail\UserVerificationMail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

use App\Http\Controllers\Controller;

class MlmController extends Controller
{
    protected $baseRoute = 'tenant.frontend.pages.customer_panel.pages.mlm.';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referral_tree()
    {
        return view($this->baseRoute . 'referral_tree');
    }

    /**
     * Show the referral list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referral_list()
    {
        return view($this->baseRoute . 'referral_lists');
    }

    /**
     * Show the commission history page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function commission_history()
    {
        return view($this->baseRoute . 'commision_records');
    }

    /**
     * Show the earning reports page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function earning_reports()
    {
        return view($this->baseRoute . 'earning_reports');
    }

    /**
     * Show the withdrawal requests page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function withdrawal_requests()
    {
        return view($this->baseRoute . 'withdrowal');
    }

    /**
     * Submit a new withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit_withdrawal_request(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'method' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        // TODO: Implement withdrawal request logic
        // - Check available balance
        // - Create withdrawal request record
        // - Send notification to admin
        // - Send confirmation email to user

        Toastr::success('Withdrawal request submitted successfully! We will process it within 24-48 hours.', 'Success');
        return redirect()->back();
    }
}
