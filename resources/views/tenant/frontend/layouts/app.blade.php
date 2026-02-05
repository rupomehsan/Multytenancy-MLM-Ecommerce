<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Start Meta Data -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="mqojk4x0lp4wedg7z9z54dbk94ikpt" />
    <!-- End Meta Data -->

    <!-- SEO Meta Tags Component (auto-injected from SeoService) -->
    @php
        $siteSeo = trim($__env->yieldPushContent('site-seo'));
    @endphp

    @if (stripos($siteSeo, '<title') !== false)
        {{-- If pushed site-seo contains a <title>, prefer it and skip the default component --}}
        {!! $siteSeo !!}
    @else
        <x-seo />
        {!! $siteSeo !!}
    @endif

    <!-- CSS -->
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/maginific-popup.min.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/glightbox.min.css">
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/fancybox.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/nice-select.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/datepicker.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/icofont.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/plugins/uicons.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/style.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/responsive.css">
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/toastr.min.css">
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/custom.css?v={{ rand(1000, 9999) }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-messaging.js";

        const firebaseConfig = {
            apiKey: "AIzaSyACRysAnd0JxaigGFRZ3mGyjm16IcPg5zI",
            authDomain: "test-ce6d4.firebaseapp.com",
            projectId: "test-ce6d4",
            storageBucket: "test-ce6d4.firebasestorage.app",
            messagingSenderId: "680663384330",
            appId: "1:680663384330:web:4d237479cf6fad9149faf3",
            measurementId: "G-98N77NZEL8"
        };

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        const vapidKey = "BNAZEVRTpDufjaL5bD0Ja0-nHbs_2jvl8zPFGik-ncXCrWvOqX1DKq5k_rzRxjx7Xqe4xZ-gcPhY25NJLjVUzj4";

        // Ask for permission and get token
        async function initFirebaseMessaging() {
            try {
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {

                    // ✅ Wait for service worker registration and pass it to getToken
                    const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js?v=1.1.1');
                    console.log('Service Worker registered with scope:', registration.scope);

                    const token = await getToken(messaging, {
                        vapidKey,
                        serviceWorkerRegistration: registration
                    });


                    console.log('FCM Token:', token);

                    await fetch('/save-fcm-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                        },
                        body: JSON.stringify({
                            token: token
                        })
                    });

                } else {
                    console.warn('Notification permission not granted.');
                }
            } catch (err) {
                console.error('FCM Error:', err);
            }
        }

        initFirebaseMessaging();

        onMessage(messaging, (payload) => {
            console.log('Foreground message received:', payload);

            const title = payload?.data?.title || 'New Notification';
            const body = payload?.data?.body || ''; // Safe default
            const icon = payload?.data?.icon || '/logo.jpg';
            const link = payload?.data?.link || '/';

            if (Notification.permission === 'granted') {
                try {
                    const notification = new Notification(title, {
                        body: body,
                        icon: icon,
                    });

                    notification.onclick = () => {
                        window.open(link, '_blank');
                    };
                } catch (e) {
                    console.error('Notification error:', e);
                }
            } else {
                alert(`${title}\n${body}`);
            }
        });
    </script>




    @yield('header_css')

    <style>
        :root {
            --primary-color: {{ optional($generalInfo)->primary_color ?? '#007bff' }};
            --secondary-color: {{ optional($generalInfo)->secondary_color ?? '#6c757d' }};
            --tertiary-color: {{ optional($generalInfo)->tertiary_color ?? '#ffffff' }};
            --title-color: {{ optional($generalInfo)->title_color ?? '#212529' }};
            --paragraph-color: {{ optional($generalInfo)->paragraph_color ?? '#6c757d' }};
            --border-color: {{ optional($generalInfo)->border_color ?? '#dee2e6' }};
        }

        .toast {
            font-size: 14px;
        }

        /* default pagination start */
        .page-link {
            font-size: 20px !important;
            padding: 8px 10px;
        }

        .active>.page-link,
        .page-link.active {
            color: white !important;
            background-color: {{ optional($generalInfo)->primary_color ?? '#007bff' }} !important;
            border-color: {{ optional($generalInfo)->primary_color ?? '#007bff' }} !important;
        }

        .page-link {
            color: {{ optional($generalInfo)->primary_color ?? '#007bff' }} !important;
        }

        /* default pagination end */

        .product__items--action__btn.add__to--cart.removeFromCart {
            background: var(--alert-color) !important;
            border-color: var(--alert-color) !important;
            border-radius: 4px;
            color: white !important;
            font-weight: 600;
        }

        /* css for stock out button */
        ul.product__items--action li.product__items--action__list a.stock_out_btn {
            color: var(--alert-color) !important;
            border-color: var(--alert-color);
        }

        ul.product__items--action li.product__items--action__list a.stock_out_btn:hover {
            background: white;
            border-color: var(--alert-color);
            cursor: no-drop;
        }

        ul.product__items--action li.product__items--action__list a.stock_out_btn:hover span {
            color: var(--alert-color);
        }

        {!! optional($generalInfo)->custom_css ?? '' !!}
    </style>

    @if (optional($generalInfo)->google_tag_manager_status)
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ optional($generalInfo)->google_tag_manager_id ?? '' }}');
        </script>
        <!-- End Google Tag Manager-->
    @endif

    @if (optional($generalInfo)->google_analytic_status)
        <!-- Google tag (gtag.js) google analytics -->
        <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ optional($generalInfo)->google_analytic_tracking_id ?? '' }}"
            type="53191a76ba85f8f784cbe351-text/javascript"></script>
        <script type="53191a76ba85f8f784cbe351-text/javascript">
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config','{{ optional($generalInfo)->google_analytic_tracking_id ?? '' }}');
        </script>
    @endif

    @if (optional($generalInfo)->fb_pixel_status)
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ optional($generalInfo)->fb_pixel_app_id ?? '' }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ optional($generalInfo)->fb_pixel_app_id ?? '' }}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    @if (optional($generalInfo)->tawk_chat_status)
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ optional($generalInfo)->tawk_chat_link ?? '' }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    @endif

    {!! optional($generalInfo)->header_script ?? '' !!}

</head>

<body>

    @if (optional($generalInfo)->google_tag_manager_status)
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe
                src="https://www.googletagmanager.com/ns.html?id={{ optional($generalInfo)->google_tag_manager_id ?? '' }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    @if (optional($generalInfo)->messenger_chat_status)
        <a href="https://m.me/fejmo" target="_blank"
            style="position: fixed; right: 25px; width: 60px; bottom: 20px; z-index: 99999;">
            <img src="{{ url('tenant/frontend') }}/img/messenger_icon.png" style="width: 100px">
        </a>
    @endif

    @stack('user_dashboard_menu')

    @include('tenant.frontend.layouts.partials.header')

    @stack('upper_content')

    <main class="main__content_wrapper">
        @yield('content')
    </main>

    @include('tenant.frontend.layouts.partials.footer')

    <!-- Scroll top bar -->
    <button id="scroll__top">
        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                d="M112 244l144-144 144 144M256 120v292" />
        </svg>
    </button>

    @php
        $popUpBanner = DB::table('banners')->where('type', 2)->where('position', 'popup')->where('status', 1)->first();
    @endphp

    <!-- Start Popup Modal -->
    @if (isset($popUpBanner) && $popUpBanner && $popUpBanner->image)
        <div id="newsletter-popup" class="newsletter-popup hidden">
            <div class="popup-content">
                <span id="close-popup" class="close-popup-btn">&times;</span>
                <a href="#" class="popup-img">
                    <img src="{{  $popUpBanner->image }}" alt="banner-1" />
                </a>
                <div class="dont-show">
                    <input type="checkbox" id="dont-show-checkbox" />
                    <label for="dont-show-checkbox">Don't show again.</label>
                </div>
            </div>
        </div>
    @endif
    <!-- End Popup Modal -->

    <!-- All Script JS Plugins here  -->
    <script src="{{ url('tenant/frontend') }}/js/vendor/bootstrap.min.js" defer="defer"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/jquery.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/jquery-migrate.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/vendor/popper.js" defer="defer"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/modernizer.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/wow.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/jquery.counterup.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/waypoints.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/nice-select.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/jquery.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/swiper-bundle.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/glightbox.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/bootstrap-datepicker.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/glightbox.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/magnific-popup.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/owl.carousel.min.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/plugins/active.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/script.js"></script>

    <!-- SIMPLE Cart Sync System - replaces the broken unified system -->
    <script src="{{ url('tenant/frontend/js/unified-stock-system.js') }}"></script>
    <!-- SIMPLE SYSTEM DISABLED: <script src="{{ url('tenant/frontend/js/simple-cart-sync.js') }}"></script> -->


    <!-- Popup Modal JS -->
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const popup = document.getElementById("newsletter-popup");
            const closeBtn = document.getElementById("close-popup");
            const dontShowCheckbox = document.getElementById("dont-show-checkbox");

            // Function to show the popup
            const showPopup = () => {
                const dontShow = localStorage.getItem("dontShowPopup");
                const lastClosedTime = localStorage.getItem("popupClosedAt");
                const currentTime = Date.now();

                if (!dontShow) {
                    // Show the popup only if 8 seconds have passed since last closed
                    if (!lastClosedTime || currentTime - lastClosedTime >= 8000) {
                        popup.classList.remove("hidden");
                    }
                }
            };

            // Check every second if the popup should be shown
            setInterval(showPopup, 2000);

            // Close the popup
            closeBtn.addEventListener("click", () => {
                popup.classList.add("hidden");

                // If the checkbox is checked, set a flag to not show the popup again
                if (dontShowCheckbox.checked) {
                    localStorage.setItem("dontShowPopup", true);
                } else {
                    // Record the current time in localStorage
                    localStorage.setItem("popupClosedAt", Date.now());
                }
            });
        });
    </script>


    {{-- for lazy load image --}}
    <script>
        function renderLazyImage() {
            var lazyloadImages;
            if ("IntersectionObserver" in window) {
                lazyloadImages = document.querySelectorAll(".lazy");
                var imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var image = entry.target;
                            image.src = image.dataset.src;
                            image.classList.remove("lazy");
                            imageObserver.unobserve(image);
                        }
                    });
                });

                lazyloadImages.forEach(function(image) {
                    imageObserver.observe(image);
                });
            } else {
                var lazyloadThrottleTimeout;
                lazyloadImages = document.querySelectorAll(".lazy");

                function lazyload() {
                    if (lazyloadThrottleTimeout) {
                        clearTimeout(lazyloadThrottleTimeout);
                    }

                    lazyloadThrottleTimeout = setTimeout(function() {
                        var scrollTop = window.pageYOffset;
                        lazyloadImages.forEach(function(img) {
                            if (img.offsetTop < (window.innerHeight + scrollTop)) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                            }
                        });
                        if (lazyloadImages.length == 0) {
                            document.removeEventListener("scroll", lazyload);
                            window.removeEventListener("resize", lazyload);
                            window.removeEventListener("orientationChange", lazyload);
                        }
                    }, 20);
                }

                document.addEventListener("scroll", lazyload);
                window.addEventListener("resize", lazyload);
                window.addEventListener("orientationChange", lazyload);
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            renderLazyImage();
        })
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    {{-- cart related function --}}
    <script>
        function closeMiniCart() {
            $($('.offCanvas__minicart')[0]).removeClass('active');
            $('body').removeClass('offCanvas__minicart_active');
        }

        // Legacy cart handlers moved to unified cart system
        // The following cart operations are now handled by UnifiedStockSystem:
        // - .addToCart click handler -> handleSimpleAddToCart()
        // - .removeFromCart click handler -> handleRemoveFromCart()
        // All functionality is now in /public/js/unified-stock-system.js


        $('body').on('click', '.sidebar-product-remove', function() {
            var id = $(this).data('id');
            var cartItem = this.closest(".minicart__product--items");

            $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {
                $(".offCanvas__minicart").html(data.rendered_cart);
                $("a.minicart__open--btn span.items__count").html(data.cartTotalQty)
                // cartSidebarQtyButtons();
                $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                $(".order-review-summary").html(data.checkoutTotalAmount);

            })

            $('.cart-' + id).html(
                "<i class='fi fi-rr-shopping-cart product__items--action__btn--svg'></i><span class='add__to--cart__text'> Add to cart</span>"
            );
            $('.cart-' + id).attr('data-id', id).removeClass("removeFromCart");
            $('.cart-' + id).attr('data-id', id).addClass("addToCart");
            $('.cart-' + id).blur();

            $('.cart-qty-' + id).html("Add to cart");
            $('.cart-qty-' + id).attr('data-id', id).removeClass("removeFromCartQty");
            $('.cart-qty-' + id).attr('data-id', id).addClass("addToCartWithQty");
            $('.cart-qty-' + id).blur();
        });


        const updateCartUrl = "{{ url('update/cart/qty') }}";

        // Delegate quantity handling to unified system if available
        $('body').on('click', '.quantity__value', function(e) {
            // Check if unified stock system is handling this
            if (typeof window.unifiedStockSystem !== 'undefined') {
                console.log('🔄 Delegating quantity control to unified system');
                // Stop this handler from executing and let unified system handle it
                e.stopImmediatePropagation();
                return false;
            }

            // Fallback for when unified system is not available
            console.log('📋 Using fallback quantity handler from master.blade.php');

            var id = $(this).data('id');
            var quantityInput = this.parentElement.querySelector("input");
            var currentQuantity = parseInt(quantityInput.value);

            if (this.classList.contains("decrease")) {
                quantityInput.value = Math.max(currentQuantity - 1, 1);
            } else if (this.classList.contains("increase")) {
                quantityInput.value = currentQuantity + 1;
            }

            // in product details page qty button
            $("#product_details_cart_qty").val(quantityInput.value);

            var formData = new FormData();
            formData.append("cart_id", id);
            formData.append("cart_qty", quantityInput.value);
            $.ajax({
                data: formData,
                url: updateCartUrl,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    updateCartTotal();
                    // cartSidebarQtyButtons();
                    $(".offCanvas__minicart").html(data.rendered_cart);
                    $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                    $(".order-review-summary").html(data.checkoutTotalAmount);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            // $("#quantity-number-" + id).html(quantityInput.value);
        });


        function updateCartTotal() {
            var subtotalElements = document.querySelectorAll(".quantity__number, .cart_product_single_price");
            var subtotal = 0;

            // Calculate the subtotal by summing the product of quantity and price for each item
            subtotalElements.forEach(function(element, index) {
                var value = parseFloat(element.value);
                if (index % 2 != 0) {
                    subtotal += value * parseFloat(subtotalElements[index - 1].value);
                }
            });

            // Update the subtotal price in the DOM
            var subtotalPriceElement = document.querySelector(".sidebar-product-subtotal-price");
            if (subtotalPriceElement) {
                subtotalPriceElement.innerText = "৳" + subtotal.toFixed(2);
            }
        }
    </script>

    @yield('footer_js')

    <!-- AJAX Wishlist Handler -->
    <script>
        $(document).ready(function() {
            // Handle AJAX wishlist buttons
            $(document).on('click', '.ajax-wishlist-btn', function(e) {
                    e.preventDefault();

                    const button = $(this);
                    const productSlug = button.data('product-slug');
                    const action = button.data('action');
                    const url = action === 'add' ? '{{ url('add/to/wishlist') }}/' + productSlug :
                        '{{ url('remove/from/wishlist') }}/' + productSlug;

                    // Check if customer is authenticated
                    const isAuthenticated = {{ auth('customer')->check() ? 'true' : 'false' }};
                    if (!isAuthenticated) {
                        toastr.error('Please login to add items to wishlist');
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                // Show loading state
                const originalIcon = button.find('i').attr('class');
                const wishlistTextSpan = button.find('.wishlist-text');
                const regularSpan = button.find('span:not(.wishlist-text)');

                if (wishlistTextSpan.length > 0) {
                    wishlistTextSpan.text(action === 'add' ? 'Adding...' : 'Removing...');
                } else if (regularSpan.length > 0) {
                    regularSpan.text(action === 'add' ? 'Adding...' : 'Removing...');
                }

                if (button.find('i').length > 0) {
                    button.find('i').attr('class', 'fa fa-spinner fa-spin');
                }
                button.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button state
                            if (action === 'add') {
                                button.data('action', 'remove');
                                button.attr('title', 'Remove from wishlist');

                                // Handle different button types
                                if (wishlistTextSpan.length > 0) {
                                    // Product details page style
                                    button.addClass('text-danger');
                                    button.css('border-color', 'currentColor');
                                    wishlistTextSpan.text('Remove from Wishlist');
                                } else {
                                    // Product card style
                                    button.find('i').attr('class',
                                        'fi fi-ss-heart product__items--action__btn--svg').css(
                                        'color', 'red');
                                    if (regularSpan.length > 0) {
                                        regularSpan.text('Remove from Wishlist');
                                    }
                                }
                            } else {
                                button.data('action', 'add');
                                button.attr('title', 'Add to wishlist');

                                // Handle different button types
                                if (wishlistTextSpan.length > 0) {
                                    // Product details page style
                                    button.removeClass('text-danger');
                                    button.css('border-color', '#ddd');
                                    wishlistTextSpan.text('Add to Wishlist');
                                } else {
                                    // Product card style
                                    button.find('i').attr('class',
                                        'fi fi-rs-heart product__items--action__btn--svg').css(
                                        'color', '');
                                    if (regularSpan.length > 0) {
                                        regularSpan.text('Add to Wishlist');
                                    }
                                }
                            }

                            // Update wishlist count in header
                            if (response.wishlist_count !== undefined) {
                                $('.items__count.wishlist').text(response.wishlist_count);
                                $('.items__count.wishlist__count').text(response.wishlist_count);
                                $('.items__count.wishlist.style2').text(response.wishlist_count);
                            }

                            // Show appropriate message based on action
                            if (action === 'add') {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        } else {
                            // Show error message
                            toastr.error(response.message || 'Something went wrong');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            toastr.error('Please login to manage wishlist');
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }

                        // Only restore original icon on error
                        if (originalIcon && button.find('i').length > 0) {
                            button.find('i').attr('class', originalIcon);
                        }
                    },
                    complete: function() {
                        // Re-enable button
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>

    {!! optional($generalInfo)->footer_script ?? '' !!}

    <script src="{{ url('tenant/frontend') }}/js/toastr.min.js"></script>
    {!! Toastr::message() !!}


    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "61572596262797");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

</body>

</html>
