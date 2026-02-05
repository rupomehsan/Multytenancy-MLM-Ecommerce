<!-- Start New Arrival section -->
@if ($flag->product_count > 0)
    <section class="container-fluid new__arrival--section">
        <div class="section__heading flag_section" style="margin-bottom: 40px">
            <div class="d-flex align-items-center justify-content-between w-100 flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="section__heading--maintitle">
                            {{ ucfirst($flag->name) }}
                        </h2>
                        @if (!empty($flag->short_description))
                            <p class="mb-0 text-muted" style="font-size: 14px; color: #7f8c8d;">
                                {{ $flag->short_description }}</p>
                        @else
                            <p class="mb-0 text-muted" style="font-size: 14px; color: #7f8c8d;">
                                {{ __('home.browse_latest_products') }}</p>
                        @endif
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ url('shop') }}/?flag_id={{ $flag->id }}" class="explore-products-btn"
                        aria-label="{{ __('home.explore_products') }} - {{ $flag->name }}">
                        <span>{{ __('home.explore_products') }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
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
                                    <span class="add__to--cart__text">{{ __('home.show_more') }}</span>
                                </button>
                            </div>

                            <!-- Show All Button (Initially Hidden) -->
                            <div class="d-inline-block">
                                <button class="product_show_btn show_more d-none showAllBtn"
                                    onclick="window.location.href='{{ url('shop') }}/?flag_id={{ $flag->id }}'">
                                    <span class="add__to--cart__text">{{ __('home.show_all_products') }}</span>
                                </button>
                            </div>
                        @elseif($flag->product_count > 0)
                            <!-- Show All Button when there are 5 or fewer products -->
                            <div class="d-inline-block">
                                <button class="product_show_btn show_more showAllBtn"
                                    onclick="window.location.href='{{ url('shop') }}'">
                                    <span class="add__to--cart__text">{{ __('home.show_all_products') }}</span>
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
@endif
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
