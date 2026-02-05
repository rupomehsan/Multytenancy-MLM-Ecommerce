<div class="product__details--media">
    <div class="product__media--preview swiper">
        <div class="swiper-wrapper">

            @if ($product->variants && count($product->variants) > 0)
                @foreach ($product->variants as $variant)
                    @if ($variant->image)
                        <div class="swiper-slide">
                            <div class="product__media--preview__items image-container zoom zoomSingleImage">
                                <img class="product__media--preview__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $variant->image }}"
                                    alt="" />
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($product->productImages && count($product->productImages) > 0)
                    @foreach ($product->productImages as $image)
                        <div class="swiper-slide">
                            <div class="product__media--preview__items image-container zoom zoomSingleImage">
                                <img class="product__media--preview__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $image->image }}"
                                    alt="" />
                            </div>
                        </div>
                    @endforeach
                @endif
            @else
                <div class="swiper-slide">
                    <div class="product__media--preview__items image-container zoom zoomSingleImage">
                        <img class="product__media--preview__items--img lazy"
                            src="{{ url('frontend_assets') }}/img/product-load.gif"
                            data-src="{{  $product->image }}" alt="" />
                    </div>
                </div>

                @if ($product->productImages && count($product->productImages) > 0)
                    @foreach ($product->productImages as $image)
                        <div class="swiper-slide">
                            <div class="product__media--preview__items image-container zoom zoomSingleImage">
                                <img class="product__media--preview__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $image->image }}"
                                    alt="" />
                            </div>
                        </div>
                    @endforeach
                @endif

            @endif

        </div>
    </div>
</div>
