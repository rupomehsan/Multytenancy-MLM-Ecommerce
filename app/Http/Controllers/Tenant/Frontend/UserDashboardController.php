<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use Carbon\Carbon;
use CURLFile;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    protected $base_url = 'tenant.frontend.pages.';
    public function userDashboard(Request $request)
    {

        $order_status = $request->order_status;
        $query = DB::table('orders')->where('user_id', Auth::guard('customer')->user()->id);


        if ($order_status !== null && in_array($order_status, [0, 1, 2, 3, 4, 5, 6])) {
            $query->where('order_status', $order_status)->orderBy('id', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $orders = $query->paginate(10);
        return view($this->base_url . 'customer_panel.pages.my_orders', compact('orders', 'order_status'));
    }

    public function orderDetails($slug)
    {
        // Use Order model with relationships to access model accessor methods
        $order = Order::with(['shippingInfo', 'user', 'orderDeliveryMen'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Add additional user fields for backward compatibility
        $order->username = $order->user->name ?? null;
        $order->user_email = $order->user->email ?? null;
        $order->phone = $order->user->phone ?? null;
        $order->shipping_address = $order->shippingInfo->address ?? null;
        $order->shipping_city = $order->shippingInfo->city ?? null;
        $order->shipping_thana = $order->shippingInfo->thana ?? null;
        $order->shipping_post_code = $order->shippingInfo->post_code ?? null;

        $orderItems = DB::table('order_details')
            ->join('products', 'order_details.product_id', 'products.id')
            ->leftJoin('units', 'products.unit_id', 'units.id')
            ->leftJoin('colors', 'order_details.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'order_details.size_id', 'product_sizes.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_variants.product_id', '=', 'order_details.product_id')
                     ->on('product_variants.color_id', '=', 'order_details.color_id')
                     ->on(function($query) {
                         $query->on('product_variants.size_id', '=', 'order_details.size_id')
                               ->orWhereNull('order_details.size_id');
                     });
            })
            ->select(
                'products.name',
                'products.code as product_code',
                'order_details.unit_price as product_price',
                'order_details.qty',
                'units.name as unit_name',
                'colors.name as color_name',
                'product_sizes.name as size_name',
                'product_variants.image as variant_image',
                'products.image as product_image',
                'products.slug as product_slug'
            )
            ->where('order_id', $order->id)
            ->get();

        $user = Auth::guard('customer')->user()->user_type;
        if ($user == 4) {
            return view($this->base_url . 'customer_panel.pages.delivery.order_details', compact('order', 'orderItems'));
        }
        return view($this->base_url . 'customer_panel.pages.order_details', compact('order', 'orderItems'));
    }

    public function orderVoucher($slug)
    {
        $order = Order::with(['shippingInfo', 'user', 'orderDeliveryMen'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Add additional user fields for backward compatibility
        $order->username = $order->user->name ?? null;
        $order->user_email = $order->user->email ?? null;
        $order->phone = $order->user->phone ?? null;
        $order->shipping_address = $order->shippingInfo->address ?? null;
        $order->shipping_city = $order->shippingInfo->city ?? null;
        $order->shipping_thana = $order->shippingInfo->thana ?? null;
        $order->shipping_post_code = $order->shippingInfo->post_code ?? null;

        $orderItems = DB::table('order_details')
            ->join('products', 'order_details.product_id', 'products.id')
            ->leftJoin('units', 'products.unit_id', 'units.id')
            ->leftJoin('colors', 'order_details.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'order_details.size_id', 'product_sizes.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_variants.product_id', '=', 'order_details.product_id')
                     ->on('product_variants.color_id', '=', 'order_details.color_id')
                     ->on(function($query) {
                         $query->on('product_variants.size_id', '=', 'order_details.size_id')
                               ->orWhereNull('order_details.size_id');
                     });
            })
            ->select(
                'products.name',
                'products.code as product_code',
                'order_details.unit_price as product_price',
                'order_details.qty',
                'units.name as unit_name',
                'colors.name as color_name',
                'product_sizes.name as size_name',
                'product_variants.image as variant_image',
                'products.image as product_image',
                'products.slug as product_slug'
            )
            ->where('order_id', $order->id)
            ->get();

        $generalInfo = DB::table('general_infos')->first();

        return view($this->base_url . 'customer_panel.pages.order_voucher', compact('order', 'orderItems', 'generalInfo'));
    }

    public function trackMyOrder($order_no)
    {
        $order = DB::table('orders')->where('order_no', $order_no)->first();
        $totalItems = DB::table('order_details')->where('order_id', $order->id)->count();

        return view($this->base_url . 'customer_panel.pages.order_tracking', compact('order', 'totalItems'));
    }

    public function myWishlists()
    {
        $wishlistedItems = DB::table('wish_lists')
            ->join('products', 'wish_lists.product_id', 'products.id')
            ->leftJoin('units', 'products.unit_id', 'units.id')
            ->where('wish_lists.user_id', Auth::guard('customer')->user()->id)
            ->select('products.name', 'products.image', 'products.price', 'products.discount_price', 'units.name as unit_name', 'products.slug as product_slug')
            ->orderBy('products.id', 'desc')
            ->get();

        return view($this->base_url . 'customer_panel.pages.my_wishlists', compact('wishlistedItems'));
    }

    public function clearAllWishlist()
    {
        DB::table('wish_lists')->where('user_id', Auth::guard('customer')->user()->id)->delete();
        Toastr::success('Removed All Items from Wishlists');
        return back();
    }

    public function changePassword()
    {
        return view($this->base_url . 'customer_panel.pages.change_password');
    }

    public function updatePassword(Request $request)
    {

        if ($request->old_password && !Auth::guard('customer')->user()->provider_id && !Hash::check($request->old_password, Auth::guard('customer')->user()->password)) {
            Toastr::error('Your old password is wrong');
            return back();
        }

        if ($request->new_password != $request->confirm_password) {
            Toastr::error('Password did not match');
            return back();
        }

        DB::table('users')->where('id', Auth::guard('customer')->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        Toastr::success('Password Changed Successfully');
        return back();
    }

    public function myPayments()
    {
        $userId = Auth::guard('customer')->user()->id;
        $currentMonthSpent = DB::table('orders')->where('user_id', $userId)->where('order_status', '!=', 4)->where('created_at', 'like', date("Y-m") . '%')->sum('total');
        $lastSixMonthSpent = DB::table('orders')->where('user_id', $userId)->where('order_status', '!=', 4)->where('created_at', '>=', date("Y-m-d", strtotime("-6 month")) . " 23:59:59")->sum('total');
        $totalSpent = DB::table('orders')->where('user_id', $userId)->where('order_status', '!=', 4)->sum('total');
        $orders = DB::table('orders')->where('user_id', $userId)->orderBy('id', 'desc')->paginate(10);

        return view($this->base_url . 'customer_panel.pages.my_payments', compact('currentMonthSpent', 'lastSixMonthSpent', 'totalSpent', 'orders'));
    }

    public function promoCoupons()
    {
        $promoCoupons = DB::table('promo_codes')->orderBy('status', 'desc')->get();

        $appliedCoupons = DB::table('orders')
            ->join('promo_codes', 'orders.coupon_code', 'promo_codes.code')
            ->select('promo_codes.*')
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->groupBy('promo_codes.code')
            ->get();

        return view($this->base_url . 'customer_panel.pages.promo_coupons', compact('promoCoupons', 'appliedCoupons'));
    }

    public function productReviews()
    {
        // Get delivered products that haven't been reviewed yet
        $deliveredProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', 'orders.id')
            ->join('products', 'order_details.product_id', 'products.id')
            ->leftJoin('product_reviews', function($join) {
                $join->on('product_reviews.product_id', '=', 'order_details.product_id')
                     ->on('product_reviews.user_id', '=', 'orders.user_id');
            })
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.image as product_image',
                'orders.order_no',
                'orders.id as order_id',
                DB::raw('MAX(orders.updated_at) as delivered_date'),
                DB::raw('MAX(product_reviews.id) as review_id')
            )
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->where('orders.order_status', 5) // 5 = delivered status
            ->groupBy('products.id', 'products.name', 'products.image', 'orders.order_no', 'orders.id')
            ->havingRaw('MAX(product_reviews.id) IS NULL')
            ->orderBy('delivered_date', 'desc')
            ->paginate(10);

        $productReviews = DB::table('product_reviews')
            ->join('products', 'product_reviews.product_id', 'products.id')
            ->select('products.name', 'products.image', 'product_reviews.rating', 'product_reviews.review', 'product_reviews.id', 'product_reviews.status')
            ->where('product_reviews.user_id', Auth::guard('customer')->user()->id)
            ->orderBy('product_reviews.id', 'desc')
            ->paginate(5);

        return view($this->base_url . 'customer_panel.pages.product_reviews', compact('productReviews', 'deliveredProducts'));
    }

    public function submitReviewFromPanel(Request $request)
    {
        // Validate that user has a delivered order for this product
        $hasOrdered = DB::table('order_details')
            ->join('orders', 'order_details.order_id', 'orders.id')
            ->where('orders.user_id', Auth::guard('customer')->user()->id)
            ->where('orders.order_status', 5)
            ->where('order_details.product_id', $request->product_id)
            ->exists();

        if (!$hasOrdered) {
            Toastr::error('You must have a delivered order to review this product.');
            return back();
        }

        // Check if already reviewed
        $alreadyReviewed = DB::table('product_reviews')
            ->where('user_id', Auth::guard('customer')->user()->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($alreadyReviewed) {
            Toastr::warning('You have already submitted a review for this product.');
            return back();
        }

        // Insert review
        DB::table('product_reviews')->insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::guard('customer')->user()->id,
            'rating' => $request->rating,
            'review' => $request->review_text,
            'slug' => Str::random(5) . time(),
            'status' => 0, // Pending approval
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Review submitted successfully!');
        return back();
    }

    public function deleteProductReview($id)
    {
        DB::table('product_reviews')->where('id', $id)->where('user_id', Auth::guard('customer')->user()->id)->delete();
        Toastr::success('Review is Deleted');
        return back();
    }

    public function updateProductReview(Request $request)
    {
        DB::table('product_reviews')->where('id', $request->product_review_id)->where('user_id', Auth::guard('customer')->user()->id)->update([
            'rating' => $request->review_rating,
            'review' => $request->review_text,
            'status' => 0
        ]);
        Toastr::success('Successfully Updated the Review');
        return back();
    }

    public function manageProfile()
    {
        return view($this->base_url . 'customer_panel.pages.manage_profile');
    }

    public function removeUserImage()
    {
        DB::table('users')->where('id', Auth::guard('customer')->user()->id)->update([
            'image' => null,
        ]);
        Toastr::success('Successfully Removed the Image');
        return back();
    }

    public function unlinkGoogleAccount()
    {
        DB::table('users')->where('id', Auth::guard('customer')->user()->id)->update([
            'provider_name' => null,
            'provider_id' => null,
        ]);
        Toastr::success('Successfully Unlinked Google Account');
        return back();
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = Auth::guard('customer')->user()->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($image && file_exists(public_path($image))) {
                unlink(public_path($image));
            }
            
            $get_attachment = $request->file('image');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('uploads/userProfileImages/');
            
            // Create directory if it doesn't exist
            if (!file_exists($location)) {
                mkdir($location, 0755, true);
            }
            
            $get_attachment->move($location, $attachment_name);
            $image = "uploads/userProfileImages/" . $attachment_name;
        }

        DB::table('users')->where('id', Auth::guard('customer')->user()->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => $image,
            'updated_at' => now(),
        ]);
        
        Toastr::success('Profile updated successfully!');
        return back();
    }

    public function sendOtpProfile(Request $request)
    {
        $randomCode = rand(1000, 9999);
        $userInfo = Auth::guard('customer')->user();

        session(['type' => $request->type, 'emailPhone' => $request->emailPhone]);

        DB::table('users')->where('id', $userInfo->id)->update([
            'verification_code' => $randomCode
        ]);

        if ($request->type == 'email') {

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
                    'mail.mailers.name' => "TechShop",
                ]);

                try {
                    Mail::to(trim($request->emailPhone))->send(new UserVerificationMail($mailData));
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
                    "toUser" => $request->emailPhone,
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
                    "contacts" => $request->emailPhone, //“88017xxxxxxxx,88018xxxxxxxx”
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

        return response()->json(['success' => true, 'message' => 'OTP Sent Successfully']);
    }

    public function verifySentOtp(Request $request)
    {

        $verificationCode = '';
        foreach ($request->code as $code) {
            $verificationCode .= $code;
        }

        $type = session('type');
        $emailPhone = session('emailPhone');

        $userInfo = Auth::guard('customer')->user();
        if ($userInfo->verification_code == $verificationCode) {
            if ($type == 'phone') {

                if (User::where('id', $userInfo->id)->where('phone', $emailPhone)->exists()) {
                    Toastr::error('Phone No Already Exists');
                    return redirect('/manage/profile');
                }

                User::where('id', $userInfo->id)->update([
                    'phone' => $emailPhone
                ]);
            } else {

                if (User::where('id', $userInfo->id)->where('email', $emailPhone)->exists()) {
                    Toastr::error('Phone No Already Exists');
                    return redirect('/manage/profile');
                }

                User::where('id', $userInfo->id)->update([
                    'email' => $emailPhone
                ]);
            }

            session()->forget('type');
            session()->forget('emailPhone');

            Toastr::success('Profile Updated Successfully', 'Successfully Verified');
            return redirect('/manage/profile');
        } else {
            Toastr::error('Wrong Verification Code', 'Failed');
            return redirect('/manage/profile');
        }
    }

    public function userAddress()
    {
        $addresses = DB::table('user_addresses')->where('user_id', Auth::guard('customer')->user()->id)->get();
        return view($this->base_url . 'customer_panel.pages.user_address', compact('addresses'));
    }

    public function saveUserAddress(Request $request)
    {

        // $addressInfo = DB::table('user_addresses')->where('user_id', Auth::guard('customer')->user()->id)->where('address_type', $request->address_type)->first();
        // if ($addressInfo) {
        //     Toastr::error($request->address_type . ' Address already Exists', 'Delete the Previous One');
        //     return back();
        // }

        $districtInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();
        $upazilaInfo = DB::table('upazilas')->where('id', $request->shipping_thana_id)->first();
        $userId = Auth::guard('customer')->user()->id;
        $setAsDefault = $request->has('set_as_default') ? 1 : 0;

        // If setting as default, remove default from all other addresses
        if ($setAsDefault == 1) {
            DB::table('user_addresses')
                ->where('user_id', $userId)
                ->update(['is_default' => 0]);
        }

        DB::table('user_addresses')->insert([
            'user_id' => $userId,
            'address_type' => $request->address_type,
            'name' => Auth::guard('customer')->user()->name,
            'address' => $request->adress_line,
            'country' => 'Bangladesh',
            'city' => $districtInfo ? $districtInfo->name : '',
            'state' => $upazilaInfo ? $upazilaInfo->name : '',
            'post_code' => $request->postal_code,
            'phone' => Auth::guard('customer')->user()->phone,
            'slug' => str::random(5) . time(),
            'is_default' => $setAsDefault,
            'created_at' => Carbon::now(),
        ]);

        Toastr::success('New Address Added', 'Saved Successfully');
        return back();
    }

    public function removeUserAddress($slug)
    {
        DB::table('user_addresses')->where('slug', $slug)->delete();
        Toastr::success('Previous Address has Removed', 'Removed Successfully');
        return back();
    }

    public function updateUserAddress(Request $request)
    {

        $districtInfo = DB::table('districts')->where('id', $request->edit_district_id)->first();
        $upazilaInfo = DB::table('upazilas')->where('id', $request->edit_shipping_thana_id)->first();

        DB::table('user_addresses')->where('slug', $request->address_slug)->update([
            'name' => Auth::guard('customer')->user()->name,
            'address' => $request->edit_address_line,
            'city' => $districtInfo ? $districtInfo->name : '',
            'state' => $upazilaInfo ? $upazilaInfo->name : '',
            'post_code' => $request->edit_postal_Code,
            'phone' => Auth::guard('customer')->user()->phone,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }

    public function toggleDefaultAddress(Request $request)
    {
        $addressSlug = $request->address_slug;
        $isDefault = $request->is_default;
        $userId = Auth::guard('customer')->user()->id;

        // First, check if the address belongs to the current user
        $address = DB::table('user_addresses')
            ->where('slug', $addressSlug)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.'
            ], 404);
        }

        if ($isDefault == 1) {
            // If setting as default, first remove default from all other addresses
            DB::table('user_addresses')
                ->where('user_id', $userId)
                ->update(['is_default' => 0]);

            // Then set this address as default
            DB::table('user_addresses')
                ->where('slug', $addressSlug)
                ->where('user_id', $userId)
                ->update([
                    'is_default' => 1,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Address set as default successfully.'
            ]);
        } else {
            // If removing default, just update this address
            DB::table('user_addresses')
                ->where('slug', $addressSlug)
                ->where('user_id', $userId)
                ->update([
                    'is_default' => 0,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Default address removed successfully.'
            ]);
        }
    }
}
