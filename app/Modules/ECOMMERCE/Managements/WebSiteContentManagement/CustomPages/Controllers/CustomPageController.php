<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Sohibd\Laravelslug\Generate;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;
use Yajra\DataTables\DataTables;


use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Database\Models\CustomPage;

use App\Http\Controllers\Controller;

class CustomPageController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/CustomPages');
    }

    public function createNewPage()
    {
        return view('create');
    }

    public function saveCustomPage(Request $request)
    {

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/custom_pages/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }


        $slug = Generate::Slug($request->page_title);
        $sameSlugCount = CustomPage::where('slug', $slug)->count();
        if ($sameSlugCount > 0) {
            $slug .= "-" . $sameSlugCount + 1;
        }

        CustomPage::insert([
            'image' => $image,
            'page_title' => $request->page_title,
            'description' => $request->description,
            'slug' => $slug,
            'status' => 1,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('New Page has been Created', 'Success');
        return back();
    }

    public function viewCustomPages(Request $request)
    {
        if ($request->ajax()) {

            $data = CustomPage::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->editColumn('slug', function ($data) {
                    return env('APP_FRONTEND_URL') . "/page/" . $data->slug;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('edit/custom/page') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon', 'featured', 'show_on_navbar'])
                ->make(true);
        }
        return view('view');
    }

    public function deleteCustomPage($slug)
    {
        $data = CustomPage::where('slug', $slug)->first();
        if ($data->image) {
            if (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
        }
        $data->delete();
        return response()->json(['success' => 'Page deleted successfully.']);
    }

    public function editCustomPage($slug)
    {
        $data = CustomPage::where('slug', $slug)->first();
        return view('update', compact('data'));
    }

    public function updateCustomPage(Request $request)
    {
        $data = CustomPage::where('id', $request->custom_page_id)->first();

        $image = $data->image;
        if ($request->hasFile('image')) {

            if ($image != '' && file_exists(public_path($image))) {
                unlink(public_path($image));
            }

            $get_image = $request->file('image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/custom_pages/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        $slug = Generate::Slug($request->page_title);
        $sameSlugCount = CustomPage::where('slug', $slug)->where('id', '!=', $request->custom_page_id)->count();
        if ($sameSlugCount > 0) {
            $slug .= "-" . $sameSlugCount + 1;
        }

        CustomPage::where('id', $request->custom_page_id)->update([
            'image' => $image,
            'page_title' => $request->page_title,
            'description' => $request->description,
            'slug' => $slug,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Custom Page has been Updated', 'Success');
        return redirect('view/all/pages');
    }
}
