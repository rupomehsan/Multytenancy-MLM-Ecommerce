<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Sohibd\Laravelslug\Generate;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;


use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\SaveNewCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\ViewAllCategory;
use Facade\FlareClient\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/Categories');
    }


    public function addNewCategory()
    {
        return view('create');
    }

    public function saveNewCategory(Request $request)
    {
        // Ensure uploads directory exists


        $data = SaveNewCategory::execute($request);
        if (isset($data['error'])) {
            Toastr::error($data['error'], 'Failed');
            return back();
        } else {
            Toastr::success('New Category has been Created', 'Success');
            return redirect('/view/all/category');
        }
    }

    public function viewAllCategory(Request $request)
    {

        if ($request->ajax()) {
            return ViewAllCategory::execute($request);
        }
        return view('view');
    }

    public function deleteCategory($slug)
    {
        $data = Category::where('slug', $slug)->first();
        if ($data->icon) {
            if (file_exists(public_path($data->icon))) {
                unlink(public_path($data->icon));
            }
        }
        if ($data->banner_image) {
            if (file_exists(public_path($data->banner_image))) {
                unlink(public_path($data->banner_image));
            }
        }
        $data->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }

    public function featureCategory($slug)
    {
        $data = Category::where('slug', $slug)->first();
        if ($data->featured == 0) {
            $data->featured = 1;
            $data->save();
        } else {
            $data->featured = 0;
            $data->save();
        }
        return response()->json(['success' => 'Status Changed successfully.']);
    }

    public function editCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('update', compact('category'));
    }

    public function updateCategory(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => 'required',
        ]);

        $duplicateCategoryExists = Category::where('id', '!=', $request->id)->where('name', $request->name)->first();
        $duplicateCategorySlugExists = Category::where('id', '!=', $request->id)->where('slug', $request->slug)->first();
        if ($duplicateCategoryExists || $duplicateCategorySlugExists) {
            Toastr::warning('Duplicate Category Or Slug Exists', 'Duplicate');
            return back();
        }

        $data = Category::where('id', $request->id)->first();

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/');
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $categoryImagesDir = public_path('uploads/category_images/');
        if (!file_exists($categoryImagesDir)) {
            mkdir($categoryImagesDir, 0777, true);
        }

        $icon = $data->icon;
        if ($request->hasFile('icon')) {

            if ($icon != '' && file_exists(public_path($icon))) {
                unlink(public_path($icon));
            }

            $get_image = $request->file('icon');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/category_images/');
            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $icon = "uploads/category_images/" . $image_name;
        }

        $categoryBanner = $data->banner_image;
        if ($request->hasFile('banner_image')) {

            if ($categoryBanner != '' && file_exists(public_path($categoryBanner))) {
                unlink(public_path($categoryBanner));
            }

            $get_image = $request->file('banner_image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/category_images/');
            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $categoryBanner = "uploads/category_images/" . $image_name;
        }

        Category::where('id', $request->id)->update([
            'name' => $request->name,
            'icon' => $icon,
            'banner_image' => $categoryBanner,
            'slug' => Generate::Slug($request->slug),
            'status' => $request->status,
            'featured' => $request->featured ? $request->featured : 0,
            'show_on_navbar' => $request->show_on_navbar,
            'updated_at' => Carbon::now()
        ]);

        Toastr::success('Category has been Updated', 'Success');
        return redirect('/view/all/category');
    }

    public function rearrangeCategory()
    {
        $categories = Category::orderBy('serial', 'asc')->get();
        return view('rearrange', compact('categories'));
    }

    public function saveRearrangeCategoryOrder(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            Category::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        Toastr::success('Category has been Rerranged', 'Success');
        return redirect('/view/all/category');
    }
}
