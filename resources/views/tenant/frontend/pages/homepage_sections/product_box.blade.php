<!-- Start New Arrival section -->
<section class="container-fluid new__arrival--section">
    <div class="section__heading flag_section" style="margin-bottom: 40px">
        <h2 class="section__heading--maintitle">{{ ucfirst($flag->name) }}</h2>
        <a href="{{ url('shop') }}/?category=&flag_id={{ $flag->id }}">
            <img src="{{ url('tenant/frontend') }}/img/product-load.gif"
                data-src="{{ url(env('ADMIN_URL') . '/' . $flag->icon) }}" alt=""
                class="lazy newArrival__items--img newArrival__primary--img" />
        </a>
    </div>

    <section class="section--padding pt-0">
        <div class="row">
            <div class="col-12">
                <div class="product__section-inner" id="target-{{ $flag->id }}">
                    @foreach ($flag->initialProducts as $product)
                        @include('tenant.frontend.pages.homepage_sections.single_product', [
                            'product' => $product,
                        ])
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    @if ($flag->product_count > 5)
                        <!-- Show More Button -->
                        <div class="d-inline-block">
                            <button class="product_show_btn show_more showMoreBtn" data-flag="{{ $flag->id }}"
                                data-skip="5">
                                <span class="add__to--cart__text">Show More</span>
                            </button>
                        </div>

                        <!-- Show All Button (Initially Hidden) -->
                        <div class="d-inline-block">
                            <button class="product_show_btn show_more d-none showAllBtn"
                                onclick="window.location.href='{{ url('shop') }}/?flag_id={{ $flag->id }}'">
                                <span class="add__to--cart__text">Show All Products</span>
                            </button>
                        </div>
                    @elseif($flag->product_count > 0)
                        <!-- Show All Button when there are 5 or fewer products -->
                        <div class="d-inline-block">
                            <button class="product_show_btn show_more showAllBtn"
                                onclick="window.location.href='{{ url('shop') }}/?flag_id={{ $flag->id }}'">
                                <span class="add__to--cart__text">Show All Products</span>
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- <div class="newArrival__section--inner newArrival__swiper--activation swiper">
        <div class="newArrival__swiper-wrapper swiper-wrapper">
            @foreach ($products as $product)
            <div class="swiper-slide">
                <div class="newArrival__items">
                    <div class="newArrival__items--thumbnail">
                        <a class="newArrival__items--link" href="{{url('product/details')}}/{{$product->slug}}">
                            <img src="{{url('frontend_assets')}}/img/product-load.gif"
                                data-src="{{url(env('ADMIN_URL') . " /" . $product->image)}}" alt=""
                            class="lazy newArrival__items--img newArrival__primary--img" />
                        </a>
                        <div class="product__badge">
                            <span class="product__badge--items sale">{{$flag->name}}</span>
                        </div>
                    </div>
                    <div class="product__items--content">
                        <h3 class="product__items--content__title h4">
                            <a href="{{url('product/details')}}/{{$product->slug}}">{{$product->name}}</a>
                        </h3>
                        @include('tenant.frontend.pages.homepage_sections.product_box_price')
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="swiper__nav--btn swiper-button-prev"></div>
        <div class="swiper__nav--btn swiper-button-next"></div>
    </div> --}}
</section>
<!-- End New Arrival section -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.showMoreBtn').click(function() {
        let button = $(this);
        if (button.prop('disabled')) return;

        button.prop('disabled', true);

        let flagId = button.data('flag');
        let skip = parseInt(button.data('skip'));

        $.ajax({
            url: '/load-flag-products',
            method: 'GET',
            data: {
                skip: skip,
                flag_id: flagId
            },
            success: function(res) {
                $('#target-' + flagId).append(res.html);
                button.data('skip', res.nextSkip);
                button.prop('disabled', false);

                if (res.reachedLimit) {
                    button.addClass('d-none');
                    button.closest('.d-inline-block').next('.d-inline-block').find('.showAllBtn')
                        .removeClass('d-none');
                }
            }
        });
    });
</script>
