<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;


use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class BrandController extends Controller
{


    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Brands');
    }

    public function addNewBrand(Request $request)
    {
        $category =   Category::getDropDownList('name');
        $subcategory =   Subcategory::getDropDownList('name');
        $childcategory =   ChildCategory::getDropDownList('name');
        return view('create', compact('category', 'subcategory', 'childcategory'));
    }
    public function viewAllBrands(Request $request)
    {
        if ($request->ajax()) {

            $data = Brand::orderBy('serial', 'asc')->get();

            return Datatables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="btn btn-sm btn-success rounded" style="padding: 0.1rem .5rem;">Active</span>';
                    } else {
                        return '<span class="btn btn-sm btn-warning rounded" style="padding: 0.1rem .5rem;">Inactive</span>';
                    }
                })
                ->editColumn('featured', function ($data) {
                    if ($data->featured == 0) {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Not Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn">Not Featured</a>';
                    } else {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn">Featured</a>';
                    }
                })
                ->editColumn('categories', function ($data) {
                    $categoryString = '';
                    $categoryArray = explode(",", $data->categories);
                    foreach ($categoryArray as $item) {
                        $catInfo = Category::where('id', $item)->first();
                        if ($catInfo) {
                            $categoryString .= '<button class="btn btn-sm btn-primary rounded" style="padding: .10rem .5rem;">' . $catInfo->name . '</button> ';
                        }
                    }
                    return $categoryString;
                })
                ->editColumn('subcategories', function ($data) {
                    $subcategoryString = '';
                    $subcategoryArray = explode(",", $data->subcategories);
                    foreach ($subcategoryArray as $item) {
                        $subcatInfo = Subcategory::where('id', $item)->first();
                        if ($subcatInfo) {
                            $subcategoryString .= '<button class="btn btn-sm btn-primary rounded" style="padding: .10rem .5rem;">' . $subcatInfo->name . '</button> ';
                        }
                    }
                    return $subcategoryString;
                })
                ->editColumn('childcategories', function ($data) {
                    $childcategoryString = '';
                    $childcategoryArray = explode(",", $data->childcategories);
                    foreach ($childcategoryArray as $item) {
                        $childcatInfo = ChildCategory::where('id', $item)->first();
                        if ($childcatInfo) {
                            $childcategoryString .= '<button class="btn btn-sm btn-primary rounded" style="padding: .10rem .5rem;">' . $childcatInfo->name . '</button> ';
                        }
                    }
                    return $childcategoryString;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('edit/brand') . '/' . $data->slug . '" class="mb-1 btn-sm btn-warning rounded"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    // if($data->featured == 0){
                    //     $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" title="Featured" data-original-title="Featured" class="btn-sm btn-success rounded featureBtn"><i class="feather-chevrons-up"></i></a>';
                    // } else {
                    //     $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" title="Featured" data-original-title="Featured" class="btn-sm btn-danger rounded featureBtn"><i class="feather-chevrons-down"></i></a>';
                    // }

                    return $btn;
                })
                ->rawColumns(['action', 'logo', 'featured', 'status', 'categories', 'subcategories', 'childcategories'])
                ->make(true);
        }
        return view('view');
    }

    public function saveNewBrand(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
        ]);

        $logo = null;
        if ($request->hasFile('logo')) {

            $get_image = $request->file('logo');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/brand_images/');
            if (!file_exists($location)) {
                mkdir($location, 0777, true);
            }
            if ($get_image->getClientOriginalExtension() == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                Image::make($get_image)->save($location . $image_name, 25);
            }

            $logo = "uploads/brand_images/" . $image_name;
        }

        $banner = null;
        if ($request->hasFile('banner')) {
            $get_image = $request->file('banner');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/brand_images/');

            if (!file_exists($location)) {
                mkdir($location, 0777, true);
            }

            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $banner = "uploads/brand_images/" . $image_name;
        }

        Brand::insert([
            'name' => $request->name,
            'logo' => $logo,
            'banner' => $banner,
            'categories' => $request->categories ? implode(",", $request->categories) : null,
            'subcategories' => $request->subcategories ? implode(",", $request->subcategories) : null,
            'childcategories' => $request->childcategories ? implode(",", $request->childcategories) : null,
            'slug' => Generate::Slug($request->name),
            'featured' => 0,
            'serial' => Brand::min('serial') - 1,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Brand has been Added', 'Success');
        return back();
    }

    public function featureBrand($id)
    {
        $data = Brand::where('id', $id)->first();
        if ($data->featured == 0) {
            $data->featured = 1;
            $data->save();
        } else {
            $data->featured = 0;
            $data->save();
        }
        return response()->json(['success' => 'Brand Featured Status Changed Successfully.']);
    }

    public function editBrand($slug)
    {
        $data = Brand::where('slug', $slug)->first();
        $categories =   Category::get();
        $subcategories =   Subcategory::get();
        $childcategories =   ChildCategory::get();
        return view('update', compact('data', 'categories', 'subcategories', 'childcategories'));
    }

    public function updateBrand(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => 'required',
        ]);

        $duplicateCategoryExists = Brand::where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($duplicateCategoryExists) {
            Toastr::warning('Duplicate Brand Exists', 'Success');
            return back();
        }

        $data = Brand::where('id', $request->id)->first();

        $logo = $data->logo;
        if ($request->hasFile('logo')) {

            if ($logo != '' && file_exists(public_path($logo))) {
                unlink(public_path($logo));
            }

            $get_image = $request->file('logo');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('brand_images/');

            if ($get_image->getClientOriginalExtension() == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                Image::make($get_image)->save($location . $image_name, 25);
            }

            $logo = "brand_images/" . $image_name;
        }

        $banner = $data->banner;
        if ($request->hasFile('banner')) {

            if ($banner != '' && file_exists(public_path($banner))) {
                unlink(public_path($banner));
            }

            $get_image = $request->file('banner');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/brand_images/');

            if (!file_exists($location)) {
                mkdir($location, 0777, true);
            }

            // Image::make($get_image)->save($location . $image_name, 80);
            $get_image->move($location, $image_name);
            $banner = "uploads/brand_images/" . $image_name;
        }

        Brand::where('id', $request->id)->update([
            'name' => $request->name,
            'logo' => $logo,
            'banner' => $banner,
            'categories' => $request->categories ? implode(",", $request->categories) : null,
            'subcategories' => $request->subcategories ? implode(",", $request->subcategories) : null,
            'childcategories' => $request->childcategories ? implode(",", $request->childcategories) : null,
            'slug' => Generate::Slug($request->name),
            'status' => $request->status,
            'featured' => $request->featured,
            'updated_at' => Carbon::now()
        ]);

        Toastr::success('Banner Info Updated', 'Success');
        return redirect('/view/all/brands');
    }

    public function rearrangeBrands()
    {
        $brands = Brand::where('status', 1)->orderBy('serial', 'asc')->get();
        return view('rearrange', compact('brands'));
    }

    public function saveRearrangeBrands(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            Brand::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        Toastr::success('Brand has been Rerranged', 'Success');
        return redirect('/view/all/brands');
    }

    public function deleteBrand($slug)
    {

        $data = Brand::where('slug', $slug)->first();
        if ($data->logo) {
            if (file_exists(public_path($data->logo))) {
                unlink(public_path($data->logo));
            }
        }

        if ($data->banner) {
            if (file_exists(public_path($data->banner))) {
                unlink(public_path($data->banner));
            }
        }

        Product::where('brand_id', $data->id)->delete();
        $data->delete();
        return response()->json(['success' => 'Brand Deleted Successfully.']);
    }
}
