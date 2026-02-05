<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewEmailCredentials;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewEmailTemplates;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ChangeMailTemplateStatus;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\SaveEmailCredential;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\DeleteEmailCredential;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\GetEmailCredentialInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateEmailCredentialInfo;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Configurations');
    }

    public function viewEmailCredentials(Request $request)
    {
        $data = ViewEmailCredentials::execute($request);
        return view('email_config', compact('data'));
    }

    public function viewEmailTemplates()
    {
        $result = ViewEmailTemplates::execute(request());

        return view($result['view'], [
            'orderPlacedTemplates' => $result['orderPlacedTemplates'] ?? collect()
        ]);
    }

    public function changeMailTemplateStatus($templateId)
    {
        $result = ChangeMailTemplateStatus::execute(request(), $templateId);
        return response()->json($result);
    }

    public function saveEmailCredential(Request $request)
    {
        $result = SaveEmailCredential::execute($request);

        if (isset($result['status']) && $result['status'] === 'success') {
            Toastr::success($result['message'] ?? 'Saved successfully.', 'Success');
        } else {
            if (isset($result['errors'])) {
                return redirect()->back()->withErrors($result['errors'])->withInput();
            } else {
                Toastr::error($result['message'] ?? 'An error occurred while saving.', 'Error');
            }
        }

        return redirect()->back();
    }

    public function deleteEmailCredential($slug)
    {
        $result = DeleteEmailCredential::execute(request(), $slug);
        return response()->json($result);
    }

    public function getEmailCredentialInfo($slug)
    {
        $result = GetEmailCredentialInfo::execute(request(), $slug);
        return response()->json($result['data'] ?? null);
    }

    public function updateEmailCredentialInfo(Request $request)
    {
        $result = UpdateEmailCredentialInfo::execute($request);
        return response()->json($result);
    }
}
