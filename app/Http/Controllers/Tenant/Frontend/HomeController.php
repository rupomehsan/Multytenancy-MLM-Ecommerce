<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use App\Mail\UserVerificationMail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

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
        $user = Auth::user()->user_type;
        $userId = Auth::user()->id;

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


    public function userVerification()
    {
        $randomCode = rand(100000, 999999);
        $userInfo = Auth::user();

        if (!$userInfo->email_verified_at && !$userInfo->verification_code) {

            User::where('id', $userInfo->id)->update([
                'verification_code' => $randomCode
            ]);

            if ($userInfo->email) {

                $mailData = array();
                $mailData['code'] = $randomCode;

                $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
                $decryption = "";

                if ($emailConfig) {
                    $ciphering = "AES-128-CTR";
                    $options = 0;
                    $decryption_iv = '1234567891011121';
                    $decryption_key = "GenericCommerceV1";
                    $decryption = openssl_decrypt($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

                    config([
                        'mail.mailers.smtp.host' => $emailConfig->host,
                        'mail.mailers.smtp.port' => $emailConfig->port,
                        'mail.mailers.smtp.username' => $emailConfig->email,
                        'mail.mailers.smtp.password' => $decryption != "" ? $decryption : '',
                        'mail.mailers.smtp.encryption' => $emailConfig ? ($emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : '')) : '',

                        'mail.mailers.from' => $emailConfig->email,
                        'mail.mailers.name' => env("APP_NAME"),
                    ]);

                    try {
                        Mail::to(trim($userInfo->email))->send(new UserVerificationMail($mailData));
                    } catch (\Exception $e) {
                        // write code for handling error from here
                    }
                }
            } else {

                $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
                if ($smsGateway && $smsGateway->provider_name == 'Reve') {

                    $response = Http::get($smsGateway->api_endpoint, [
                        'apikey' => $smsGateway->api_key,
                        'secretkey' => $smsGateway->secret_key,
                        "callerID" => $smsGateway->sender_id,
                        "toUser" => $userInfo->phone,
                        "messageContent" => "Verification Code is : " . $randomCode
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } elseif ($smsGateway && $smsGateway->provider_name == 'ElitBuzz') {

                    $response = Http::get($smsGateway->api_endpoint, [
                        'api_key' => $smsGateway->api_key,
                        "type" => "text",
                        "contacts" => $userInfo->phone, //“88017xxxxxxxx,88018xxxxxxxx”
                        "senderid" => $smsGateway->sender_id,
                        "msg" => $randomCode . " is your OTP verification code for shadikorun.com"
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } else {
                    Toastr::error('No SMS Gateway is Active Now', 'Failed to send SMS');
                    return back();
                }
            }

            return view('customer_panel.pages.verification');
        } elseif (!$userInfo->email_verified_at && $userInfo->verification_code) {
            return view('customer_panel.pages.verification');
        } else {
            return redirect('/cutomer/home');
        }
    }

    public function userVerificationResend()
    {
        $randomCode = rand(100000, 999999);
        $userInfo = Auth::user();

        if (!$userInfo->email_verified_at) {

            User::where('id', $userInfo->id)->update([
                'verification_code' => $randomCode
            ]);

            if ($userInfo->email) {

                $mailData = array();
                $mailData['code'] = $randomCode;

                $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
                $decryption = "";

                if ($emailConfig) {
                    $ciphering = "AES-128-CTR";
                    $options = 0;
                    $decryption_iv = '1234567891011121';
                    $decryption_key = "GenericCommerceV1";
                    $decryption = openssl_decrypt($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

                    config([
                        'mail.mailers.smtp.host' => $emailConfig->host,
                        'mail.mailers.smtp.port' => $emailConfig->port,
                        'mail.mailers.smtp.username' => $emailConfig->email,
                        'mail.mailers.smtp.password' => $decryption != "" ? $decryption : '',
                        'mail.mailers.smtp.encryption' => $emailConfig ? ($emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : '')) : '',

                        'mail.mailers.from' => $emailConfig->email,
                        'mail.mailers.name' => env("APP_NAME"),
                    ]);


                    // try {
                    Mail::to(trim($userInfo->email))->send(new UserVerificationMail($mailData));
                    // } catch(\Exception $e) {
                    //     // write code for handling error from here
                    // }
                }
            } else {

                $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
                if ($smsGateway && $smsGateway->provider_name == 'Reve') {
                    $response = Http::get($smsGateway->api_endpoint, [
                        'apikey' => $smsGateway->api_key,
                        'secretkey' => $smsGateway->secret_key,
                        "callerID" => $smsGateway->sender_id,
                        "toUser" => $userInfo->phone,
                        "messageContent" => "Verification Code is : " . $randomCode
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } elseif ($smsGateway && $smsGateway->provider_name == 'ElitBuzz') {

                    $response = Http::get($smsGateway->api_endpoint, [
                        'api_key' => $smsGateway->api_key,
                        "type" => "text",
                        "contacts" => $userInfo->phone, //“88017xxxxxxxx,88018xxxxxxxx”
                        "senderid" => $smsGateway->sender_id,
                        "msg" => $randomCode . " is your OTP verification code for shadikorun.com"
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } else {
                    Toastr::error('No SMS Gateway is Active Now', 'Failed to send SMS');
                    return back();
                }
            }

            Toastr::success('Verification Code Sent', 'Resend Verification Code');
            return back();
        } else {
            return redirect('/home');
        }
    }

    public function userVerifyCheck(Request $request)
    {

        $verificationCode = '';
        foreach ($request->code as $code) {
            $verificationCode .= $code;
        }

        $userInfo = Auth::user();
        if ($userInfo->verification_code == $verificationCode) {
            if ($userInfo->email_verified_at) {
                Toastr::info('User already verified', 'Already Verified');
                return redirect('/home');
            }

            User::where('id', $userInfo->id)->update([
                'email_verified_at' => Carbon::now()
            ]);

            Toastr::success('User Verification Complete', 'Successfully Verified');

            if (session('cart') && count(session('cart')) > 0) {
                return redirect('/checkout');
            } else {
                return redirect('/home');
            }
        } else {
            Toastr::error('Wrong Verification Code', 'Failed');
            return back();
        }
    }


    public function submitProductReview(Request $request)
    {

        $purchaseStatus = DB::table('order_details')
            ->join('orders', 'order_details.order_id', 'orders.id')
            ->where('orders.order_status', 5)
            ->where('orders.user_id', Auth::user()->id)
            ->where('product_id', $request->review_product_id)
            ->first();

        if (!$purchaseStatus) {
            // Toastr::error('Approved order is required for submitting a review.');
            Toastr::error('Please order first for submitting a review.');
            return back();
        }

        $alreadyReviewSubmitted = DB::table('product_reviews')
            ->where('user_id', Auth::user()->id)
            ->where('product_id', $request->review_product_id)
            ->count();

        if ($alreadyReviewSubmitted >= 1) {
            Toastr::warning('You have Already submitted a review');
            return back();
        }

        DB::table('product_reviews')->insert([
            'product_id' => $request->review_product_id,
            'user_id' => Auth::user()->id,
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
        //                     ->where('orders.user_id', Auth::user()->id)
        //                     ->where('product_id', $request->question_product_id)
        //                     ->first();

        // if(!$purchaseStatus){
        //     Toastr::error('Approved order is required for submitting a question.');
        //     return back();
        // }

        $authenticatedUser = Auth::user();
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
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::user()->id)->count();
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'wishlist_count' => $wishlistCount
                ], 404);
            }
            Toastr::error('Product not found');
            return back();
        }

        if (DB::table('wish_lists')->where('product_id', $productInfo->id)->where('user_id', Auth::user()->id)->exists()) {
            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::user()->id)->count();
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
                'user_id' => Auth::user()->id,
                'slug' => str::random(5) . time(),
                'created_at' => Carbon::now()
            ]);

            if (request()->ajax()) {
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::user()->id)->count();
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
                $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::user()->id)->count();
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
            ->where('user_id', Auth::user()->id)->delete();

        if (request()->ajax()) {
            $wishlistCount = DB::table('wish_lists')->where('user_id', Auth::user()->id)->count();
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
