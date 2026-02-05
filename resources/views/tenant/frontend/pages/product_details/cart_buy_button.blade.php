<style>
    .quantity__value_details {
        display: inline-block;
        border: 1px solid var(--border-color2);
        margin: 0;
        width: 3.3rem;
        height: 3rem;
        text-align: center;
        padding: 0;
        background: var(--gray-color2);
        cursor: pointer;
        font-size: 2rem;
        font-weight: 500;
    }

    .quantity__value_details.decrease {
        margin-right: -4px;
        border-radius: 13px 0 0 13px;
    }

    .quantity__value_details.increase {
        margin-left: -4px;
        border-radius: 0 13px 13px 0;
    }
</style>

<div class="product__variant--list quantity d-flex align-items-center mb-20">
    <div class="quantity__box minicart__quantity">
        <button type="button" class="quantity__value_details decrease" data-id="{{ $product->id }}"
            aria-label="quantity value" value="Decrease Value">-</button>
        <label>
            {{-- ** dont change the id of the input field below ** --}}
            <input type="number" id="product_details_cart_qty" class="quantity__number"
                value="{{ isset(session()->get('cart')[$product->id]) ? session()->get('cart')[$product->id]['quantity'] : 1 }}"
                min="1" 
                max="{{ (isset($variants) && $variants && count($variants) > 0) ? ($totalStockAllVariants ?? 0) : $product->stock }}"
                data-counter />
        </label>
        <button type="button" class="quantity__value_details increase" data-id="{{ $product->id }}"
            value="Increase Value">+</button>
    </div>

    @php
        // Check if current variant is in cart
        $cart = session()->get('cart', []);
        $currentVariantInCart = false;
        $currentVariantCartKey = null;
        $currentVariantQuantity = 1;
        
        // Create cart key format that matches the one used in CartController
        $cartKey = $product->id;
        
        // For products with variants, we'll check via JavaScript since we don't know the selected variant yet
        // For products without variants, check directly
        if (!isset($variants) || count($variants) == 0) {
            if (isset($cart[$cartKey])) {
                $currentVariantInCart = true;
                $currentVariantCartKey = $cartKey;
                $currentVariantQuantity = $cart[$cartKey]['quantity'];
            }
        }
    @endphp

    @if ($currentVariantInCart)
        <button class="quickview__cart--btn primary__btn cart-qty-{{ $product->id }} removeFromCartQty"
            data-id="{{ $product->id }}" 
            data-cart-key="{{ $currentVariantCartKey }}" 
            type="button">{{ __('home.remove_from_cart') }}</button>
    @else
        <button class="quickview__cart--btn primary__btn cart-qty-{{ $product->id }} addToCartWithQty"
            data-id="{{ $product->id }}" type="button">{{ __('home.add_to_cart') }}</button>
    @endif
</div>
<div class="product__variant--list mb-15">
    <button class="variant__buy--now__btn primary__btn buyNowWithQty" type="button" data-id="{{ $product->id }}">
        {{ __('home.buy_it_now') }}
    </button>

</div>
