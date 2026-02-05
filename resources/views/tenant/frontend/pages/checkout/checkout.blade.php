@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}
    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    {{-- Page Title & Favicon --}}
    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }} - {{ __('checkout.page_title') }}
        @else
            {{ $generalInfo->company_name }} - {{ __('checkout.page_title') }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    {{-- open graph meta --}}
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{  $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
@endpush

@section('header_css')
    <link href="{{ url('tenant/frontend') }}/css/plugins/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2-selection {
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }

        .select2 {
            width: 100% !important;
        }

        .select2 .selection {
            width: 100%;
        }

        .select2-selection {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 37px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        .select-style-2 .nice-select .list {
            max-height: 240px;
            overflow: scroll;
        }

        /* css for guest order section */
        .guest_order_alert {
            border-radius: 8px;
            padding: 10px 20px;
            position: relative;
        }

        .guest_order_alert::before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: var(--primary-color);
            opacity: 0.15;
            border-radius: 8px;
            z-index: -1
        }

        .guest_order_alert p {
            font-weight: 600;
        }

        .guest_order_alert a {
            font-weight: 600;
            color: var(--primary-color);
            margin-right: 8px;
            padding: 4px 12px;
            background: var(--white-color);
            z-index: 1;
            font-size: 14px;
            border-radius: 4px;
            transition: all .3s linear
        }

        .guest_order_alert a:hover {
            background: var(--primary-color);
            color: var(--white-color);
        }

        .guest_order_alert a:last-child {
            margin-right: 0px;
            background: var(--primary-color);
            color: var(--white-color);
        }
        /* Responsive: stack guest alert content on small screens */
        @media (max-width: 767px) {
            .guest_order_alert {
                padding: 12px;
            }

            .guest_order_alert .row {
                display: flex;
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }

            .guest_order_alert .row > [class*="col-"] {
                text-align: center !important;
            }

            .guest_order_alert .row .col-lg-6.text-end {
                text-align: center !important;
            }

            .guest_order_alert a {
                display: inline-block;
                width: 48%;
                margin: 5px 1% 0 1%;
                box-sizing: border-box;
                padding: 8px 10px;
            }

            .guest_order_alert a:last-child {
                margin-right: 1%;
            }

            .guest_order_alert p {
                margin-bottom: 6px;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    @include('tenant.frontend.pages.checkout.breadcrumbs')

    <!-- Checkout Page Area -->
    <section class="checkout-area">
        <div class="container-fluid">

            @guest('customer')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="guest_order_alert">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <p class="m-0">{{ __('checkout.have_account') }}</p>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ url('/login') }}" class="d-inline-block">{{ __('checkout.login') }}</a>
                                    <a href="{{ url('/register') }}" class="d-inline-block">{{ __('checkout.register') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

            <form action="{{ url('place/order') }}" method="post">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-xl-7 col-12">
                        <div class="checkout-order-review">
                            <h5 class="checkout-widget-title">{{ __('checkout.order_review') }}</h5>
                            <div class="checkout-order-review-inner">
                                <table style="width: 100%" class="cart-single-product-table">
                                    <thead>
                                        <tr class="cart-single-product-table-head">
                                            <th class="table-head-1" scope="col">{{ __('checkout.product_name') }}</th>
                                            <th class="table-head-0" scope="col">{{ __('checkout.image') }}</th>
                                            <th class="table-head-2" scope="col">{{ __('checkout.quantity') }}</th>
                                            <th class="table-head-3" scope="col">{{ __('checkout.unit_price') }}</th>
                                            <th class="table-head-4" scope="col">{{ __('checkout.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('tenant.frontend.pages.checkout.cart_items')
                                    </tbody>
                                </table>
                                <div class="checkout-review-table-bottom">
                                    <div class="row g-0">

                                        <div class="col-lg-5 col-md-8 col-12">
                                            @include('tenant.frontend.pages.checkout.coupon')
                                        </div>

                                        <div class="col-lg-5 offset-lg-2 col-md-8 col-12">
                                            <div class="order-review-summary">
                                                @include('tenant.frontend.pages.checkout.order_total')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout-special-note">
                                <h5 class="checkout-widget-title">{{ __('checkout.special_notes') }}</h5>
                                <div class="checkout-special-note-box">
                                    <div class="form-group">
                                        <textarea name="special_note" placeholder="{{ __('checkout.special_notes_placeholder') }}"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-4 offset-xl-1 col-md-10 col-12 order-class">

                        @include('tenant.frontend.pages.checkout.order_form')

                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End Checkout Page Area -->
@endsection

@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/plugins/select2.min.js"></script>
    <script>
        $('[data-toggle="select2"]').select2();

        function removeCartItems(id) {
            $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {

                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("{{ __('checkout.item_removed') }}");
                $(".offCanvas__minicart").html(data.rendered_cart);
                $("a.minicart__open--btn span.items__count").html(data.cartTotalQty);

                $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                $(".order-review-summary").html(data.checkoutTotalAmount);

                // Update coupon section if coupon data is available
                if (data.checkoutCoupon) {
                    $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                }

                // Check if cart is now empty and remove coupon if applied
                if (data.cartTotalQty <= 0) {
                    // Auto-remove coupon if cart is empty
                    if (sessionStorage.getItem('coupon_applied') === 'true') {
                        console.log('🛒 Cart is empty - removing coupon automatically');

                        $.ajax({
                            url: "{{ url('remove/coupon') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                auto_remove_reason: 'cart_empty',
                                @guest('customer')
                                    guest_checkout: 1
                                @endguest
                            },
                            success: function() {
                                sessionStorage.removeItem('coupon_applied');
                                $("#coupon_code").val('');
                                toastr.info('{{ __('checkout.coupon_removed_cart_empty') }}', '{{ __('checkout.coupon_removed') }}');
                            },
                            error: function() {
                                sessionStorage.removeItem('coupon_applied');
                                $("#coupon_code").val('');
                            }
                        });
                    }

                    setTimeout(function() {
                        window.location.href = '{{ url('/') }}';
                    }, 1000);
                }
            })
        }

        // Global coupon timer management
        let globalCouponTimer = null;

        window.startCouponTimer = function() {
            // Clear any existing timer
            if (globalCouponTimer) {
                clearTimeout(globalCouponTimer);
            }

            // Start 60-minute timer
            globalCouponTimer = setTimeout(function() {
                console.log('⏰ 60 minutes elapsed - removing coupon automatically');
                window.removeCouponAutomatically('time_expired');
            }, 60 * 60 * 1000); // 60 minutes in milliseconds

            console.log('⏱️ Started global 60-minute coupon timer');
        };

        window.removeCouponAutomatically = function(reason = 'auto_remove') {
            if (sessionStorage.getItem('coupon_applied') === 'true') {
                console.log('🗑️ Auto-removing coupon due to:', reason);

                $.ajax({
                    url: "{{ url('remove/coupon') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        auto_remove_reason: reason,
                        @guest('customer')
                            guest_checkout: 1
                        @endguest
                    },
                    success: function(data) {
                        // Update order total
                        if (data.checkoutTotalAmount) {
                            $(".order-review-summary").html(data.checkoutTotalAmount);
                        }

                        // Update coupon section to remove warning message
                        if (data.checkoutCoupon) {
                            $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                        }

                        // Clear session storage
                        sessionStorage.removeItem('coupon_applied');

                        // Clear coupon input
                        $("#coupon_code").val('');

                        // Show notification based on reason
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.timeOut = 3000;

                        if (reason === 'time_expired') {
                            toastr.warning('Coupon expired after 60 minutes of inactivity',
                                'Coupon Removed');
                        } else if (reason === 'cart_empty') {
                            toastr.info('Coupon removed - cart is empty', 'Coupon Removed');
                        } else {
                            toastr.info('Coupon removed automatically', 'Coupon Removed');
                        }

                        console.log('✅ Coupon removed successfully');
                    },
                    error: function() {
                        console.log('⚠️ Error removing coupon, clearing local storage anyway');
                        sessionStorage.removeItem('coupon_applied');
                        $("#coupon_code").val('');
                    }
                });
            }

            // Clear the timer
            if (globalCouponTimer) {
                clearTimeout(globalCouponTimer);
                globalCouponTimer = null;
            }
        };

        function applyCoupon() {
            var couponCode = $("#coupon_code").val();
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1000;

            if (couponCode == '') {
                toastr.error("{{ __('checkout.enter_valid_coupon') }}");
                return false;
            }

            var formData = new FormData();
            formData.append("coupon_code", couponCode);
            $.ajax({
                data: formData,
                url: "{{ url('apply/coupon') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == 0) {
                        toastr.error(data.message);
                        $(".order-review-summary").html(data.checkoutTotalAmount);

                        // Update coupon section to remove any previous warning messages
                        if (data.checkoutCoupon) {
                            $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                        }

                        sessionStorage.removeItem('coupon_applied');
                    } else {
                        toastr.success(data.message);
                        $(".order-review-summary").html(data.checkoutTotalAmount);

                        // Update coupon section to show any new warning messages
                        if (data.checkoutCoupon) {
                            $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                        }

                        // Track that coupon is applied
                        sessionStorage.setItem('coupon_applied', 'true');
                        // Trigger timer start event for enhanced coupon management
                        if (typeof window.startCouponTimer === 'function') {
                            window.startCouponTimer();
                        }
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        }

        $(document).ready(function() {
            // Auto-remove coupon after 60 minutes (3600 seconds)
            let couponTimer = null;

            function startCouponTimer() {
                // Clear any existing timer
                if (couponTimer) {
                    clearTimeout(couponTimer);
                }

                // Start 60-minute timer
                couponTimer = setTimeout(function() {
                    console.log('⏰ 60 minutes elapsed - removing coupon automatically');
                    removeCouponAutomatically('time_expired');
                }, 60 * 60 * 1000); // 60 minutes in milliseconds

                console.log('⏱️ Started 60-minute coupon timer');
            }

            function removeCouponAutomatically(reason = 'auto_remove') {
                if (sessionStorage.getItem('coupon_applied') === 'true') {
                    console.log('🗑️ Auto-removing coupon due to:', reason);

                    $.ajax({
                        url: "{{ url('remove/coupon') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            auto_remove_reason: reason,
                            @guest('customer')
                                guest_checkout: 1
                            @endguest
                        },
                        success: function(data) {
                            // Update order total
                            if (data.checkoutTotalAmount) {
                                $(".order-review-summary").html(data.checkoutTotalAmount);
                            }

                            // Update coupon section to remove warning message
                            if (data.checkoutCoupon) {
                                $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                            }

                            // Clear session storage
                            sessionStorage.removeItem('coupon_applied');

                            // Clear coupon input
                            $("#coupon_code").val('');

                            // Show notification based on reason
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.options.timeOut = 3000;

                            if (reason === 'time_expired') {
                                toastr.warning('{{ __('checkout.coupon_expired') }}',
                                    '{{ __('checkout.coupon_removed') }}');
                            } else if (reason === 'cart_empty') {
                                toastr.info('{{ __('checkout.coupon_removed_cart_empty') }}', '{{ __('checkout.coupon_removed') }}');
                            } else {
                                toastr.info('{{ __('checkout.coupon_removed') }}', '{{ __('checkout.coupon_removed') }}');
                            }

                            console.log('✅ Coupon removed successfully');
                        },
                        error: function() {
                            console.log('⚠️ Error removing coupon, clearing local storage anyway');
                            sessionStorage.removeItem('coupon_applied');
                            $("#coupon_code").val('');
                        }
                    });
                }

                // Clear the timer
                if (couponTimer) {
                    clearTimeout(couponTimer);
                    couponTimer = null;
                }
            }

            // Check if coupon is applied on page load and start timer
            if (sessionStorage.getItem('coupon_applied') === 'true') {
                startCouponTimer();
            }

            // Auto-remove coupon when input field is cleared
            $('#coupon_code').on('input', function() {
                const couponCode = $(this).val().trim();

                // If input is cleared and coupon was applied, remove it
                if (couponCode === '' && sessionStorage.getItem('coupon_applied') === 'true') {
                    console.log('🗑️ Coupon input cleared - removing coupon automatically');

                    $.ajax({
                        url: "{{ url('remove/coupon') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            auto_remove_reason: 'input_cleared',
                            @guest('customer')
                                guest_checkout: 1
                            @endguest
                        },
                        success: function(data) {
                            // Update order total
                            if (data.checkoutTotalAmount) {
                                $(".order-review-summary").html(data.checkoutTotalAmount);
                            }

                            // Update coupon section if available
                            if (data.checkoutCoupon) {
                                $(".checkout-order-review-coupon-box").html(data
                                .checkoutCoupon);
                            }

                            // Clear session storage
                            sessionStorage.removeItem('coupon_applied');

                            // Show notification
                            toastr.options.positionClass = 'toast-top-right';
                            toastr.options.timeOut = 2000;
                            toastr.info('Coupon removed', 'Coupon Cleared');

                            // Clear the timer
                            if (couponTimer) {
                                clearTimeout(couponTimer);
                                couponTimer = null;
                            }

                            console.log('✅ Coupon removed due to input being cleared');
                        },
                        error: function() {
                            console.log(
                                '⚠️ Error removing coupon, clearing local storage anyway');
                            sessionStorage.removeItem('coupon_applied');

                            // Clear the timer
                            if (couponTimer) {
                                clearTimeout(couponTimer);
                                couponTimer = null;
                            }
                        }
                    });
                }
            });

            // Override the applyCoupon function to start timer when coupon is applied
            window.originalApplyCoupon = window.applyCoupon;
            window.applyCoupon = function() {
                var couponCode = $("#coupon_code").val();
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;

                if (couponCode == '') {
                    toastr.error("Please Enter a Coupon Code");
                    return false;
                }

                var formData = new FormData();
                formData.append("coupon_code", couponCode);
                $.ajax({
                    data: formData,
                    url: "{{ url('apply/coupon') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 0) {
                            toastr.error(data.message);
                            $(".order-review-summary").html(data.checkoutTotalAmount);

                            // Update coupon section to remove any previous warning messages
                            if (data.checkoutCoupon) {
                                $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                            }

                            sessionStorage.removeItem('coupon_applied');
                        } else {
                            toastr.success(data.message);
                            $(".order-review-summary").html(data.checkoutTotalAmount);

                            // Update coupon section to show any new warning messages
                            if (data.checkoutCoupon) {
                                $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
                            }

                            // Track that coupon is applied
                            sessionStorage.setItem('coupon_applied', 'true');
                            // Start the 60-minute timer
                            startCouponTimer();
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            };

            // Override removeCartItems function to check if cart becomes empty
            window.originalRemoveCartItems = window.removeCartItems;
            window.removeCartItems = function(id) {
                $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Item is Removed");
                    $(".offCanvas__minicart").html(data.rendered_cart);
                    $("a.minicart__open--btn span.items__count").html(data.cartTotalQty);

                    $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                    $(".order-review-summary").html(data.checkoutTotalAmount);

                    // Check if cart is now empty and remove coupon if applied
                    if (data.cartTotalQty <= 0) {
                        // Auto-remove coupon if cart is empty
                        removeCouponAutomatically('cart_empty');

                        setTimeout(function() {
                            window.location.href = '{{ url('/') }}';
                        }, 1000);
                    }
                });
            };

            // Reset timer on any activity (optional - keeps coupon active if user is active)
            let activityEvents = ['click', 'keypress', 'scroll', 'mousemove'];
            let lastActivity = Date.now();

            activityEvents.forEach(event => {
                document.addEventListener(event, function() {
                    lastActivity = Date.now();
                }, true);
            });

            // Check for inactivity every 5 minutes and restart timer if user was active
            setInterval(function() {
                if (sessionStorage.getItem('coupon_applied') === 'true') {
                    let inactiveTime = Date.now() - lastActivity;
                    // If user was active in last 5 minutes, restart the timer
                    if (inactiveTime < 5 * 60 * 1000) { // 5 minutes
                        console.log('🔄 User activity detected, restarting coupon timer');
                        startCouponTimer();
                    }
                }
            }, 5 * 60 * 1000); // Check every 5 minutes

            // Clear any existing coupon when entering checkout page (fresh start)
            // This ensures coupons don't persist from previous sessions
            // $.ajax({
            //     url: "{{ url('remove/coupon') }}",
            //     type: "POST",
            //     data: {
            //         _token: '{{ csrf_token() }}',
            //         @guest
            //         guest_checkout: 1
            //         @endguest
            //     },
            //     success: function () {
            //         // Clear the tracking as well
            //         sessionStorage.removeItem('coupon_applied');
            //         // Clear the coupon input field
            //         $("#coupon_code").val('');
            //     },
            //     error: function() {
            //         // Silent fail - coupon might not exist
            //         sessionStorage.removeItem('coupon_applied');
            //     }
            // });

            // Remove coupon from session when leaving checkout page
            // window.addEventListener('beforeunload', function(e) {
            //     // Only remove coupon if there's one applied
            //     if (sessionStorage.getItem('coupon_applied') === 'true') {
            //         navigator.sendBeacon("{{ url('remove/coupon') }}", 
            //             new URLSearchParams({
            //                 _token: '{{ csrf_token() }}',
            //                 @guest
            //                 guest_checkout: 1
            //                 @endguest
            //             })
            //         );
            //     }
            // });

            // window.addEventListener('pagehide', function(e) {
            //     // Only remove coupon if there's one applied
            //     if (sessionStorage.getItem('coupon_applied') === 'true') {
            //         fetch("{{ url('remove/coupon') }}", {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/x-www-form-urlencoded',
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             body: new URLSearchParams({
            //                 @guest
            //                 guest_checkout: 1
            //                 @endguest
            //             }),
            //             keepalive: true
            //         });
            //     }
            // });

            // Also handle visibility change for mobile browsers
            // document.addEventListener('visibilitychange', function() {
            //     if (document.hidden && sessionStorage.getItem('coupon_applied') === 'true') {
            //         window.couponTimer = setTimeout(function() {
            //             fetch("{{ url('remove/coupon') }}", {
            //                 method: 'POST',
            //                 headers: {
            //                     'Content-Type': 'application/x-www-form-urlencoded',
            //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //                 },
            //                 body: new URLSearchParams({
            //                     @guest
            //                     guest_checkout: 1
            //                     @endguest
            //                 }),
            //                 keepalive: true
            //             }).then(() => {
            //                 sessionStorage.removeItem('coupon_applied');
            //             });
            //         }, 3000); // 3 second delay
            //     } else {
            //         // Clear timer when page becomes visible again
            //         if (window.couponTimer) {
            //             clearTimeout(window.couponTimer);
            //         }
            //     }
            // });

            $('#shipping_district_id').on('change', function() {
                var district_id = this.value;
                $("#shipping_thana_id").html('');
                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#shipping_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>'
                            );
                        $.each(result.data, function(key, value) {
                            // Use the localized name returned from server
                            $("#shipping_thana_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $(".order-review-summary").html(result.checkoutTotalAmount);
                    }
                });
            });

            $('#billing_district_id').on('change', function() {
                var district_id = this.value;
                $("#billing_thana_id").html('');
                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#billing_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>'
                            );
                        $.each(result.data, function(key, value) {
                            $("#billing_thana_id").append('<option value="' + value.id +
                                '">' +
                                value.name + '</option>');
                        });
                    }
                });
            });
        });

        function applySavedAddress(slug) {

            // fetching the values
            var address = $("#saved_address_line_" + slug).val();
            var district = $("#saved_address_district_" + slug).val();
            var districtId = $("#saved_address_district_id_" + slug).val();
            var upazila = $("#saved_address_upazila_" + slug).val();
            var upazilaId = $("#saved_address_upazila_id_" + slug).val();
            var post_code = $("#saved_address_post_code_" + slug).val();

            // setting the values
            $("#shipping_address").val(address);
            $("#shipping_postal_code").val(post_code);
            
            // Select district by ID if available, otherwise fallback to text matching
            if (districtId && districtId !== '') {
                $("#shipping_district_id").val(districtId).trigger('change.select2');
                
                // Load thanas for selected district
                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: districtId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#shipping_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#shipping_thana_id").append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                        
                        // Select the thana by ID if available
                        if (upazilaId && upazilaId !== '') {
                            $("#shipping_thana_id").val(upazilaId).trigger('change.select2');
                        }
                        
                        $(".order-review-summary").html(result.checkoutTotalAmount);
                    }
                });
            } else {
                // Fallback to text matching if district ID not available
                var districtOption = $("#shipping_district_id option").filter(function() {
                    return $(this).text().trim() === district.trim();
                });
                
                if (districtOption.length > 0) {
                    var districtIdFromText = districtOption.val();
                    $("#shipping_district_id").val(districtIdFromText).trigger('change.select2');
                    
                    $.ajax({
                        url: "{{ url('/district/wise/thana') }}",
                        type: "POST",
                        data: {
                            district_id: districtIdFromText,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#shipping_thana_id').html(
                                '<option data-display="Select One" value="">Select Thana</option>'
                            );
                            $.each(result.data, function(key, value) {
                                $("#shipping_thana_id").append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                            
                            var thanaOption = $("#shipping_thana_id option").filter(function() {
                                return $(this).text().trim() === upazila.trim();
                            });
                            if (thanaOption.length > 0) {
                                $("#shipping_thana_id").val(thanaOption.val()).trigger('change.select2');
                            }
                            
                            $(".order-review-summary").html(result.checkoutTotalAmount);
                        }
                    });
                }
            }

            var isChecked = $('#flexCheckChecked').prop('checked');
            if (isChecked) {
                $('#flexCheckChecked').trigger('click');
            }

        }

        function sameShippingBilling() {

            if ($("#flexCheckChecked").prop('checked') == true) {
                var shppingAdress = $("#shipping_address").val();
                var shppingDistrict = $("#shipping_district_id").val();
                var shippingThana = $("#shipping_thana_id").val();
                var shppingPostalCode = $("#shipping_postal_code").val();

                if (shppingAdress == '' || shppingAdress == null) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Write Shipping Address");
                    return false;
                }
                if (!shppingDistrict || shppingDistrict == "" || shppingDistrict == null) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Select Shipping District");
                    return false;
                }
                if (shippingThana == '' || shippingThana == null) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Select Shipping Thana");
                    return false;
                }

                $("#billing_address").val(shppingAdress);
                $("#billing_district_id").val(shppingDistrict).change();
                $("#billing_postal_code").val(shppingPostalCode);

                var district_id = shppingDistrict;
                $("#billing_thana_id").html('');

                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#billing_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>');
                        $.each(result.data, function(key, value) {
                            $("#billing_thana_id").append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        $("#billing_thana_id").val(shippingThana).change();
                        $(".order-review-summary").html(result.checkoutTotalAmount);
                    }
                });

            } else {
                $("#billing_address").val(shppingAdress);
                $("#billing_district_id").val('').change();
                $("#billing_thana_id").html('');
                $('#billing_thana_id').html('<option data-display="Select One" value="">Select Thana</option>');
                $("#billing_postal_code").val('');
            }

        }

        function changeDeliveryMethod(value) {

            var district_id = $("#shipping_district_id").val();
            var delivery_method = value;

            // Show/hide outlet selection based on delivery method
            if (delivery_method == 2) {
                // Store pickup selected - show outlet selection
                $("#outlet_selection_container").show();
                $("#outlet_id").attr('required', true);
                console.log('🏪 Store pickup selected - showing outlet selection');
            } else {
                // Home delivery selected - hide outlet selection
                $("#outlet_selection_container").hide();
                $("#outlet_id").attr('required', false);
                $("#outlet_id").val('').trigger('change'); // Clear selection
                console.log('🏠 Home delivery selected - hiding outlet selection');
            }

            $.ajax({
                 url: "{{ route('ChangeDeliveryMethod') }}",
                type: "POST",
                data: {
                    district_id: district_id,
                    delivery_method: delivery_method,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $(".order-review-summary").html(result.checkoutTotalAmount);
                }
            });
        }

        function validateAllOrderFields() {

            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var shppingAdress = $("#shipping_address").val();
            var shppingDistrict = $("#shipping_district_id").val();
            var shippingThana = $("#shipping_thana_id").val();
            var payment_method = $("input[name='payment_method']:checked").val();
            var delivery_method = $("input[name='delivery_method']:checked").val();
            var flexCheckChecked = $("#flexCheckChecked2").is(":checked");
            console.log(flexCheckChecked);

            if (name == '' || name == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Write Your Full Name");
                return false;
            }
            if (email == '' || email == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Write Your Email Address");
                return false;
            }
            if (phone == '' || phone == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Write Your Phone Number");
                return false;
            }
            if (shppingAdress == '' || shppingAdress == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Write Shipping Address");
                return false;
            }
            if (!shppingDistrict || shppingDistrict == "" || shppingDistrict == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Shipping District");
                return false;
            }
            if (shippingThana == '' || shippingThana == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Shipping Thana");
                return false;
            }
            if (payment_method == '' || payment_method == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Payment Method");
                return false;
            }
            if (delivery_method == '' || delivery_method == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Delivery Method");
                return false;
            }

            // Validate outlet selection for store pickup
            if (delivery_method == '2') {
                var outlet_id = $("#outlet_id").val();
                if (outlet_id == '' || outlet_id == null) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Select Pickup Outlet");
                    return false;
                }
            }

            if (flexCheckChecked == '' || flexCheckChecked == null) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Accept Terms and Conditions");
                return false;
            }

            const placeOrderBtn = document.querySelector(".checkout-order-review-button button[type='button']");
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerText = "Processing..."; // Optional for UX

            // Clear coupon timer since order is being placed
            if (typeof window.globalCouponTimer !== 'undefined' && window.globalCouponTimer) {
                clearTimeout(window.globalCouponTimer);
                window.globalCouponTimer = null;
                console.log('🛍️ Order being placed - coupon timer cleared');
            }

            $("#actual_order_place_btn").click();
        }
    </script>

    @php $cartTotal = 0 @endphp
    @foreach ((array) session('cart') as $id => $details)
        @php
            $cartTotal +=
                ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) *
                $details['quantity'];
        @endphp
    @endforeach

    @if ($generalInfo->google_tag_manager_status)
        <script type="text/javascript">
            dataLayer.push({
                ecommerce: null
            }); // Clear the previous ecommerce object.
            dataLayer.push({
                event: "begin_checkout",
                ecommerce: {
                    value: "{{ $cartTotal }}",
                    items: [
                        @foreach (session('cart') as $id => $details)
                            {
                                item_name: "{{ $details['name'] }}",
                                item_id: "{{ $id }}",
                                price: "{{ $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'] }}",
                                item_brand: "{{ $details['brand_name'] ?? '' }}",
                                item_category: "{{ $details['category_name'] ?? '' }}",
                                item_category2: "",
                                item_category3: "",
                                item_category4: "",
                                item_variant: "",
                                item_list_name: "", // If associated with a list selection.
                                item_list_id: "", // If associated with a list selection.
                                index: 0, // If associated with a list selection.
                                quantity: {{ $details['quantity'] }}
                            },
                        @endforeach
                    ]
                }
            });
        </script>
    @endif
@endsection
