@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- using shared $generalInfo provided by AppServiceProvider (no per-view DB query) --}}

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
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{  $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush


@section('header_css')
    <style>
        .shop__header {
            background: #f8f8f8;
            border-radius: 4px;
            margin-top: 16px;
        }

        .pagination__area {
            border-radius: 4px;
            margin-bottom: 30px;
            margin-top: 25px;
        }

        .pagination__area nav.pagination ul.pagination li.page-item .page-link {
            border-radius: 50%;
            height: 38px;
            width: 38px;
            text-align: center;
            line-height: 20px;
            font-size: 18px !important;
            margin: 0px 2px;
        }
    </style>
@endsection

@push('upper_content')
    <!-- Start offcanvas filter sidebar -->
    <div class="offcanvas__filter--sidebar widget__area">
        <button type="button" class="offcanvas__filter--close" data-offcanvas>
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32" d="M368 368L144 144M368 144L144 368"></path>
            </svg>
            <span class="offcanvas__filter--close__text">Close</span>
        </button>
        <div class="offcanvas__filter--sidebar__inner">
            {{-- @include('tenant.frontend.pages.shop.filter_category')
            @include('tenant.frontend.pages.shop.filter_flag')
            @include('tenant.frontend.pages.shop.filter_price')
            @include('tenant.frontend.pages.shop.filter_brand') --}}
        </div>
    </div>
    <!-- End offcanvas filter sidebar -->
@endpush

@php
    $brand_banner = DB::table('brands')->where('id', $brandParam)->first();
    $category_banner = DB::table('categories')->where('slug', $category_id)->first();

    // dump($brand_banner, $brandId);

    $requestUri = $_SERVER['REQUEST_URI']; // e.g. /shop?category=mens-collection&subcategory_id=1&flag_id=1&brand_id=1
    $queryString = parse_url($requestUri, PHP_URL_QUERY); // Extract query part only
    $firstParam = null;

    if ($queryString) {
        $pairs = explode('&', $queryString);
        foreach ($pairs as $pair) {
            $kv = explode('=', $pair, 2);
            $key = $kv[0] ?? null;
            $value = $kv[1] ?? null;

            if (!empty($value)) {
                $firstParam = $key;
                break;
            }
        }
    }
@endphp

@section('content')
    <!-- Start shop section -->
    <section class="shop__section">
        <div class="container-fluid">
            <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                <button class="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas>
                    <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80" />
                        <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                        <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                        <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                    </svg>
                    <span class="widget__filter--btn__text">Filter</span>
                </button>
                <div class="product__view--mode d-flex align-items-center">

                    @include('tenant.frontend.pages.shop.filter_sorting')
                    @include('tenant.frontend.pages.shop.filter_search')

                </div>
                <p class="product__showing--count">{{ __('home.showing') }} {{ ($products->currentpage() - 1) * $products->perpage() + 1 }}
                    - {{ $products->currentpage() * $products->perpage() }} {{ __('home.of') }} {{ $products->total() }} {{ __('home.results') }}</p>
            </div>

            <div class="row mb-5">

                <div class="col-xl-3 col-lg-4">

                    <div class="shop__sidebar--widget widget__area d-none d-lg-block">

                        @include('tenant.frontend.pages.shop.filter_product_type')
                        @include('tenant.frontend.pages.shop.filter_category')
                        @include('tenant.frontend.pages.shop.filter_flag')
                        @include('tenant.frontend.pages.shop.filter_price')
                        @include('tenant.frontend.pages.shop.filter_brand')

                    </div>

                </div>

                <div class="col-xl-9 col-lg-8">
                    <div class="">
                        <div class="shop__banner--area mb-30">
                            @if ($firstParam === 'category' && $category_banner && $category_banner->banner_image)
                                <img src="{{  $category_banner->banner_image }}" alt="banner"
                                    class="img-fluid" style="max-height: 300px; width: 100%; object-fit: cover;">
                            @elseif ($firstParam === 'brand' && $brand_banner && $brand_banner->banner)
                                <img src="{{  $brand_banner->banner }}" alt="banner"
                                    class="img-fluid" style="max-height: 300px; width: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="shop__product--wrapper">
                            @include('tenant.frontend.pages.shop.products')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section -->
@endsection


@section('footer_js')
    <script>
        $(document).ready(function() {
            // Initialize the filter

            console.log("First parameter in the query string:", "{{ $firstParam }}");

        });
    </script>

    <script>
        if (isMobileDevice()) {
            console.log("Detected device is a mobile");
            var htmlContent = $(".shop__sidebar--widget").html();
            $(".offcanvas__filter--sidebar__inner").html(htmlContent);
            $(".shop__sidebar--widget").html("");

            document.addEventListener("click", (e) => {
                    e.target == document.querySelector(".modal.is-visible") &&
                        document.querySelector(".modal.is-visible").classList.remove(isVisible);
                }),
                document.addEventListener("keyup", (e) => {
                    "Escape" == e.key &&
                        document.querySelector(".modal.is-visible") &&
                        document
                        .querySelector(".modal.is-visible")
                        .classList.remove(isVisible);
                }),
                customAccordion(
                    ".accordion__container",
                    ".accordion__items",
                    ".accordion__items--body"
                ),
                customAccordion(
                    ".widget__categories--menu",
                    ".widget__categories--menu__list",
                    ".widget__categories--sub__menu"
                );

        } else {
            $(".offcanvas__filter--sidebar__inner").html("");
        }

        function isMobileDevice() {
            return window.matchMedia("only screen and (max-width: 760px)").matches;
        }

        function filterProducts() {

            // console.log("First parameter in the query string:", "{{ $firstParam }}");

            if ("{{ $firstParam }}" === 'category') {
                filterProductsCategory();
            } else if ("{{ $firstParam }}" === 'brand') {
                filterProductsBrand();
            } else {
                console.log("No valid first parameter found in the query string.");
                filterProductsCategory();
            }
        }

        function filterProductsCategory() {
            // fetching filter values
            let subcategory_id_array = [];
            let flag_id_array = [];
            let brand_id_array = [];

            $("input[name='filter_subcategory_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!subcategory_id_array.includes($(this).val())) {
                        subcategory_id_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_flag_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!flag_id_array.includes($(this).val())) {
                        flag_id_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_brand_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!brand_id_array.includes($(this).val())) {
                        brand_id_array.push($(this).val());
                    }
                }
            });

            let subcategoryIds = String(subcategory_id_array);
            let flagIds = String(flag_id_array);
            let brandIds = String(brand_id_array);
            var min_price_range = Number($("#filter_min_price").val());
            var max_price_range = Number($("#filter_max_price").val());
            var sort_by = Number($("#filter_sort_by").val());
            var search_keyword = $("#filter_search_keyword").val();
            var product_type = $("input[name='filter_product_type']:checked").val();

            // setting up get url with filter parameters
            var baseUrl = window.location.pathname;
            baseUrl += '?category=' + '{{ $category_id }}';

            if (subcategoryIds) {
                baseUrl += '&subcategory_id=' + subcategoryIds;
            }
            if (flagIds) {
                baseUrl += '&flag_id=' + flagIds;
            }
            if (brandIds) {
                baseUrl += '&brand_id=' + brandIds;
            }
            if (search_keyword) {
                baseUrl += '&search_keyword=' + search_keyword;
            }
            if (sort_by && sort_by > 0) {
                baseUrl += '&sort_by=' + sort_by;
            }
            if (min_price_range && min_price_range > 0) {
                baseUrl += '&min_price=' + min_price_range;
            }
            if (max_price_range && max_price_range > 0) {
                baseUrl += '&max_price=' + max_price_range;
            }
            if (product_type && product_type != '') {
                baseUrl += '&filter=' + product_type;
            }
            history.pushState(null, null, baseUrl);

            // sending request
            var formData = new FormData();
            formData.append("category", '{{ $category_id }}');
            formData.append("subcategory_id", subcategoryIds);
            formData.append("flag_id", flagIds);
            formData.append("brand_id", brandIds);
            formData.append("search_keyword", search_keyword);
            formData.append("sort_by", sort_by);
            formData.append("min_price", min_price_range);
            formData.append("max_price", max_price_range);
            formData.append("filter", product_type);
            formData.append("path_name", window.location.pathname);
            formData.append("firstParam", "{{ $firstParam }}");

            $.ajax({
                data: formData,
                url: "{{ url('filter/products') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.shop__product--wrapper').fadeOut(function() {
                        $(this).html(data.rendered_view);
                        $(this).fadeIn();
                        renderLazyImage()
                    });
                    $(".product__showing--count").html(data.showingResults);
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });
        }

        function filterProductsBrand() {

            // fetching filter values
            let subcategory_id_array = [];
            let flag_id_array = [];
            let brand_id_array = [];

            $("input[name='filter_subcategory_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!subcategory_id_array.includes($(this).val())) {
                        subcategory_id_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_flag_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!flag_id_array.includes($(this).val())) {
                        flag_id_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_brand_id[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!brand_id_array.includes($(this).val())) {
                        brand_id_array.push($(this).val());
                    }
                }
            });


            let subcategoryIds = String(subcategory_id_array);
            let flagIds = String(flag_id_array);
            let brandIds = String(brand_id_array);
            var min_price_range = Number($("#filter_min_price").val());
            var max_price_range = Number($("#filter_max_price").val());
            var sort_by = Number($("#filter_sort_by").val());
            var search_keyword = $("#filter_search_keyword").val();


            // setting up get url with filter parameters
            var baseUrl = window.location.pathname;
            baseUrl += '?brand=' + '{{ $brandParam }}';

            if (subcategoryIds) {
                baseUrl += '&subcategory_id=' + subcategoryIds;
            }
            if (flagIds) {
                baseUrl += '&flag_id=' + flagIds;
            }
            if (brandIds) {
                baseUrl += '&brand_id=' + brandIds;
            }
            if (search_keyword) {
                baseUrl += '&search_keyword=' + search_keyword;
            }
            if (sort_by && sort_by > 0) {
                baseUrl += '&sort_by=' + sort_by;
            }
            if (min_price_range && min_price_range > 0) {
                baseUrl += '&min_price=' + min_price_range;
            }
            if (max_price_range && max_price_range > 0) {
                baseUrl += '&max_price=' + max_price_range;
            }
            history.pushState(null, null, baseUrl);


            // sending request
            var formData = new FormData();
            formData.append("category", '{{ $category_id }}');
            formData.append("subcategory_id", subcategoryIds);
            formData.append("flag_id", flagIds);
            formData.append("brand_id", brandIds);
            formData.append("search_keyword", search_keyword);
            formData.append("sort_by", sort_by);
            formData.append("min_price", min_price_range);
            formData.append("max_price", max_price_range);
            formData.append("path_name", window.location.pathname);
            formData.append("firstParam", "{{ $firstParam }}");

            $.ajax({
                data: formData,
                url: "{{ url('filter/products') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.shop__product--wrapper').fadeOut(function() {
                        $(this).html(data.rendered_view);
                        $(this).fadeIn();
                        renderLazyImage()
                    });
                    $(".product__showing--count").html(data.showingResults);
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });
        }
    </script>
@endsection
