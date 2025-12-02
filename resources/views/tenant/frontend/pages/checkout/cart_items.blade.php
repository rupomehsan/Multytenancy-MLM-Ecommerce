@if (session('cart'))
    @foreach (session('cart') as $id => $details)
        <tr class="cart-single-product-table-wrapper" data-cart-id="{{ $id }}" @if(isset($details['is_package']) && $details['is_package']) data-package-id="{{ $details['product_id'] ?? $id }}" @else data-product-id="{{ $id }}" @endif>
            <td class="table-head-1">
                <div class="cart-single-product-first-col">
                    <button onclick="removeCartItems('{{ $id }}')" type="button" class="cart-single-product-remove"><i class="fi-rr-trash"></i></button>
                    <div>
                        <span class="cart-single-product-title d-block">
                            {{ $details['name'] }}
                            @if(isset($details['is_package']) && $details['is_package'])
                                <span class="package-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; margin-left: 5px;">Package</span>
                            @endif
                        </span>

                        {{-- Package Stock Status --}}
                        @if(isset($details['is_package']) && $details['is_package'])
                            {{-- <div class="checkout-package-stock-status" id="checkout_stock_{{ $id }}" style="margin: 5px 0; font-size: 12px;">
                                <span class="stock-available">
                                    <i class="bi bi-check-circle"></i> Verifying stock...
                                </span>
                            </div> --}}
                        @else
                            {{-- Regular Product Stock Status --}}
                            {{-- <div class="checkout-product-stock-status" id="checkout_stock_{{ $id }}" style="margin: 5px 0; font-size: 12px;">
                                <span class="stock-available">
                                    <i class="bi bi-check-circle"></i> Verifying stock...
                                </span>
                            </div> --}}
                        @endif

                        @if ($details['color_id'])
                            @php
                                $colorInfo = DB::table('colors')
                                    ->where('id', $details['color_id'])
                                    ->first();
                            @endphp
                            @if ($colorInfo)
                                <small><b>Color</b>: {{ $colorInfo ? $colorInfo->name : '' }}</small>
                            @endif
                        @endif
                        @if ($details['size_id'])
                            @php
                                $sizeInfo = DB::table('product_sizes')
                                    ->where('id', $details['size_id'])
                                    ->first();
                            @endphp
                            @if ($sizeInfo)
                                <small><b>Size</b>: {{ $sizeInfo ? $sizeInfo->name : '' }}</small>
                            @endif
                        @endif

                    </div>
                </div>
            </td>
            <td class="table-head-2">
                <div class="quantity__box minicart__quantity">
                    <button type="button" class="quantity__value decrease" data-id="{{ $id }}" aria-label="quantity value" value="Decrease Value">-</button>
                    <label>
                        @php
                            // Get actual stock for this product/variant
                            $actualStock = 999; // Default fallback
                            
                            if(isset($details['is_package']) && $details['is_package']) {
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
                               data-counter="" max="{{ $actualStock }}" data-max-stock="{{ $actualStock }}"
                               @if($actualStock < 999) title="Maximum available: {{ $actualStock }}" @endif>
                    </label>
                    <button type="button" class="quantity__value increase" data-id="{{ $id }}" value="Increase Value">+</button>
                </div>
            </td>
            <td class="table-head-3">
                @php
                    $checkoutUnitPrice = $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'];
                @endphp
                <span class="cart-product-price">{{ number_format($checkoutUnitPrice, 2) }} BDT</span>
            </td>
            <td class="table-head-4">
                <span class="cart-product-price">{{ number_format($checkoutUnitPrice * $details['quantity'], 2) }} BDT</span>
            </td>
        </tr>
    @endforeach
@endif

<style>
.checkout-package-stock-status .stock-checking,
.checkout-product-stock-status .stock-checking {
    color: #6c757d;
}

.checkout-package-stock-status .stock-available,
.checkout-product-stock-status .stock-available {
    color: #28a745;
}

.checkout-package-stock-status .stock-issue,
.checkout-product-stock-status .stock-issue {
    color: #dc3545;
}

.package-badge {
    display: inline-block !important;
}

/* Smooth quantity controls */
.quantity__box {
    display: flex;
    align-items: center;
}

.quantity__value {
    transition: all 0.1s ease;
    cursor: pointer;
    user-select: none;
    min-width: 30px;
    text-align: center;
}

.quantity__value:active {
    transform: scale(0.95);
}

.quantity__number {
    transition: background-color 0.2s ease;
    text-align: center;
}
</style>

<!-- The unified stock system will handle all stock checking for checkout -->
<script>
// Cart item removal function
function removeCartItems(id){
    $.get("{{ url('remove/cart/item') }}" +'/' + id, function (data) {
        toastr.options.positionClass = 'toast-top-right';
        toastr.options.timeOut = 1000;
        toastr.error("Item is Removed");
        $(".offCanvas__minicart").html(data.rendered_cart);
        $("a.minicart__open--btn span.items__count").html(data.cartTotalQty);

        $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
        $(".order-review-summary").html(data.checkoutTotalAmount);
        
        // Update coupon section if coupon data is available
        if (data.checkoutCoupon) {
            $(".checkout-order-review-coupon-box").html(data.checkoutCoupon);
        }

        if(data.cartTotalQty <= 0){
            setTimeout(function() {
                window.location.href = '{{ url('/') }}';
            }, 1000);
        }
    })
}

// Legacy function for backward compatibility
window.refreshCheckoutPackageStock = function() {
    if (window.unifiedStockSystem) {
        window.unifiedStockSystem.performInitialStockCheck();
    }
};

// Debug function to check if unified system is working
window.debugStockSystem = function() {
    console.log('=== Stock System Debug ===');
    console.log('Unified system exists:', !!window.unifiedStockSystem);
    console.log('Context:', window.unifiedStockSystem?.context);
    
    // Check checkout table rows specifically
    const checkoutRows = document.querySelectorAll('.cart-single-product-table-wrapper[data-cart-id]');
    console.log('Checkout table rows found:', checkoutRows.length);
    
    checkoutRows.forEach((row, index) => {
        const cartId = row.getAttribute('data-cart-id');
        const checkoutStatusEl = document.getElementById(`checkout_stock_${cartId}`);
        const miniStatusEl = document.getElementById(`mini_stock_${cartId}`);
        console.log(`Checkout Row ${index + 1}:`, {
            cartId: cartId,
            classes: row.className,
            checkoutStatusElement: checkoutStatusEl,
            miniStatusElement: miniStatusEl,
            checkoutExists: !!checkoutStatusEl,
            miniExists: !!miniStatusEl
        });
    });
    
    // Check all cart items
    const allCartRows = document.querySelectorAll('[data-cart-id]');
    console.log('All cart rows found:', allCartRows.length);
    
    allCartRows.forEach((row, index) => {
        const cartId = row.getAttribute('data-cart-id');
        console.log(`All Rows ${index + 1}:`, {
            cartId: cartId,
            classes: row.className,
            isCheckoutWrapper: row.classList.contains('cart-single-product-table-wrapper'),
            isSidebarItem: row.classList.contains('minicart__product--items')
        });
    });
    
    if (window.unifiedStockSystem) {
        console.log('Triggering manual stock check...');
        window.unifiedStockSystem.performInitialStockCheck();
    }
};

// Auto-trigger after page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Checkout page loaded, checking for unified stock system...');
    
    // Wait a moment for scripts to load
    setTimeout(function() {
        if (window.unifiedStockSystem) {
            console.log('✅ Unified stock system found, context:', window.unifiedStockSystem.context);
        } else {
            console.warn('❌ Unified stock system not found, trying manual trigger...');
            // Try to trigger it manually
            setTimeout(() => {
                if (window.unifiedStockSystem) {
                    console.log('✅ Unified stock system now available');
                    window.unifiedStockSystem.performInitialStockCheck();
                } else {
                    console.error('❌ Unified stock system still not available');
                }
            }, 1000);
        }
    }, 500);
});

// Ultra-smooth quantity controls - override any existing handlers
let isUpdating = false;
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('increase') || e.target.classList.contains('decrease')) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        
        if (isUpdating) return; // Prevent rapid-fire clicks
        isUpdating = true;
        
        const button = e.target;
        const row = button.closest('.cart-single-product-table-wrapper');
        
        // Fix: Check if row exists before accessing querySelector
        if (!row) {
            isUpdating = false;
            return; // This is probably a sidebar button, let unified system handle it
        }
        
        const input = row.querySelector('.quantity__number');
        
        if (!input) {
            isUpdating = false;
            return;
        }
        
        let currentValue = parseInt(input.value) || 1;
        const cartId = row.getAttribute('data-cart-id');
        
        // Get stock limit from input attributes or data
        const maxStock = parseInt(input.getAttribute('max')) || parseInt(input.dataset.maxStock) || 999;
        const minStock = parseInt(input.getAttribute('min')) || 1;
        
        if (button.classList.contains('increase')) {
            // Check if we can increase (stock validation)
            if (currentValue >= maxStock) {
                // At maximum stock - show warning
                button.style.backgroundColor = '#ffc107';
                button.style.color = '#212529';
                input.style.backgroundColor = '#fff3cd';
                input.style.borderColor = '#ffc107';
                
                // Show validation message
                showStockMessage('Maximum available quantity: ' + maxStock, 'warning');
                
                setTimeout(() => {
                    button.style.backgroundColor = '';
                    button.style.color = '';
                    input.style.backgroundColor = '';
                    input.style.borderColor = '';
                    isUpdating = false;
                }, 500);
                return false;
            }
            currentValue++;
        } else if (button.classList.contains('decrease')) {
            // Check if we can decrease (minimum validation)
            if (currentValue <= minStock) {
                // At minimum stock - show warning
                button.style.backgroundColor = '#dc3545';
                button.style.color = 'white';
                input.style.backgroundColor = '#f8d7da';
                input.style.borderColor = '#dc3545';
                
                // Show validation message
                showStockMessage('Minimum quantity is: ' + minStock, 'error');
                
                setTimeout(() => {
                    button.style.backgroundColor = '';
                    button.style.color = '';
                    input.style.backgroundColor = '';
                    input.style.borderColor = '';
                    isUpdating = false;
                }, 500);
                return false;
            }
            currentValue--;
        }
        
        // Immediate visual update
        input.value = currentValue;
        
        // Ultra-fast visual feedback
        input.style.backgroundColor = button.classList.contains('increase') ? '#d4edda' : '#f8d7da';
        button.style.backgroundColor = button.classList.contains('increase') ? '#28a745' : '#dc3545';
        button.style.color = 'white';
        button.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            input.style.backgroundColor = '';
            button.style.backgroundColor = '';
            button.style.color = '';
            button.style.transform = '';
            isUpdating = false;
        }, 100);
        
        // Update server and sidebar using unified system after visual feedback
        setTimeout(() => {
            if (window.unifiedStockSystem && window.unifiedStockSystem.updateCartQuantity) {
                window.unifiedStockSystem.updateCartQuantity(cartId, currentValue);
            } else if (window.updateCartQuantity) {
                window.updateCartQuantity(cartId, currentValue);
            }
        }, 50);
        
        return false; // Prevent any other handlers from running
    }
}, true); // Use capture phase to intercept before other handlers

// Stock validation message function
function showStockMessage(message, type = 'warning') {
    // Remove existing messages
    document.querySelectorAll('.stock-validation-message').forEach(msg => msg.remove());
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'stock-validation-message';
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 16px;
        border-radius: 4px;
        z-index: 9999;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateX(100%);
        ${type === 'warning' ? 
            'background: #fff3cd; color: #856404; border: 1px solid #ffeaa7;' : 
            'background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'
        }
    `;
    messageDiv.textContent = message;
    
    document.body.appendChild(messageDiv);
    
    // Animate in
    setTimeout(() => {
        messageDiv.style.opacity = '1';
        messageDiv.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateX(100%)';
        setTimeout(() => messageDiv.remove(), 300);
    }, 3000);
}

// Add input validation for direct typing
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('quantity__number') && 
        e.target.closest('.cart-single-product-table-wrapper')) {
        
        const input = e.target;
        const value = parseInt(input.value) || 1;
        const maxStock = parseInt(input.getAttribute('max')) || parseInt(input.dataset.maxStock) || 999;
        const minStock = parseInt(input.getAttribute('min')) || 1;
        
        if (value < minStock) {
            input.value = minStock;
            input.style.backgroundColor = '#f8d7da';
            input.style.borderColor = '#dc3545';
            showStockMessage('Minimum quantity is: ' + minStock, 'error');
            
            setTimeout(() => {
                input.style.backgroundColor = '';
                input.style.borderColor = '';
            }, 2000);
        } else if (value > maxStock && maxStock < 999) {
            input.value = maxStock;
            input.style.backgroundColor = '#fff3cd';
            input.style.borderColor = '#ffc107';
            showStockMessage('Maximum available quantity: ' + maxStock, 'warning');
            
            setTimeout(() => {
                input.style.backgroundColor = '';
                input.style.borderColor = '';
            }, 2000);
        }
    }
});
</script>
