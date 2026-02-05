<?php


namespace App\Modules\ECOMMERCE\Managements\SmsService\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\ViewAllSmsTemplates;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\CreateSmsTemplate;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\DeleteSmsTemplate;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\GetTemplateDescription;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\GetSmsTemplateInfo;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\UpdateSmsTemplate;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\GetContactsForSms;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\SendSms;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\ViewAllSmsHistory;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\DeleteSmsHistoryRange;
use App\Modules\ECOMMERCE\Managements\SmsService\Actions\DeleteSmsHistory;


class SmsServiceController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/SmsService');
    }
    public function viewSmsTemplates(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSmsTemplates::execute($request);
        }

        return view('sms_template');
    }

    public function createSmsTemplate()
    {
        return view('create_template');
    }

    public function saveSmsTemplate(Request $request)
    {
        $result = CreateSmsTemplate::execute($request);
        Toastr::success($result['message'], 'Successfully');
        return redirect('view/sms/templates');
    }

    public function deleteSmsTemplate($id)
    {
        $result = DeleteSmsTemplate::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function getTemplateDescription(Request $request)
    {
        $result = GetTemplateDescription::execute($request);
        return response()->json($result['data']);
    }

    public function getSmsTemplateInfo($id)
    {
        $result = GetSmsTemplateInfo::execute(request(), $id);
        return response()->json($result['data']);
    }

    public function updateSmsTemplate(Request $request)
    {
        $result = UpdateSmsTemplate::execute($request);
        return response()->json(['success' => $result['message']]);
    }

    public function sendSmsPage()
    {
        $result = GetContactsForSms::execute(request());
        $data = $result['data'];
        return view('send_sms', compact('data'));
    }

    public function sendSms(Request $request)
    {
        $result = SendSms::execute($request);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Failed');
            return back();
        }

        Toastr::success($result['message'], 'Successfully');
        return back();
    }
    public function viewSmsHistory(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSmsHistory::execute($request);
        }

        return view('sms_history');
    }

    public function deleteSmsHistoryRange()
    {
        $result = DeleteSmsHistoryRange::execute(request());
        Toastr::error($result['message'], 'Successful');
        return back();
    }

    public function deleteSmsHistory($id)
    {
        $result = DeleteSmsHistory::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }
}
