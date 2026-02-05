{{-- Single Product Card --}}
<div class="product__items">
    {{-- Discount Ribbon --}}
    @if ($product->discount_price > 0)
        <div class="product__ribbon-wrap">
            <span class="ribbon-text">
                {{-- ৳{{ number_format($product->price - $product->discount_price, 2) }} --}}
                {{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 2) }}% {{ __('home.off') }}
            </span>
            <span class="ribbon-fold left"></span>
            <span class="ribbon-fold right"></span>
        </div>
    @endif
    <div class="product__items--thumbnail">
        @php
            $is_package = $product->is_package ?? false;
        @endphp

        {{-- If product is a package, link to package details --}}
        @if ($is_package)
            <a class="product__items--link" href="{{ url('package/details') }}/{{ $product->slug }}">
                <img src="{{ asset($product->image) }}"
                    onerror="this.onerror=null;this.src='{{ url('frontend_assets') }}/img/product-load.gif';"
                    data-src="{{ asset($product->image) }}"
                    class="lazy product__items--img product__primary--img" alt="" />
            </a>
        @else
            {{-- If product is not a package, link to product details --}}
            <a class="product__items--link" href="{{ url('product/details') }}/{{ $product->slug }}">
                <img src="{{ asset($product->image) }}"
                    onerror="this.onerror=null;this.src='{{ url('frontend_assets') }}/img/product-load.gif';"
                    data-src="{{ asset($product->image) }}"
                    class="lazy product__items--img product__primary--img" alt="" />
            </a>
        @endif


        @if ($product->flag_name)
            <div class="product__badge">
                <span class="product__badge--items sale">{{ $product->flag_name }}</span>
            </div>
        @endif
        {{-- @if ($product->discount_price > 0)
            <div class="product__discount" data-label="৳{{ number_format($product->price - $product->discount_price, 2) }}">
            </div>
        @endif --}}

    </div>
    <div class="product__items--content">
        <span class="product__items--content__subtitle">{{ $product->category_name }}@if ($product->subcategory_name)
                ,
                {{ $product->subcategory_name }}
            @endif
        </span>
        <h3 class="product__items--content__title h4">
            @if ($is_package)
                <a href="{{ url('package/details') }}/{{ $product->slug }}">{{ $product->name }}</a>
            @else
                <a href="{{ url('product/details') }}/{{ $product->slug }}">{{ $product->name }}</a>
            @endif

        </h3>

        @php
            $totalStockAllVariants = 0; // jekonon variant er at least ekta stock e thakleo stock in dekhabe
            $variants = DB::table('product_variants')
                ->select('discounted_price', 'price', 'stock')
                ->where('product_id', $product->id)
                ->get();
            if ($variants && count($variants) > 0) {
                $variantMinDiscountPrice = 0;
                $variantMinPrice = 0;
                $variantMinDiscountPriceArray = [];
                $variantMinPriceArray = [];

                foreach ($variants as $variant) {
                    $variantMinDiscountPriceArray[] = $variant->discounted_price;
                    $variantMinPriceArray[] = $variant->price;
                    $totalStockAllVariants = $totalStockAllVariants + (int) $variant->stock;
                }

                $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
                $variantMinPrice = min($variantMinPriceArray);
            }
        @endphp

        {{-- price section --}}
        @if ($variants && count($variants) > 0)
            <div class="product__items--price">
                @if ($variantMinDiscountPrice > 0)
                    <span class="current__price">৳{{ number_format($variantMinDiscountPrice) }}</span>
                    <span class="price__divided"></span>
                    <span class="old__price">৳{{ number_format($variantMinPrice) }}</span>
                @else
                    <span class="current__price">৳{{ number_format($variantMinPrice) }}</span>
                @endif
            </div>
        @else
            <div class="product__items--price">
                @if ($product->discount_price > 0)
                    <span class="current__price">৳{{ number_format($product->discount_price) }}</span>
                    <span class="price__divided"></span>
                    <span class="old__price">৳{{ number_format($product->price) }}</span>
                @else
                    <span class="current__price">৳{{ number_format($product->price) }}</span>
                @endif
            </div>
        @endif

        @include('tenant.frontend.pages.homepage_sections.single_product_rating')

        {{-- add to cart --}}
        <ul class="product__items--action d-flex justify-content-center">
            @if ($variants && count($variants) > 0)
                @if ($totalStockAllVariants > 0)
                    @include('tenant.frontend.pages.homepage_sections.single_product_add_to_cart')
                @else
                    @include('tenant.frontend.pages.homepage_sections.single_product_stock_out')
                @endif
            @else
                @if ($product->stock && $product->stock > 0)
                    @include('tenant.frontend.pages.homepage_sections.single_product_add_to_cart')
                @else
                    @include('tenant.frontend.pages.homepage_sections.single_product_stock_out')
                @endif
            @endif
        </ul>

    </div>
</div>
