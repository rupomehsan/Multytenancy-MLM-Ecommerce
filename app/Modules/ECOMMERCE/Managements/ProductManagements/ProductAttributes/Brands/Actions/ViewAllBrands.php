<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class ViewAllBrands
{
    public static function execute(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Brand::orderBy('serial', 'asc')->get();

                return DataTables::of($data)
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
                        return $btn;
                    })
                    ->rawColumns(['action', 'logo', 'featured', 'status', 'categories', 'subcategories', 'childcategories'])
                    ->make(true);
            }

            return [
                'status' => 'success',
                'view' => 'view'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
