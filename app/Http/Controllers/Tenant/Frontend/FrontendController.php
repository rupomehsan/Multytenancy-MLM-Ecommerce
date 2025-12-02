<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;



use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    protected $baseUrl = 'tenant.frontend.pages.';
    public function index()
    {
        $sliders = DB::table('banners')->where('type', 1)->where('status', 1)->orderBy('serial', 'asc')->get();

        $flags = DB::table('flags')
            ->where('status', 1)
            ->where('featured', 1)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // Attach 10 products for each flag
        foreach ($flags as $flag) {
            $flag->initialProducts = DB::table('products')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
                ->leftJoin('flags', 'products.flag_id', '=',  'flags.id')
                ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'is_package', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
                ->where('products.status', 1)
                ->where('products.flag_id', $flag->id)
                ->orderBy('products.id', 'desc')
                ->skip(0)
                ->limit(5)
                ->get();

            // Add total count of products for each flag
            $flag->product_count = DB::table('products')
                ->where('status', 1)
                ->where('flag_id', $flag->id)
                ->count();
        }

        // Get package products for homepage
        $packageProducts = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', '=',  'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'is_package', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.status', 1)
            ->where('products.is_package', 1)
            ->orderBy('products.id', 'desc')
            ->limit(8)
            ->get();



        $featuredCategories = DB::table('categories')->where('status', 1)->where('featured', 1)->orderBy('serial', 'asc')->get();
        $productsForYou = $this->productsForYou();
        $testimonials = DB::table('testimonials')->orderBy('id', 'desc')->get();
        $featuredBrands = DB::table('brands')
            ->where('status', 1)
            ->where('featured', 1)
            ->select('id', 'name', 'logo', 'slug', 'serial', 'status')
            ->orderBy('serial', 'asc')
            ->get();

        $sidebarBanners = DB::table('side_banners')->where('status', 1)->orderBy('id', 'asc')->get();

        return view($this->baseUrl . 'index', compact('sliders', 'flags', 'featuredCategories', 'productsForYou', 'featuredBrands', 'testimonials', 'sidebarBanners', 'packageProducts'));
    }

    public function loadFlagProducts(Request $request)
    {
        $skip = $request->get('skip', 0);
        $flagId = $request->get('flag_id');

        // Get total product count for that flag
        $totalCount = DB::table('products')
            ->where('status', 1)
            ->where('flag_id', $flagId)
            ->count();

        // Set maximum number of products shown via "Show More"
        $maxShowable = min(20, $totalCount);

        // Fetch next 5 products, but don't go beyond maxShowable
        $limit = min(5, $maxShowable - $skip);


        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', '=',  'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.status', 1)
            ->where('products.flag_id', $flagId)
            ->orderBy('products.id', 'desc')
            ->skip($skip)
            ->take($limit)
            ->distinct() // 🔥 THIS IS IMPORTANT
            ->get();

        $html = view('tenant.frontend.pages.homepage_sections.single_product_list', compact('products'))->render();

        // ✅ New reachedLimit logic: if we've now loaded all we can (not just 20)
        $newSkip = $skip + $products->count();
        $reachedLimit = $newSkip >= $totalCount || $newSkip >= 20;

        return response()->json([
            'html' => $html,
            'nextSkip' => $newSkip,
            'reachedLimit' => $reachedLimit
        ]);
    }

    public function trackOrder($orderNo)
    {
        $orderInfo = DB::table('orders')->where('order_no', $orderNo)->first();

        $orderdItems = '';
        $orderProgress = '';

        if ($orderInfo) {
            $orderdItems = DB::table('order_details')
                ->join('orders', 'order_details.order_id', 'orders.id')
                ->join('products', 'order_details.product_id', 'products.id')
                ->leftJoin('colors', 'order_details.color_id', 'colors.id')
                ->leftJoin('product_sizes', 'order_details.size_id', 'product_sizes.id')
                ->select('products.name as product_name', 'products.image as product_image', 'colors.name as color_name', 'product_sizes.name as size_name', 'order_details.product_id', 'order_details.total_price', 'order_details.qty')
                ->where('orders.id', $orderInfo->id)
                ->get();
            $orderProgress = DB::table('order_progress')->where('order_id', $orderInfo->id)->orderBy('order_status', 'asc')->get();
        }

        return view($this->baseUrl . 'track_order', compact('orderInfo', 'orderdItems', 'orderProgress'));
    }

    public function trackOrderNo(Request $request)
    {
        $orderInfo = DB::table('orders')->where('order_no', $request->order_no)->first();

        $orderdItems = '';
        $orderProgress = '';

        if ($orderInfo) {
            $orderdItems = DB::table('order_details')
                ->join('orders', 'order_details.order_id', 'orders.id')
                ->join('products', 'order_details.product_id', 'products.id')
                ->leftJoin('colors', 'order_details.color_id', 'colors.id')
                ->leftJoin('product_sizes', 'order_details.size_id', 'product_sizes.id')
                ->select('products.name as product_name', 'products.image as product_image', 'colors.name as color_name', 'product_sizes.name as size_name', 'order_details.product_id', 'order_details.total_price', 'order_details.qty')
                ->where('orders.id', $orderInfo->id)
                ->get();
            $orderProgress = DB::table('order_progress')->where('order_id', $orderInfo->id)->orderBy('order_status', 'asc')->get();
        }

        return view($this->baseUrl . 'track_order', compact('orderInfo', 'orderdItems', 'orderProgress'));
    }

    public function redirectForTracking(Request $request)
    {
        $order_no = $request->order_no;
        return redirect('track/my/order/' . $order_no);
    }

    public function searchForProducts(Request $request)
    {
        $category = isset($request->category) ? $request->category : '';
        $searchKeyword = $request->filter_search_keyword;
        return redirect('shop?category=' . $category . '&search_keyword=' . $searchKeyword);
    }

    public function productsForYou($productSkip = 0)
    {

        $alreadyOrdered = array();
        $similarCategories = array();
        $similarSubCategories = array();
        // $similarChildCategories = array();

        if (Auth::user()) {

            // calculating already ordered products category start
            $similarOrderedProducts = DB::table('order_details')
                ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
                ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.user_id', Auth::user()->id)
                ->select('products.category_id', 'products.subcategory_id', 'products.childcategory_id', 'products.id as product_id')
                ->groupBy('order_details.product_id')
                ->get();

            if (count($similarOrderedProducts) > 0) {
                foreach ($similarOrderedProducts as $item) {
                    array_push($alreadyOrdered, $item->product_id);
                    array_push($similarCategories, $item->category_id);
                    array_push($similarSubCategories, $item->subcategory_id);
                    // array_push($similarChildCategories, $item->childcategory_id);
                }

                $query = DB::table('products')
                    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
                    ->leftJoin('flags', 'products.flag_id', 'flags.id')
                    ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
                    ->where('products.status', 1);

                // custom lagic for products you may like start
                if (count($alreadyOrdered) > 0) {
                    $query->whereNotIn('products.id', $alreadyOrdered);
                }
                if (count($similarCategories) > 0) {
                    $query->whereIn('products.category_id', $similarCategories);
                }
                if (count($similarSubCategories) > 0) {
                    $query->whereIn('products.subcategory_id', $similarSubCategories);
                }
                // if(count($similarChildCategories) > 0){
                //     $query->whereIn('products.childcategory_id', $similarChildCategories);
                // }
                // custom lagic for products you may like end

                $productsForYou = $query->orderBy('products.id', 'desc')->skip($productSkip)->limit(20)->get();
            } else {
                $productsForYou = DB::table('products')
                    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
                    ->leftJoin('flags', 'products.flag_id', 'flags.id')
                    ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
                    ->where('products.status', 1)
                    ->orderBy('products.id', 'desc')
                    ->skip($productSkip)
                    ->limit(20)
                    ->get();
            }
        } else {
            $productsForYou = DB::table('products')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
                ->leftJoin('flags', 'products.flag_id', 'flags.id')
                ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
                ->where('products.status', 1)
                ->orderBy('products.id', 'desc')
                ->skip($productSkip)
                ->limit(20)
                ->get();
        }

        return $productsForYou;
    }

    public function fetchMoreProducts(Request $request)
    {
        $product_fetch_skip = $request->product_fetch_skip;
        $totalProducts = DB::table('products')->where('products.status', 1)->count();

        if ($product_fetch_skip < $totalProducts) {

            $productsForYou = $this->productsForYou($product_fetch_skip);

            $countFetchedProducts = count($productsForYou);
            $returnHTML = view('tenant.frontend.pages.homepage_sections.more_products', compact('productsForYou'))->render();
            return response()->json(['more_products' => $returnHTML, 'fetched_products' => $countFetchedProducts]);
        } else {
            $countFetchedProducts = 0;
            return response()->json(['fetched_products' => $countFetchedProducts]);
        }
    }

    public function shop(Request $request)
    {
        $categories = DB::table('categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $flags = DB::table('flags')->where('status', 1)->orderBy('id', 'desc')->get();
        $brands = DB::table('brands')->where('status', 1)->orderBy('serial', 'asc')->get();

        $query = DB::table('products')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'is_package', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.status', 1);


        // ============== applying filters from url parameter start ================
        $parameters = '';
        $subcategoryId = $request->subcategory_id;
        $flagId = $request->flag_id;
        $brandId = $request->brand_id ?? $request->brand;
        $brandParam = $request->brand;
        $search_keyword = $request->search_keyword;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $sort_by = $request->sort_by;
        $filter = $request->filter; // Add filter parameter for packages

        $category_id = isset($request->category) ? $request->category : '';
        if ($category_id) {
            $query->where('categories.slug', $category_id);
        }

        $parameters .= '?category=' . $category_id;

        // Package filter
        if ($filter === 'packages') {
            $query->where('products.is_package', 1);
            $parameters .= '&filter=packages';
        } elseif ($filter === 'products') {
            $query->where('products.is_package', '!=', 1);
            $parameters .= '&filter=products';
        }

        // subcategory
        if ($subcategoryId) {
            $query->whereIn('products.subcategory_id', explode(",", $subcategoryId));
            $parameters .= '&subcategory_id=' . $subcategoryId;
        }
        // flag
        if ($flagId) {
            $query->whereIn('products.flag_id', explode(",", $flagId));
            $parameters .= '&flag_id=' . $flagId;
        }
        // brand
        if ($brandId) {
            $query->whereIn('products.brand_id', explode(",", $brandId));
            $parameters .= '&brand_id=' . $brandId;
        }
        // search keyword
        if ($search_keyword) {
            $query->where('products.name', 'LIKE', '%' . $search_keyword . '%');
            $parameters .= '&search_keyword=' . $search_keyword;
        }



        // min price
        if ($min_price && $min_price > 0) {
            $query->where(function ($query) use ($min_price) {
                $query->where('products.discount_price', '>=', $min_price)->orWhere('products.price', '>=', $min_price);
            });
            $parameters .= '&min_price=' . $min_price;
        }
        // max price
        if ($max_price && $max_price > 0) {
            $query->where(function ($query) use ($max_price) {
                $query->where([['products.discount_price', '<=', $max_price], ['products.discount_price', '>', 0]])->orWhere([['products.price', '<=', $max_price], ['products.price', '>', 0]]);
            });
            $parameters .= '&max_price=' . $max_price;
        }


        // sorting
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

        // setting pagination with custom path and parameters
        $products = $query->paginate(12);
        $products->withPath('/shop' . $parameters);

        return view(
            $this->baseUrl . 'shop.shop',
            compact(
                'products',
                'categories',
                'flags',
                'brandParam',
                'brands',
                'category_id',
                'subcategoryId',
                'flagId',
                'brandId',
                'min_price',
                'max_price',
                'sort_by',
                'search_keyword',
                'filter'
            )
        );
    }

    public function productDetails($slug)
    {

        $product = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', 'brands.id')
            ->leftJoin('product_models', 'products.model_id', 'product_models.id')
            ->select('products.*', 'categories.name as category_name', 'categories.slug as category_slug', 'brands.name as brand_name', 'product_models.name as model_name')
            ->where('products.slug', $slug)
            ->first();
        // dd($product);

        $mayLikedProducts = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.id', '!=', $product->id)
            ->where('products.status', 1)
            ->inRandomOrder()
            ->skip(0)
            ->limit(12)
            ->get();

        $productReviews = DB::table('product_reviews')
            ->leftJoin('users', 'product_reviews.user_id', 'users.id')
            ->select('product_reviews.rating', 'product_reviews.review', 'product_reviews.reply', 'product_reviews.created_at', 'product_reviews.status', 'users.name as username', 'users.image as user_image')
            ->where('product_reviews.product_id', $product->id)
            ->where('product_reviews.status', 1)
            ->orderBy('product_reviews.id', 'desc')
            ->paginate(10);

        $totalReviews = $productReviews->total();
        $totalRating = DB::table('product_reviews')->where('product_reviews.product_id', $product->id)->where('product_reviews.status', 1)->sum('rating');
        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;

        $productMultipleImages = DB::table('product_images')->select('image')->where('product_id', $product->id)->get();
        $variants = DB::table('product_variants')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select('product_variants.*', 'colors.id as color_id', 'colors.name as color_name', 'colors.code as color_code', 'product_sizes.name as size_name')
            ->where('product_variants.product_id', $product->id)
            ->get();

        $configSetup = DB::table('config_setups')->get();

        $productQuestions = DB::table('product_question_answers')
            ->select('id', 'full_name', "email", 'question', 'answer', 'created_at', 'updated_at')
            ->where('product_id', $product->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $totalQuestions = $productQuestions->total();



        return view(
            $this->baseUrl . 'product_details.details',
            compact(
                'mayLikedProducts',
                'product',
                'averageRating',
                'totalReviews',
                'productReviews',
                'productMultipleImages',
                'variants',
                'configSetup',
                'productQuestions',
                'totalQuestions'
            )
        );
    }

    public function checkProductVariant(Request $request)
    {

        $query = DB::table('product_variants')->where('product_id', $request->product_id);
        if ($request->color_id != 'null') {
            $query->where('color_id', $request->color_id);
        }
        if ($request->size_id != 'null') {
            $query->where('size_id', $request->size_id);
        }

        $data = $query->where('stock', '>', 0)->orderBy('discounted_price', 'asc')->orderBy('price', 'asc')->first();
        if ($data) {

            $product = DB::table('products')->where('id', $request->product_id)->first();

            // Get variants and calculate total stock for template
            $variants = DB::table('product_variants')
                ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')
                ->leftJoin('product_sizes', 'product_variants.size_id', '=', 'product_sizes.id')
                ->select('product_variants.*', 'colors.name as color_name', 'colors.code as color_code', 'product_sizes.name as size_name')
                ->where('product_variants.product_id', $request->product_id)
                ->get();

            $totalStockAllVariants = 0;
            if ($variants && count($variants) > 0) {
                foreach ($variants as $variant) {
                    $totalStockAllVariants += (int) $variant->stock;
                }
            }

            $returnHTML = view('product_details.cart_buy_button', compact('product', 'variants', 'totalStockAllVariants'))->render();
            return response()->json([
                'rendered_button' => $returnHTML,
                'price' => $data->price,
                'discounted_price' => $data->discounted_price,
                'stock' => $data->stock
            ]);
        } else {
            $query = DB::table('product_variants')->where('product_id', $request->product_id);
            $data = $query->orderBy('discounted_price', 'asc')->orderBy('price', 'asc')->first();

            return response()->json(['price' => $data->price ?? 0, 'discounted_price' => $data->discounted_price ?? 0, 'save' => 0, 'stock' => 0]);
        }
    }

    public function about()
    {
        $data = DB::table('about_us')->where('id', 1)->first();
        $testimonials = DB::table('testimonials')->orderBy('id', 'desc')->get();
        $brands = DB::table('brands')->where('logo', '!=', null)->where('logo', '!=', '')->orderBy('serial', 'asc')->get();
        return view($this->baseUrl . 'about', compact('data', 'testimonials', 'brands'));
    }

    public function faq()
    {
        $data = DB::table('faqs')->orderBy('id', 'desc')->get();
        return view($this->baseUrl . 'faq', compact('data'));
    }

    public function contact()
    {
        $contactInfo = DB::table('general_infos')->select('contact', 'email', 'address', 'facebook', 'twitter', 'instagram', 'linkedin', 'messenger', 'youtube', 'whatsapp', 'telegram', 'tiktok', 'pinterest', 'viber')->first();
        $brands = DB::table('brands')->where('logo', '!=', null)->where('logo', '!=', '')->orderBy('serial', 'asc')->get();
        return view($this->baseUrl . 'contact', compact('contactInfo', 'brands'));
    }

    public function customPage($slug)
    {
        $data = DB::table('custom_pages')->where('slug', $slug)->first();
        return view($this->baseUrl . 'custom_page', compact('data'));
    }

    public function submitContactRequest(Request $request)
    {

        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
        ]);

        DB::table('contact_requests')->insert([
            'name' => $request->firstname . " " . $request->lastname,
            'email' => $request->email,
            'phone' => $request->number,
            'message' => $request->message,
            'status' => 0,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Request is Submitted', 'Success');
        return back();
    }


    public function subscribeForNewsletter(Request $request)
    {

        $data = DB::table('subscribed_users')->where('email', trim($request->email))->first();
        if ($data) {
            Toastr::warning('Already Subscribed', 'Success');
            return back();
        } else {
            DB::table('subscribed_users')->insert([
                'email' => $request->email,
                'created_at' => Carbon::now()
            ]);
            Toastr::success('Successfully Subscribed', 'Success');
            return back();
        }
    }


    public function privacyPolicy()
    {
        $pageTitle = "Privacy Policy";
        $pageUrl = url('/privacy/policy');
        $policy = DB::table('terms_and_policies')->select('privacy_policy as policy')->first();
        return view($this->baseUrl . 'policy', compact('pageTitle', 'pageUrl', 'policy'));
    }

    public function termsOfServices()
    {
        $pageTitle = "Terms of Services";
        $pageUrl = url('/terms/of/services');
        $policy = DB::table('terms_and_policies')->select('terms as policy')->first();
        return view($this->baseUrl . 'policy', compact('pageTitle', 'pageUrl', 'policy'));
    }

    public function refundPolicy()
    {
        $pageTitle = "Refund Policy";
        $pageUrl = url('/refund/policy');
        $policy = DB::table('terms_and_policies')->select('return_policy as policy')->first();
        return view($this->baseUrl . 'policy', compact('pageTitle', 'pageUrl', 'policy'));
    }

    public function shippingPolicy()
    {
        $pageTitle = "Shipping Policy";
        $pageUrl = url('/shipping/policy');
        $policy = DB::table('terms_and_policies')->select('shipping_policy as policy')->first();
        return view($this->baseUrl . 'policy', compact('pageTitle', 'pageUrl', 'policy'));
    }


    public function photo_album()
    {

        $sortOrder = request()->get('sort', 'desc');
        $categorySlug = request()->get('category');
        $subcategoryId = request()->get('subcategory_id');

        // Start building the query
        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('product_models', 'products.model_id', '=', 'product_models.id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.slug as product_slug',
                'categories.name as category_name',
                'brands.name as brand_name',
                'product_models.name as model_name',
                'product_images.image as product_image',
                'product_images.created_at as product_image_created_at',
                'product_variants.image as variant_image',
                'product_variants.created_at as variant_image_created_at'
            )
            ->orderBy('products.created_at', $sortOrder);

        // Apply category filter if present
        if ($categorySlug) {
            $query->where('categories.slug', $categorySlug);
        }

        // Apply subcategory filter if present
        if ($subcategoryId) {
            $query->where('products.subcategory_id', $subcategoryId);
        }

        $rawProducts = $query->get();

        // Collect all images with associated product details
        $allImages = collect();
        $rawProducts->groupBy('product_id')->each(function ($productGroup) use (&$allImages) {
            $product = $productGroup->first();
            $productImages = $productGroup->pluck('product_image')->filter()->unique();
            $variantImages = $productGroup->pluck('variant_image')->filter()->unique();

            $mergedImages = $productImages->merge($variantImages)->unique();

            foreach ($mergedImages as $image) {
                $allImages->push([
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'product_slug' => $product->product_slug,
                    'image' => $image,
                ]);
            }
        });

        // Paginate by images
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedImages = new LengthAwarePaginator(
            $allImages->forPage($currentPage, $perPage),
            $allImages->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $categories = DB::table('categories')
            ->select('name', 'id', 'slug', 'show_on_navbar')
            ->where('status', 1)
            ->orderBy('serial', 'asc')
            ->get();

        return view($this->baseUrl . 'product_details.photo_album', ['images' => $paginatedImages, 'categories' => $categories]);
    }

    public function outlet(Request $request)
    {
        $outlets = DB::table('outlets')->where("status", 'active')->paginate(10);
        return view($this->baseUrl . 'product_details.outlet', compact('outlets'));
    }

    public function video_gallery(Request $request)
    {
        $video_galleries = DB::table('video_galleries')->paginate(10);
        return view($this->baseUrl . 'product_details.video_gallery', compact('video_galleries'));
    }

    public function packageDetails($slug)
    {
        $package = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.name as category_name', 'categories.slug as category_slug', 'brands.name as brand_name')
            ->where('products.slug', $slug)
            ->where('products.is_package', 1)
            ->first();

        if (!$package) {
            abort(404);
        }

        // Get package product images
        $package->productImages = DB::table('product_images')
            ->select('image')
            ->where('product_id', $package->id)
            ->get();

        // Get package items with product details
        // Get package items with product details and try to fetch variant stock if color/size is set
        $packageItems = DB::table('package_product_items')
            ->join('products', 'package_product_items.product_id', '=', 'products.id')
            ->leftJoin('colors', 'package_product_items.color_id', '=', 'colors.id')
            ->leftJoin('product_sizes', 'package_product_items.size_id', '=', 'product_sizes.id')
            ->select(
                'package_product_items.*',
                'products.name as product_name',
                'products.image as product_image',
                'products.price as product_price',
                'products.discount_price as product_discount_price',
                'products.slug as product_slug',
                'products.stock as product_stock',
                'colors.name as color_name',
                'colors.code as color_code',
                'product_sizes.name as size_name'
            )
            ->where('package_product_items.package_product_id', $package->id)
            ->get();

        // Attach variant stock if color_id or size_id is set
        foreach ($packageItems as $item) {
            if ($item->color_id || $item->size_id) {
                $variantQuery = DB::table('product_variants')
                    ->where('product_id', $item->product_id);
                if ($item->color_id) {
                    $variantQuery->where('color_id', $item->color_id);
                }
                if ($item->size_id) {
                    $variantQuery->where('size_id', $item->size_id);
                }
                $variant = $variantQuery->first();
                if ($variant) {
                    $item->variant_stock = $variant->stock;
                    $item->variant_price = $variant->price;
                    $item->variant_discount_price = $variant->discounted_price;
                    // If variant exists, set product_stock to variant_stock
                    $item->product_stock = $variant->stock;
                } else {
                    $item->variant_stock = null;
                    $item->variant_price = null;
                    $item->variant_discount_price = null;
                }
            } else {
                $item->variant_stock = null;
                $item->variant_price = null;
                $item->variant_discount_price = null;
            }
        }


        // Calculate total package value
        $totalPackageValue = 0;
        $totalPackageDiscountValue = 0;
        foreach ($packageItems as $item) {
            $totalPackageValue += ($item->product_price * $item->quantity);
            $totalPackageDiscountValue += (($item->product_discount_price > 0 ? $item->product_discount_price : $item->product_price) * $item->quantity);
        }

        $prePackageValue = $totalPackageDiscountValue ?? $totalPackageValue;
        $thisPackageValue = $package->discount_price ?? $package->price;

        $packageSavings = $prePackageValue - $thisPackageValue;
        $totalPackageValue = $prePackageValue;

        // dd(
        //      $packageItems,
        //     'Total Package Value: ' . $totalPackageValue,
        //     'Total Package Discount Value: ' . $totalPackageDiscountValue,
        //     'Package Savings: ' . $packageSavings,
        //     'Package Price: ' . $package->price,
        //     'Package Discount Price: ' . $package->discount_price
        // );

        // Get related packages
        $relatedPackages = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'is_package', 'products.short_description', 'categories.name as category_name', 'subcategories.name as subcategory_name', 'brands.name as brand_name')
            ->where('products.id', '!=', $package->id)
            ->where('products.status', 1)
            ->where('products.is_package', 1)
            ->where(function ($query) use ($package) {
                $query->where('products.category_id', $package->category_id)
                    ->orWhere('products.brand_id', $package->brand_id);
            })
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view($this->baseUrl . 'package_details.details', compact('package', 'packageItems', 'totalPackageValue', 'totalPackageDiscountValue', 'packageSavings', 'relatedPackages'));
    }

    public function packages()
    {
        $packages = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name', 'brands.name as brand_name')
            ->where('products.status', 1)
            ->where('products.is_package', 1)
            ->orderBy('products.id', 'desc')
            ->paginate(12);

        return view($this->baseUrl . 'packages.index', compact('packages'));
    }

    public function checkPackageStock(Request $request)
    {
        try {
            $packageId = $request->package_id;
            $quantity = $request->quantity ?? 1;

            // Get package items
            $packageItems = DB::table('package_product_items')
                ->join('products', 'package_product_items.product_id', '=', 'products.id')
                ->leftJoin('colors', 'package_product_items.color_id', '=', 'colors.id')
                ->leftJoin('product_sizes', 'package_product_items.size_id', '=', 'product_sizes.id')
                ->select(
                    'package_product_items.*',
                    'products.name as product_name',
                    'products.stock as product_stock',
                    'colors.name as color_name',
                    'product_sizes.name as size_name'
                )
                ->where('package_product_items.package_product_id', $packageId)
                ->get();

            $stockIssues = [];
            $itemDetails = [];
            $variantAnalysis = [];
            $allInStock = true;

            foreach ($packageItems as $index => $item) {
                $requiredQuantity = $item->quantity * $quantity;

                // Create unique identifier for each package item
                $uniqueId = $item->product_id . '_' . ($item->color_id ?? 'no_color') . '_' . ($item->size_id ?? 'no_size') . '_' . $index;

                $itemDetail = [
                    'unique_id' => $uniqueId,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'color_name' => $item->color_name,
                    'size_name' => $item->size_name,
                    'required_quantity' => $requiredQuantity,
                    'available_quantity' => 0,
                    'in_stock' => false,
                    'status' => 'checking'
                ];

                // First: Check for variant from product_id in package_product_items
                $variantQuery = DB::table('product_variants')
                    ->where('product_id', $item->product_id);

                // Apply filters if specified in package item
                if ($item->color_id) {
                    $variantQuery->where('color_id', $item->color_id);
                }
                if ($item->size_id) {
                    $variantQuery->where('size_id', $item->size_id);
                }

                $variant = $variantQuery->first();

                if ($variant) {
                    // Variant found - check variant stock
                    $availableStock = $variant->stock;
                    $maxPackageQty = floor($availableStock / $item->quantity); // How many packages can be made

                    if ($variant->stock >= $requiredQuantity) {
                        $itemDetail['status'] = 'available';
                        $itemDetail['available_quantity'] = $variant->stock;
                        $itemDetail['in_stock'] = true;
                    } else {
                        $variantDescription = '';
                        if ($item->color_name) $variantDescription .= " ({$item->color_name}";
                        if ($item->size_name) $variantDescription .= ($variantDescription ? ", {$item->size_name}" : " ({$item->size_name}");
                        if ($variantDescription) $variantDescription .= ')';

                        $stockIssues[] = "{$item->product_name}{$variantDescription} - Only {$variant->stock} available, need {$requiredQuantity}";
                        $itemDetail['status'] = $variant->stock > 0 ? 'insufficient' : 'out_of_stock';
                        $itemDetail['available_quantity'] = $variant->stock;
                        $allInStock = false;
                    }

                    // Add to variant analysis for unified system
                    $variantAnalysis[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'variant_description' => $variantDescription ?? '',
                        'required_qty' => $requiredQuantity,
                        'available_qty' => $availableStock,
                        'per_package_qty' => $item->quantity,
                        'max_package_qty' => $maxPackageQty,
                        'is_limiting' => $maxPackageQty <= $quantity,
                        'variant_type' => 'product_variant'
                    ];
                } else {
                    // No variant found - check product table
                    $availableStock = $item->product_stock;
                    $maxPackageQty = floor($availableStock / $item->quantity);

                    if ($item->product_stock >= $requiredQuantity) {
                        $itemDetail['status'] = 'available';
                        $itemDetail['available_quantity'] = $item->product_stock;
                        $itemDetail['in_stock'] = true;
                    } else {
                        $stockIssues[] = "{$item->product_name} - Only {$item->product_stock} available, need {$requiredQuantity}";
                        $itemDetail['status'] = $item->product_stock > 0 ? 'insufficient' : 'out_of_stock';
                        $itemDetail['available_quantity'] = $item->product_stock;
                        $allInStock = false;
                    }

                    // Add to variant analysis
                    $variantAnalysis[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'variant_description' => '',
                        'required_qty' => $requiredQuantity,
                        'available_qty' => $availableStock,
                        'per_package_qty' => $item->quantity,
                        'max_package_qty' => $maxPackageQty,
                        'is_limiting' => $maxPackageQty <= $quantity,
                        'variant_type' => 'main_product'
                    ];
                }

                $itemDetails[] = $itemDetail;
            }

            return response()->json([
                'success' => true,
                'in_stock' => $allInStock,
                'stock_issues' => $stockIssues,
                'item_details' => $itemDetails,
                'variant_analysis' => $variantAnalysis,
                'message' => $allInStock ? 'All items in stock' : 'Some items have insufficient stock'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'in_stock' => false,
                'stock_issues' => ['Error checking stock: ' . $e->getMessage()],
                'item_details' => [],
                'message' => 'Error checking package stock'
            ], 500);
        }
    }

    public function checkProductStock(Request $request)
    {
        try {
            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;
            $colorId = $request->color_id;
            $sizeId = $request->size_id;

            // Get product info
            $product = DB::table('products')
                ->select('id', 'name', 'stock', 'has_variant')
                ->where('id', $productId)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'in_stock' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $stockIssues = [];
            $inStock = false;
            $availableQuantity = 0;

            // Check if product has variants
            if ($product->has_variant) {
                // Check variant stock
                $variantQuery = DB::table('product_variants')
                    ->where('product_id', $productId);

                if ($colorId) {
                    $variantQuery->where('color_id', $colorId);
                }
                if ($sizeId) {
                    $variantQuery->where('size_id', $sizeId);
                }

                $variant = $variantQuery->first();

                if ($variant) {
                    $availableQuantity = $variant->stock;
                    if ($variant->stock >= $quantity) {
                        $inStock = true;
                    } else {
                        $stockIssues[] = "Only {$variant->stock} available, need {$quantity}";
                    }
                } else {
                    $stockIssues[] = "Selected variant not available";
                }
            } else {
                // Check product stock
                $availableQuantity = $product->stock;
                if ($product->stock >= $quantity) {
                    $inStock = true;
                } else {
                    $stockIssues[] = "Only {$product->stock} available, need {$quantity}";
                }
            }

            return response()->json([
                'success' => true,
                'in_stock' => $inStock,
                'available_quantity' => $availableQuantity,
                'required_quantity' => $quantity,
                'stock_issues' => $stockIssues,
                'message' => $inStock ? 'Product is in stock' : implode(', ', $stockIssues)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'in_stock' => false,
                'message' => 'Error checking stock: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCartStatus(Request $request)
    {
        try {
            $cartKey = $request->input('cart_key');
            $cart = session()->get('cart', []);

            if (isset($cart[$cartKey])) {
                return response()->json([
                    'in_cart' => true,
                    'quantity' => $cart[$cartKey]['quantity']
                ]);
            }

            return response()->json([
                'in_cart' => false,
                'quantity' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'in_cart' => false,
                'quantity' => 1,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
