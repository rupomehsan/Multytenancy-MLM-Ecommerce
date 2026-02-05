<!-- Package Badge with Enhanced Styling -->
<div class="package-badge-enhanced mb-20">
    <div class="package-badge-content">
        <i class="bi bi-box-seam package-icon"></i>
        <span class="package-text">Exclusive Package Deal</span>
        <div class="package-shine"></div>
    </div>
</div>

<div class="product__details--media">
    <div class="product__media--preview swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="product__media--preview__items image-container zoom zoomSingleImage">
                    <img class="product__media--preview__items--img lazy"
                        src="{{ url('tenant/frontend') }}/img/product-load.gif"
                        data-src="{{  $package->image }}" alt="{{ $package->name }}" />
                </div>
            </div>

            @if ($package->productImages && count($package->productImages) > 0)
                @foreach ($package->productImages as $image)
                    <div class="swiper-slide">
                        <div class="product__media--preview__items image-container zoom zoomSingleImage">
                            <img class="product__media--preview__items--img lazy"
                                src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                data-src="{{ $image->image }}"
                                alt="{{ $package->name }}" />
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Enhanced Package Description -->
    @if ($package->short_description)
        <div class="package-description-card mt-3">
            <div class="description-header">
                <i class="bi bi-info-circle"></i>
                <h5>Package Short Description</h5>
            </div>
            <div class="description-content">
                {{ $package->short_description }}
            </div>
        </div>
    @endif

    {{-- <div class="product__media--nav swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="product__media--nav__items">
                    <img class="product__media--nav__items--img lazy" 
                         src="{{url('frontend_assets')}}/img/product-load.gif" 
                         data-src="{{env('ADMIN_URL')."/".$package->image}}" alt="{{$package->name}}" />
                </div>
            </div>

            @if ($package->productImages && count($package->productImages) > 0)
                @foreach ($package->productImages as $image)
                    <div class="swiper-slide">
                        <div class="product__media--nav__items">
                            <img class="product__media--nav__items--img lazy" 
                                 src="{{url('frontend_assets')}}/img/product-load.gif" 
                                 data-src="{{$image->image}}" alt="{{$package->name}}" />
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div> --}}
</div>
