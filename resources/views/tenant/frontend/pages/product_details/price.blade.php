@if($variants && count($variants) > 0)
    <div class="product__details--info__price mb-10">
        @if($variantMinDiscountPrice > 0)
            <span class="current__price fw-bolder">৳{{number_format($variantMinDiscountPrice)}}</span>
            <span class="price__divided"></span>
            <span class="old__price" style="margin-left: 0px;">৳{{number_format($variantMinPrice)}}</span>
            <input type="hidden" name="product_price" id="product_discount_price" value="{{$variantMinDiscountPrice}}">
            <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
        @else
            <span class="current__price fw-bolder">৳{{number_format($variantMinPrice)}}</span>
            <input type="hidden" name="product_price" id="product_discount_price" value="0">
            <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
        @endif
    </div>
@else
    <div class="product__details--info__price mb-10">
        @if($product->discount_price > 0)
            <span class="current__price fw-bolder">৳{{number_format($product->discount_price)}}</span>
            <span class="price__divided"></span>
            <span class="old__price" style="margin-left: 0px;">৳{{number_format($product->price)}}</span>
            <input type="hidden" name="product_price" id="product_discount_price" value="{{$product->discount_price}}">
            <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
        @else
            <span class="current__price fw-bolder">৳{{number_format($product->price)}}</span>
            <input type="hidden" name="product_price" id="product_discount_price" value="0">
            <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
        @endif
    </div>
@endif
