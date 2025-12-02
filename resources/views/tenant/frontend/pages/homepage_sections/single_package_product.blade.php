{{-- Single Package Product Card --}}
<div class="product__items package-product" data-package-id="{{ $product->id }}">
    {{-- Discount Ribbon --}}
    @if ($product->discount_price > 0)
        <div class="product__ribbon-wrap">
            <span class="ribbon-text">
                {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% Off
            </span>
            <span class="ribbon-fold left"></span>
            <span class="ribbon-fold right"></span>
        </div>
    @endif

    <div class="product__items--thumbnail">
        <a class="product__items--link" href="{{ url('package/details') }}/{{ $product->slug }}">
            <img src="{{ url(env('ADMIN_URL') . '/' . $product->image) }}"
                onerror="this.onerror=null;this.src='{{ url('frontend_assets') }}/img/product-load.gif';"
                data-src="{{ url(env('ADMIN_URL') . '/' . $product->image) }}"
                class="lazy product__items--img product__primary--img" alt="" />
        </a>
    </div>
    
    <div class="product__items--content">
        <span class="product__items--content__subtitle">{{ $product->category_name }}@if ($product->subcategory_name)
                , {{ $product->subcategory_name }}
            @endif
        </span>
        <h3 class="product__items--content__title h4">
            <a href="{{ url('package/details') }}/{{ $product->slug }}">{{ $product->name }}</a>
        </h3>

        {{-- Package Price Section --}}
        <div class="product__items--price">
            @if ($product->discount_price > 0)
                <span class="current__price">৳{{ number_format($product->discount_price, 2) }}</span>
                <span class="price__divided"></span>
                <span class="old__price">৳{{ number_format($product->price, 2) }}</span>
            @else
                <span class="current__price">৳{{ number_format($product->price, 2) }}</span>
            @endif
        </div>

        {{-- Package Stock Status Display --}}
        <div class="package-stock-status mb-2" id="package_stock_{{ $product->id }}">
            <small class="stock-checking text-muted">
                <i class="bi bi-clock"></i> Checking stock...
            </small>
        </div>

        {{-- Package Action Buttons --}}
        <ul class="product__items--action ">
            {{-- add to cart --}}
            <ul class="product__items--action d-flex justify-content-center">
                <li class="product__items--action__list col-9" id="package_action_{{ $product->id }}">
                    {{-- Initially show checking state --}}
                    <a href="javascript:void(0)" class="product__items--action__btn add__to--cart" style="opacity: 0.6; pointer-events: none;">
                        <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
                        <span class="add__to--cart__text">Checking...</span>
                    </a>
                </li>
                @php
                    $wishlist = DB::table('wish_lists')->where('product_id', $product->id)->where('user_id', Auth::id())->first();
                    $isWishlisted = $wishlist ? true : false;
                @endphp
                @if($isWishlisted)
                    <li class="product__items--action__list col-2">
                        <a class="product__items--action__btn wishlist__btn" href="{{ url('remove/from/wishlist') }}/{{$product->slug}}">
                            <i class="fi fi-ss-heart product__items--action__btn--svg" style="color: red;"></i>
                            <span class="visually-hidden">Remove from Wishlist</span>
                        </a>
                    </li>
                @else
                    <li class="product__items--action__list col-2">
                        <a class="product__items--action__btn wishlist__btn" href="{{ url('add/to/wishlist') }}/{{$product->slug}}">
                            <i class="fi fi-rs-heart product__items--action__btn--svg"></i>
                            <span class="visually-hidden">Wishlist</span>
                        </a>
                    </li>
                @endif
            </ul>
        </ul>
    </div>
</div>
