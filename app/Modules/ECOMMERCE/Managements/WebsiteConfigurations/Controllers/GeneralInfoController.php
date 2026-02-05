<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewAboutUsPage;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateAboutUsPage;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewGeneralInfo;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateGeneralInfo;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewWebsiteTheme;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateWebsiteThemeColor;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewSocialMedia;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateSocialMediaLinks;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewSeoHomePage;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateSeoHomePage;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewCustomCssJs;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateCustomCssJs;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ViewSocialChatScript;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateGoogleRecaptcha;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateGoogleAnalytic;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateGoogleTagManager;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateSocialLogin;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateFacebookPixel;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateMessengerChat;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateTawkChat;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\UpdateCrispChat;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions\ChangeGuestCheckoutStatus;

class GeneralInfoController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebsiteConfigurations');
    }

    public function aboutUsPage()
    {
        $result = ViewAboutUsPage::execute(request());
        return view('about_us', compact('result'))->with($result);
    }

    public function updateAboutUsPage(Request $request)
    {
        $result = UpdateAboutUsPage::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function generalInfo(Request $request)
    {
        $result = ViewGeneralInfo::execute($request);
        return view('info', compact('result'))->with($result);
    }

    public function updateGeneralInfo(Request $request)
    {
        $result = UpdateGeneralInfo::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function websiteThemePage()
    {
        $result = ViewWebsiteTheme::execute(request());
        return view('website_theme', compact('result'))->with($result);
    }

    public function updateWebsiteThemeColor(Request $request)
    {
        $result = UpdateWebsiteThemeColor::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function socialMediaPage()
    {
        $result = ViewSocialMedia::execute(request());
        return view('social_media', compact('result'))->with($result);
    }

    public function updateSocialMediaLinks(Request $request)
    {
        $result = UpdateSocialMediaLinks::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function seoHomePage()
    {
        $result = ViewSeoHomePage::execute(request());
        return view('seo_homepage', compact('result'))->with($result);
    }

    public function updateSeoHomePage(Request $request)
    {
        $result = UpdateSeoHomePage::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function customCssJs()
    {
        $result = ViewCustomCssJs::execute(request());
        return view('custom_css_js', compact('result'))->with($result);
    }

    public function updateCustomCssJs(Request $request)
    {
        $result = UpdateCustomCssJs::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function socialChatScriptPage()
    {
        $result = ViewSocialChatScript::execute(request());
        return view('social_chat_script')->with($result);
    }

    public function updateGoogleRecaptcha(Request $request)
    {
        $result = UpdateGoogleRecaptcha::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateGoogleAnalytic(Request $request)
    {
        $result = UpdateGoogleAnalytic::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateGoogleTagManager(Request $request)
    {
        $result = UpdateGoogleTagManager::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateSocialLogin(Request $request)
    {
        $result = UpdateSocialLogin::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateFacebookPixel(Request $request)
    {
        $result = UpdateFacebookPixel::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateMessengerChat(Request $request)
    {
        $result = UpdateMessengerChat::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateTawkChat(Request $request)
    {
        $result = UpdateTawkChat::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function updateCrispChat(Request $request)
    {
        $result = UpdateCrispChat::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function changeGuestCheckoutStatus()
    {
        $result = ChangeGuestCheckoutStatus::execute(request());
        return response()->json(['success' => $result['message']]);
    }
}
