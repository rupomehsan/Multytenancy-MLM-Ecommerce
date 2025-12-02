/**
 * ULTRA SIMPLE Cart Sync System
 * No complexity, no loops, just direct sync between product details and sidebar
 */

class SimpleCartSync {
    constructor() {
        this.isProcessing = false;
        this.init();
    }

    init() {
        console.log('🚀 Simple Cart Sync initialized');
        this.setupProductDetailsSync();
    }

    setupProductDetailsSync() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) {
            console.log('ℹ️ No product details input found');
            return;
        }

        console.log('🔧 Setting up ULTRA SIMPLE sync...');

        // Remove any existing handlers
        const newInput = quantityInput.cloneNode(true);
        quantityInput.parentNode.replaceChild(newInput, quantityInput);

        // Get fresh reference
        const freshInput = document.getElementById('product_details_cart_qty');

        // SIMPLE: Input change handler
        freshInput.addEventListener('input', (e) => {
            if (this.isProcessing) return;
            
            const quantity = parseInt(e.target.value) || 1;
            const productId = document.getElementById('product_id')?.value;
            
            if (productId) {
                this.syncToSidebar(productId, quantity);
            }
        });

        // SIMPLE: Change handler with backend update
        freshInput.addEventListener('change', (e) => {
            if (this.isProcessing) return;
            
            const quantity = parseInt(e.target.value) || 1;
            const productId = document.getElementById('product_id')?.value;
            
            if (productId) {
                this.syncToSidebar(productId, quantity);
                this.updateBackend(productId, quantity);
            }
        });

        // SIMPLE: Increase/decrease buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('quantity__value_details')) {
                e.preventDefault();
                
                if (this.isProcessing) return;
                
                const input = document.getElementById('product_details_cart_qty');
                if (!input) return;
                
                const currentQty = parseInt(input.value) || 1;
                
                if (e.target.classList.contains('increase')) {
                    input.value = currentQty + 1;
                } else if (e.target.classList.contains('decrease') && currentQty > 1) {
                    input.value = currentQty - 1;
                }
                
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        }, true);

        console.log('✅ ULTRA SIMPLE sync setup complete');
    }

    syncToSidebar(productId, quantity) {
        if (this.isProcessing) return;
        this.isProcessing = true;

        console.log('🔄 Syncing to sidebar:', { productId, quantity });

        try {
            // Build cart key
            const cartKey = this.buildCartKey(productId);
            console.log('🔍 Cart key:', cartKey);

            // Find sidebar item
            const sidebarItem = document.querySelector(`[data-cart-id="${cartKey}"]`);
            console.log('🔍 Sidebar item found:', !!sidebarItem);
            
            if (sidebarItem) {
                const sidebarInput = sidebarItem.querySelector('.quantity__number');
                console.log('🔍 Sidebar input found:', !!sidebarInput);
                console.log('🔍 Current sidebar quantity:', sidebarInput?.value);
                console.log('🔍 New quantity:', quantity);
                
                if (sidebarInput && parseInt(sidebarInput.value) !== quantity) {
                    console.log('✅ Updating sidebar quantity from', sidebarInput.value, 'to:', quantity);
                    sidebarInput.value = quantity;
                } else if (sidebarInput) {
                    console.log('ℹ️ Sidebar quantity already matches:', quantity);
                }
            } else {
                console.log('ℹ️ Item not in sidebar cart:', cartKey);
                
                // Debug: List all cart items in sidebar
                const allCartItems = document.querySelectorAll('[data-cart-id]');
                console.log('🔍 All cart items in sidebar:', Array.from(allCartItems).map(item => item.getAttribute('data-cart-id')));
            }
        } catch (error) {
            console.error('❌ Sync error:', error);
        } finally {
            this.isProcessing = false;
        }
    }

    buildCartKey(productId) {
        let cartKey = productId;

        // Check for color
        const colorInput = document.querySelector('input[name="color_id[]"]:checked');
        if (colorInput && colorInput.value) {
            cartKey += '_c' + colorInput.value;
        }

        // Check for size
        const sizeInput = document.querySelector('input[name="size_id[]"]:checked');
        if (sizeInput && sizeInput.value) {
            cartKey += '_s' + sizeInput.value;
        }

        return cartKey;
    }

    updateBackend(productId, quantity) {
        const cartKey = this.buildCartKey(productId);

        // Check if item exists in cart
        const cartItem = document.querySelector(`[data-cart-id="${cartKey}"]`);
        if (!cartItem) {
            console.log('ℹ️ Item not in cart, skipping backend update');
            return;
        }

        console.log('🛒 Updating backend:', cartKey, 'quantity:', quantity);

        const formData = new FormData();
        formData.append("cart_id", cartKey);
        formData.append("cart_qty", quantity);
        formData.append("_token", document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

        fetch('/update/cart/qty', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Backend response:', data);
            
            if (data.rendered_cart) {
                // Update the entire sidebar cart
                const sidebarCart = document.querySelector(".offCanvas__minicart");
                if (sidebarCart) {
                    sidebarCart.innerHTML = data.rendered_cart;
                    console.log('✅ Sidebar cart updated with server response');
                }
            }
            
            // Update cart counters
            if (data.cartTotalQty !== undefined) {
                const cartCounters = document.querySelectorAll('a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count');
                cartCounters.forEach(counter => {
                    counter.textContent = data.cartTotalQty;
                });
                console.log('✅ Cart counters updated to:', data.cartTotalQty);
            }
            
            if (data.success !== false) {
                console.log('✅ Backend updated successfully');
            } else {
                console.warn('⚠️ Backend update failed:', data.message);
            }
        })
        .catch(error => {
            console.error('❌ Backend update error:', error);
        });
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.simpleCartSync = new SimpleCartSync();
    });
} else {
    window.simpleCartSync = new SimpleCartSync();
}
