@extends('tenant.frontend.layouts.app')


@push('site-seo')
    {{-- using shared $generalInfo provided by AppServiceProvider --}}

    <meta name="title" content="{{ $generalInfo ? $generalInfo->meta_title : '' }}" />
    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush

@section('header_css')
@endsection


@push('top_header')
    <div class="header__topbar bg__secondary">
        <div class="container-fluid">
            <div class="header__topbar--inner d-flex align-items-center justify-content-between">
                <div class="header__shipping">
                    <ul class="header__shipping--wrapper d-flex">
                        {{-- debug dd removed: do not dump here in production --}}
                        <li class="header__shipping--text text-white">Welcome to {{ $generalInfo->company_name }}</li>
                        <li class="header__shipping--text text-white d-sm-2-none">
                            <img class="header__shipping--text__icon"
                                src="{{ url('tenant/frontend/frontend_assets') }}/img/icon/bus.png" alt="bus-icon" />
                            <a class="header__shipping--text__link" href="{{ url('track/order') }}"> Track Your Order</a>
                        </li>
                        @foreach (explode(',', $generalInfo->email) as $email)
                            <li class="header__shipping--text text-white d-sm-2-none">
                                <img class="header__shipping--text__icon"
                                    src="{{ url('tenant/frontend/frontend_assets') }}/img/icon/email.png"
                                    alt="email-icon" />
                                <a class="header__shipping--text__link"
                                    href="mailto:demo@gmail.com">{{ $email }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endpush


@section('content')

    {{-- Slider --}}
    @include('tenant.frontend.pages.homepage_sections.sliders')
    {{-- End slider --}}

    {{-- Sidebanner --}}
    @include('tenant.frontend.pages.homepage_sections.sidebanner')
    {{-- End Sidebanner --}}


    {{-- Categories --}}
    @include('tenant.frontend.pages.homepage_sections.categories')
    {{-- End Categories --}}

    {{-- Top Banner --}}
    @php
        $tops = DB::table('banners')->where('type', 2)->where('position', 'top')->where('status', 1)->get();
    @endphp

    @if (isset($tops) && $tops->count() > 0)
        @foreach ($tops as $top)
            @include('tenant.frontend.pages.homepage_sections.banner', ['banner' => $top])
        @endforeach
    @endif
    {{-- End Top Banner --}}

    {{-- Deals of the Day --}}
    {{-- Flag wise Product --}}
    @foreach ($flags as $index => $flag)
        @include('tenant.frontend.pages.homepage_sections.product_box')
        @if ($index == 1)
            @include('tenant.frontend.pages.homepage_sections.promotional_banner')
        @endif
    @endforeach
    {{-- End Flag wise Product --}}

    {{-- Package Products Section --}}
    @if (isset($packageProducts) && $packageProducts->count() > 0)
        @include('tenant.frontend.pages.homepage_sections.package_products')
    @endif
    {{-- End Package Products Section --}}


    {{-- Middle Banner --}}
    @php
        $middles = DB::table('banners')->where('type', 2)->where('position', 'middle')->where('status', 1)->get();
    @endphp

    @if (isset($middles) && $middles->count() > 0)
        @foreach ($middles as $middle)
            @include('tenant.frontend.pages.homepage_sections.banner', ['banner' => $middle])
        @endforeach
    @endif
    {{-- End Top Banner --}}


    {{-- Brands --}}
    @include('tenant.frontend.pages.homepage_sections.brands')
    {{-- End Brands --}}

    <!-- Start product section -->
    {{-- <section class="product__section section--padding pt-0" id="yourDivId">
        <div class="container-fluid">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">For You</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product__section-inner" id="target">

                        @foreach ($productsForYou as $product)
                        @include('tenant.frontend.pages.homepage_sections.single_product')
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End product section -->

    {{-- testimonial Section --}}
    @include('tenant.frontend.pages.homepage_sections.testimonial')
    {{-- End testimonial Section --}}

    {{-- Bootom Banner --}}
    @php
        $bottoms = DB::table('banners')->where('type', 2)->where('position', 'bottom')->where('status', 1)->get();
    @endphp

    @if (isset($bottoms) && $bottoms->count() > 0)
        @foreach ($bottoms as $bottom)
            @include('tenant.frontend.pages.homepage_sections.banner', ['banner' => $bottom])
        @endforeach
    @endif
    {{-- End Bootom Banner --}}

@endsection

@section('footer_js')
    {{-- Fetch More Prodjuct While Scrolling start --}}
    {{--
    <script>
        let debounceTimer;
        var finishedFetchProducts = 0;
        function handleScroll() {
            // Clear the previous timer
            clearTimeout(debounceTimer);

            // Set a new timer to call the function after a delay
            debounceTimer = setTimeout(function () {

                // fetching product start
                var divTop = $('#yourDivId').offset().top;
                var divHeight = $('#yourDivId').outerHeight();
                var wHeight = $(window).height();
                var windowScrTp = $(this).scrollTop();

                if (windowScrTp > (divTop + divHeight - wHeight)) {
                    if (finishedFetchProducts == 0) {
                        var formData = new FormData();
                        formData.append("product_fetch_skip", Number($(".product__items").length));
                        $.ajax({
                            data: formData,
                            url: "{{ url('fetch/more/products') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (Number(data.fetched_products) > 0) {
                                    $(".product__section-inner").append(data.more_products);
                                    renderLazyImage();
                                } else {
                                    finishedFetchProducts = 1
                                }
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                }
                // fetching product end

            }, 200); // Adjust the delay (in milliseconds) as needed
        }
        // Attach the debounced function to the scroll event
        window.addEventListener("scroll", handleScroll);
    </script> --}}
    {{-- Fetch More Prodjuct While Scrolling end --}}
@endsection
