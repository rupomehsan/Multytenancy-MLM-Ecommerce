@php
    $variants = DB::table('product_variants')->select('discounted_price', 'price')->where('product_id', $product->id)->get();
    if($variants && count($variants) > 0){
        $variantMinDiscountPrice = 0;
        $variantMinPrice = 0;
        $variantMinDiscountPriceArray = array();
        $variantMinPriceArray = array();

        foreach ($variants as $variant) {
            $variantMinDiscountPriceArray[] = $variant->discounted_price;
            $variantMinPriceArray[] = $variant->price;
        }

        $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
        $variantMinPrice = min($variantMinPriceArray);
    }
@endphp


@if($variants && count($variants) > 0)
    <div class="product__items--price">
        @if($variantMinDiscountPrice > 0)
            <span class="current__price">৳{{number_format($variantMinDiscountPrice)}}</span>
            <span class="price__divided"></span>
            <span class="old__price">৳{{number_format($variantMinPrice)}}</span>
        @else
            <span class="current__price">৳{{number_format($variantMinPrice)}}</span>
        @endif
    </div>
@else
    <div class="product__items--price">
        @if($product->discount_price > 0)
            <span class="current__price">৳{{number_format($product->discount_price)}}</span>
            <span class="price__divided"></span>
            <span class="old__price">৳{{number_format($product->price)}}</span>
        @else
            <span class="current__price">৳{{number_format($product->price)}}</span>
        @endif
    </div>
@endif
