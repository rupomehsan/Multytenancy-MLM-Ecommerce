<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;

class UpdateCartItemAction
{
    public function execute(Request $request): array
    {
        $cartIndex = $request->cart_index ?? $request->route('cartIndex');
        $qty = $request->qty ?? $request->route('qty');

        $cart = session()->get('cart');

        if (isset($cart[$cartIndex])) {
            $cart[$cartIndex]['quantity'] = $qty;
            session()->put('cart', $cart);
        }

        // Remove discount because some coupon code have minimum order value
        session(['pos_discount' => 0]);

        return $cart;
    }
}
