<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\ViewAllSliders;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\SaveNewSlider;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\DeleteSlider;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\GetSliderForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\UpdateSlider;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\GetSlidersForRearrange;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\UpdateRearrangedSliders;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\ViewAllBanners;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\SaveNewBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\GetBannerForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\UpdateBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\GetBannersForRearrange;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\UpdateRearrangedBanners;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\ViewPromotionalBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\UpdatePromotionalBanner;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\RemovePromotionalHeaderIcon;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\RemovePromotionalProductImage;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions\RemovePromotionalBackgroundImage;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/Banners');
    }

    public function viewAllSliders(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllSliders::execute($request);
        }
        return view('sliders');
    }

    public function addNewSlider()
    {
        return view('create_slider');
    }

    public function saveNewSlider(Request $request)
    {
        $result = SaveNewSlider::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function deleteData($slug)
    {
        $result = DeleteSlider::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editSlider($slug)
    {
        $result = GetSliderForEdit::execute($slug);
        return view('update_slider')->with($result);
    }

    public function updateSlider(Request $request)
    {
        $result = UpdateSlider::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/sliders');
    }

    public function rearrangeSlider()
    {
        $result = GetSlidersForRearrange::execute(request());
        return view('rearrange_slider')->with($result);
    }

    public function updateRearrangedSliders(Request $request)
    {
        $result = UpdateRearrangedSliders::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/sliders');
    }

    public function viewAllBanners(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllBanners::execute($request);
        }
        return view('banners');
    }

    public function addNewBanner()
    {
        return view('create_banner');
    }

    public function saveNewBanner(Request $request)
    {
        $result = SaveNewBanner::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/banners');
    }

    public function editBanner($slug)
    {
        $result = GetBannerForEdit::execute($slug);
        return view('update_banner')->with($result);
    }

    public function updateBanner(Request $request)
    {
        $result = UpdateBanner::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/banners');
    }

    public function rearrangeBanners()
    {
        $result = GetBannersForRearrange::execute(request());
        return view('rearrange_banners')->with($result);
    }

    public function updateRearrangedBanners(Request $request)
    {
        $result = UpdateRearrangedBanners::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/banners');
    }

    public function viewPromotionalBanner()
    {
        $result = ViewPromotionalBanner::execute(request());
        return view('promotional_banner')->with($result);
    }

    public function updatePromotionalBanner(Request $request)
    {
        $result = UpdatePromotionalBanner::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function removePromotionalHeaderIcon()
    {
        $result = RemovePromotionalHeaderIcon::execute(request());
        return response()->json(['success' => $result['message']]);
    }

    public function removePromotionalProductImage()
    {
        $result = RemovePromotionalProductImage::execute(request());
        return response()->json(['success' => $result['message']]);
    }

    public function removePromotionalBackgroundImage()
    {
        $result = RemovePromotionalBackgroundImage::execute(request());
        return response()->json(['success' => $result['message']]);
    }
}
