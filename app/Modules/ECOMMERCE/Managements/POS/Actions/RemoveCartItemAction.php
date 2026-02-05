<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;

class RemoveCartItemAction
{
    public function execute(Request $request): array
    {
        $cartIndex = $request->cart_index ?? $request->route('cartIndex');
        $cart = session()->get('cart');

        if (isset($cart[$cartIndex])) {
            unset($cart[$cartIndex]);
            session()->put('cart', $cart);
        }

        // Clear all POS session values
        session(['pos_discount' => 0]);
        session(['discount' => 0]);
        session(['shipping_charge' => 0]);

        return $cart;
    }
}
