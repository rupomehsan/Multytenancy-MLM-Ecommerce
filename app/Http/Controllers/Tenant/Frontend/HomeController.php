<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Brian2694\Toastr\Facades\Toastr;

use Carbon\Carbon;
use Illuminate\Support\Str;



use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $baseRoute = 'tenant.frontend.pages.';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::guard('customer')->user()->user_type;
        $userId = Auth::guard('customer')->user()->id;

        $totalOrderPlaced = DB::table('orders')->where('user_id', $userId)->count();
        $totalRunningOrder = DB::table('orders')->where('user_id', $userId)->where('order_status', '<', 3)->count();
        $itemsInWishList = DB::table('wish_lists')->where('user_id', $userId)->count();
        $totalAmountSpent = DB::table('orders')->where('user_id', $userId)->where('order_status', '!=', 4)->sum('total');
        $totalOpenedTickets = DB::table('support_tickets')->where('support_taken_by', $userId)->where('status', '<', 2)->count();

        $recentOrders = DB::table('orders')->where('user_id', $userId)->orderBy('id', 'desc')->skip(0)->limit(5)->get();
        $wishlistedItems = DB::table('wish_lists')
            ->join('products', 'wish_lists.product_id', 'products.id')
            ->leftJoin('units', 'products.unit_id', 'units.id')
            ->where('wish_lists.user_id', $userId)
            ->select('products.name', 'products.image', 'products.price', 'products.discount_price', 'units.name as unit_name', 'products.slug as product_slug')
            ->orderBy('products.id', 'desc')
            ->skip(0)
            ->limit(6)
            ->get();

        if ($user == 4) {
            $orders = DB::table('order_delivey_men')
                ->join('orders', 'order_delivey_men.order_id', '=', 'orders.id')
                ->where('order_delivey_men.delivery_man_id', $userId)
                ->select('order_delivey_men.order_id', 'order_delivey_men.delivery_man_id', 'order_delivey_men.status', 'order_delivey_men.id', 'orders.*')
                ->orderBy('order_delivey_men.id', 'desc')
                ->skip(0)->limit(5)->get();

            $totalPendingOrders = DB::table('order_delivey_men')->where('delivery_man_id', auth()->user()->id)->where('status', 'pending')->count();
            $totalProcessingOrders = DB::table('order_delivey_men')->where('delivery_man_id', auth()->user()->id)->where('status', 'accepted')->count();
            $totalRejectedOrders = DB::table('order_delivey_men')->where('delivery_man_id', auth()->user()->id)->where('status', 'rejected')->count();
            $totalDeliveredOrders = DB::table('order_delivey_men')->where('delivery_man_id', auth()->user()->id)->where('status', 'delivered')->count();
            $totalReturnedOrders = DB::table('order_delivey_men')->where('delivery_man_id', auth()->user()->id)->where('status', 'returned')->count();



            return view(
                'customer_panel.pages.delivery.home',
                compact(
                    'totalOrderPlaced',
                    'totalRunningOrder',
                    'itemsInWishList',
                    'totalAmountSpent',
                    'recentOrders',
                    'wishlistedItems',
                    'totalOpenedTickets',

                    'orders',
                    'totalPendingOrders',
                    'totalProcessingOrders',
                    'totalRejectedOrders',
                    'totalDeliveredOrders',
                    'totalReturnedOrders'
                )
            );
        } else {
            return view($this->baseRoute . 'customer_panel.pages.home', compact('totalOrderPlaced', 'totalRunningOrder', 'itemsInWishList', 'totalAmountSpent', 'recentOrders', 'wishlistedItems', 'totalOpenedTickets'));
        }
    }



    public function submitProductReview(Request $request)
    {

        $purchaseStatus = DB::table('order_details')
            ->join('orders', 'order_details.order_id', 'orders.id')
            ->where('orders.order_status', 5)
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->where('product_id', $request->review_product_id)
            ->first();

        if (!$purchaseStatus) {
            // Toastr::error('Approved order is required for submitting a review.');
            Toastr::error('Please order first for submitting a review.');
            return back();
        }

        $alreadyReviewSubmitted = DB::table('product_reviews')
            ->where('user_id', Auth::guard('customer')->user()->id)
            ->where('product_id', $request->review_product_id)
            ->count();

        if ($alreadyReviewSubmitted >= 1) {
            Toastr::warning('You have Already submitted a review');
            return back();
        }

        DB::table('product_reviews')->insert([
            'product_id' => $request->review_product_id,
            'user_id' => Auth::guard('customer')->user()->id,
            'rating' => $request->rarting,
            'review' => $request->review,
            'slug' => str::random(5) . time(),
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Successfully Submitted Review');
        return back();
    }

    public function submitProductQuestion(Request $request)
    {

        // $purchaseStatus = DB::table('order_details')
        //                     ->join('orders', 'order_details.order_id', 'orders.id')
        //                     ->where('orders.order_status', 5)
        //                     ->where('orders.user_id', Auth::guard('customer')->user()->id)
        //                     ->where('product_id', $request->question_product_id)
        //                     ->first();

        // if(!$purchaseStatus){
        //     Toastr::error('Approved order is required for submitting a question.');
        //     return back();
        // }

        $authenticatedUser = Auth::guard('customer')->user();
        if ($authenticatedUser->user_type !== 3) {
            Toastr::error('You are not allowed to ask a question');
            return back();
        }

        if (!$authenticatedUser) {
            Toastr::error('Login is required to ask a question');
            return back();
        }

        DB::table('product_question_answers')->insert([
            'product_id' => $request->question_product_id,
            'full_name' => $authenticatedUser->name,
            'email' => $authenticatedUser->email,
            'question' => $request->question,
            'slug' => str::random(5) . time(),
            'status' => 0,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Successfully Submitted Question');
        return back();
    }

    public function addToWishlist($slug)
    {
        $productInfo = DB::table('products')->where('slug', $slug)->first();

        if (!$productInfo) {
            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->count();
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'wishlist_count' => $wishlistCount
                ], 404);
            }
            Toastr::error('Product not found');
            return back();
        }

        if (DB::table('wish_lists')->where('product_id', $productInfo->id)->where('user_id', Auth::guard('customer')->user()->id)->exists()) {
            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->count();
                return response()->json([
                    'success' => false,
                    'message' => 'Already in Wishlist',
                    'wishlist_count' => $wishlistCount
                ], 400);
            }
            Toastr::warning('Already in Wishlist');
            return back();
        } else {
            DB::table('wish_lists')->insert([
                'product_id' => $productInfo->id,
                'user_id' => Auth::guard('customer')->user()->id,
                'slug' => str::random(5) . time(),
                'created_at' => Carbon::now()
            ]);

            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->count();
                return response()->json([
                    'success' => true,
                    'message' => 'Added to Wishlist',
                    'wishlist_count' => $wishlistCount
                ]);
            }
            Toastr::success('Added to Wishlist');
            return back();
        }
    }

    public function removeFromWishlist($slug)
    {
        $productInfo = DB::table('products')->where('slug', $slug)->first();

        if (!$productInfo) {
            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->count();
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'wishlist_count' => $wishlistCount
                ], 404);
            }
            Toastr::error('Product not found');
            return back();
        }

        $deleted = DB::table('wish_lists')->where('product_id', $productInfo->id)
            ->where('user_id', Auth::guard('customer')->user()->id)->delete();

        if (request()->ajax()) {
            $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->count();
            return response()->json([
                'success' => true,
                'message' => 'Removed from Wishlist',
                'wishlist_count' => $wishlistCount
            ]);
        }
        Toastr::error('Removed From Wishlist');
        return back();
    }
}
