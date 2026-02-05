<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\POS\Actions\LoadPosDataAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\SearchProductsAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetProductVariantsAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\CheckProductVariantAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\AddToCartAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetSavedAddressAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\RemoveCartItemAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\UpdateCartItemAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\UpdateCartItemDiscountAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\ApplyCouponAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\RemoveCouponAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\SaveNewCustomerAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\UpdateOrderTotalAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetDistrictThanasAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetDistrictThanasByNameAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\ChangeDeliveryMethodAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\SaveCustomerAddressAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\PlaceOrderAction;

class PosController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/POS');
    }

    public function createNewOrder(LoadPosDataAction $action, Request $request)
    {
        $data = $action->execute($request);

        return view('pos.create', $data);
    }

    public function productLiveSearch(SearchProductsAction $action, Request $request)
    {
        $products = $action->execute($request);

        $searchResults = view('pos.components.live_search_products', compact('products'))->render();

        return response()->json(['searchResults' => $searchResults]);
    }

    public function getProductVariantsPos(GetProductVariantsAction $action, Request $request)
    {
        $result = $action->execute($request);

        return response()->json($result);
    }

    public function checkProductVariant(CheckProductVariantAction $action, Request $request)
    {
        $result = $action->execute($request);

        return response()->json($result);
    }

    public function addToCart(AddToCartAction $action, Request $request)
    {
        $action->execute($request);

        $returnHTML = view('pos.components.cart_items')->render();
        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'rendered_cart' => $returnHTML,
            'cart_calculation' => $cartCalculationHTML,
        ]);
    }

    public function getSavedAddress(GetSavedAddressAction $action, Request $request, $user_id)
    {
        $request->merge(['user_id' => $user_id]);
        $result = $action->execute($request);

        $savedAddressHTML = view('pos.components.saved_address', ['savedAddressed' => $result['saved_addressed']])->render();

        return response()->json([
            'saved_address' => $savedAddressHTML,
            'user_info' => $result['user_info']
        ]);
    }

    public function removeCartItem(RemoveCartItemAction $action, Request $request, $cartIndex)
    {
        $request->merge(['cart_index' => $cartIndex]);
        $action->execute($request);

        $returnHTML = view('pos.components.cart_items')->render();
        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'rendered_cart' => $returnHTML,
            'cart_calculation' => $cartCalculationHTML,
        ]);
    }

    public function updateCartItem(UpdateCartItemAction $action, Request $request, $cartIndex, $qty)
    {
        $request->merge(['cart_index' => $cartIndex, 'qty' => $qty]);
        $action->execute($request);

        $returnHTML = view('pos.components.cart_items')->render();
        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'rendered_cart' => $returnHTML,
            'cart_calculation' => $cartCalculationHTML,
        ]);
    }

    public function updateCartItemDiscount(UpdateCartItemDiscountAction $action, Request $request, $cartIndex, $discount)
    {
        $request->merge(['cart_index' => $cartIndex, 'discount' => $discount]);
        $action->execute($request);

        $returnHTML = view('pos.components.cart_items')->render();
        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'rendered_cart' => $returnHTML,
            'cart_calculation' => $cartCalculationHTML,
        ]);
    }

    public function applyCoupon(ApplyCouponAction $action, Request $request)
    {
        $result = $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();
        $result['cart_calculation'] = $cartCalculationHTML;

        return response()->json($result);
    }

    public function removeCoupon(RemoveCouponAction $action, Request $request)
    {
        $result = $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();
        $result['cart_calculation'] = $cartCalculationHTML;

        return response()->json($result);
    }

    public function saveNewCustomer(SaveNewCustomerAction $action, Request $request)
    {
        $result = $action->execute($request);

        Toastr::success($result['message'], 'Success');

        return back();
    }

    public function updateOrderTotal(UpdateOrderTotalAction $action, Request $request, $shipping_charge, $discount)
    {
        $request->merge(['shipping_charge' => $shipping_charge, 'discount' => $discount]);
        $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'cart_calculation' => $cartCalculationHTML
        ]);
    }

    public function districtWiseThana(GetDistrictThanasAction $action, Request $request)
    {
        $result = $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();
        $result['cart_calculation'] = $cartCalculationHTML;

        return response()->json($result);
    }

    public function districtWiseThanaByName(GetDistrictThanasByNameAction $action, Request $request)
    {
        $result = $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();
        $result['cart_calculation'] = $cartCalculationHTML;

        return response()->json($result);
    }

    public function changeDeliveryMethod(ChangeDeliveryMethodAction $action, Request $request)
    {
        $action->execute($request);

        $cartCalculationHTML = view('pos.components.cart_calculation')->render();

        return response()->json([
            'cart_calculation' => $cartCalculationHTML
        ]);
    }

    public function saveCustomerAddress(SaveCustomerAddressAction $action, Request $request)
    {
        $result = $action->execute($request);

        Toastr::success($result['message'], 'Success');

        return back();
    }

    /**
     * Place a new POS order
     * Thin controller: validates basic requirements and delegates to action
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(Request $request)
    {
        // Call static action to process order
        $result = PlaceOrderAction::execute($request);

        // Handle failure
        if (!$result['success']) {
            // If there are validation errors, show the first message and flash them into session
            if (isset($result['errors'])) {
                $errors = $result['errors'];

                if ($errors instanceof \Illuminate\Support\MessageBag) {
                    $first = $errors->first();
                    Toastr::error($first ?: $result['message'], 'Validation Error');
                    return back()->withErrors($errors)->withInput();
                }

                // If errors is an array or other structure, normalize to MessageBag
                try {
                    $messageBag = new \Illuminate\Support\MessageBag($errors);
                    $first = $messageBag->first();
                    Toastr::error($first ?: $result['message'], 'Validation Error');
                    return back()->withErrors($messageBag)->withInput();
                } catch (\Throwable $e) {
                    Toastr::error($result['message'], 'Error');
                    return back()->withInput();
                }
            }

            Toastr::error($result['message'], 'Error');
            return back()->withInput();
        }

        // Handle success
        Toastr::success($result['message'], 'Success');

        // Redirect back to POS page with order ID in session
        // JS will open invoice in new tab after Toastr is visible
        return back()->with('pos_order_success', $result['order_id']);
    }
}
