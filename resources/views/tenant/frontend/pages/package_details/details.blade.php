@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}

    <meta name="keywords" content="{{ $package ? $package->meta_keywords : '' }}" />
    <meta name="description" content="{{ $package ? $package->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') . '/package/details/' . $package->slug }}">

    <title>
        @if ($package->meta_title)
            {{ $package->meta_title }}
        @else
            {{ $package->name }} - Package
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($package->meta_title) {{ $package->meta_title }}@else{{ $package->name }} - Package @endif" />
    <meta property="og:type" content="{{ $package->category_name }}" />
    <meta property="og:url" content="{{ env('APP_URL') . '/package/details/' . $package->slug }}" />
    <meta property="og:image" content="{{  $package->image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $package->short_description }}" />
@endpush

@section('header_css')
    <style>
        .product__details--tab__inner #description ul li,
        .product__details--tab__inner #information ul li,
        .product__details--tab__inner #custom ul li {
            list-style: disc;
            padding-bottom: 5px;
            color: #1e1e1e;
        }

        .product__details--tab__inner #description ul,
        .product__details--tab__inner #information ul,
        .product__details--tab__inner #custom ul {
            padding-left: 15px;
        }

        .swiper-slide .product__media--preview__items img {
            cursor: zoom-in;
        }

        .product__details--info__meta p.product__details--info__meta--list {
            margin-bottom: 2px !important;
        }

        .quickview__variant--wishlist__svg {
            width: 18px;
            margin-right: 3px;
        }

        #product_details_add_to_cart_section button.stock_out_button {
            border: 1px solid var(--alert-color) !important;
            font-size: 16px !important;
            color: var(--alert-color) !important;
            padding: 2px 15px !important;
            margin: 10px 0px !important;
            padding: 5px 20px !important;
            margin: 15px 0px !important;
            cursor: not-allowed !important;
            border-radius: 4px !important;
        }

        .product__variant--list button.removeFromCartQty {
            background: transparent !important;
            color: var(--alert-color) !important;
            border: 1px solid var(--alert-color) !important;
            font-weight: 600 !important;
        }

        /* slider css start */
        .swiper-slide .product__media--preview__items {
            border-radius: 4px;
        }

        .product__media--nav__items {
            border: 2px solid var(--border-color2);
        }

        .product__details--media .product__media--preview {
            height: 550px;
        }

        .product__details--media .product__media--preview img.product__media--preview__items--img {
            object-fit: contain;
            height: 550px;
        }

        .product__details--media .swiper-wrapper {
            height: 120px;
        }

        .product__details--media .swiper-slide .product__media--nav__items {
            height: 108px;
            overflow: hidden;
            border-radius: 4px;
        }

        .product__details--media .swiper-slide .product__media--nav__items img.product__media--nav__items--img {
            height: 95px;
            object-fit: contain;
        }

        .width_height {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }



        /* slider css end */

        /* Ensure minicart works properly on package pages */
        .offCanvas__minicart {
            z-index: 9999 !important;
            opacity: 0;
            visibility: hidden;
        }

        .offCanvas__minicart.active {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateX(0) !important;
        }

        .offCanvas__minicart_active {
            overflow: hidden;
        }

        @media only screen and (max-width: 575px) {
            .breadcrumb__content {
                overflow-x: scroll;
                white-space: nowrap;
            }

            /* slider css start */
            .product__details--media .product__media--preview {
                height: 350px;
            }

            .product__details--media .product__media--preview img.product__media--preview__items--img {
                object-fit: contain;
                height: 350px;
            }

            .product__details--media .swiper-wrapper {
                height: 120px;
            }

            .product__details--media .swiper-slide .product__media--nav__items {
                height: 108px;
                overflow: hidden;
                border-radius: 4px;
            }

            .product__details--media .swiper-slide .product__media--nav__items img.product__media--nav__items--img {
                height: 95px;
                object-fit: contain;
            }

            /* slider css end */
        }

        /* Package Items Stock Styles */
        .package-items-stock {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .stock-overview-title {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 14px;
        }

        .items-stock-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .item-stock-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: white;
            border: 1px solid #e8e8e8;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .item-stock-card:hover {
            border-color: #d0d0d0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .item-image {
            width: 50px;
            height: 50px;
            margin-right: 12px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            color: #888;
            font-size: 20px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .item-variants {
            display: flex;
            gap: 8px;
            margin-bottom: 4px;
        }

        .variant-info {
            font-size: 11px;
            color: #666;
            background-color: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .item-quantity {
            font-size: 11px;
            color: #888;
            font-weight: 500;
        }

        .item-stock-status {
            min-width: 80px;
            text-align: right;
        }

        .stock-checking,
        .stock-available,
        .stock-unavailable,
        .stock-insufficient {
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
        }

        .stock-available {
            color: #28a745;
        }

        .stock-unavailable {
            color: #dc3545;
        }

        .stock-insufficient {
            color: #fd7e14;
        }

        .stock-checking {
            color: #6c757d;
        }

        /* Enhanced stock status badges */
        .stock-status-badge .text-success {
            color: #28a745 !important;
        }

        .stock-status-badge .text-danger {
            color: #dc3545 !important;
        }

        .stock-status-badge .text-warning {
            color: #fd7e14 !important;
        }

        /* Stock details styling */
        .stock-details {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
        }

        .stock-details h6 {
            color: #495057;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .stock-details ul {
            margin-bottom: 0;
            padding-left: 0;
        }

        .stock-details li {
            list-style: none;
            padding: 4px 0;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Visual feedback for item stock status */
        .item-stock-card.stock-available {
            border-color: #28a745;
            background-color: #f8fff9;
        }

        .item-stock-card.stock-issue {
            border-color: #dc3545;
            background-color: #fff8f8;
        }
    </style>
@endsection

@section('content')
    <!-- Start package details section -->
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    @include('tenant.frontend.pages.package_details.package_gallery')
                </div>
                <div class="col">
                    <div class="product__details--info">
                        @include('tenant.frontend.pages.package_details.package_info')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End package details section -->

    <!-- Start package details tab section -->
    <section class="product__details--tab__section">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <ul class="product__details--tab d-flex mb-30">
                        <li class="product__details--tab__list active" data-toggle="tab" data-target="#package_items">
                            Package Contains
                        </li>
                        <li class="product__details--tab__list" data-toggle="tab" data-target="#description">
                            Description
                        </li>
                        {{-- @if ($relatedPackages->count() > 0)
                            <li class="product__details--tab__list" data-toggle="tab" data-target="#related_packages">
                                Related Packages
                            </li>
                        @endif --}}
                    </ul>
                    <div class="product__details--tab__inner border-radius-10">
                        <div class="tab_content">
                            <div id="package_items" class="tab_pane active show">
                                @include('tenant.frontend.pages.package_details.package_items')
                            </div>
                            <div id="description" class="tab_pane">
                                @include('tenant.frontend.pages.package_details.package_description')
                            </div>
                            {{-- @if ($relatedPackages->count() > 0)
                                <div id="related_packages" class="tab_pane">
                                    @include('tenant.frontend.pages.package_details.related_packages')
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End package details tab section -->
@endsection

@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script>
        // Enhanced tab initialization
        function initializePackageTabs() {
            const tabContainer = document.querySelector('.product__details--tab');
            const tabPanes = document.querySelectorAll('.tab_pane');

            if (tabContainer) {
                // Add click event listeners to all tab buttons
                const tabButtons = tabContainer.querySelectorAll('[data-toggle="tab"]');

                tabButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const targetId = this.getAttribute('data-target');
                        const targetPane = document.querySelector(targetId);

                        if (targetPane) {
                            // Remove active class from all tabs
                            tabButtons.forEach(btn => btn.classList.remove('active'));

                            // Add active class to clicked tab
                            this.classList.add('active');

                            // Hide all tab panes
                            tabPanes.forEach(pane => {
                                pane.classList.remove('active', 'show');
                            });

                            // Show target tab pane with animation
                            setTimeout(() => {
                                targetPane.classList.add('active');
                                setTimeout(() => {
                                    targetPane.classList.add('show');
                                }, 50);
                            }, 150);
                        }
                    });
                });

                // Initialize first tab as active if none is active
                const activeTab = tabContainer.querySelector('.active');
                if (!activeTab && tabButtons.length > 0) {
                    tabButtons[0].click();
                }
            }
        }
        $(document).ready(function() {
            $('.zoomSingleImage').zoom();

            // Ensure minicart functionality works on package pages
            // Delay initialization to override any conflicting handlers from main script
            setTimeout(function() {
                initializePackagePageCart();
                initializePackageTabs();
            }, 100);

            // $('input[type=radio]').prop("checked", false);

            var $firstColorInput = $("input[name='color_id[]']").first();
            if ($firstColorInput.length > 0) {
                $firstColorInput.prop("checked", true).trigger('change');

                // Remove existing selected classes
                $(".variant__color--value--label").removeClass("selected");

                // Find label using for attribute
                $("label[for='" + $firstColorInput.attr("id") + "']").addClass("selected");
            }

            // Set first size as selected
            var $firstSizeInput = $("input[name='size_id[]']").first();
            if ($firstSizeInput.length > 0) {
                $firstSizeInput.prop("checked", true);
            }

            // When user changes color
            $("input[name='color_id[]']").on('change', function() {
                $(".variant__color--value--label").removeClass("selected");
                $("label[for='" + $(this).attr("id") + "']").addClass("selected");
                // Check stock when variant changes
                checkPackageStockOnLoad();
            });

            // When user changes size
            $("input[name='size_id[]']").on('change', function() {
                // Check stock when variant changes
                checkPackageStockOnLoad();
            });

            // Check stock when page loads
            checkPackageStockOnLoad();
        });

        // Initialize package page cart functionality
        function initializePackagePageCart() {
            console.log('Initializing package page cart functionality');

            // Ensure minicart open/close functionality works
            $(document).off('click', '.minicart__open--btn').on('click', '.minicart__open--btn', function(e) {
                console.log('Minicart open button clicked');
                e.preventDefault();
                e.stopPropagation();
                $('.offCanvas__minicart').addClass('active');
                $('body').addClass('offCanvas__minicart_active');
                console.log('Minicart should be open now');
            });

            // Override any existing close handlers
            $(document).off('click', '.minicart__close--btn').on('click', '.minicart__close--btn', function(e) {
                console.log('Minicart close button clicked');
                e.preventDefault();
                e.stopPropagation();
                $('.offCanvas__minicart').removeClass('active');
                $('body').removeClass('offCanvas__minicart_active');
            });

            // Close when clicking outside minicart
            $(document).off('click.minicart').on('click.minicart', function(e) {
                if ($('body').hasClass('offCanvas__minicart_active')) {
                    if (!$(e.target).closest('.offCanvas__minicart').length && !$(e.target).closest(
                            '.minicart__open--btn').length) {
                        $('.offCanvas__minicart').removeClass('active');
                        $('body').removeClass('offCanvas__minicart_active');
                    }
                }
            });

            // Test function - you can call this from browser console
            window.testMinicart = function() {
                $('.offCanvas__minicart').addClass('active');
                $('body').addClass('offCanvas__minicart_active');
                console.log('Test minicart opened');
            };
        }

        function checkVariantStock() {

            let color_id = null;
            let size_id = null;

            // color
            let colorFields = document.getElementsByName("color_id[]");
            for (let i = 0; i < colorFields.length; i++) {
                if (colorFields[i].checked) {
                    swiper2.slideTo(i, 500, false);
                    color_id = colorFields[i].value;
                }
            }

            // size
            let sizeFields = document.getElementsByName("size_id[]");
            for (let i = 0; i < sizeFields.length; i++) {
                if (sizeFields[i].checked) {
                    size_id = sizeFields[i].value;
                }
            }


            // sending request
            var formData = new FormData();
            formData.append("product_id", $("#product_id").val());
            formData.append("color_id", color_id);
            formData.append("size_id", size_id);

            $.ajax({
                data: formData,
                url: "{{ url('check/product/variant') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (Number(data.discounted_price) > 0) {
                        $(".old__price").show();
                        $(".price__divided").show();
                        $(".old__price").html('৳' + data.price);
                        $(".current__price ").html('৳' + data.discounted_price);
                        $("#product_price").val(Number(data.discounted_price));
                    } else {
                        $(".price__divided").hide();
                        $(".old__price").hide();
                        $(".current__price ").html('৳' + data.price);
                        $("#product_price").val(Number(data.price));
                    }

                    if (data.stock > 0) {
                        $("#stock_status_text").html("Stock in");
                        $("#stock_status_text").addClass("text-success");
                        $("#stock_status_text").removeClass("text-danger");
                        $("#product_details_add_to_cart_section").html(data.rendered_button)
                    } else {
                        $("#stock_status_text").html("Stock Out");
                        $("#stock_status_text").addClass("text-danger");
                        $("#stock_status_text").removeClass("text-success");
                        $("#product_details_add_to_cart_section").html(
                            "<button class='btn rounded stock_out_button'>Stock Out</button>")
                    }
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }


        $('body').on('click', '.addToCartWithQty', function() {
            var id = $(this).data('id');
            var $button = $(this);
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;

            // For packages, we don't need color/size selection
            // Get quantity value or default to 1
            var quantity = $("#product_details_cart_qty").length ? Number($("#product_details_cart_qty").val()) : 1;

            // Disable button and show loading state
            $button.prop('disabled', true);
            var originalText = $button.html();
            $button.html('<i class="fa fa-spinner fa-spin"></i> Checking Stock...');

            // First check package stock before adding to cart
            $.ajax({
                url: "{{ url('check/package/stock') }}",
                type: "POST",
                data: {
                    package_id: id,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(stockResponse) {
                    if (stockResponse.in_stock) {
                        // Stock is available, proceed with add to cart
                        addPackageToCart(id, quantity, $button, originalText);
                    } else {
                        // Stock issues found
                        $button.prop('disabled', false);
                        $button.html(originalText);

                        var errorMessage = "Stock Issues Found:\n" + stockResponse.stock_issues.join(
                            '\n');
                        toastr.error(errorMessage, "Cannot Add to Cart");

                        // Update UI to show stock issues
                        updatePackageStockStatus(false, stockResponse.stock_issues);
                    }
                },
                error: function(xhr, status, error) {
                    $button.prop('disabled', false);
                    $button.html(originalText);
                    toastr.error("Error checking stock availability");
                    console.error('Stock check error:', error);
                }
            });
        });

        function addPackageToCart(id, quantity, $button, originalText) {
            // sending request
            var formData = new FormData();
            formData.append("product_id", id);
            formData.append("qty", quantity);
            formData.append("price", {{ $package->price }});
            formData.append("discount_price", {{ $package->discount_price }});

            $.ajax({
                data: formData,
                url: "{{ url('add/to/cart/with/qty') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.success("Package Added to Cart");
                    $(".offCanvas__minicart").html(data.rendered_cart);
                    $("a.minicart__open--btn span.items__count").html(data.cartTotalQty);

                    // Open minicart to show the added item
                    setTimeout(function() {
                        $('.offCanvas__minicart').addClass('active');
                        $('body').addClass('offCanvas__minicart_active');
                    }, 100);

                    @if ($generalInfo->google_tag_manager_status)
                        // data layer
                        dataLayer.push({
                            ecommerce: null
                        }); // Clear the previous ecommerce object.
                        dataLayer.push({
                            event: "add_to_cart",
                            ecommerce: {
                                items: [{
                                    item_name: data
                                        .p_name_data_layer, // Name or ID is required.
                                    item_id: id,
                                    price: data.p_price_data_layer,
                                    item_brand: data.p_brand_name,
                                    item_category: data.p_category_name,
                                    item_category2: "",
                                    item_category3: "",
                                    item_category4: "",
                                    item_variant: "",
                                    item_list_name: "", // If associated with a list selection.
                                    item_list_id: "", // If associated with a list selection.
                                    index: 0, // If associated with a list selection.
                                    quantity: data.p_qauntity,
                                }]
                            }
                        });
                    @endif

                    $button.html("Remove from cart");
                    $button.removeClass("addToCartWithQty");
                    $button.addClass("removeFromCartQty");
                    $button.prop('disabled', false);
                    $button.blur();
                },
                error: function(data) {
                    toastr.error("Something Went Wrong");
                    $button.prop('disabled', false);
                    $button.html(originalText);
                }
            });
        }

        function updatePackageStockStatus(inStock, stockIssues) {
            // Update stock status in package info
            var stockStatusElement = $('#stock_status_text');
            if (stockStatusElement.length) {
                if (inStock) {
                    stockStatusElement.removeClass('text-danger').addClass('text-success').text('In Stock');
                } else {
                    stockStatusElement.removeClass('text-success').addClass('text-danger').text('Stock Issues');
                }
            }

            // Show detailed stock issues in console for debugging
            if (!inStock && stockIssues) {
                console.log('Package Stock Issues:', stockIssues);
            }
        }



        $('body').on('click', '.buyNowWithQty', function() {
            var id = $(this).data('id');
            var $button = $(this);
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 2000;

            // For packages, we don't need color/size selection
            // Get quantity value or default to 1
            var quantity = $("#product_details_cart_qty").length ? Number($("#product_details_cart_qty").val()) : 1;

            // Disable button and show loading state
            $button.prop('disabled', true);
            var originalText = $button.html();
            $button.html('<i class="fa fa-spinner fa-spin"></i> Checking Stock...');

            // First check package stock before proceeding
            $.ajax({
                url: "{{ url('check/package/stock') }}",
                type: "POST",
                data: {
                    package_id: id,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(stockResponse) {
                    if (stockResponse.in_stock) {
                        // Stock is available, proceed with buy now
                        $button.html('<i class="fa fa-spinner fa-spin"></i> Processing...');

                        var formData = new FormData();
                        formData.append("product_id", id);
                        formData.append("qty", quantity);
                        formData.append("price", {{ $package->price }});
                        formData.append("discount_price", {{ $package->discount_price }});

                        $.ajax({
                            data: formData,
                            url: "{{ url('add/to/cart/with/qty') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                window.location.href = "{{ url('checkout') }}";
                            },
                            error: function(data) {
                                toastr.error("Something Went Wrong");
                                $button.prop('disabled', false);
                                $button.html(originalText);
                            }
                        });
                    } else {
                        // Stock issues found
                        $button.prop('disabled', false);
                        $button.html(originalText);

                        var errorMessage = "Stock Issues Found:\n" + stockResponse.stock_issues.join(
                            '\n');
                        toastr.error(errorMessage, "Cannot Proceed to Checkout");

                        // Update UI to show stock issues
                        updatePackageStockStatus(false, stockResponse.stock_issues);
                    }
                },
                error: function(xhr, status, error) {
                    $button.prop('disabled', false);
                    $button.html(originalText);
                    toastr.error("Error checking stock availability");
                    console.error('Stock check error:', error);
                }
            });
        });


        $('body').on('click', '.removeFromCartQty', function() {
            var id = $(this).data('id');
            $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {

                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Removed from cart");
                $(".offCanvas__minicart").html(data.rendered_cart);
                $("a.minicart__open--btn span.items__count").html(data.cartTotalQty);

            })

            $("#product_details_cart_qty").val(1);
            $(this).html("Add to cart");
            $(this).removeClass("removeFromCartQty");
            $(this).addClass("addToCartWithQty");
            $(this).blur();
        });


        $('body').on('click', '.quantity__value_details', function() {
            var id = $(this).data('id');
            var quantityInput = this.parentElement.querySelector("input");
            var currentQuantity = parseInt(quantityInput.value);

            if (this.classList.contains("decrease")) {
                quantityInput.value = Math.max(currentQuantity - 1, 1);
            } else if (this.classList.contains("increase")) {
                quantityInput.value = currentQuantity + 1;
            }

            var formData = new FormData();
            formData.append("cart_id", id);
            formData.append("cart_qty", quantityInput.value);
            $.ajax({
                data: formData,
                url: "{{ url('update/cart/qty') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(".offCanvas__minicart").html(data.rendered_cart);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        // Function to check package stock on page load and variant changes
        function checkPackageStockOnLoad() {
            console.log('Starting package stock check...');

            // Reset all item statuses to "Checking..."
            $('.item-stock-status').each(function() {
                $(this).html(
                    '<span class="stock-checking"><i class="bi bi-clock text-muted"></i> Checking...</span>');
            });

            // Collect variants if any
            var colorIds = [];
            var sizeIds = [];

            $("input[name='color_id[]']:checked").each(function() {
                colorIds.push($(this).val());
            });

            $("input[name='size_id[]']:checked").each(function() {
                sizeIds.push($(this).val());
            });

            var requestData = {
                package_id: {{ $package->id }},
                quantity: $("#product_details_cart_qty").length ? Number($("#product_details_cart_qty").val()) : 1,
                _token: "{{ csrf_token() }}"
            };

            if (colorIds.length > 0) {
                requestData.color_id = colorIds;
            }

            if (sizeIds.length > 0) {
                requestData.size_id = sizeIds;
            }

            // Debug: Log all data being sent
            console.log('Request data:', requestData);

            console.log('Sending AJAX request to check stock...');
            $.ajax({
                url: "{{ route('CheckPackageStock') }}",
                type: "POST",
                data: requestData,
                success: function(response) {
                    console.log('Stock check response:', response);
                    updatePackageStockStatus(response);
                },
                error: function(xhr, status, error) {
                    console.error('Stock check error:', error);
                    console.error('Status:', status);
                    console.error('XHR status:', xhr.status);
                    console.error('XHR response:', xhr.responseText);

                    // Update UI to show unknown stock status
                    $('.stock-status').html('<span class="text-warning">Stock status unavailable</span>');
                    $('.stock-details').hide();

                    // Update all item statuses to show error
                    $('.item-stock-status').each(function() {
                        $(this).html(
                            '<span class="stock-unavailable"><i class="bi bi-x-circle"></i> Error</span>'
                        );
                    });
                }
            });
        }

        // Function to update package stock status display
        function updatePackageStockStatus(response) {
            console.log('updatePackageStockStatus called with:', response);

            const stockStatusElement = $('.stock-status');
            const stockDetailsElement = $('.stock-details');
            const addToCartButton = $('.addToCartWithQty');
            const buyNowButton = $('.buyNowWithQty');

            if (response.success && response.in_stock) {
                // All items are in stock
                stockStatusElement.html('<span class="text-success"><i class="fas fa-check-circle"></i> In Stock</span>');
                stockDetailsElement.hide();
                addToCartButton.prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
                buyNowButton.prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
            } else {
                // Some items are out of stock or insufficient stock
                stockStatusElement.html(
                    '<span class="text-danger"><i class="fas fa-times-circle"></i> Stock Issues</span>');

                if (response.stock_issues && response.stock_issues.length > 0) {
                    let detailsHtml = '<div class="mt-2"><h6>Stock Issues:</h6><ul class="list-unstyled">';
                    response.stock_issues.forEach(function(issue) {
                        detailsHtml +=
                            `<li class="text-danger"><i class="fas fa-exclamation-triangle"></i> ${issue}</li>`;
                    });
                    detailsHtml += '</ul></div>';
                    stockDetailsElement.html(detailsHtml).show();
                } else {
                    stockDetailsElement.html(
                        '<div class="mt-2 text-danger">Some items in this package are not available.</div>').show();
                }

                // addToCartButton.prop('disabled', true).removeClass('btn-primary').addClass('btn-secondary');
                // buyNowButton.prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
            }

            // Update individual item stock statuses using detailed response
            console.log('Checking for item_details:', response.item_details);
            if (response.item_details && response.item_details.length > 0) {
                console.log('Using detailed item status update');
                updateIndividualItemStockStatusFromDetails(response.item_details);
            } else {
                console.log('Using fallback item status update');
                // Fallback to old method if no detailed data
                updateIndividualItemStockStatus(response.stock_issues);
            }
        }

        // Enhanced function to update individual item stock status using detailed backend data
        function updateIndividualItemStockStatusFromDetails(itemDetails) {
            console.log('Updating individual item stock status:', itemDetails);

            itemDetails.forEach(function(item) {
                console.log('Processing item:', item);

                // Use unique_id if available, otherwise fall back to product_id
                const itemId = item.unique_id || item.product_id;

                // Find the corresponding item card by unique ID
                const itemCard = $(`#item_stock_${itemId}`);
                const statusElement = $(`#item_status_${itemId}`);

                console.log('Looking for elements with ID:', itemId, {
                    itemCard: itemCard.length,
                    statusElement: statusElement.length
                });

                if (statusElement.length > 0) {
                    let statusHtml = '';

                    switch (item.status) {
                        case 'available':
                            statusHtml =
                                '<span class="stock-available"><i class="bi bi-check-circle"></i> Available</span>';
                            break;
                        case 'insufficient':
                            statusHtml =
                                `<span class="stock-insufficient"><i class="bi bi-exclamation-triangle"></i> Low Stock (${item.available_quantity})</span>`;
                            break;
                        case 'out_of_stock':
                            statusHtml =
                                '<span class="stock-unavailable"><i class="bi bi-x-circle"></i> Out of Stock</span>';
                            break;
                        case 'not_found':
                            statusHtml =
                                '<span class="stock-unavailable"><i class="bi bi-question-circle"></i> Not Found</span>';
                            break;
                        default:
                            statusHtml =
                                '<span class="stock-checking"><i class="bi bi-clock"></i> Checking...</span>';
                    }

                    console.log('Setting status HTML:', statusHtml);
                    statusElement.html(statusHtml);

                    // Add visual feedback to the item card
                    if (itemCard.length > 0) {
                        itemCard.removeClass('stock-issue stock-available');
                        if (item.status === 'available') {
                            itemCard.addClass('stock-available');
                        } else if (item.status !== 'checking') {
                            itemCard.addClass('stock-issue');
                        }
                    }
                } else {
                    console.error('Status element not found for item ID:', itemId);
                    // Debug: list all available status elements
                    console.log('Available status elements:', $('.item-stock-status').map(function() {
                        return this.id;
                    }).get());
                }
            });
        }
    </script>
@endsection
