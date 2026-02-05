<li class="product__items--action__list col-9">
    @if(isset(session()->get('cart')[$product->id]))
        <a href="javascript:void(0)"
            class="product__items--action__btn add__to--cart minicart__open--btn cart-{{$product->id}} removeFromCart"
            data-id="{{$product->id}}">
            <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
            <span class="add__to--cart__text"> {{ __('home.remove') }}</span>
        </a>
    @else
        <a href="javascript:void(0)"
            class="product__items--action__btn add__to--cart minicart__open--btn cart-{{$product->id}} addToCart"
            data-id="{{$product->id}}">
            <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
            <span class="add__to--cart__text"> {{ __('home.add_to_cart') }}</span>
        </a>
    @endif
</li>
@php
    $wishlist = Auth::guard('customer')->check() ? DB::table('wish_lists')->where('product_id', $product->id)->where('user_id', Auth::guard('customer')->id())->first() : null;
    $isWishlisted = $wishlist ? true : false;
@endphp
@if($isWishlisted)
    <li class="product__items--action__list col-2">
        <a class="product__items--action__btn wishlist__btn ajax-wishlist-btn" 
           href="javascript:void(0)" 
           data-product-slug="{{ $product->slug }}" 
           data-action="remove">
            <i class="fi fi-ss-heart product__items--action__btn--svg" style="color: red;"></i>
            <span class="visually-hidden">{{ __('home.remove_from_wishlist') }}</span>
        </a>
    </li>
@else
    <li class="product__items--action__list col-2">
        <a class="product__items--action__btn wishlist__btn ajax-wishlist-btn" 
           href="javascript:void(0)" 
           data-product-slug="{{ $product->slug }}" 
           data-action="add">
            <i class="fi fi-rs-heart product__items--action__btn--svg"></i>
            <span class="visually-hidden">{{ __('home.add_to_wishlist') }}</span>
        </a>
    </li>
@endif