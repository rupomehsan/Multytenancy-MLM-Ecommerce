<?php


namespace App\Modules\ECOMMERCE\Managements\Configurations\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

use App\Modules\ECOMMERCE\Managements\Configurations\Actions\SaveEmailCredential;

use App\Modules\ECOMMERCE\Managements\EmailService\Database\Models\EmailTemplate;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;


use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewEmailCredentials;
use Facade\FlareClient\View;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Configurations');
    }
    public function viewEmailCredentials(Request $request)
    {
        $data =  ViewEmailCredentials::execute($request);
        return view('email_config', compact('data'));
    }

    public function viewEmailTemplates()
    {
        $orderPlacedTemplates = EmailTemplate::where('type', 'order_placed')->orderBy('serial', 'asc')->get();
        return view('email_template', compact('orderPlacedTemplates'));
    }

    public function changeMailTemplateStatus($templateId)
    {
        $template = EmailTemplate::where('id', $templateId)->first();
        if ($template && $template->status == 1) {
            $template->status = 0;
            $template->save();
            EmailTemplate::where('type', $template->type)->where('id', '!=', $template->id)->update(['status' => 1]);
        } else {
            $template->status = 1;
            $template->save();
            EmailTemplate::where('type', $template->type)->where('id', '!=', $template->id)->update(['status' => 0]);
        }
        return response()->json(['success' => 'Saved successfully.']);
    }

    public function saveEmailCredential(Request $request)
    {

        $result = SaveEmailCredential::execute($request);
        // Normalize responses from the action and show appropriate Toastr messages
        if (isset($result['status']) && $result['status'] === 'success') {
            $msg = $result['message'] ?? 'Saved successfully.';
            Toastr::success($msg, 'Success');
        } else {
            // Validation errors -> redirect back with errors and old input
            if (isset($result['errors'])) {
                // attach errors to the session so Blade's @error helpers work
                return redirect()->back()->withErrors($result['errors'])->withInput();
            } else {
                $msg = $result['message'] ?? 'An error occurred while saving.';
                Toastr::error($msg, 'Error');
            }
        }

        return redirect()->back();
    }

    public function deleteEmailCredential($slug)
    {
        EmailConfigure::where('slug', $slug)->delete();
        return response()->json(['success' => 'Deleted Successfully.']);
    }

    public function getEmailCredentialInfo($slug)
    {
        $data = EmailConfigure::where('slug', $slug)->first();
        return response()->json($data);
    }

    public function updateEmailCredentialInfo(Request $request)
    {

        if ($request->status == 1) {
            DB::table('email_configures')->update([
                'status' => 0,
            ]);
        }



        EmailConfigure::where('slug', $request->email_config_slug)->update([
            'host' => $request->host,
            'port' => $request->port,
            'email' => $request->email,
            'mail_from_name' => $request->mail_from_name,
            'mail_from_email' => $request->mail_from_email,
            'encryption' => $request->encryption,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
