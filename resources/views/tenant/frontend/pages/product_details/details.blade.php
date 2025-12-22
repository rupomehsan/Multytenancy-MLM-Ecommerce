@extends('tenant.frontend.layouts.app')


@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}

    <meta name="keywords" content="{{ $product ? $product->meta_keywords : '' }}" />
    <meta name="description" content="{{ $product ? $product->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') . '/product/details/' . $product->slug }}">

    <title>
        @if ($product->meta_title)
            {{ $product->meta_title }}
        @else
            {{ $product->name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($product->meta_title) {{ $product->meta_title }}@else{{ $product->name }} @endif" />
    <meta property="og:type" content="{{ $product->category_name }}" />
    <meta property="og:url" content="{{ env('APP_URL') . '/product/details/' . $product->slug }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $product->image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $product->short_description }}" />

    <meta property="product:brand" content="Fejmo">
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="{{ $product->discount_price }}">
    <meta property="product:price:currency" content="BDT">
    <meta property="product:item_group_id" content="{{ $product->category_name ?? '' }}">
    <!-- End Open Graph general (Facebook, Pinterest)-->
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
    </style>
@endsection

@section('content')

    {{-- @include('product_details.breadcrumb') --}}

    <!-- Start product details section -->
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    @include('tenant.frontend.pages.product_details.product_gallery')
                </div>
                <div class="col">


                    <div class="product__details--info">

                        @php
                            $totalStockAllVariants = 0; // jekonon variant er at least ekta stock e thakleo stock in dekhabe
                            if ($variants && count($variants) > 0) {
                                $variantMinDiscountPrice = 0;
                                $variantMinPrice = 0;
                                $variantMinDiscountPriceArray = [];
                                $variantMinPriceArray = [];

                                foreach ($variants as $variant) {
                                    $variantMinDiscountPriceArray[] = $variant->discounted_price;
                                    $variantMinPriceArray[] = $variant->price;
                                    $totalStockAllVariants = $totalStockAllVariants + (int) $variant->stock;
                                }

                                $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
                                $variantMinPrice = min($variantMinPriceArray);
                            }
                        @endphp

                        @include('tenant.frontend.pages.product_details.name_with_wishlist')
                        @include('tenant.frontend.pages.product_details.price')
                        @include('tenant.frontend.pages.product_details.rating')
                        @include('tenant.frontend.pages.product_details.short_info')
                        @if ($product->weight)
                            <p class="product__details--info__meta--list">
                                <span>Product Weight:</span>
                                <strong id="stock_status_text" class="text-success">
                                    {{ $product->weight }}g
                                </strong>
                            </p>
                        @endif


                        <div class="product__variant">

                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">

                            @if ($variants && count($variants) > 0)

                                {{-- variant start --}}
                                @php
                                    $colorCheckArray = [];
                                    $colorChecked = [];
                                    $colorArray = [];
                                    foreach ($variants as $variant) {
                                        if ($variant->color_id) {
                                            $colorCheckArray[] = $variant->color_id;
                                        }
                                        if ($variant->color_id && !in_array($variant->color_id, $colorChecked)) {
                                            $colorChecked[] = $variant->color_id;
                                        }
                                    }
                                @endphp
                                @if (count($colorCheckArray) > 0)
                                    <div class="product__variant--list mb-10">
                                        <fieldset class="variant__input--fieldset color-field">
                                            <legend class="product__variant--title mb-8">
                                                Choose color :
                                            </legend>
                                            @foreach ($variants as $variant)
                                                @if ($variant->color_code && !in_array($variant->color_code, $colorArray))
                                                    @php $colorArray[] = $variant->color_code; @endphp
                                                    <input id="option_color_{{ $variant->color_id }}" name="color_id[]"
                                                        value="{{ $variant->color_id }}" type="radio"
                                                        onchange="checkVariantStock()" class="btn-check"
                                                        @if (count($colorChecked) == 1) checked="checked" @endif />

                                                    <div class="d-inline-block text-center mx-1">
                                                        <label
                                                            class="variant__color--value btn btn-secondary variant__color--value--label"
                                                            style="background: {{ $variant->color_code }};"
                                                            for="option_color_{{ $variant->color_id }}"
                                                            title="{{ $variant->color_name }}">

                                                            {{-- <img src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $variant->image }}"
                                                                data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $variant->image }}"
                                                                alt="" class="width_height"> --}}

                                                        </label>

                                                        <div
                                                            style="white-space: nowrap; text-overflow: ellipsis; width: 55px; overflow: hidden">
                                                            <small>{{ $variant->color_name }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </fieldset>
                                    </div>
                                @endif

                                @if ($configSetup[0]->status == 1)
                                    @php
                                        $sizeCheckArray = [];
                                        $sizeChecked = [];
                                        $sizeArray = [];
                                        foreach ($variants as $variant) {
                                            if ($variant->size_id) {
                                                $sizeCheckArray[] = $variant->size_id;
                                            }
                                            if ($variant->size_id && !in_array($variant->size_id, $sizeChecked)) {
                                                $sizeChecked[] = $variant->size_id;
                                            }
                                        }
                                    @endphp
                                    <div class="product__variant--list mb-15">
                                        <fieldset class="variant__input--fieldset weight">
                                            <legend class="product__variant--title mb-8">
                                                Choose size :
                                            </legend>
                                            @foreach ($variants as $variant)
                                                @if ($variant->size_id && !in_array($variant->size_id, $sizeArray))
                                                    @php $sizeArray[] = $variant->size_id; @endphp
                                                    <input id="option_size_{{ $variant->size_id }}"
                                                        onchange="checkVariantStock()" value="{{ $variant->size_id }}"
                                                        name="size_id[]" type="radio"
                                                        @if (count($sizeChecked) == 1) checked @endif class="btn-check"
                                                        autocomplete="off" />
                                                    <label class="variant__size--value red btn btn-secondary"
                                                        for="option_size_{{ $variant->size_id }}">{{ $variant->size_name }}</label>
                                                @endif
                                            @endforeach
                                        </fieldset>
                                    </div>
                                @endif

                            @endif

                            <div style="display: block; width: 100%" id="product_details_add_to_cart_section">
                                @if ($variants && count($variants) > 0)
                                    @if ($totalStockAllVariants && $totalStockAllVariants > 0)
                                        @include('tenant.frontend.pages.product_details.cart_buy_button', [
                                            'variants' => $variants,
                                            'totalStockAllVariants' => $totalStockAllVariants,
                                        ])
                                    @else
                                        <button class="btn rounded stock_out_button">Stock Out</button>
                                    @endif
                                @else
                                    @if ($product->stock && $product->stock > 0)
                                        @include('tenant.frontend.pages.product_details.cart_buy_button', [
                                            'variants' => null,
                                            'totalStockAllVariants' => 0,
                                        ])
                                    @else
                                        <button class="btn rounded stock_out_button">Stock Out</button>
                                    @endif
                                @endif
                            </div>

                        </div>

                        @if ($product->size_chart)
                            <p class="product__details--info__desc mb-15"><b>Size Chart: </b>{!! $product->size_chart !!}</p>
                        @endif

                        @if ($product->short_description)
                            <p class="product__details--info__desc mb-15"><b>Short Description:
                                </b>{{ $product->short_description }}</p>
                        @endif

                        @include('tenant.frontend.pages.product_details.social_share')

                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- End product details section -->

    <!-- Start product details tab section -->
    @include('tenant.frontend.pages.product_details.description')
    <!-- End product details tab section -->

    <!-- Start may also like section -->
    @include('tenant.frontend.pages.product_details.you_may_also_like')
    <!-- End may also like section -->
@endsection

@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script>
        $(document).ready(function() {
            $('.zoomSingleImage').zoom();

            // Track initialization state to prevent toast messages during page load
            window.isInitializing = true;

            // Initialize stock tracking
            @if ($variants && count($variants) > 0)
                window.currentVariantStock = 0; // Will be set when variant is selected
            @else
                window.currentVariantStock = {{ $product->stock }};
            @endif

            // Initialize variant selections
            var $firstColorInput = $("input[name='color_id[]']").first();
            if ($firstColorInput.length > 0) {
                $firstColorInput.prop("checked", true);

                // Remove existing selected classes
                $(".variant__color--value--label").removeClass("selected");

                // Find label using for attribute and add selected class
                $("label[for='" + $firstColorInput.attr("id") + "']").addClass("selected");

                // Trigger change to update pricing and stock
                $firstColorInput.trigger('change');
            }

            // Set first size as selected
            var $firstSizeInput = $("input[name='size_id[]']").first();
            if ($firstSizeInput.length > 0) {
                $firstSizeInput.prop("checked", true);
            }

            // When user changes color selection
            $("input[name='color_id[]']").on('change', function() {
                $(".variant__color--value--label").removeClass("selected");
                $("label[for='" + $(this).attr("id") + "']").addClass("selected");
            });

            // Initialize stock check if variants exist
            if ($("input[name='color_id[]']").length > 0 || $("input[name='size_id[]']").length > 0) {
                checkVariantStock();
            } else {
                // For products without variants, show stock info and check cart status
                var productStock = {{ $product->stock }};
                window.currentVariantStock = productStock; // Set this for consistency
                // Check if this product (without variants) is in cart
                checkCurrentVariantInCart(null, null);
            }

            // Mark initialization as complete after a short delay
            setTimeout(function() {
                window.isInitializing = false;
            }, 1000);

            // Add keypress validation to prevent non-numeric input
            $('#product_details_cart_qty').on('keypress', function(e) {
                // Allow only numbers, backspace, delete, tab, escape, enter
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                    // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                        105)) {
                    e.preventDefault();
                }
            });
        });

        function checkVariantStock() {
            let color_id = null;
            let size_id = null;

            // Get selected color
            let colorFields = document.getElementsByName("color_id[]");
            for (let i = 0; i < colorFields.length; i++) {
                if (colorFields[i].checked) {
                    if (typeof swiper2 !== 'undefined') {
                        swiper2.slideTo(i, 500, false);
                    }
                    color_id = colorFields[i].value;
                    break;
                }
            }

            // Get selected size
            let sizeFields = document.getElementsByName("size_id[]");
            for (let i = 0; i < sizeFields.length; i++) {
                if (sizeFields[i].checked) {
                    size_id = sizeFields[i].value;
                    break;
                }
            }

            // Prepare form data
            var formData = new FormData();
            formData.append("product_id", $("#product_id").val());
            formData.append("color_id", color_id || '');
            formData.append("size_id", size_id || '');
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                data: formData,
                url: "{{ url('check/product/variant') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data) {
                        // Store current variant stock globally for quantity validation
                        window.currentVariantStock = data.stock || 0;

                        // Debug logging to identify the source of incorrect stock value
                        console.log('===== VARIANT STOCK DEBUG =====');
                        console.log('Full response data:', data);
                        console.log('data.stock value:', data.stock);
                        console.log('data.stock type:', typeof data.stock);
                        console.log('Color ID sent:', color_id);
                        console.log('Size ID sent:', size_id);
                        console.log('Product ID:', $("#product_id").val());
                        console.log('Updated currentVariantStock to:', window.currentVariantStock);
                        console.log('===============================');

                        // Update price display
                        if (Number(data.discounted_price) > 0) {
                            $(".old__price").show();
                            $(".price__divided").show();
                            $(".old__price").html('৳' + data.price);
                            $(".current__price").html('৳' + data.discounted_price);
                            $("#product_price").val(Number(data.price));
                            $("#product_discount_price").val(Number(data.discounted_price));
                        } else {
                            $(".price__divided").hide();
                            $(".old__price").hide();
                            $(".current__price").html('৳' + data.price);
                            $("#product_price").val(Number(data.price));
                            $("#product_discount_price").val(0);
                        }

                        // Update stock status and button
                        if (data.stock > 0) {
                            $("#stock_status_text").html("Stock in");
                            $("#stock_status_text").addClass("text-success");
                            $("#stock_status_text").removeClass("text-danger");
                            if (data.rendered_button) {
                                $("#product_details_add_to_cart_section").html(data.rendered_button);

                                // After rendering new button, check if this specific variant is in cart
                                checkCurrentVariantInCart(color_id, size_id);
                            }

                            // Update quantity input max attribute
                            $("#product_details_cart_qty").attr('max', data.stock);

                            // Only validate and adjust quantity if user has manually changed it
                            // Don't show validation message during initialization
                            var currentQty = parseInt($("#product_details_cart_qty").val()) || 1;
                            if (currentQty > data.stock && currentQty > 1 && !window.isInitializing) {
                                $("#product_details_cart_qty").val(data.stock);
                                toastr.warning(`Quantity adjusted to available stock (${data.stock})`);
                            } else if (currentQty > data.stock) {
                                // Silent adjustment during initialization or when quantity is 1
                                $("#product_details_cart_qty").val(Math.min(currentQty, data.stock));
                            }
                        } else {
                            $("#stock_status_text").html("Stock Out");
                            $("#stock_status_text").addClass("text-danger");
                            $("#stock_status_text").removeClass("text-success");
                            $("#product_details_add_to_cart_section").html(
                                "<button class='btn rounded stock_out_button'>Stock Out</button>"
                            );

                            // Update quantity input max attribute to 0 and reset value
                            $("#product_details_cart_qty").attr('max', 0);
                            $("#product_details_cart_qty").val(1);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Variant check error:', xhr.responseText);
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Error checking variant availability");

                    // Reset variant stock on error
                    window.currentVariantStock = 0;
                }
            });
        }

        // Function to check if current variant combination is in cart
        function checkCurrentVariantInCart(colorId, sizeId) {
            // Generate cart key that matches CartController format
            var cartKey = $("#product_id").val();
            if (colorId) {
                cartKey += '_c' + colorId;
            }
            if (sizeId) {
                cartKey += '_s' + sizeId;
            }

            // Check cart via AJAX
            $.ajax({
                url: "{{ route('GetCartStatus') }}",
                type: "POST",
                data: {
                    cart_key: cartKey,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var $button = $(".cart-qty-{{ $product->id }}");

                    if (response.in_cart) {
                        // This specific variant is in cart
                        $button.html("Remove from cart");
                        $button.removeClass("addToCartWithQty");
                        $button.addClass("removeFromCartQty");
                        $button.attr('data-cart-key', cartKey);

                        // Update quantity input to show cart quantity
                        if (response.quantity && $("#product_details_cart_qty").length) {
                            $("#product_details_cart_qty").val(response.quantity);
                        }
                    } else {
                        // This specific variant is not in cart
                        $button.html("Add To Cart");
                        $button.removeClass("removeFromCartQty");
                        $button.addClass("addToCartWithQty");
                        $button.removeAttr('data-cart-key');

                        // Reset quantity to 1
                        if ($("#product_details_cart_qty").length) {
                            $("#product_details_cart_qty").val(1);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Check variant in cart error:', xhr.responseText);
                    // If error, assume not in cart
                    var $button = $(".cart-qty-{{ $product->id }}");
                    $button.html("Add To Cart");
                    $button.removeClass("removeFromCartQty");
                    $button.addClass("addToCartWithQty");
                    $button.removeAttr('data-cart-key');
                }
            });
        }


        // Add input validation for manual typing
        $('body').on('input change', '#product_details_cart_qty', function() {
            // Skip validation during initialization
            if (window.isInitializing) return;

            var quantity = parseInt($(this).val()) || 1;
            var maxStock = getMaxAvailableStock();

            // Prevent unreasonably large numbers
            if (quantity > 9999) {
                $(this).val(1);
                toastr.warning("Please enter a reasonable quantity");
                return;
            }

            if (quantity < 1) {
                $(this).val(1);
                toastr.warning("Minimum quantity is 1");
                return;
            }

            // For products with variants, if no variant is selected yet, limit to reasonable number
            if (maxStock === 0 && $("input[name='color_id[]']").length > 0) {
                if (quantity > 99) { // Reasonable limit when no variant selected
                    $(this).val(99);
                    toastr.warning("Please select product variants first");
                    return;
                }
            } else if (maxStock > 0 && quantity > maxStock) {
                $(this).val(maxStock);
                toastr.warning(`Only ${maxStock} items available in stock`);
                return;
            }

            // Clear any existing timeout
            if (window.updateSidebarTimeout) {
                clearTimeout(window.updateSidebarTimeout);
            }

            // Update sidebar cart quantity if this variant is in cart (with slight delay to prevent rapid calls)
            window.updateSidebarTimeout = setTimeout(function() {
                updateSidebarQuantityIfInCart();
            }, 300);
        });

        // Function to update sidebar cart quantity when product details quantity changes
        // DISABLED: This function was causing infinite recursion - calling window.updateSidebarQuantityIfInCart
        function updateSidebarQuantityIfInCart() {
            console.log('🚫 updateSidebarQuantityIfInCart disabled to prevent infinite loop');

            // Check if the current variant is in cart by checking button state
            var $button = $(".cart-qty-{{ $product->id }}");

            console.log('🔄 updateSidebarQuantityIfInCart called');
            console.log('Button has removeFromCartQty class:', $button.hasClass("removeFromCartQty"));

            if ($button.hasClass("removeFromCartQty")) {
                var cartKey = $button.attr('data-cart-key');
                var newQuantity = parseInt($("#product_details_cart_qty").val()) || 1;

                console.log('Cart key:', cartKey);
                console.log('New quantity:', newQuantity);

                if (cartKey) {
                    // Use the unified stock system directly (removed infinite recursive call)
                    if (window.unifiedStockSystem && typeof window.unifiedStockSystem.updateCartQuantityDirectly ===
                        'function') {
                        console.log('🔄 Using unified stock system for direct sidebar update from details page.');
                        window.unifiedStockSystem.updateCartQuantityDirectly(cartKey, newQuantity);
                    } else {
                        // Enhanced fallback with better error handling
                        console.log('⚠️ Unified system not found, falling back to enhanced AJAX call.');
                        var formData = new FormData();
                        formData.append("cart_id", cartKey);
                        formData.append("cart_qty", newQuantity);
                        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

                        $.ajax({
                            data: formData,
                            url: "{{ url('update/cart/qty') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            timeout: 10000, // 10 second timeout
                            success: function(data) {
                                console.log('✅ Fallback cart update successful:', data);

                                if (data.success === false) {
                                    console.warn('⚠️ Server reported update failure:', data.message);
                                    toastr.error(data.message || 'Failed to update cart quantity');
                                    return;
                                }

                                if (data.rendered_cart) {
                                    $(".offCanvas__minicart").html(data.rendered_cart);
                                    console.log('✅ Sidebar cart HTML updated via fallback');
                                }

                                // Update checkout cart if present
                                if (data.checkoutCartItems) {
                                    $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                                    console.log('✅ Checkout cart updated via fallback');
                                }

                                if (data.checkoutTotalAmount) {
                                    $(".order-review-summary").html(data.checkoutTotalAmount);
                                    console.log('✅ Order summary updated via fallback');
                                }

                                if (data.cartTotalQty !== undefined) {
                                    $("a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count")
                                        .html(data.cartTotalQty);
                                    console.log('✅ Cart counters updated to:', data.cartTotalQty);
                                }

                                // Refresh cart status to ensure quantity is properly synced
                                setTimeout(function() {
                                    console.log('🔄 Refreshing cart status after fallback update');
                                    // Extract color and size from cart key if needed
                                    var colorId = null;
                                    var sizeId = null;

                                    var cartKeyParts = cartKey.split('_');
                                    for (var i = 0; i < cartKeyParts.length; i++) {
                                        var part = cartKeyParts[i];
                                        if (part.startsWith('c')) {
                                            colorId = part.substring(1);
                                        } else if (part.startsWith('s')) {
                                            sizeId = part.substring(1);
                                        }
                                    }

                                    checkCurrentVariantInCart(colorId, sizeId);
                                }, 500);
                            },
                            error: function(xhr, status, error) {
                                console.error('❌ Fallback update sidebar quantity error:', xhr.responseText);
                                console.error('Status:', status, 'Error:', error);

                                var errorMessage = 'Failed to update cart quantity';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                } else if (status === 'timeout') {
                                    errorMessage = 'Request timeout. Please try again.';
                                }

                                toastr.error(errorMessage);
                            }
                        });
                    }
                } else {
                    console.log('❌ No cart key found');
                }
            } else {
                console.log('ℹ️ Product not in cart (button does not have removeFromCartQty class)');
            }
        }

        // Function to get maximum available stock based on current selections
        function getMaxAvailableStock() {
            var maxStock = 0;

            // Check if product has variants
            if ($("input[name='color_id[]']").length > 0 || $("input[name='size_id[]']").length > 0) {
                // For products with variants, use the current variant stock set by checkVariantStock
                maxStock = window.currentVariantStock || 0;

                // Debug logging
                console.log('Variant product - currentVariantStock:', window.currentVariantStock, 'maxStock:', maxStock);
            } else {
                // For products without variants, use main product stock
                maxStock = {{ $product->stock }};
                console.log('Non-variant product - product stock:', maxStock);
            }

            return maxStock;
        }
    </script>

    <script type="application/ld+json">
        {
            "@context":"https://schema.org",
            "@type":"Product",
            "productID":"{{$product->id}}",
            "name":"{{$product->name}}",
            "description":"{{$product->short_description}}",
            "url":"{{ env('APP_URL') . '/product/details/' . $product->slug }}",
            "image":"{{ env('ADMIN_URL') . '/' . $product->image }}",
            "brand":"Fejmo",
            "offers": [
                {
                    "@type": "Offer",
                    "price": "{{$product->discount_price}}",
                    "priceCurrency": "BDT",
                    "itemCondition": "https://schema.org/NewCondition",
                    "availability": "https://schema.org/InStock"
                }
            ],
            "additionalProperty": [{
                "@type": "{{ $product->category_name ?? '' }}",
                "propertyID": "",
                "value": "{{ $product->category_name ?? '' }}"
            }]
        }
    </script>

    @if ($generalInfo->google_tag_manager_status)
        @php
            if ($variants && count($variants) > 0) {
                $variantMinDiscountPrice > 0
                    ? ($priceForDataLayer = $variantMinDiscountPrice)
                    : ($priceForDataLayer = $variantMinPrice);
            } else {
                $product->discount_price > 0
                    ? ($priceForDataLayer = $product->discount_price)
                    : ($priceForDataLayer = $product->price);
            }
        @endphp

        <script type="text/javascript">
            dataLayer.push({
                ecommerce: null
            }); // Clear the previous ecommerce object.
            dataLayer.push({
                event: "view_item",
                ecommerce: {
                    items: [{
                        item_name: "{{ $product->name }}", // Name or ID is required.
                        item_id: {{ $product->id }},
                        price: "{{ $priceForDataLayer }}",
                        item_brand: "{{ $product->brand_name ?? '' }}",
                        item_category: "{{ $product->category_name ?? '' }}",
                        item_category2: "",
                        item_category3: "",
                        item_category4: "",
                        item_variant: "",
                        item_list_name: "", // If associated with a list selection.
                        item_list_id: "", // If associated with a list selection.
                        index: 0, // If associated with a list selection.
                        quantity: {{ $product->stock }},
                    }]
                }
            });
        </script>
    @endif
@endsection
