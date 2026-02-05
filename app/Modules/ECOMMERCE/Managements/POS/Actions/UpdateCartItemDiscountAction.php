<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;

class UpdateCartItemDiscountAction
{
    public function execute(Request $request): array
    {
        $cartIndex = $request->cart_index ?? $request->route('cartIndex');
        $discount = $request->discount ?? $request->route('discount');

        $cart = session()->get('cart');

        if (isset($cart[$cartIndex])) {
            $cart[$cartIndex]['discount_price'] = is_numeric($discount) ? (float)$discount : 0;
            session()->put('cart', $cart);
        }

        return $cart;
    }
}
