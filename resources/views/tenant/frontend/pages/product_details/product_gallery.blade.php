<div class="product__details--media">
    <div class="product__media--preview swiper">
        <div class="swiper-wrapper">

            @if ($variants && count($variants) > 0)
                @foreach ($variants as $variant)
                    @if ($variant->image)
                        <div class="swiper-slide">
                            <div class="product__media--preview__items image-container zoom zoomSingleImage">
                                <img class="product__media--preview__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ url($variant->image) }}"
                                    alt="" />
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
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
                            data-src="{{ url($product->image) }}" alt="" />
                    </div>
                </div>

                @if ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
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
    <div class="product__media--nav swiper">
        <div class="swiper-wrapper">

            @if ($variants && count($variants) > 0)
                @foreach ($variants as $variant)
                    @if ($variant->image)
                        <div class="swiper-slide">
                            <div class="product__media--nav__items">
                                <img class="product__media--nav__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ url($variant->image) }}"
                                    alt="" />
                            </div>
                        </div>
                    @endif
                @endforeach

                @if ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
                        <div class="swiper-slide">
                            <div class="product__media--nav__items">
                                <img class="product__media--nav__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $image->image }}"
                                    alt="product-nav-img" />
                            </div>
                        </div>
                    @endforeach
                @endif
            @else
                <div class="swiper-slide">
                    <div class="product__media--nav__items">
                        <img class="product__media--nav__items--img lazy"
                            src="{{ url('frontend_assets') }}/img/product-load.gif"
                            data-src="{{ url($product->image) }}" alt="product-nav-img" />
                    </div>
                </div>

                @if ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
                        <div class="swiper-slide">
                            <div class="product__media--nav__items">
                                <img class="product__media--nav__items--img lazy"
                                    src="{{ url('frontend_assets') }}/img/product-load.gif"
                                    data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $image->image }}"
                                    alt="product-nav-img" />
                            </div>
                        </div>
                    @endforeach
                @endif

            @endif

        </div>
        <div class="swiper__nav--btn-2 swiper-button-next"></div>
        <div class="swiper__nav--btn-2 swiper-button-prev"></div>
    </div>
</div>
