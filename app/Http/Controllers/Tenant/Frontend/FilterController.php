<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function filterProducts(Request $request)
    {

        $firstParam = $request->firstParam ?? 'category';
        if ($firstParam === 'category') {
            return $this->filterProductsCategory($request);
        } else if ($firstParam === 'brand_id') {
            return $this->filterProductsBrand($request);
        } else {
            return $this->filterProductsCategory($request);
        }
    }

    public function filterProductsCategory(Request $request)
    {
        // filter parameter
        $categoryId = $request->category;

        // main query
        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.status', 1);

        // fixed parameter query
        if ($categoryId) {
            $query->where('categories.slug', $categoryId);
        }

        // ========== filter parameters query start ============
        $subcategoryId = $request->subcategory_id;
        $flagId = $request->flag_id;
        $brandId = $request->brand_id;
        $search_keyword = $request->search_keyword;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $filter = $request->filter;
        $pathName = $request->path_name;
        $parameters = '';

        // Package filter
        if ($filter === 'packages') {
            $query->where('products.is_package', 1);
            $parameters .= '&filter=packages';
        } elseif ($filter === 'products') {
            $query->where('products.is_package', '!=', 1);
            $parameters .= '&filter=products';
        }

        if ($subcategoryId) {
            $query->whereIn('products.subcategory_id', explode(",", $subcategoryId));
            $parameters .= '&subcategory_id=' . $subcategoryId;
        }
        if ($flagId) {
            $query->whereIn('products.flag_id', explode(",", $flagId));
            $parameters .= '&flag_id=' . $flagId;
        }
        if ($brandId) {
            $query->whereIn('products.brand_id', explode(",", $brandId));
            $parameters .= '&brand_id=' . $brandId;
        }
        if ($search_keyword) {
            $query->where('products.name', 'LIKE', '%' . $search_keyword . '%');
            $parameters .= '&search_keyword=' . $search_keyword;
        }

        if ($sort_by && $sort_by > 0) {
            if ($sort_by == 1) {
                $query->orderBy('products.id', 'desc');
            }
            if ($sort_by == 2) {
                $query->orderBy('products.discount_price', 'asc')->orderBy('products.price', 'asc');
            }
            if ($sort_by == 3) {
                $query->orderBy('products.discount_price', 'desc')->orderBy('products.price', 'desc');
            }
            $parameters .= '&sort_by=' . $sort_by;
        } else {
            $query->orderBy('products.id', 'desc');
        }

        if ($min_price && $min_price > 0) {
            $query->where(function ($query) use ($min_price) {
                $query->where('products.price', '>=', $min_price)->orWhere('products.discount_price', '>=', $min_price);
            });
            $parameters .= '&min_price=' . $min_price;
        }
        if ($max_price && $max_price > 0) {
            $query->where(function ($query) use ($max_price) {
                $query->where([['products.discount_price', '<=', $max_price], ['products.discount_price', '>', 0]])->orWhere([['products.price', '<=', $max_price], ['products.price', '>', 0]]);
            });
            $parameters .= '&max_price=' . $max_price;
        }
        // ========== filter parameters query end ============

        // fetch data with pagination
        $products = $query->paginate(12);
        $products->withPath($pathName . '?category=' . $categoryId . $parameters);

        // return response
        $showingResults = "Showing " . (($products->currentpage() - 1) * $products->perpage() + 1) . " - " . $products->currentpage() * $products->perpage() . " of " . $products->total() . " results";
        $returnHTML = view('shop.products', [
            'products' => $products,
        ])->render();

        return response()->json([
            'rendered_view' => $returnHTML,
            'showingResults' => $showingResults,
        ]);
    }

    public function filterProductsBrand(Request $request)
    {
        // filter parameter
        $brand = $request->brand;

        // main query
        $query = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.status', 1);



        // fixed parameter query
        if ($brand) {
            $query->where('brands.id', $brand);
        }

        // ========== filter parameters query start ============
        $subcategoryId = $request->subcategory_id;
        $flagId = $request->flag_id;
        $categoryId =  $request->category;
        $brandId = $request->brand_id;
        $search_keyword = $request->search_keyword;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $pathName = $request->path_name;
        $parameters = '';

        if ($subcategoryId) {
            $query->whereIn('products.subcategory_id', explode(",", $subcategoryId));
            $parameters .= '&subcategory_id=' . $subcategoryId;
        }
        if ($flagId) {
            $query->whereIn('products.flag_id', explode(",", $flagId));
            $parameters .= '&flag_id=' . $flagId;
        }
        if ($categoryId) {
            $query->whereIn('products.category_id', explode(",", $categoryId));
            $parameters .= '&category=' . $categoryId;
        }
        if ($brandId) {
            $query->whereIn('products.brand_id', explode(",", $brandId));
            $parameters .= '&brand_id=' . $brandId;
        }
        if ($search_keyword) {
            $query->where('products.name', 'LIKE', '%' . $search_keyword . '%');
            $parameters .= '&search_keyword=' . $search_keyword;
        }

        if ($sort_by && $sort_by > 0) {
            if ($sort_by == 1) {
                $query->orderBy('products.id', 'desc');
            }
            if ($sort_by == 2) {
                $query->orderBy('products.discount_price', 'asc')->orderBy('products.price', 'asc');
            }
            if ($sort_by == 3) {
                $query->orderBy('products.discount_price', 'desc')->orderBy('products.price', 'desc');
            }
            $parameters .= '&sort_by=' . $sort_by;
        } else {
            $query->orderBy('products.id', 'desc');
        }

        if ($min_price && $min_price > 0) {
            $query->where(function ($query) use ($min_price) {
                $query->where('products.price', '>=', $min_price)->orWhere('products.discount_price', '>=', $min_price);
            });
            $parameters .= '&min_price=' . $min_price;
        }
        if ($max_price && $max_price > 0) {
            $query->where(function ($query) use ($max_price) {
                $query->where([['products.discount_price', '<=', $max_price], ['products.discount_price', '>', 0]])->orWhere([['products.price', '<=', $max_price], ['products.price', '>', 0]]);
            });
            $parameters .= '&max_price=' . $max_price;
        }
        // ========== filter parameters query end ============

        // fetch data with pagination
        $products = $query->paginate(12);
        $products->withPath($pathName . '?brand_id=' . $brandId . $parameters);

        // return response
        $showingResults = "Showing " . (($products->currentpage() - 1) * $products->perpage() + 1) . " - " . $products->currentpage() * $products->perpage() . " of " . $products->total() . " results";
        $returnHTML = view('shop.products', [
            'products' => $products,
        ])->render();

        return response()->json([
            'rendered_view' => $returnHTML,
            'showingResults' => $showingResults,
        ]);
    }
}
