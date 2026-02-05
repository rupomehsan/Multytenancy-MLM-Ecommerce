<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions\SaveNewVideoGallery;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions\ViewAllVideoGallery;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions\GetVideoGalleryForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions\UpdateVideoGallery;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions\DeleteVideoGallery;

class VideoGalleryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/Videos');
    }

    public function addNewVideoGallery()
    {
        return view('create');
    }

    public function saveNewVideoGallery(Request $request)
    {
        $result = SaveNewVideoGallery::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllVideoGallery(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllVideoGallery::execute($request);
        }
        return view('view');
    }

    public function editVideoGallery($slug)
    {
        $result = GetVideoGalleryForEdit::execute($slug);
        return view('edit')->with($result);
    }

    public function updateVideoGallery(Request $request)
    {
        $result = UpdateVideoGallery::execute($request);
        Toastr::success($result['message'], 'Success!');
        return view('edit')->with(['data' => $result['data']]);
    }

    public function deleteVideoGallery($slug)
    {
        $result = DeleteVideoGallery::execute($slug);
        return response()->json([
            'success' => $result['message'],
            'data' => $result['data']
        ]);
    }
}
