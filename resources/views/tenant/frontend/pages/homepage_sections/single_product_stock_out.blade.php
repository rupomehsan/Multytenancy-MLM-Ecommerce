<li class="product__items--action__list col-9">
    <a href="javascript:void(0)" class="product__items--action__btn add__to--cart minicart__open--btn stock_out_btn" data-offcanvas>
        <span class="add__to--cart__text" style="font-weight: 600">{{ __('home.stock_out') }}</span>
    </a>
</li>
@php
    $wishlist = Auth::guard('customer')->check() ? DB::table('wish_lists')->where('product_id', $product->id)->where('user_id', Auth::guard('customer')->id())->first() : null;
    $isWishlisted = $wishlist ? true : false;
@endphp
@if($isWishlisted)
    <li class="product__items--action__list col-2">
        <a class="product__items--action__btn wishlist__btn" href="{{ url('remove/from/wishlist') }}/{{$product->slug}}">
            <i class="fi fi-ss-heart product__items--action__btn--svg" style="color: red;"></i>
            <span class="visually-hidden">{{ __('home.remove_from_wishlist') }}</span>
        </a>
    </li>
@else
    <li class="product__items--action__list col-2">
        <a class="product__items--action__btn wishlist__btn" href="{{ url('add/to/wishlist') }}/{{$product->slug}}">
            <i class="fi fi-rs-heart product__items--action__btn--svg"></i>
            <span class="visually-hidden">{{ __('home.add_to_wishlist') }}</span>
        </a>
    </li>
@endif
