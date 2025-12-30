<div class="minicart__header">
    <div class="minicart__header--top d-flex justify-content-between align-items-center">
        <h2 class="minicart__title h3">Shopping Cart</h2>
        <button class="minicart__close--btn" data-offcanvas onclick="closeMiniCart()">
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32" d="M368 368L144 144M368 144L144 368" />
            </svg>
        </button>
    </div>
</div>


@if (session('cart') && count(session('cart')))
    <div class="minicart__product">

        @foreach (session('cart') as $id => $details)
            @php
                $imageToShow = $details['image']; // Default to main product image
                // If this is a variant product (has color_id), try to get variant image
                if (isset($details['color_id']) && $details['color_id']) {
                    $productId =
                        isset($details['is_package']) && $details['is_package']
                            ? $details['product_id']
                            : (strpos($id, '_') !== false
                                ? explode('_', $id)[0]
                                : $id);

                    $variantImage = DB::table('product_variants')
                        ->where('product_id', $productId)
                        ->where('color_id', $details['color_id'])
                        ->when(isset($details['size_id']) && $details['size_id'], function ($query) use ($details) {
                            return $query->where('size_id', $details['size_id']);
                        })
                        ->value('image');

                    // Use variant image if available, otherwise stick with main product image
                    if ($variantImage) {
                        $imageToShow = $variantImage;
                    }
                }
            @endphp

            <div class="minicart__product--items d-flex" data-cart-id="{{ $id }}"
                @if (isset($details['is_package']) && $details['is_package']) data-package-id="{{ $details['product_id'] ?? $id }}" @else data-product-id="{{ $id }}" @endif>
                <div class="minicart__thumb">
                    <a
                        href="{{ url(isset($details['is_package']) && $details['is_package'] ? 'package/details' : 'product/details') }}/{{ $details['slug'] ?? '' }}">
                        @if (isset($details['has_variant']) && $details['has_variant'])
                            <img src="{{ url(env('ADMIN_URL') . '/uploads/productImages/' . $imageToShow) }}"
                                alt="product-img" />
                        @else
                            <img src="{{ url(env('ADMIN_URL') . '/' . $imageToShow) }}" alt="product-img" />
                        @endif
                    </a>
                </div>
                <div class="minicart__text">
                    <h3 class="minicart__subtitle h4">
                        <a
                            href="{{ url(isset($details['is_package']) && $details['is_package'] ? 'package/details' : 'product/details') }}/{{ $details['slug'] ?? '' }}">{{ substr($details['name'] ?? '', 0, 25) }}..</a>
                        @if (isset($details['is_package']) && $details['is_package'])
                            <span class="package-badge"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; margin-left: 5px;">Package</span>
                        @endif
                    </h3>

                    {{-- Stock Status Display --}}
                    <div class="stock-status-mini" id="mini_stock_{{ $id }}"
                        style="margin: 5px 0; font-size: 11px;">
                        <span class="stock-available text-success">
                            <i class="fas fa-check-circle"></i> Available
                        </span>
                    </div>

                    @if ($details['color_id'] && ($colorInfo = DB::table('colors')->where('id', $details['color_id'])->first()))
                        <span class="color__variant" style="font-size: 14px"><b>Color:</b>
                            {{ $colorInfo->name }}</span>
                    @endif
                    @if ($details['size_id'] && ($sizeInfo = DB::table('product_sizes')->where('id', $details['size_id'])->first()))
                        <span class="color__variant" style="font-size: 14px"><b>Size:</b> {{ $sizeInfo->name }}</span>
                    @endif
                    <div class="minicart__price">
                        @if ($details['discount_price'] > 0 && $details['discount_price'] < $details['price'])
                            <span class="current__price">৳{{ $details['discount_price'] }}</span>
                            <input type="hidden" class="cart_product_single_price"
                                value="{{ $details['discount_price'] }}">
                        @else
                            <span class="current__price">৳{{ $details['price'] }}</span>
                            <input type="hidden" class="cart_product_single_price" value="{{ $details['price'] }}">
                        @endif

                        @if ($details['discount_price'] > 0 && $details['discount_price'] < $details['price'])
                            <span class="old__price">৳{{ $details['price'] }}</span>
                        @endif
                    </div>
                    <div class="minicart__text--footer d-flex align-items-center">
                        <div class="quantity__box minicart__quantity">
                            <button type="button" class="quantity__value decrease" data-id="{{ $id }}"
                                aria-label="quantity value" value="Decrease Value">-</button>
                            <label>
                                @php
                                    // Get actual stock for this product/variant
                                    $actualStock = 999; // Default fallback

                                    if (isset($details['is_package']) && $details['is_package']) {
                                        // For packages, we'll let the JavaScript system handle the stock checking
    $actualStock = 999;
} else {
    // For regular products, get actual stock
    if ($details['color_id'] || $details['size_id']) {
        // Variant product - get variant stock
        $variantQuery = DB::table('product_variants')->where('product_id', $id);
        if ($details['color_id']) {
            $variantQuery->where('color_id', $details['color_id']);
        }
        if ($details['size_id']) {
            $variantQuery->where('size_id', $details['size_id']);
        }
        $variant = $variantQuery->first();
        if ($variant) {
            $actualStock = $variant->stock;
        }
    } else {
        // Simple product - get product stock
        $product = DB::table('products')->where('id', $id)->first();
                                            if ($product) {
                                                $actualStock = $product->stock;
                                            }
                                        }
                                    }
                                @endphp
                                <input type="number" class="quantity__number" value="{{ $details['quantity'] }}"
                                    data-counter data-max-stock="{{ $actualStock }}" max="{{ $actualStock }}"
                                    min="1"
                                    @if ($actualStock < 999) title="Maximum available: {{ $actualStock }}" @endif />
                            </label>
                            <button type="button" class="quantity__value increase" data-id="{{ $id }}"
                                value="Increase Value">+</button>
                        </div>
                        <button type="button" class="minicart__product--remove sidebar-product-remove"
                            data-id="{{ $id }}">Remove</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="minicart__amount">
        <div class="minicart__amount_list d-flex justify-content-between">
            <span style="font-weight: 600;">Total:</span>
            @php $cartTotal = 0 @endphp
            @foreach ((array) session('cart') as $id => $details)
                @php
                    $cartTotal +=
                        ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) *
                        $details['quantity'];
                @endphp
            @endforeach
            <span><b class="sidebar-product-subtotal-price">৳{{ number_format($cartTotal, 2) }}</b></span>
        </div>
    </div>

    {{-- Stock Warning Display --}}
    <div class="stock-warning-container" id="minicart_stock_warning" style="display: none; margin: 10px 0;">
        <!-- Warning content will be populated by JavaScript -->
    </div>

    <div class="minicart__button d-flex justify-content-center mt-5">
        <a class="primary__btn minicart__button--link" href="{{ url('/checkout') }}"
            id="minicart_checkout_btn">Checkout</a>
    </div>
@else
    <div style="display:block; width: 100%; height: 100%; text-align:center; position: relative;">
        <div style="width: 100%; position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%);">
            <img src="{{ url('tenant/frontend') }}/img/empty_cart.png" alt="Empty Cart">
            <h5>There are no more items in your cart!</h5>
            <a href="javascript:void(0)" onclick="closeMiniCart()" class="auth-card-form-btn primary__btn"
                style="width: 220px; margin: auto;">Continue Shopping</a>
        </div>
    </div>
@endif

<style>
    .stock-status-mini .stock-checking {
        color: #6c757d;
        font-size: 11px;
    }

    .stock-status-mini .stock-available {
        color: #28a745;
        font-weight: 500;
        font-size: 11px;
    }

    .stock-status-mini .stock-issue {
        color: #dc3545;
        font-weight: 500;
        font-size: 11px;
    }

    .stock-status-mini .stock-warning {
        color: #ffc107;
        font-weight: 500;
        font-size: 11px;
    }

    .package-badge {
        display: inline-block !important;
    }

    /* Loading animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .spin {
        animation: spin 1s linear infinite;
    }

    /* Smooth transitions */
    .stock-status-mini {
        transition: all 0.2s ease;
    }

    /* Quantity button states */
    .quantity__value:disabled {
        opacity: 0.4 !important;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .quantity__value[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        white-space: nowrap;
        z-index: 1000;
    }

    .stock-warning-container .alert {
        margin: 0;
        padding: 8px 12px;
        font-size: 12px;
        border-radius: 6px;
    }
</style>

<script>
    // ⚡ INSTANT Cart System - Consistent Stock Status
    console.log('⚡ Sidebar cart optimized for speed - using unified stock system');

    // Function to ensure consistent "Available" status for all sidebar items
    function ensureConsistentStatus() {
        $('.stock-status-mini').each(function() {
            const currentHTML = $(this).html();
            // If it's showing any positive stock status, standardize to "Available"
            if (currentHTML.includes('stock-available') || currentHTML.includes('In stock') || currentHTML
                .includes('available')) {
                $(this).html(
                    '<span class="stock-available text-success"><i class="fas fa-check-circle"></i> Available</span>'
                );
            }
        });
    }

    // Only keep basic validation for quantity inputs when unified system is not available
    document.addEventListener('DOMContentLoaded', function() {
        // Check if unified system is available
        if (typeof window.unifiedStockSystem === 'undefined') {
            console.warn('⚠️ Unified stock system not available, using basic validation');

            // Basic quantity validation with INSTANT feedback
            $(document).on('input', '.quantity__number', function() {
                const min = parseInt(this.getAttribute('min')) || 1;
                const max = parseInt(this.getAttribute('max'));
                let value = parseInt(this.value);

                if (isNaN(value) || value < min) {
                    this.value = min;
                }
                if (max && value > max) {
                    this.value = max;
                    // Show toast immediately without delay
                    if (typeof toastr !== 'undefined') {
                        toastr.warning(`Only ${max} available, adjusted from ${value}`,
                            'Auto-Adjusted to Maximum');
                    }
                }
            });

            // Show all items as available immediately with consistent styling
            $('.stock-status-mini').html(
                '<span class="stock-available text-success"><i class="fas fa-check-circle"></i> Available</span>'
            );

        } else {
            console.log('✅ Unified stock system detected - all cart functionality delegated');

            // Ensure consistent status after any stock updates
            setTimeout(ensureConsistentStatus, 500);

            // Also check periodically to maintain consistency
            setInterval(ensureConsistentStatus, 2000);
        }
    });
</script>
