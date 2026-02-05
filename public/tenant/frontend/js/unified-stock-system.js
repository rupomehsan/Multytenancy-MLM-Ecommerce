/**
 * Unified Stock Checking System
 * Handles stock validation for both sidebar cart and checkout pages
 * Supports both packages and products with variant-based calculations
 */

// Prevent multiple definitions
if (typeof window.UnifiedStockSystem !== 'undefined') {
    console.warn('⚠️ UnifiedStockSystem already defined, skipping redefinition');
} else {

class UnifiedStockSystem {
    constructor() {
        // Core system properties
        this.cache = new Map();
        this.debounceTimers = new Map();
        this.bidirectionalSyncTimer = null;
        this.isAutoCheck = false; // Flag to prevent showing "Checking..." on auto-checks
        this.storedStockData = null; // Store stock attributes during cart updates
        this.lastCheckedQuantities = new Map(); // Track last checked quantities to prevent duplicates
        
        // Cart operation tracking
        this.cartOperationQueue = new Map(); // Queue for cart operations
        this.cartOperationInProgress = new Set(); // Track ongoing cart operations
        
        // Configuration
        this.config = {
            debounceTime: 300, // Increased from 100ms to 300ms to reduce API calls
            cacheTimeout: 300000, // Increased to 5 minutes (300 seconds)
            maxRetries: 2,
            batchSize: 5,
            requestTimeout: 3000,
            throttleDelay: 1000, // Add 1-second throttle between API calls
            endpoints: {
                package: '/check/package/stock',
                product: '/check/product/stock',
                addToCart: '/add/to/cart',
                addToCartWithQty: '/add/to/cart/with/qty',
                updateCart: '/update/cart/qty',
                removeFromCart: '/remove/cart/item',
                removeFromCartByKey: '/remove/cart/item/by/key'
            }
        };
        
        // Request throttling
        this.lastRequestTime = 0;
        this.pendingRequests = new Set();
        
        // Detect current context
        this.context = this.detectContext();
        console.log(`🎯 Unified Cart & Stock System initialized for: ${this.context}`);
        
        this.initialize();
    }
    
    /**
     * Detect whether we're on sidebar cart, checkout, or other page
     */
    detectContext() {
        const hasCheckoutTable = document.querySelector('.cart-single-product-table') ||
                                document.querySelector('.cart-single-product-table-wrapper') ||
                                document.querySelector('.checkout-table');
        const hasMinicart = document.querySelector('.minicart__product');
        
        console.log('🔍 Context detection:', {
            hasCheckoutTable: !!hasCheckoutTable,
            hasMinicart: !!hasMinicart,
            pathname: window.location.pathname
        });
        
        if (hasCheckoutTable) {
            return 'checkout';
        } else if (hasMinicart) {
            return 'sidebar';
        }
        return 'other';
    }
    
    /**
     * Initialize the system based on context
     */
    initialize() {
        const hasCheckoutTable = document.querySelector('.cart-single-product-table') ||
                                document.querySelector('.cart-single-product-table-wrapper') ||
                                document.querySelector('.checkout-table');
        const hasMinicart = document.querySelector('.minicart__product');
        
        // Initialize checkout if checkout table exists
        if (hasCheckoutTable) {
            this.initializeCheckout();
        }
        
        // Initialize sidebar if minicart exists (can coexist with checkout)
        if (hasMinicart) {
            this.initializeSidebar();
        }
        
        // Initialize bidirectional sync for product details pages
        this.initializeBidirectionalSync();
        
        // Initialize product details page controls
        this.initializeProductDetailsControls();
        
        // Initialize unified cart operations (replaces legacy cart handlers)
        this.initializeUnifiedCartOperations();
    }
    
    /**
     * Initialize unified cart operations - replaces all legacy cart handlers
     */
    initializeUnifiedCartOperations() {
        console.log('🛒 Initializing unified cart operations...');
        
        // Handle simple "Add to Cart" buttons (no quantity selection)
        this.setupSimpleAddToCartHandlers();
        
        // Handle "Add to Cart with Quantity" buttons
        this.setupAddToCartWithQuantityHandlers();
        
        // Handle "Buy Now" buttons
        this.setupBuyNowHandlers();
        
        // Handle "Remove from Cart" buttons
        this.setupRemoveFromCartHandlers();
        
        // Handle sidebar cart remove buttons
        this.setupSidebarRemoveHandlers();
        
        console.log('✅ Unified cart operations initialized');
    }
    
    /**
     * Setup simple "Add to Cart" button handlers (no quantity selection)
     */
    setupSimpleAddToCartHandlers() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.addToCart')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.addToCart');
                const productId = button.getAttribute('data-id');
                
                console.log('🛒 Simple add to cart clicked for product:', productId);
                this.handleSimpleAddToCart(productId, button);
            }
        }, true);
    }
    
    /**
     * Setup "Add to Cart with Quantity" button handlers
     */
    setupAddToCartWithQuantityHandlers() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.addToCartWithQty')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.addToCartWithQty');
                const productId = button.getAttribute('data-id');
                
                console.log('🛒 Add to cart with quantity clicked for product:', productId);
                this.handleAddToCartWithQuantity(productId, button);
            }
        }, true);
    }
    
    /**
     * Setup "Buy Now" button handlers
     */
    setupBuyNowHandlers() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.buyNowWithQty')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.buyNowWithQty');
                const productId = button.getAttribute('data-id');
                
                console.log('🛒 Buy now clicked for product:', productId);
                this.handleBuyNow(productId, button);
            }
        }, true);
    }
    
    /**
     * Setup "Remove from Cart" button handlers
     */
    setupRemoveFromCartHandlers() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.removeFromCart')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.removeFromCart');
                const productId = button.getAttribute('data-id');
                
                console.log('🛒 Remove from cart clicked for product:', productId);
                this.handleRemoveFromCart(productId, button);
            } else if (e.target.closest('.removeFromCartQty')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.removeFromCartQty');
                const productId = button.getAttribute('data-id');
                const cartKey = button.getAttribute('data-cart-key');
                
                console.log('🛒 Remove from cart (with qty) clicked for product:', productId, 'cartKey:', cartKey);
                this.handleRemoveFromCartWithKey(productId, cartKey, button);
            }
        }, true);
    }
    
    /**
     * Setup sidebar cart remove button handlers
     */
    setupSidebarRemoveHandlers() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.sidebar-product-remove')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.sidebar-product-remove');
                const productId = button.getAttribute('data-id');
                
                console.log('🛒 Sidebar remove clicked for product:', productId);
                this.handleSidebarProductRemove(productId, button);
            }
        }, true);
    }
    
    /**
     * Initialize bidirectional sync for product details pages
     */
    initializeBidirectionalSync() {
        // This will be handled by initializeProductDetailsControls() for better integration
        // Just a placeholder for now - the actual sync is set up in reinitializeBidirectionalSync()
        console.log('� Bidirectional sync will be initialized by product details controls');
    }
    
    /**
     * Build exact cart key from product details page selections
     */
    buildExactCartKeyFromDetailsPage(productId) {
        // SIMPLE: Use the same logic as buildSimpleCartKey
        return this.buildSimpleCartKey(productId);
    }

    /**
     * Initialize comprehensive product details page controls
     */
    initializeProductDetailsControls() {
        // Only initialize if we have product details elements
        const productDetailsInput = document.getElementById('product_details_cart_qty');
        const productIdElement = document.getElementById('product_id');
        
        if (!productDetailsInput || !productIdElement) {
            console.log('ℹ️ No product details elements found, skipping product details controls');
            return;
        }
        
        console.log('🎮 Initializing SIMPLE product details controls...');
        
        // SIMPLE: Just set up the basic handlers without complications
        this.setupSimpleProductDetailsSync();
        
        console.log('✅ Product details controls initialized');
    }
    
    /**
     * SIMPLE: Set up basic product details sync
     */
    setupSimpleProductDetailsSync() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) return;
        
        console.log('🔧 Setting up SIMPLE product details sync...');
        
        // Remove all existing handlers first
        const newInput = quantityInput.cloneNode(true);
        quantityInput.parentNode.replaceChild(newInput, quantityInput);
        
        // Get the fresh input element
        const freshInput = document.getElementById('product_details_cart_qty');
        
        // SIMPLE input handler - just sync to sidebar when value changes
        freshInput.addEventListener('input', (e) => {
            const quantity = parseInt(e.target.value) || 1;
            const productId = document.getElementById('product_id')?.value;
            
            if (productId) {
                this.syncProductDetailsToSidebar(productId, quantity);
            }
        });
        
        // SIMPLE change handler - update backend too
        freshInput.addEventListener('change', (e) => {
            const quantity = parseInt(e.target.value) || 1;
            const productId = document.getElementById('product_id')?.value;
            
            if (productId) {
                this.syncProductDetailsToSidebar(productId, quantity);
                this.updateBackendCartQuantity(productId, quantity);
            }
        });
        
        // SIMPLE increase/decrease buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('quantity__value_details')) {
                e.preventDefault();
                
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
        
        console.log('✅ SIMPLE product details sync setup complete');
    }
    
    /**
     * SIMPLE: Sync product details quantity to sidebar
     */
    syncProductDetailsToSidebar(productId, quantity) {
        console.log('🔄 SIMPLE sync to sidebar:', { productId, quantity });
        
        // Build the correct cart key
        const cartKey = this.buildSimpleCartKey(productId);
        console.log('🔍 Looking for cart item:', cartKey);
        
        // Find the cart item in sidebar
        const cartItem = document.querySelector(`[data-cart-id="${cartKey}"]`);
        if (cartItem) {
            const sidebarInput = cartItem.querySelector('.quantity__number');
            if (sidebarInput && parseInt(sidebarInput.value) !== quantity) {
                console.log('✅ Updating sidebar quantity:', cartKey, 'to', quantity);
                sidebarInput.value = quantity;
            }
        } else {
            console.log('ℹ️ Cart item not found in sidebar:', cartKey);
        }
    }
    
    /**
     * SIMPLE: Build cart key from current selections
     */
    buildSimpleCartKey(productId) {
        let cartKey = productId;
        
        // Check for color selection
        const colorInput = document.querySelector('input[name="color_id[]"]:checked');
        if (colorInput && colorInput.value) {
            cartKey += '_c' + colorInput.value;
        }
        
        // Check for size selection  
        const sizeInput = document.querySelector('input[name="size_id[]"]:checked');
        if (sizeInput && sizeInput.value) {
            cartKey += '_s' + sizeInput.value;
        }
        
        return cartKey;
    }
    
    /**
     * SIMPLE: Update backend cart quantity
     */
    updateBackendCartQuantity(productId, quantity) {
        const cartKey = this.buildSimpleCartKey(productId);
        
        // Check if item exists in cart first
        const cartItem = document.querySelector(`[data-cart-id="${cartKey}"]`);
        if (!cartItem) {
            console.log('ℹ️ Item not in cart yet, skipping backend update:', cartKey);
            return;
        }
        
        console.log('🛒 Updating backend cart:', cartKey, 'quantity:', quantity);
        
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
            if (data.success) {
                console.log('✅ Backend cart updated successfully');
            } else {
                console.warn('⚠️ Backend cart update failed:', data.message);
            }
        })
        .catch(error => {
            console.error('❌ Backend cart update error:', error);
        });
    }
    
    /**
     * Disable legacy product details handlers to prevent conflicts
     */
    disableLegacyProductDetailsHandlers() {
        console.log('🚫 Disabling legacy product details handlers...');
        
        // Store current value before replacement
        const quantityInput = document.getElementById('product_details_cart_qty');
        let currentValue = 1;
        if (quantityInput) {
            currentValue = quantityInput.value || 1;
        }
        
        // Remove legacy event listeners by cloning and replacing elements
        if (quantityInput) {
            const newInput = quantityInput.cloneNode(true);
            newInput.value = currentValue; // Preserve value
            quantityInput.parentNode.replaceChild(newInput, quantityInput);
            console.log('🔄 Replaced product_details_cart_qty input to remove legacy handlers');
        }
        
        // Disable any legacy jQuery handlers
        if (typeof $ !== 'undefined') {
            $(document).off('click', '.quantity__value_details');
            $(document).off('input change', '#product_details_cart_qty');
            $(document).off('keypress', '#product_details_cart_qty');
            $('body').off('input change', '#product_details_cart_qty');
            console.log('🚫 Disabled legacy jQuery handlers');
        }
        
        // Override legacy global functions if they exist
        if (typeof window.increaseProductDetailsQuantity === 'function') {
            window.increaseProductDetailsQuantity = () => {
                console.log('📢 Legacy increaseProductDetailsQuantity called - redirecting to unified system');
                this.handleProductDetailsQuantityIncrease();
            };
        }
        
        if (typeof window.decreaseProductDetailsQuantity === 'function') {
            window.decreaseProductDetailsQuantity = () => {
                console.log('📢 Legacy decreaseProductDetailsQuantity called - redirecting to unified system');
                this.handleProductDetailsQuantityDecrease();
            };
        }
        
        console.log('✅ Legacy handlers disabled');
        
        // CRITICAL: Re-initialize ALL event handlers after cleaning up legacy handlers
        setTimeout(() => {
            this.reinitializeBidirectionalSync();
            this.setupProductDetailsInputValidation(); // Re-setup input validation
            console.log('🔄 All product details handlers re-initialized after cleanup');
        }, 100);
    }
    
    /**
     * Re-initialize bidirectional sync after legacy cleanup
     */
    reinitializeBidirectionalSync() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) {
            console.warn('⚠️ Cannot reinitialize bidirectional sync - quantity input not found');
            return;
        }
        
        console.log('🔄 Re-initializing bidirectional sync...');
        
        // Remove any existing event listeners on the new input
        quantityInput.removeEventListener('input', this.handleProductDetailsInput);
        quantityInput.removeEventListener('change', this.handleProductDetailsChange);
        
        // Create bound event handlers to maintain 'this' context
        this.handleProductDetailsInput = (e) => {
            console.log('🔄 Product details quantity changed (input):', e.target.value);
            
            const productIdElement = document.getElementById('product_id');
            if (productIdElement && productIdElement.value) {
                const productId = productIdElement.value;
                const quantity = parseInt(e.target.value) || 1;
                
                // Debounce the update to prevent rapid calls
                clearTimeout(this.bidirectionalSyncTimer);
                this.bidirectionalSyncTimer = setTimeout(() => {
                    const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
                    console.log('🎯 Updating sidebar with exact cart key (input):', exactCartKey, 'quantity:', quantity);
                    
                    // Check if item exists in cart before updating
                    const cartItem = document.querySelector(`[data-cart-id="${exactCartKey}"]`);
                    if (cartItem) {
                        this.updateSidebarQuantityIfInCart(productId, quantity, exactCartKey);
                        // CRITICAL: Also update the cart backend
                        this.updateCartQuantityDirectly(exactCartKey, quantity);
                    } else {
                        console.log('ℹ️ Product not in cart yet:', exactCartKey);
                    }
                }, 300);
            }
        };
        
        this.handleProductDetailsChange = (e) => {
            console.log('🔄 Product details quantity changed (change):', e.target.value);
            
            const productIdElement = document.getElementById('product_id');
            if (productIdElement && productIdElement.value) {
                const productId = productIdElement.value;
                const quantity = parseInt(e.target.value) || 1;
                
                const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
                console.log('🎯 Updating sidebar with exact cart key (change):', exactCartKey, 'quantity:', quantity);
                
                // Check if item exists in cart before updating
                const cartItem = document.querySelector(`[data-cart-id="${exactCartKey}"]`);
                if (cartItem) {
                    this.updateSidebarQuantityIfInCart(productId, quantity, exactCartKey);
                    // CRITICAL: Also update the cart backend immediately
                    this.updateCartQuantityDirectly(exactCartKey, quantity);
                } else {
                    console.log('ℹ️ Product not in cart yet:', exactCartKey);
                }
            }
        };
        
        // Add fresh event listeners to the new input element
        quantityInput.addEventListener('input', this.handleProductDetailsInput);
        quantityInput.addEventListener('change', this.handleProductDetailsChange);
        
        console.log('✅ Bidirectional sync re-initialized with backend updates');
    }
    
    /**
     * Set up product details quantity increase/decrease controls
     */
    setupProductDetailsQuantityControls() {
        document.addEventListener('click', (e) => {
            // Handle increase button
            if (e.target.classList.contains('quantity__value_details') && e.target.classList.contains('increase')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                console.log('➕ Product details increase clicked');
                this.handleProductDetailsQuantityIncrease();
            }
            // Handle decrease button  
            else if (e.target.classList.contains('quantity__value_details') && e.target.classList.contains('decrease')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                console.log('➖ Product details decrease clicked');
                this.handleProductDetailsQuantityDecrease();
            }
        }, true);
    }
    
    /**
     * Handle product details quantity increase
     */
    handleProductDetailsQuantityIncrease() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        const maxStock = parseInt(quantityInput.getAttribute('max')) || 999;
        
        console.log('📊 Product details increase validation:', { currentQty, maxStock });
        
        if (currentQty >= maxStock) {
            this.showToastr('warning', `Maximum available quantity is ${maxStock}`, 'Stock Limit');
            return;
        }
        
        quantityInput.value = currentQty + 1;
        
        // Trigger both input and change events for complete sync
        const inputEvent = new Event('input', { bubbles: true });
        const changeEvent = new Event('change', { bubbles: true });
        quantityInput.dispatchEvent(inputEvent);
        quantityInput.dispatchEvent(changeEvent);
        
        // Perform stock check for new quantity
        this.performProductDetailsStockCheck();
    }
    
    /**
     * Handle product details quantity decrease
     */
    handleProductDetailsQuantityDecrease() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        
        if (currentQty <= 1) {
            this.showToastr('info', 'Minimum quantity is 1', 'Quantity Limit');
            return;
        }
        
        quantityInput.value = currentQty - 1;
        
        // Trigger both input and change events for complete sync
        const inputEvent = new Event('input', { bubbles: true });
        const changeEvent = new Event('change', { bubbles: true });
        quantityInput.dispatchEvent(inputEvent);
        quantityInput.dispatchEvent(changeEvent);
        
        // Perform stock check for new quantity
        this.performProductDetailsStockCheck();
    }
    
    /**
     * Set up product details input validation
     */
    setupProductDetailsInputValidation() {
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (!quantityInput) {
            console.warn('⚠️ Cannot setup input validation - quantity input not found');
            return;
        }
        
        console.log('🔧 Setting up product details input validation...');
        
        // Remove any existing event listeners
        quantityInput.removeEventListener('input', this.handleValidationInput);
        quantityInput.removeEventListener('change', this.handleValidationChange);
        quantityInput.removeEventListener('keypress', this.handleValidationKeypress);
        
        // Create bound event handlers
        this.handleValidationInput = (e) => {
            this.validateProductDetailsQuantityInput(e.target);
        };
        
        this.handleValidationChange = (e) => {
            this.validateProductDetailsQuantityInput(e.target);
            this.performProductDetailsStockCheck();
        };
        
        this.handleValidationKeypress = (e) => {
            // Only allow numbers
            if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.preventDefault();
            }
        };
        
        // Add event listeners
        quantityInput.addEventListener('input', this.handleValidationInput);
        quantityInput.addEventListener('change', this.handleValidationChange);
        quantityInput.addEventListener('keypress', this.handleValidationKeypress);
        
        console.log('✅ Product details input validation setup complete');
    }
    
    /**
     * Validate product details quantity input
     */
    validateProductDetailsQuantityInput(input) {
        const value = parseInt(input.value) || 1;
        const maxStock = parseInt(input.getAttribute('max')) || 999;
        const minStock = parseInt(input.getAttribute('min')) || 1;
        
        if (value < minStock) {
            input.value = minStock;
            this.showToastr('info', `Minimum quantity is ${minStock}`, 'Quantity Adjusted');
        } else if (value > maxStock && maxStock < 999) {
            input.value = maxStock;
            this.showToastr('warning', `Maximum available quantity is ${maxStock}`, 'Quantity Adjusted');
        }
    }
    
    /**
     * Set up variant change handlers (color/size selection)
     */
    setupProductDetailsVariantHandlers() {
        // Listen for color changes - handle both array and single input formats
        document.addEventListener('change', (e) => {
            if (e.target.name === 'color_id[]' || e.target.name === 'color_id' || e.target.id === 'color_id') {
                console.log('🎨 Color variant changed:', e.target.value, 'from input:', e.target.name || e.target.id);
                this.handleProductDetailsVariantChange();
            }
        });
        
        // Listen for size changes - handle both array and single input formats
        document.addEventListener('change', (e) => {
            if (e.target.name === 'size_id[]' || e.target.name === 'size_id' || e.target.id === 'size_id') {
                console.log('📏 Size variant changed:', e.target.value, 'from input:', e.target.name || e.target.id);
                this.handleProductDetailsVariantChange();
            }
        });
        
        // Listen for radio button clicks (if variants use radio buttons)
        document.addEventListener('click', (e) => {
            if (e.target.type === 'radio' && (
                e.target.name === 'color_id[]' || e.target.name === 'color_id' ||
                e.target.name === 'size_id[]' || e.target.name === 'size_id'
            )) {
                console.log('🔘 Variant radio changed:', e.target.name, e.target.value);
                setTimeout(() => this.handleProductDetailsVariantChange(), 50);
            }
        });
    }
    
    /**
     * Handle variant change (color/size selection)
     */
    handleProductDetailsVariantChange() {
        console.log('🔄 Handling variant change...');
        
        // Reset quantity to 1 when variant changes
        const quantityInput = document.getElementById('product_details_cart_qty');
        if (quantityInput) {
            quantityInput.value = 1;
        }
        
        // Perform stock check for new variant
        setTimeout(() => {
            this.performProductDetailsStockCheck();
        }, 100);
        
        // Update sidebar if current variant is in cart
        const productId = document.getElementById('product_id')?.value;
        if (productId) {
            const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
            this.updateSidebarQuantityIfInCart(productId, 1, exactCartKey);
        }
    }
    
    /**
     * Set up cart operation handlers for product details
     */
    setupProductDetailsCartHandlers() {
        // Override legacy add to cart handlers with event capture
        document.addEventListener('click', (e) => {
            // Handle add to cart with quantity
            if (e.target.closest('.addToCartWithQty')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.addToCartWithQty');
                const productId = button.getAttribute('data-id') || document.getElementById('product_id')?.value;
                
                if (productId) {
                    console.log('🛒 Product details add to cart with qty:', productId);
                    this.handleProductDetailsAddToCart(productId, button);
                }
            }
            // Handle buy now
            else if (e.target.closest('.buyNowWithQty')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const button = e.target.closest('.buyNowWithQty');
                const productId = button.getAttribute('data-id') || document.getElementById('product_id')?.value;
                
                if (productId) {
                    console.log('🛒 Product details buy now:', productId);
                    this.handleProductDetailsBuyNow(productId, button);
                }
            }
        }, true); // Use capture phase to intercept before legacy handlers
    }
    
    /**
     * Handle add to cart from product details
     */
    async handleProductDetailsAddToCart(productId, button) {
        const quantityInput = document.getElementById('product_details_cart_qty');
        const quantity = parseInt(quantityInput?.value) || 1;
        
        // Validate stock before adding
        const stockCheckPassed = await this.validateProductDetailsStock(quantity);
        if (!stockCheckPassed) {
            return;
        }
        
        // Get variant information
        const formData = this.buildProductDetailsFormData(productId, quantity);
        
        console.log('🛒 Adding to cart from product details:', formData);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
        button.disabled = true;
        
        try {
            const response = await fetch('/add/to/cart/with/qty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update UI
                this.updateCartUI(data);
                
                // Update button state
                button.innerHTML = '<span class="add__to--cart__text">Added</span>';
                button.classList.remove('addToCartWithQty');
                button.classList.add('removeFromCart');
                
                // Show success message
                this.showToastr('success', 'Product added to cart successfully!', 'Added to Cart');
                
                // Update sidebar quantity if needed
                setTimeout(() => {
                    const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
                    this.updateSidebarQuantityIfInCart(productId, quantity, exactCartKey);
                }, 500);
                
            } else {
                throw new Error(data.message || 'Failed to add to cart');
            }
            
        } catch (error) {
            console.error('Add to cart failed:', error);
            this.showToastr('error', error.message || 'Failed to add to cart', 'Error');
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    }
    
    /**
     * Handle buy now from product details  
     */
    async handleProductDetailsBuyNow(productId, button) {
        const quantityInput = document.getElementById('product_details_cart_qty');
        const quantity = parseInt(quantityInput?.value) || 1;
        
        // Validate stock before proceeding
        const stockCheckPassed = await this.validateProductDetailsStock(quantity);
        if (!stockCheckPassed) {
            return;
        }
        
        // Get variant information
        const formData = this.buildProductDetailsFormData(productId, quantity);
        
        console.log('🛒 Buy now from product details:', formData);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        button.disabled = true;
        
        try {
            // First add to cart
            const addResponse = await fetch('/add/to/cart/with/qty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(formData)
            });
            
            const addData = await addResponse.json();
            
            if (addData.success) {
                // Redirect to checkout
                window.location.href = '/cart';
            } else {
                throw new Error(addData.message || 'Failed to process buy now');
            }
            
        } catch (error) {
            console.error('Buy now failed:', error);
            this.showToastr('error', error.message || 'Failed to process buy now', 'Error');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    }
    
    /**
     * Build form data for product details operations
     */
    buildProductDetailsFormData(productId, quantity) {
        const formData = {
            product_id: productId,
            quantity: quantity
        };
        
        // Add color if selected - handle both array and single input formats
        const colorInput = document.querySelector('input[name="color_id[]"]:checked') ||  // Array format (radio buttons)
                          document.querySelector('input[name="color_id"]:checked') ||     // Single format (radio)
                          document.querySelector('select[name="color_id"]') ||            // Select dropdown
                          document.querySelector('#color_id');                           // ID-based input
        
        if (colorInput && colorInput.value) {
            formData.color_id = colorInput.value;
        }
        
        // Add size if selected - handle both array and single input formats
        const sizeInput = document.querySelector('input[name="size_id[]"]:checked') ||    // Array format (radio buttons)
                         document.querySelector('input[name="size_id"]:checked') ||       // Single format (radio)
                         document.querySelector('select[name="size_id"]') ||              // Select dropdown
                         document.querySelector('#size_id');                             // ID-based input
        
        if (sizeInput && sizeInput.value) {
            formData.size_id = sizeInput.value;
        }
        
        console.log('🔍 Built form data from details page:', formData, {
            colorInput: colorInput?.name || 'not found',
            sizeInput: sizeInput?.name || 'not found'
        });
        
        return formData;
    }
    
    /**
     * Validate product details stock before operations
     */
    async validateProductDetailsStock(quantity) {
        const productId = document.getElementById('product_id')?.value;
        if (!productId) return false;
        
        const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
        
        try {
            const response = await this.checkProductStockWithVariant(exactCartKey, productId, quantity);
            
            if (!response.success || !response.in_stock) {
                this.showToastr('warning', response.message || 'Insufficient stock', 'Stock Error');
                return false;
            }
            
            return true;
        } catch (error) {
            console.error('Stock validation failed:', error);
            this.showToastr('error', 'Unable to verify stock. Please try again.', 'Validation Error');
            return false;
        }
    }
    
    /**
     * Perform stock check for current product details variant
     */
    async performProductDetailsStockCheck() {
        const productId = document.getElementById('product_id')?.value;
        const quantityInput = document.getElementById('product_details_cart_qty');
        
        if (!productId || !quantityInput) return;
        
        const quantity = parseInt(quantityInput.value) || 1;
        const exactCartKey = this.buildExactCartKeyFromDetailsPage(productId);
        
        console.log('🔍 Performing product details stock check:', { exactCartKey, quantity });
        
        try {
            const response = await this.checkProductStockWithVariant(exactCartKey, productId, quantity);
            
            if (response.success && response.in_stock) {
                const availableQty = response.available_quantity || 999;
                
                // Update max attribute
                quantityInput.setAttribute('max', availableQty);
                
                // Validate current quantity
                if (quantity > availableQty) {
                    quantityInput.value = availableQty;
                    this.showToastr('warning', `Quantity adjusted to available stock: ${availableQty}`, 'Stock Limit');
                }
                
                // Update increase button state
                const increaseBtn = document.querySelector('.quantity__value_details.increase');
                if (increaseBtn) {
                    if (quantity >= availableQty) {
                        increaseBtn.disabled = true;
                        increaseBtn.style.opacity = '0.5';
                        increaseBtn.setAttribute('title', `Maximum: ${availableQty}`);
                    } else {
                        increaseBtn.disabled = false;
                        increaseBtn.style.opacity = '1';
                        increaseBtn.removeAttribute('title');
                    }
                }
                
                console.log('✅ Product details stock check passed:', { availableQty });
                
            } else {
                // Out of stock
                quantityInput.setAttribute('max', '0');
                quantityInput.value = 1;
                
                const increaseBtn = document.querySelector('.quantity__value_details.increase');
                if (increaseBtn) {
                    increaseBtn.disabled = true;
                    increaseBtn.style.opacity = '0.5';
                    increaseBtn.setAttribute('title', 'Out of stock');
                }
                
                this.showToastr('warning', response.message || 'Product is out of stock', 'Stock Warning');
            }
            
        } catch (error) {
            console.error('Product details stock check failed:', error);
        }
    }

    /**
     * Initialize checkout-specific functionality
     */
    initializeCheckout() {
        console.log('🛒 Initializing checkout stock validation...');
        
        // Set up quantity controls
        this.setupQuantityControls();
        
        // Set up input validation
        this.setupQuantityInputValidation();
        
        // Immediate stock check for better UX
        this.performInitialStockCheck();
    }
    
    /**
     * Initialize sidebar cart functionality
     */
    initializeSidebar() {
        console.log('⚡ Initializing sidebar cart - optimized for single item checks...');
        
        // Set up quantity controls for sidebar
        this.setupSidebarControls();
        
        // ONLY do initial batch check once during startup
        console.log('🔄 Performing one-time initial stock check for all sidebar items...');
        setTimeout(() => this.performSidebarStockCheck(), 100);
    }
    
    /**
     * Set up quantity controls for checkout
     */
    setupQuantityControls() {
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.cart-single-product-table-wrapper')) return;
            
            if (e.target.classList.contains('increase')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const cartId = e.target.getAttribute('data-id');
                if (cartId) this.handleQuantityIncrease(cartId);
            } else if (e.target.classList.contains('decrease')) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const cartId = e.target.getAttribute('data-id');
                if (cartId) this.handleQuantityDecrease(cartId);
            }
        }, true);
    }
    
    /**
     * Set up quantity input validation for checkout
     */
    setupQuantityInputValidation() {
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('quantity__number') && 
                e.target.closest('.cart-single-product-table-wrapper')) {
                const cartId = this.getCartIdFromInput(e.target);
                if (cartId) this.validateQuantityInput(e.target, cartId);
            }
        });
        
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('quantity__number') && 
                e.target.closest('.cart-single-product-table-wrapper')) {
                const cartId = this.getCartIdFromInput(e.target);
                if (cartId) {
                    const quantity = parseInt(e.target.value) || 1;
                    this.updateCartQuantity(cartId, quantity);
                    this.debounceStockCheck(cartId);
                }
            }
        });
    }
    
    /**
     * Set up sidebar cart controls
     */
    setupSidebarControls() {
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.minicart__product')) return;
            
            if (e.target.classList.contains('increase') || e.target.classList.contains('quantity__value') && e.target.classList.contains('increase')) {
                e.preventDefault();
                e.stopImmediatePropagation(); // Prevent other handlers
                const cartId = e.target.getAttribute('data-id');
                if (cartId) this.handleSidebarQuantityIncrease(cartId);
            } else if (e.target.classList.contains('decrease') || e.target.classList.contains('quantity__value') && e.target.classList.contains('decrease')) {
                e.preventDefault();
                e.stopImmediatePropagation(); // Prevent other handlers
                const cartId = e.target.getAttribute('data-id');
                if (cartId) this.handleSidebarQuantityDecrease(cartId);
            }
        }, true); // Use capture phase to handle before other event listeners
        
        // Add input validation for sidebar quantity inputs
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('quantity__number') && 
                e.target.closest('.minicart__product')) {
                const cartId = this.getCartIdFromInput(e.target);
                if (cartId) this.validateQuantityInput(e.target, cartId);
            }
        });
        
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('quantity__number') && 
                e.target.closest('.minicart__product')) {
                const cartId = this.getCartIdFromInput(e.target);
                if (cartId) {
                    this.validateQuantityInput(e.target, cartId);
                    const quantity = parseInt(e.target.value) || 1;
                    this.updateSidebarQuantity(cartId, quantity);
                    this.debounceStockCheck(cartId);
                }
            }
        });
    }
    
    /**
     * Handle quantity increase for checkout
     */
    handleQuantityIncrease(cartId) {
        const cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartRow) return;
        
        const quantityInput = cartRow.querySelector('.quantity__number');
        const increaseBtn = cartRow.querySelector('.increase');
        
        if (!quantityInput || !increaseBtn) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        const maxStock = parseInt(quantityInput.getAttribute('data-max-stock')) || 
                        parseInt(quantityInput.getAttribute('max'));
        const isPackage = cartRow.hasAttribute('data-package-id');
        
        console.log('📊 Increase validation:', { cartId, currentQty, maxStock, isPackage });
        
        if (increaseBtn.disabled) {
            const message = increaseBtn.getAttribute('title') || 'Stock limit reached';
            this.showToastr('warning', message, 'Cannot Increase');
            return;
        }
        
        // For packages, be more flexible with variant-based checking
        if (isPackage) {
            this.checkPackageCapacity(cartId, currentQty + 1).then(canIncrease => {
                if (canIncrease) {
                    quantityInput.value = currentQty + 1;
                    this.updateCartQuantity(cartId, currentQty + 1);
                    this.debounceStockCheck(cartId);
                } else {
                    this.showToastr('warning', 'Package stock limit reached', 'Cannot Increase');
                }
            });
            return;
        }
        
        // For regular products with variant checking
        if (maxStock && !isNaN(maxStock) && maxStock > 0 && currentQty >= maxStock) {
            this.showToastr('warning', `Maximum available quantity is ${maxStock}`, 'Stock Limit');
            return;
        }
        
        quantityInput.value = currentQty + 1;
        this.updateCartQuantity(cartId, currentQty + 1);
        this.debounceStockCheck(cartId);
    }
    
    /**
     * Handle quantity decrease
     */
    handleQuantityDecrease(cartId) {
        const cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartRow) return;
        
        const quantityInput = cartRow.querySelector('.quantity__number');
        if (!quantityInput) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        if (currentQty <= 1) return;
        
        quantityInput.value = currentQty - 1;
        this.updateCartQuantity(cartId, currentQty - 1);
        this.debounceStockCheck(cartId);
    }
    
    /**
     * Handle sidebar quantity increase
     */
    handleSidebarQuantityIncrease(cartId) {
        console.log('➕ Sidebar quantity increase for:', cartId);
        
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartItem) {
            console.warn('❌ Cart item not found for:', cartId);
            return;
        }
        
        const quantityInput = cartItem.querySelector('.quantity__number');
        const increaseBtn = cartItem.querySelector('.quantity__value.increase');
        
        if (!quantityInput || !increaseBtn) {
            console.warn('❌ Quantity input or increase button not found for:', cartId);
            return;
        }
        
        const currentQty = parseInt(quantityInput.value) || 1;
        const maxStock = parseInt(quantityInput.getAttribute('data-max-stock')) || 
                        parseInt(quantityInput.getAttribute('max'));
        const isPackage = cartItem.hasAttribute('data-package-id');
        
        console.log('📊 Sidebar increase validation:', { cartId, currentQty, maxStock, isPackage });
        
        if (increaseBtn.disabled) {
            const message = increaseBtn.getAttribute('title') || 'Stock limit reached';
            this.showToastr('warning', message, 'Cannot Increase', 1000);
            return;
        }
        
        // Check stock limit for regular products
        if (!isPackage && maxStock && !isNaN(maxStock) && maxStock > 0) {
            if (currentQty >= maxStock) {
                // Already at maximum - show warning and keep at max
                quantityInput.value = maxStock;
                this.showToastr('warning', `Maximum available quantity is ${maxStock}`, 'Stock Limit', 2000);
                console.warn('❌ Stock limit reached, keeping at maximum:', { cartId, maxStock });
                this.updateSidebarQuantity(cartId, maxStock);
                this.debounceStockCheck(cartId);
                return;
            } else if (currentQty + 1 > maxStock) {
                // Would exceed maximum - set to maximum instead (AUTO-FALLBACK)
                quantityInput.value = maxStock;
                this.showToastr('info', `Set to maximum available quantity: ${maxStock}`, 'Auto-adjusted', 2000);
                console.log('📈 Auto-adjusted to maximum stock:', { cartId, from: currentQty + 1, to: maxStock });
                this.updateSidebarQuantity(cartId, maxStock);
                this.debounceStockCheck(cartId);
                return;
            }
        }
        
        // For packages, check variant-based capacity
        if (isPackage) {
            this.checkPackageCapacity(cartId, currentQty + 1).then(canIncrease => {
                if (canIncrease) {
                    quantityInput.value = currentQty + 1;
                    console.log('✅ Package quantity increased to:', currentQty + 1);
                    this.updateSidebarQuantity(cartId, currentQty + 1);
                    this.debounceStockCheck(cartId);
                } else {
                    // Try to find the maximum allowed quantity for packages
                    this.findPackageMaxQuantity(cartId).then(maxQty => {
                        if (maxQty && maxQty > currentQty) {
                            quantityInput.value = maxQty;
                            this.showToastr('info', `Set to maximum package quantity: ${maxQty}`, 'Auto-adjusted');
                            this.updateSidebarQuantity(cartId, maxQty);
                            this.debounceStockCheck(cartId);
                        } else {
                            this.showToastr('warning', 'Package stock limit reached', 'Cannot Increase');
                        }
                    });
                }
            });
            return;
        }
        
        // Normal increase - within limits
        quantityInput.value = currentQty + 1;
        console.log('✅ Sidebar quantity increased to:', currentQty + 1);
        this.updateSidebarQuantity(cartId, currentQty + 1);
        this.debounceStockCheck(cartId);
    }
    
    /**
     * Handle sidebar quantity decrease
     */
    handleSidebarQuantityDecrease(cartId) {
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartItem) return;
        
        const quantityInput = cartItem.querySelector('.quantity__number');
        if (!quantityInput) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        if (currentQty <= 1) return;
        
        quantityInput.value = currentQty - 1;
        this.updateSidebarQuantity(cartId, currentQty - 1);
        this.debounceStockCheck(cartId);
    }
    
    /**
     * Check package capacity with variant-based logic
     */
    async checkPackageCapacity(cartId, requestedQty) {
        const cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartRow) return false;
        
        const packageId = cartRow.getAttribute('data-package-id');
        if (!packageId) return false;
        
        try {
            const response = await this.checkPackageStock(packageId, requestedQty);
            
            if (response.success && response.variant_analysis) {
                // Check if any variant would be exceeded
                const variantIssues = response.variant_analysis.filter(variant => 
                    variant.required_qty > variant.available_qty
                );
                
                if (variantIssues.length > 0) {
                    console.log('📦 Package variant limits:', variantIssues);
                    return false;
                }
            }
            
            return response.success && response.in_stock;
        } catch (error) {
            console.error('Package capacity check failed:', error);
            return false;
        }
    }
    
    /**
     * Find maximum allowed quantity for a package by checking stock limits
     */
    async findPackageMaxQuantity(cartId) {
        const cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        if (!cartRow) return null;
        
        const packageId = cartRow.getAttribute('data-package-id');
        if (!packageId) return null;
        
        // Binary search for maximum quantity
        let low = 1;
        let high = 100; // Reasonable upper limit
        let maxQty = 1;
        
        while (low <= high) {
            const mid = Math.floor((low + high) / 2);
            
            try {
                const response = await this.checkPackageStock(packageId, mid);
                
                if (response.success && response.in_stock) {
                    maxQty = mid;
                    low = mid + 1;
                } else {
                    high = mid - 1;
                }
            } catch (error) {
                break;
            }
        }
        
        return maxQty;
    }
    
    /**
     * Perform initial stock check for checkout
     */
    performInitialStockCheck() {
        this.isAutoCheck = true; // Set auto-check flag to prevent loading indicators
        
        // Context-aware cart row selection
        let cartRows;
        if (this.context === 'checkout') {
            // Only find checkout table rows, not sidebar elements
            cartRows = document.querySelectorAll('.cart-single-product-table-wrapper[data-cart-id]');
            
            // Fallback to other checkout selectors if no wrapper found
            if (cartRows.length === 0) {
                cartRows = document.querySelectorAll('.cart-single-product-table [data-cart-id], .checkout-table [data-cart-id]');
            }
        } else {
            // For other contexts, find all cart items
            cartRows = document.querySelectorAll('[data-cart-id]');
        }
        
        console.log(`🔍 Performing initial stock check for ${cartRows.length} items... (Context: ${this.context})`);
        
        if (cartRows.length === 0) {
            console.warn('❌ No cart items found for stock checking');
            this.isAutoCheck = false;
            return;
        }
        
        // Log what we found
        cartRows.forEach((cartRow, index) => {
            const cartId = cartRow.getAttribute('data-cart-id');
            const isPackage = cartRow.hasAttribute('data-package-id');
            const packageId = cartRow.getAttribute('data-package-id');
            const productId = cartRow.getAttribute('data-product-id');
            const statusElement = cartRow.querySelector('.stock-status') || 
                                cartRow.querySelector('.stock-status-mini') ||
                                cartRow.querySelector(`#checkout_stock_${cartId}`) ||
                                cartRow.querySelector('.checkout-package-stock-status') ||
                                cartRow.querySelector('.checkout-product-stock-status');
            
            console.log(`Item ${index + 1}:`, {
                cartId,
                isPackage,
                packageId,
                productId,
                hasStatusElement: !!statusElement,
                statusElementId: statusElement?.id || 'no-id',
                statusElementClass: statusElement?.className || 'no-class'
            });
        });
        
        // Use batch processing for faster initial load
        const items = Array.from(cartRows).map(cartRow => {
            const cartId = cartRow.getAttribute('data-cart-id');
            const quantityInput = cartRow.querySelector('.quantity__number');
            const quantity = parseInt(quantityInput?.value) || 1;
            
            return { cartId, quantity, cartRow };
        }).filter(item => item.cartId);
        
        // Process in smaller batches to prevent overwhelming the server
        this.processBatchedStockCheck(items);
    }
    
    /**
     * Perform sidebar stock check
     */
    performSidebarStockCheck() {
        this.isAutoCheck = true; // Set auto-check flag to prevent loading indicators
        
        const cartItems = document.querySelectorAll('.minicart__product--items[data-cart-id]');
        console.log(`🔍 Performing sidebar stock check for ${cartItems.length} items...`);
        
        this.batchCheckStock(Array.from(cartItems).map(item => {
            const cartId = item.getAttribute('data-cart-id');
            const packageId = item.getAttribute('data-package-id');
            const productId = item.getAttribute('data-product-id') || cartId;
            const quantity = parseInt(item.querySelector('.quantity__number')?.value) || 1;
            let statusEl;
            // Always use .stock-status-mini, but fallback to global ID for robustness
            statusEl = item.querySelector('.stock-status-mini') || document.getElementById(`mini_stock_${cartId}`);
            return {
                cartId,
                packageId,
                productId,
                quantity,
                statusEl,
                isPackage: !!packageId
            };
        }));
    }
    
    /**
     * Batch stock checking for better performance
     */
    async batchCheckStock(items) {
        const batchSize = this.config.batchSize;
        
        for (let i = 0; i < items.length; i += batchSize) {
            const batch = items.slice(i, i + batchSize);
            
            await Promise.allSettled(batch.map(async (item) => {
                if (item.isPackage) {
                    await this.checkPackageStockForSidebar(item);
                } else {
                    await this.checkProductStockForSidebar(item);
                }
            }));
            
            // Brief pause between batches
            if (i + batchSize < items.length) {
                await new Promise(resolve => setTimeout(resolve, 100));
            }
        }
        
        // Reset auto-check flag after sidebar batch processing
        this.isAutoCheck = false;
    }
    
    /**
     * Check package stock for sidebar
     */
    async checkPackageStockForSidebar(item) {
        if (!item.statusEl) return;
        
        item.statusEl.innerHTML = '<span class="stock-checking text-muted"><i class="bi bi-clock"></i> Checking...</span>';
        
        try {
            const response = await this.checkPackageStock(item.packageId, item.quantity);
            this.applyStockStatus(item.statusEl, response, item.cartId, true);
        } catch (error) {
            console.error('Package stock check failed:', error);
            const errorMsg = error.message.includes('timeout') ? 'Timeout' : 'Connection error';
            item.statusEl.innerHTML = `<span class="stock-issue"><i class="bi bi-exclamation-triangle"></i> ${errorMsg}</span>`;
        }
    }
    
    /**
     * Check product stock for sidebar
     */
    async checkProductStockForSidebar(item) {
        if (!item.statusEl) return;
        
        item.statusEl.innerHTML = '<span class="stock-checking text-muted"><i class="bi bi-clock"></i> Checking...</span>';
        
        try {
            // Use variant-aware stock checking for sidebar
            const response = await this.checkProductStockWithVariant(item.cartId, item.productId, item.quantity);
            this.applyStockStatus(item.statusEl, response, item.cartId, false);
        } catch (error) {
            console.error('Product stock check failed:', error);
            const errorMsg = error.message.includes('timeout') ? 'Timeout' : 'Connection error';
            item.statusEl.innerHTML = `<span class="stock-issue"><i class="bi bi-exclamation-triangle"></i> ${errorMsg}</span>`;
        }
    }
    
    /**
     * Check package stock via API with throttling
     */
    async checkPackageStock(packageId, quantity) {
        const cacheKey = `pkg_${packageId}_${quantity}`;
        const cached = this.cache.get(cacheKey);
        
        if (cached && (Date.now() - cached.timestamp) < this.config.cacheTimeout) {
            return cached.data;
        }

        // Check if we're already processing this request
        const requestKey = `pkg_${packageId}_${quantity}`;
        if (this.pendingRequests.has(requestKey)) {
            console.log('⏭️ Skipping duplicate package request:', requestKey);
            return cached?.data || { success: false, message: 'Request in progress' };
        }

        // Throttle requests
        const now = Date.now();
        const timeSinceLastRequest = now - this.lastRequestTime;
        if (timeSinceLastRequest < this.config.throttleDelay) {
            const delay = this.config.throttleDelay - timeSinceLastRequest;
            console.log(`⏱️ Throttling package request for ${delay}ms`);
            await new Promise(resolve => setTimeout(resolve, delay));
        }

        this.pendingRequests.add(requestKey);
        this.lastRequestTime = Date.now();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            this.pendingRequests.delete(requestKey);
            throw new Error('CSRF token not found');
        }
        
        // Create abort controller for timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), this.config.requestTimeout);
        
        try {
            const response = await fetch(this.config.endpoints.package, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    package_id: packageId,
                    quantity: quantity
                }),
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Cache the result
            this.cache.set(cacheKey, {
                data,
                timestamp: Date.now()
            });
            
            return data;
        } catch (error) {
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (error.name === 'AbortError') {
                console.error('Package stock check timeout for package:', packageId);
                throw new Error('Request timeout');
            }
            throw error;
        }
    }
    
    /**
     * Check product stock with variant support via API with throttling
     */
    async checkProductStockWithVariant(cartId, productId, quantity) {
        // Parse variant information from cart ID
        const variantInfo = this.parseVariantFromCartId(cartId);
        
        const cacheKey = `prod_variant_${cartId}_${quantity}`;
        const cached = this.cache.get(cacheKey);
        
        if (cached && (Date.now() - cached.timestamp) < this.config.cacheTimeout) {
            return cached.data;
        }

        // Check if we're already processing this request
        const requestKey = `prod_variant_${cartId}_${quantity}`;
        if (this.pendingRequests.has(requestKey)) {
            console.log('⏭️ Skipping duplicate variant product request:', requestKey);
            return cached?.data || { success: false, message: 'Request in progress' };
        }

        // Throttle requests
        const now = Date.now();
        const timeSinceLastRequest = now - this.lastRequestTime;
        if (timeSinceLastRequest < this.config.throttleDelay) {
            const delay = this.config.throttleDelay - timeSinceLastRequest;
            console.log(`⏱️ Throttling variant product request for ${delay}ms`);
            await new Promise(resolve => setTimeout(resolve, delay));
        }

        this.pendingRequests.add(requestKey);
        this.lastRequestTime = Date.now();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            this.pendingRequests.delete(requestKey);
            throw new Error('CSRF token not found');
        }
        
        // Create abort controller for timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), this.config.requestTimeout);
        
        // Prepare request payload with variant information
        const requestPayload = {
            product_id: variantInfo.productId,
            quantity: quantity
        };
        
        // Add variant attributes if present
        if (variantInfo.colorId) {
            requestPayload.color_id = variantInfo.colorId;
        }
        if (variantInfo.sizeId) {
            requestPayload.size_id = variantInfo.sizeId;
        }
        
        console.log('🎯 Variant stock check payload:', requestPayload);
        
        try {
            const response = await fetch(this.config.endpoints.product, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(requestPayload),
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Cache the result
            this.cache.set(cacheKey, {
                data,
                timestamp: Date.now()
            });
            
            return data;
        } catch (error) {
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (error.name === 'AbortError') {
                console.error('Variant product stock check timeout for cart:', cartId);
                throw new Error('Request timeout');
            }
            throw error;
        }
    }

    /**
     * Parse variant information from cart ID
     */
    parseVariantFromCartId(cartId) {
        const variantInfo = {
            productId: cartId,
            colorId: null,
            sizeId: null
        };
        
        // Check if this is a variant cart ID (contains color/size info)
        if (cartId.includes('_c') || cartId.includes('_s')) {
            const parts = cartId.split('_');
            variantInfo.productId = parts[0]; // Base product ID
            
            // Parse color and size IDs
            parts.forEach(part => {
                if (part.startsWith('c') && part.length > 1) {
                    variantInfo.colorId = parseInt(part.substring(1));
                } else if (part.startsWith('s') && part.length > 1) {
                    variantInfo.sizeId = parseInt(part.substring(1));
                }
            });
        }
        
        console.log('🔍 Parsed variant info from cart ID:', cartId, '->', variantInfo);
        return variantInfo;
    }

    /**
     * Check product stock via API with throttling
     */
    async checkProductStock(productId, quantity) {
        const cacheKey = `prod_${productId}_${quantity}`;
        const cached = this.cache.get(cacheKey);
        
        if (cached && (Date.now() - cached.timestamp) < this.config.cacheTimeout) {
            return cached.data;
        }

        // Check if we're already processing this request
        const requestKey = `prod_${productId}_${quantity}`;
        if (this.pendingRequests.has(requestKey)) {
            console.log('⏭️ Skipping duplicate product request:', requestKey);
            return cached?.data || { success: false, message: 'Request in progress' };
        }

        // Throttle requests
        const now = Date.now();
        const timeSinceLastRequest = now - this.lastRequestTime;
        if (timeSinceLastRequest < this.config.throttleDelay) {
            const delay = this.config.throttleDelay - timeSinceLastRequest;
            console.log(`⏱️ Throttling product request for ${delay}ms`);
            await new Promise(resolve => setTimeout(resolve, delay));
        }

        this.pendingRequests.add(requestKey);
        this.lastRequestTime = Date.now();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            this.pendingRequests.delete(requestKey);
            throw new Error('CSRF token not found');
        }
        
        // Create abort controller for timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), this.config.requestTimeout);
        
        try {
            const response = await fetch(this.config.endpoints.product, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                }),
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Cache the result
            this.cache.set(cacheKey, {
                data,
                timestamp: Date.now()
            });
            
            return data;
        } catch (error) {
            clearTimeout(timeoutId);
            this.pendingRequests.delete(requestKey);
            
            if (error.name === 'AbortError') {
                console.error('Product stock check timeout for product:', productId);
                throw new Error('Request timeout');
            }
            throw error;
        }
    }
    
    /**
     * Check stock for a specific item
     */
    async checkStockForItem(cartId, quantity) {
        console.log(`🔍 Checking stock for cart ID: ${cartId}, quantity: ${quantity} (Context: ${this.context})`);
        
        // Avoid duplicate checks for the same quantity
        const lastCheckedKey = `${cartId}_${quantity}`;
        if (this.lastCheckedQuantities.get(cartId) === quantity && !this.isAutoCheck) {
            console.log(`⏭️ Skipping duplicate check for cart ${cartId} with quantity ${quantity}`);
            return;
        }
        this.lastCheckedQuantities.set(cartId, quantity);
        
        // Context-aware cart row selection - prioritize based on current context
        let cartRow;
        if (this.context === 'checkout') {
            // In checkout context, prioritize checkout table rows
            cartRow = document.querySelector(`.cart-single-product-table-wrapper[data-cart-id="${cartId}"]`) ||
                     document.querySelector(`.cart-single-product-table [data-cart-id="${cartId}"]`) ||
                     document.querySelector(`.checkout-table [data-cart-id="${cartId}"]`) ||
                     document.querySelector(`[data-cart-id="${cartId}"]`); // fallback
        } else {
            // In other contexts, find any cart row
            cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        }
        
        if (!cartRow) {
            console.warn(`❌ Cart row not found for ID: ${cartId}`);
            return;
        }
        
        const isPackage = cartRow.hasAttribute('data-package-id');
        
        // Smart element detection - check what type of cart row this is
        let statusElement;
        const isCheckoutRow = cartRow.classList.contains('cart-single-product-table-wrapper') || 
                             cartRow.closest('.cart-single-product-table') ||
                             cartRow.closest('.checkout-table');
        const isSidebarRow = cartRow.closest('.minicart__product');
        
        console.log(`🔍 Element detection for cart ${cartId}:`, {
            cartRowClasses: cartRow.className,
            hasWrapperClass: cartRow.classList.contains('cart-single-product-table-wrapper'),
            isCheckoutRow: !!isCheckoutRow,
            isSidebarRow: !!isSidebarRow,
            context: this.context
        });
        
        if (isCheckoutRow) {
            // This is a checkout table row
            const checkoutById = document.getElementById(`checkout_stock_${cartId}`);
            const checkoutByPackageClass = cartRow.querySelector('.checkout-package-stock-status');
            const checkoutByProductClass = cartRow.querySelector('.checkout-product-stock-status');
            statusElement = checkoutById || checkoutByPackageClass || checkoutByProductClass;
        } else if (isSidebarRow) {
            // This is a sidebar cart row
            statusElement = cartRow.querySelector('.stock-status-mini') || 
                          document.getElementById(`mini_stock_${cartId}`);
        } else {
            // Fallback - context-aware selection
            if (this.context === 'checkout') {
                // Prioritize checkout elements
                statusElement = document.getElementById(`checkout_stock_${cartId}`) ||
                              cartRow.querySelector('.checkout-package-stock-status') ||
                              cartRow.querySelector('.checkout-product-stock-status') ||
                              document.getElementById(`mini_stock_${cartId}`) ||
                              cartRow.querySelector('.stock-status-mini') ||
                              cartRow.querySelector('.stock-status');
            } else {
                // Prioritize sidebar elements
                statusElement = document.getElementById(`mini_stock_${cartId}`) ||
                              cartRow.querySelector('.stock-status-mini') ||
                              document.getElementById(`checkout_stock_${cartId}`) ||
                              cartRow.querySelector('.checkout-package-stock-status') ||
                              cartRow.querySelector('.checkout-product-stock-status') ||
                              cartRow.querySelector('.stock-status');
            }
        }

        console.log(`🎯 Found element for cart ${cartId}:`, {
            element: statusElement,
            id: statusElement?.id,
            classes: statusElement?.className,
            isPackage,
            isCheckoutRow: !!isCheckoutRow,
            isSidebarRow: !!isSidebarRow,
            context: this.context
        });

        if (!statusElement) {
            console.warn(`❌ No status element found for cart ID: ${cartId}`);
            return;
        }

        // Only show loading state if this is a user-initiated action (not an auto-check)
        // This prevents "Verifying stock..." from appearing on other items
        if (!this.isAutoCheck) {
            statusElement.innerHTML = '<span class="stock-checking text-muted"><i class="bi bi-clock"></i> Checking stock...</span>';
        }
        
        // Set a fallback timeout to prevent indefinite loading
        const fallbackTimeout = setTimeout(() => {
            if (statusElement.innerHTML.includes('Checking stock...') || statusElement.innerHTML.includes('Verifying stock...')) {
                statusElement.innerHTML = '<span class="stock-issue"><i class="bi bi-exclamation-triangle"></i> Unable to check stock</span>';
            }
        }, this.config.requestTimeout + 1000);
        
        try {
            if (isPackage) {
                const packageId = cartRow.getAttribute('data-package-id');
                console.log(`🔍 Checking package stock: ${packageId}, quantity: ${quantity}`);
                const response = await this.checkPackageStock(packageId, quantity);
                clearTimeout(fallbackTimeout);
                console.log(`📦 Package response received for ${cartId}:`, response);
                this.applyStockStatus(statusElement, response, cartId, true);
            } else {
                // For variant products, use the cart ID to get variant-specific stock
                const productId = cartRow.getAttribute('data-product-id') || cartId.split('_')[0];
                console.log(`🔍 Checking product stock: ${productId} (cartId: ${cartId}), quantity: ${quantity}`);
                const response = await this.checkProductStockWithVariant(cartId, productId, quantity);
                clearTimeout(fallbackTimeout);
                console.log(`🛍️ Product response received for ${cartId}:`, response);
                this.applyStockStatus(statusElement, response, cartId, false);
            }
        } catch (error) {
            clearTimeout(fallbackTimeout);
            console.error('Stock check failed:', error);
            const errorMsg = error.message.includes('timeout') ? 'Request timeout' : 'Check failed';
            statusElement.innerHTML = `<span class="stock-issue"><i class="bi bi-exclamation-triangle"></i> ${errorMsg}</span>`;
        }
    }
    
    /**
     * Apply stock status for both checkout and sidebar items (smart detection)
     */
    applyStockStatus(statusElement, data, cartId, isPackage) {
        console.log(`🎯 Applying status for cart ${cartId}:`, {
            success: data.success,
            in_stock: data.in_stock,
            isPackage,
            message: data.message
        });
        
        if (!statusElement) {
            console.warn(`❌ No status element provided for cart ${cartId}`);
            return;
        }
        
        const cartRow = document.querySelector(`[data-cart-id="${cartId}"]`);
        const quantityInput = cartRow?.querySelector('.quantity__number');
        
        // Smart button detection - different classes for checkout vs sidebar
        const increaseBtn = cartRow?.querySelector('.increase') || cartRow?.querySelector('.quantity__value.increase');
        
        // Detect if this is a sidebar or checkout element
        const isSidebarElement = statusElement.classList.contains('stock-status-mini') || 
                                statusElement.id?.startsWith('mini_stock_');
        
        let statusHTML = '';
        
        if (data.success && data.in_stock) {
            if (isPackage) {
                // Enhanced package status with variant info
                if (data.variant_analysis && data.variant_analysis.length > 0) {
                    const itemCount = data.variant_analysis.length;
                    const limitingVariant = data.variant_analysis.reduce((min, variant) => 
                        variant.max_package_qty < min.max_package_qty ? variant : min
                    );
                    
                    if (isSidebarElement) {
                        statusHTML = `<span class="stock-available"><i class="bi bi-check-circle-fill"></i> Max: ${limitingVariant.max_package_qty} packages</span>`;
                    } else {
                        statusHTML = `<span class="stock-available"><i class="bi bi-check-circle"></i> ${itemCount} items available, max: ${limitingVariant.max_package_qty}</span>`;
                    }
                    
                    // Set limit based on most restrictive variant
                    if (quantityInput) {
                        quantityInput.setAttribute('data-max-stock', limitingVariant.max_package_qty);
                        quantityInput.setAttribute('max', limitingVariant.max_package_qty);
                    }
                    this.updateIncreaseButton(increaseBtn, quantityInput, limitingVariant.max_package_qty);
                } else {
                    if (isSidebarElement) {
                        statusHTML = '<span class="stock-available text-success"><i class="fas fa-check-circle"></i> Available</span>';
                    } else {
                        statusHTML = '<span class="stock-available"><i class="bi bi-check-circle"></i> Package available</span>';
                    }
                    if (quantityInput) {
                        quantityInput.setAttribute('data-max-stock', '999');
                        quantityInput.setAttribute('max', '999');
                    }
                    this.resetQuantityLimit(increaseBtn);
                }
            } else {
                // Product status with real-time stock calculation
                const availableQty = data.available_quantity || 0;
                const currentQty = parseInt(quantityInput?.value) || 1;
                const remainingQty = Math.max(0, availableQty - currentQty);
                
                if (availableQty > 0) {
                    if (isSidebarElement) {
                        // CONSISTENT: Always show "Available" for sidebar items that are in stock
                        statusHTML = '<span class="stock-available text-success"><i class="fas fa-check-circle"></i> Available</span>';
                    } else {
                        if (currentQty > 1 && availableQty < 999) {
                            statusHTML = `<span class="stock-available"><i class="bi bi-check-circle"></i> ${availableQty} total, ${remainingQty} remaining</span>`;
                        } else {
                            statusHTML = `<span class="stock-available"><i class="bi bi-check-circle"></i> ${availableQty} available</span>`;
                        }
                    }
                    if (quantityInput) {
                        quantityInput.setAttribute('data-max-stock', availableQty);
                        quantityInput.setAttribute('max', availableQty);
                    }
                    this.updateIncreaseButton(increaseBtn, quantityInput, availableQty);
                } else {
                    if (isSidebarElement) {
                        // CONSISTENT: Show "Available" even for unlimited stock in sidebar
                        statusHTML = '<span class="stock-available text-success"><i class="fas fa-check-circle"></i> Available</span>';
                    } else {
                        statusHTML = '<span class="stock-available"><i class="bi bi-check-circle"></i> In stock</span>';
                    }
                    this.resetQuantityLimit(increaseBtn);
                }
            }
        } else {
            // Out of stock or error
            const message = data.message || (isPackage ? 'Package unavailable' : 'Out of stock');
            if (isSidebarElement) {
                statusHTML = `<span class="stock-issue"><i class="bi bi-x-circle-fill"></i> ${message}</span>`;
            } else {
                statusHTML = `<span class="stock-issue"><i class="bi bi-exclamation-triangle"></i> ${message}</span>`;
            }
            
            if (quantityInput) {
                quantityInput.setAttribute('data-max-stock', '0');
                quantityInput.setAttribute('max', '0');
            }
            if (increaseBtn) {
                increaseBtn.disabled = true;
                increaseBtn.style.opacity = '0.5';
                increaseBtn.setAttribute('title', message);
            }
        }
        
        // Update DOM only if content changed
        if (statusElement.innerHTML !== statusHTML) {
            statusElement.innerHTML = statusHTML;
            console.log(`✅ Status updated for cart ${cartId}: ${statusHTML.replace(/<[^>]*>/g, '').trim()}`);
        } else {
            console.log(`ℹ️ No update needed for cart ${cartId}`);
        }
    }
    
    /**
     * Update increase button state
     */
    updateIncreaseButton(increaseBtn, quantityInput, maxStock) {
        if (!increaseBtn || !quantityInput) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        
        if (currentQty >= maxStock) {
            increaseBtn.disabled = true;
            increaseBtn.style.opacity = '0.5';
            increaseBtn.setAttribute('title', `Maximum: ${maxStock}`);
        } else {
            increaseBtn.disabled = false;
            increaseBtn.style.opacity = '1';
            increaseBtn.removeAttribute('title');
        }
    }
    
    /**
     * Set quantity limit for inputs and buttons
     */
    setQuantityLimit(quantityInput, increaseBtn, maxStock) {
        if (!quantityInput || !increaseBtn) return;
        
        const currentQty = parseInt(quantityInput.value) || 1;
        
        if (maxStock !== null && maxStock > 0) {
            quantityInput.setAttribute('max', maxStock);
            quantityInput.setAttribute('data-max-stock', maxStock);
            
            if (currentQty > maxStock) {
                quantityInput.value = maxStock;
            }
        } else {
            quantityInput.setAttribute('max', '999');
            quantityInput.setAttribute('data-max-stock', '0');
        }
        
        if (maxStock !== null && maxStock <= 0) {
            increaseBtn.disabled = true;
            increaseBtn.style.opacity = '0.4';
            increaseBtn.setAttribute('title', 'Out of stock');
        } else if (maxStock !== null && currentQty >= maxStock) {
            increaseBtn.disabled = true;
            increaseBtn.style.opacity = '0.4';
            increaseBtn.setAttribute('title', `Maximum: ${maxStock}`);
        } else {
            increaseBtn.disabled = false;
            increaseBtn.style.opacity = '1';
            increaseBtn.removeAttribute('title');
        }
    }
    
    /**
     * Reset quantity limit
     */
    resetQuantityLimit(increaseBtn) {
        if (!increaseBtn) return;
        
        increaseBtn.disabled = false;
        increaseBtn.style.opacity = '1';
        increaseBtn.removeAttribute('title');
    }
    
    /**
     * Validate quantity input
     */
    validateQuantityInput(input, cartId) {
        const value = parseInt(input.value) || 1;
        const maxStock = parseInt(input.getAttribute('data-max-stock')) || 
                        parseInt(input.getAttribute('max')) || null; // Don't use 999 as fallback
        
        console.log('🔍 Validating quantity input:', { cartId, value, maxStock });
        
        if (value < 1) {
            input.value = 1;
            this.showToastr('info', 'Minimum quantity is 1', 'Quantity Adjusted');
        } else if (maxStock !== null && maxStock > 0 && value > maxStock) {
            const originalValue = value;
            input.value = maxStock;
            console.log('📈 Auto-fallback applied:', { cartId, from: originalValue, to: maxStock });
            this.showToastr('warning', `Only ${maxStock} available, adjusted from ${originalValue}`, 'Auto-Adjusted to Maximum', 3000);
        } else if (maxStock === null) {
            // No stock information available, trigger stock check to get real limits
            console.log('⚠️ No stock limit found, triggering stock check for cart:', cartId);
            this.debounceStockCheck(cartId);
        }
        
        // Set both attributes to ensure they persist
        if (maxStock !== null && maxStock > 0) {
            input.setAttribute('max', maxStock);
            input.setAttribute('data-max-stock', maxStock);
        }
    }
    
    /**
     * Debounced stock check - OPTIMIZED for single item checking
     */
    debounceStockCheck(cartId) {
        console.log(`⚡ Debouncing stock check for single item: ${cartId}`);
        
        if (this.debounceTimers.has(cartId)) {
            clearTimeout(this.debounceTimers.get(cartId));
        }
        
        const timer = setTimeout(() => {
            // User-initiated actions should show loading indicators
            this.isAutoCheck = false;
            
            console.log(`🎯 Performing targeted stock check for item: ${cartId} (not checking all items)`);
            
            const cartElement = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (cartElement) {
                const quantityInput = cartElement.querySelector('.quantity__number');
                if (quantityInput) {
                    const quantity = parseInt(quantityInput.value) || 1;
                    
                    // ONLY check this specific item - no batch operations
                    this.checkStockForItem(cartId, quantity);
                }
            } else {
                console.warn(`❌ Cart element not found for ${cartId} - skipping stock check`);
            }
            this.debounceTimers.delete(cartId);
        }, this.config.debounceTime);
        
        this.debounceTimers.set(cartId, timer);
    }
    
    /**
     * Get cart ID from input element
     */
    getCartIdFromInput(input) {
        // Try data attribute first
        const cartElement = input.closest('[data-cart-id]');
        return cartElement?.getAttribute('data-cart-id');
    }
    
    /**
     * Update product details quantity input (for bidirectional sync)
     */
    updateProductDetailsQuantity(cartId, quantity) {
        // Check if we're on a product details page
        const productDetailsInput = document.getElementById('product_details_cart_qty');
        if (!productDetailsInput) return;
        
        // Check if the current product matches the cart item being updated
        const productId = document.getElementById('product_id')?.value;
        if (!productId) return;
        
        // Extract product details from cart ID if possible
        let productIdFromCart = cartId;
        if (cartId.includes('_c') || cartId.includes('_s')) {
            // Handle variant-specific cart keys (e.g., "157_c44_s1" -> "157")
            productIdFromCart = cartId.split('_')[0];
        }
        
        // First check if the base product matches
        if (productId === productIdFromCart) {
            // For variant products, check if the specific variant matches what's selected on details page
            if (cartId.includes('_c') || cartId.includes('_s')) {
                const currentlySelectedCartKey = this.buildExactCartKeyFromDetailsPage(productId);
                if (cartId === currentlySelectedCartKey) {
                    console.log('🎯 Updating product details quantity from matching variant:', { cartId, quantity });
                    productDetailsInput.value = quantity;
                    
                    // Trigger any necessary events on the input
                    const event = new Event('input', { bubbles: true });
                    productDetailsInput.dispatchEvent(event);
                } else {
                    console.log('ℹ️ Variant mismatch - cart:', cartId, 'vs selected:', currentlySelectedCartKey);
                }
            } else {
                // Simple product (no variants) - update directly
                console.log('🔄 Updating product details quantity from simple product:', { productId, quantity });
                productDetailsInput.value = quantity;
                
                // Trigger any necessary events on the input
                const event = new Event('input', { bubbles: true });
                productDetailsInput.dispatchEvent(event);
            }
        }
    }
    
    /**
     * Update sidebar quantity when product details quantity changes (reverse sync)
     */
    updateSidebarQuantityIfInCart(productId, quantity, exactCartKey = null) {
        console.log('🔄 Checking if product is in cart for sidebar update:', { productId, quantity, exactCartKey });
        
        // CRITICAL: Only update if we have an exact cart key or we're sure about the product
        if (exactCartKey) {
            // Update only the specific variant by exact cart key
            const exactItem = document.querySelector(`[data-cart-id="${exactCartKey}"]`);
            if (exactItem) {
                const quantityInput = exactItem.querySelector('.quantity__number');
                if (quantityInput && parseInt(quantityInput.value) !== quantity) {
                    console.log('🎯 Updating specific variant:', exactCartKey, 'to quantity:', quantity);
                    
                    // Update the visual quantity
                    quantityInput.value = quantity;
                    
                    // Trigger the cart update for this specific variant only
                    this.updateCartQuantityDirectly(exactCartKey, quantity);
                } else if (quantityInput) {
                    console.log('ℹ️ Quantity already matches for variant:', exactCartKey);
                } else {
                    console.warn('⚠️ No quantity input found for variant:', exactCartKey);
                }
            } else {
                console.log('⚠️ Specific variant not found in sidebar:', exactCartKey);
            }
            return; // Exit early - don't search for other variants
        }
        
        // Fallback: only for simple products without variants
        console.log('🔍 No exact cart key provided, searching by product ID (fallback for simple products):', productId);
        const allCartItems = document.querySelectorAll('[data-cart-id]');
        let matchingItems = [];
        
        allCartItems.forEach(item => {
            const cartId = item.getAttribute('data-cart-id');
            const itemProductId = cartId.split('_')[0]; // Extract base product ID
            
            if (itemProductId === productId) {
                // Check if this is a simple product (no variant suffixes)
                if (cartId === productId || !cartId.includes('_c') && !cartId.includes('_s')) {
                    matchingItems.push({
                        cartId: cartId,
                        element: item
                    });
                }
            }
        });
        
        if (matchingItems.length > 0) {
            console.log('🎯 Found simple product items for update:', matchingItems.length);
            
            matchingItems.forEach(({ cartId, element }) => {
                const quantityInput = element.querySelector('.quantity__number');
                if (quantityInput && parseInt(quantityInput.value) !== quantity) {
                    console.log('🔄 Updating simple product cart item:', cartId, 'to quantity:', quantity);
                    
                    // Update the visual quantity
                    quantityInput.value = quantity;
                    
                    // Trigger the cart update
                    this.updateCartQuantityDirectly(cartId, quantity);
                }
            });
        } else {
            console.log('ℹ️ No simple product found in cart for product ID:', productId);
        }
    }
    
    /**
     * Direct cart update for product details to sidebar sync
     */
    updateCartQuantityDirectly(cartId, quantity) {
        console.log('🛒 Direct cart update from product details:', { cartId, quantity });
        
        // Prevent duplicate updates
        const updateKey = `direct_update_${cartId}`;
        if (this.pendingRequests.has(updateKey)) {
            console.log('⏭️ Skipping duplicate direct cart update for:', cartId);
            return;
        }
        
        this.pendingRequests.add(updateKey);
        
        const formData = new FormData();
        formData.append("cart_id", cartId);
        formData.append("cart_qty", quantity);
        formData.append("_token", document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
        
        fetch('/update/cart/qty', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            this.pendingRequests.delete(updateKey);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Cart update successful from product details:', data);
            
            if (data.success === false) {
                console.warn('⚠️ Server reported update failure:', data.message);
                // Show error to user if needed
                if (typeof toastr !== 'undefined') {
                    toastr.error(data.message || 'Failed to update cart quantity');
                }
                return;
            }
            
            // Update sidebar cart HTML
            if (data.rendered_cart) {
                const minicart = document.querySelector(".offCanvas__minicart");
                if (minicart) {
                    minicart.innerHTML = data.rendered_cart;
                    console.log('✅ Sidebar cart HTML updated');
                    
                    // Only set up sidebar controls and perform targeted stock check
                    setTimeout(() => {
                        this.setupSidebarControls();
                        console.log('✅ Sidebar event handlers reinitialized');
                        
                        // Force stock check for the updated item only
                        setTimeout(() => {
                            console.log('🔍 Forcing stock check for updated sidebar item');
                            this.isAutoCheck = false; // Show loading indicators
                            this.checkStockForItem(cartId, quantity);
                        }, 200);
                    }, 100);
                }
            }
            
            // Update checkout cart if present
            if (data.checkoutCartItems) {
                const checkoutTable = document.querySelector("table.cart-single-product-table tbody");
                if (checkoutTable) {
                    checkoutTable.innerHTML = data.checkoutCartItems;
                    console.log('✅ Checkout cart updated');
                }
            }
            
            if (data.checkoutTotalAmount) {
                const orderSummary = document.querySelector(".order-review-summary");
                if (orderSummary) {
                    orderSummary.innerHTML = data.checkoutTotalAmount;
                    console.log('✅ Order summary updated');
                }
            }
            
            // Update coupon section if present
            if (data.checkoutCoupon) {
                const couponSection = document.querySelector(".checkout-order-review-coupon-box");
                if (couponSection) {
                    couponSection.innerHTML = data.checkoutCoupon;
                    console.log('✅ Coupon section updated');
                }
            }
            
            // Update cart counters
            if (data.cartTotalQty !== undefined) {
                document.querySelectorAll("a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count").forEach(el => {
                    el.textContent = data.cartTotalQty;
                });
                console.log('✅ Cart counters updated to:', data.cartTotalQty);
            }
            
            // Show success notification
            if (typeof toastr !== 'undefined') {
                // toastr.success('Cart quantity updated successfully');
            }
            
            // Refresh the cart status on product details page to ensure quantity is synced
            if (window.location.pathname.includes('/product/details/')) {
                setTimeout(() => {
                    // Extract product ID from cart ID
                    const productIdFromCart = cartId.split('_')[0];
                    const currentProductId = document.getElementById('product_id')?.value;
                    
                    if (productIdFromCart === currentProductId && typeof checkCurrentVariantInCart === 'function') {
                        console.log('🔄 Refreshing product details cart status after update');
                        
                        // Extract color and size IDs from cart ID
                        let colorId = null;
                        let sizeId = null;
                        
                        const cartIdParts = cartId.split('_');
                        for (const part of cartIdParts) {
                            if (part.startsWith('c')) {
                                colorId = part.substring(1);
                            } else if (part.startsWith('s')) {
                                sizeId = part.substring(1);
                            }
                        }
                        
                        // Call the function to refresh cart status
                        checkCurrentVariantInCart(colorId, sizeId);
                    }
                }, 500);
            }
        })
        .catch(error => {
            this.pendingRequests.delete(updateKey);
            console.error('❌ Error updating cart from product details:', error);
            
            // Show error to user
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to update cart quantity. Please try again.');
            }
            
            // Revert the quantity input if the update failed
            const cartElement = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (cartElement) {
                const quantityInput = cartElement.querySelector('.quantity__number');
                if (quantityInput) {
                    // Get the original quantity from the server or restore previous value
                    console.log('🔄 Reverting quantity due to update failure');
                }
            }
        });
    }
    
    /**
     * Update cart quantity (checkout version)
     */
    updateCartQuantity(cartId, quantity) {
        // Store stock attributes before update
        this.storeStockAttributes();
        
        // Use the unified cart update to prevent duplicates
        this.performSingleCartUpdate(cartId, quantity);
    }
    
    /**
     * Centralized cart update function to prevent multiple simultaneous requests
     */
    performSingleCartUpdate(cartId, quantity) {
        const updateKey = `update_${cartId}`;
        
        // Prevent multiple simultaneous updates for the same cart item
        if (this.pendingRequests.has(updateKey)) {
            console.log('⏭️ Skipping duplicate cart update for:', cartId);
            return;
        }
        
        this.pendingRequests.add(updateKey);
        
        // Use the global cart update function if available
        if (typeof updateCartQuantity === 'function') {
            updateCartQuantity(cartId, quantity);
            this.pendingRequests.delete(updateKey);
            
            // After cart update, refresh stock checks for updated items
            setTimeout(() => {
                this.refreshStockAfterCartUpdate(cartId);
            }, 500);
        } else if (typeof window.updateCartQuantity === 'function') {
            window.updateCartQuantity(cartId, quantity);
            this.pendingRequests.delete(updateKey);
            
            // After cart update, refresh stock checks for updated items
            setTimeout(() => {
                this.refreshStockAfterCartUpdate(cartId);
            }, 500);
        } else {
            console.warn('updateCartQuantity function not found, using direct call');
            
            // Direct AJAX call as fallback
            const formData = new FormData();
            formData.append("cart_id", cartId);
            formData.append("cart_qty", quantity);
            formData.append("_token", document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
            
            fetch('/update/cart/qty', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                this.pendingRequests.delete(updateKey);
                
                if (data.rendered_cart) {
                    const minicart = document.querySelector(".offCanvas__minicart");
                    if (minicart) {
                        minicart.innerHTML = data.rendered_cart;
                        
                        // Only set up sidebar controls and perform targeted stock check
                        setTimeout(() => {
                            this.setupSidebarControls();
                            this.refreshStockAfterCartUpdate(cartId);
                        }, 100);
                    }
                }
                
                // Update checkout sections if we're on checkout page
                if (data.checkoutCartItems) {
                    const checkoutTableBody = document.querySelector("table.cart-single-product-table tbody");
                    if (checkoutTableBody) {
                        checkoutTableBody.innerHTML = data.checkoutCartItems;
                    }
                }
                
                if (data.checkoutTotalAmount) {
                    const orderReviewSummary = document.querySelector(".order-review-summary");
                    if (orderReviewSummary) {
                        orderReviewSummary.innerHTML = data.checkoutTotalAmount;
                    }
                }
                
                // Update coupon section if coupon data is available
                if (data.checkoutCoupon) {
                    const couponBox = document.querySelector(".checkout-order-review-coupon-box");
                    if (couponBox) {
                        couponBox.innerHTML = data.checkoutCoupon;
                    }
                }
                
                // Update cart counters
                if (data.cartTotalQty !== undefined) {
                    document.querySelectorAll("a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count").forEach(el => {
                        el.textContent = data.cartTotalQty;
                    });
                }
                
                // Update product details page quantity if it's the same item
                if (window.location.pathname.includes('/product/details/')) {
                    this.updateProductDetailsQuantity(cartId, quantity);
                }
            })
            .catch(error => {
                this.pendingRequests.delete(updateKey);
                console.error('Error updating cart quantity:', error);
            });
        }
    }
    
    /**
     * Refresh stock checks after cart updates to ensure sidebar shows correct stock status
     */
    refreshStockAfterCartUpdate(updatedCartId) {
        console.log('🔄 Refreshing stock checks after cart update for:', updatedCartId);
        
        // Find the specific cart item that was updated
        const specificCartItem = document.querySelector(`.minicart__product--items[data-cart-id="${updatedCartId}"]`);
        
        if (specificCartItem) {
            console.log(`🎯 Refreshing stock for specific cart item: ${updatedCartId}`);
            
            // Extract item details for the specific updated item only
            const cartId = specificCartItem.getAttribute('data-cart-id');
            const packageId = specificCartItem.getAttribute('data-package-id');
            const productId = specificCartItem.getAttribute('data-product-id') || cartId;
            const quantity = parseInt(specificCartItem.querySelector('.quantity__number')?.value) || 1;
            const statusEl = specificCartItem.querySelector('.stock-status-mini') || document.getElementById(`mini_stock_${cartId}`);
            
            const itemData = {
                cartId,
                packageId,
                productId,
                quantity,
                statusEl,
                isPackage: !!packageId
            };
            
            // Use a short delay to ensure DOM is updated
            setTimeout(() => {
                this.isAutoCheck = false; // Show loading indicators for post-update checks
                console.log('🔍 Performing targeted stock check for updated item:', itemData);
                
                // Check stock for only this specific item instead of all items
                this.batchCheckStock([itemData]);
            }, 200);
        } else {
            console.warn('🚫 Could not find specific cart item to refresh:', updatedCartId);
            
            // OPTIMIZED: Skip full refresh to avoid checking all items
            // Only the changed item should be checked, not all items
            console.log('⚡ Skipping full cart refresh to avoid checking all items unnecessarily');
        }
    }
    
    /**
     * Update sidebar quantity - unified approach with single cart update
     */
    updateSidebarQuantity(cartId, quantity) {
        console.log('🔄 Updating sidebar quantity:', { cartId, quantity });
        
        // Store stock attributes before update
        this.storeStockAttributes();
        
        // Immediate sync to product details if on product page
        if (window.location.pathname.includes('/product/details/')) {
            this.updateProductDetailsQuantity(cartId, quantity);
        }
        
        // Use the unified cart update function to prevent multiple calls
        this.performSingleCartUpdate(cartId, quantity);
    }
    
    /**
     * Show toast notification
     */
    showToastr(type, message, title = '') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message, title);
        } else if (typeof showToastr === 'function') {
            showToastr(type, message, title);
        } else {
            console.log(`${type.toUpperCase()}: ${title} - ${message}`);
        }
    }
    
    /**
     * Clear cache
     */
    clearCache() {
        this.cache.clear();
        console.log('🧹 Stock cache cleared');
    }
    
    /**
     * Get cache statistics
     */
    getCacheStats() {
        return {
            size: this.cache.size,
            entries: Array.from(this.cache.keys())
        };
    }
    
    /**
     * Process stock checks in batches for better performance
     */
    async processBatchedStockCheck(items) {
        const batchSize = 3; // Reduced from 5 to 3 to prevent server overload
        
        for (let i = 0; i < items.length; i += batchSize) {
            const batch = items.slice(i, i + batchSize);
            
            // Process batch concurrently but with timeout protection
            await Promise.allSettled(
                batch.map(item => 
                    this.checkStockForItem(item.cartId, item.quantity)
                        .catch(error => {
                            console.error(`Stock check failed for ${item.cartId}:`, error);
                            // Don't let one failure stop the others
                        })
                )
            );
            
            // Increased delay between batches to prevent server overload
            if (i + batchSize < items.length) {
                await new Promise(resolve => setTimeout(resolve, 500)); // Increased from 100ms to 500ms
            }
        }
        
        // Reset auto-check flag after initial batch processing
        this.isAutoCheck = false;
    }
    
    /**
     * Store current stock attributes before cart update
     */
    storeStockAttributes() {
        const stockData = new Map();
        document.querySelectorAll('.quantity__number[data-max-stock]').forEach(input => {
            const cartElement = input.closest('[data-cart-id]');
            if (cartElement) {
                const cartId = cartElement.getAttribute('data-cart-id');
                const maxStock = input.getAttribute('data-max-stock');
                const currentQty = input.value;
                stockData.set(cartId, { maxStock, currentQty });
            }
        });
        this.storedStockData = stockData;
        console.log('📁 Stored stock attributes for', stockData.size, 'items');
    }
    
    /**
     * Restore stock attributes after cart update
     */
    restoreStockAttributes() {
        if (!this.storedStockData) return;
        
        let restored = 0;
        this.storedStockData.forEach((data, cartId) => {
            const cartElement = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (cartElement) {
                const input = cartElement.querySelector('.quantity__number');
                if (input && data.maxStock) {
                    input.setAttribute('data-max-stock', data.maxStock);
                    input.setAttribute('max', data.maxStock);
                    restored++;
                }
            }
        });
        
        console.log('🔄 Restored stock attributes for', restored, 'items');
        this.storedStockData = null;
    }
    
    // ====================================================================
    // UNIFIED CART OPERATIONS - Handles all cart-related functionality
    // ====================================================================
    
    /**
     * Handle simple add to cart (no quantity selection)
     */
    async handleSimpleAddToCart(productId, button) {
        const operationKey = `simple_add_${productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate simple add to cart operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
        button.disabled = true;
        
        try {
            const response = await fetch(`${this.config.endpoints.addToCart}/${productId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Update UI
            this.updateCartUI(data);
            
            // Update button state
            button.innerHTML = '<span class="add__to--cart__text">Remove</span>';
            button.classList.remove('addToCart');
            button.classList.add('removeFromCart');
            button.disabled = false;
            button.blur();
            
            // Show success message
            this.showToastr('success', 'Added to Cart');
            
            // Track with Google Analytics
            this.trackAddToCartEvent(data, productId);
            
            console.log('✅ Simple add to cart successful');
            
        } catch (error) {
            console.error('❌ Simple add to cart failed:', error);
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            this.showToastr('error', 'Failed to add to cart. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    /**
     * Handle add to cart with quantity (product details page)
     */
    async handleAddToCartWithQuantity(productId, button) {
        const operationKey = `add_qty_${productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate add to cart with quantity operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Checking...';
        button.disabled = true;
        
        try {
            // Get form data
            const formData = this.getProductFormData();
            if (!formData.isValid) {
                throw new Error(formData.error);
            }
            
            // Check stock first
            const stockCheck = await this.checkProductStockBeforeAdd(formData);
            if (!stockCheck.success) {
                throw new Error(stockCheck.message);
            }
            
            // Add to cart
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
            
            const response = await fetch(this.config.endpoints.addToCartWithQty, {
                method: 'POST',
                body: formData.formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            if (data.success === false) {
                throw new Error(data.message || 'Failed to add to cart');
            }
            
            // Update UI
            this.updateCartUI(data);
            
            // Update button state to "Remove from cart" with translation
            const removeText = window.cartButtonTexts?.removeFromCart || 'Remove from cart';
            button.innerHTML = removeText;
            button.classList.remove('addToCartWithQty');
            button.classList.add('removeFromCartQty');
            button.setAttribute('data-cart-key', this.generateCartKey(formData));
            button.disabled = false;
            button.blur();
            
            // Show success message
            this.showToastr('success', 'Added to Cart');
            
            // Open minicart
            setTimeout(() => {
                const minicart = document.querySelector('.offCanvas__minicart');
                if (minicart) {
                    minicart.classList.add('active');
                    document.body.classList.add('offCanvas__minicart_active');
                }
            }, 100);
            
            // Track with Google Analytics
            this.trackAddToCartEvent(data, productId, formData.quantity);
            
            console.log('✅ Add to cart with quantity successful');
            
        } catch (error) {
            console.error('❌ Add to cart with quantity failed:', error);
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            this.showToastr('error', error.message || 'Failed to add to cart. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    /**
     * Handle buy now functionality
     */
    async handleBuyNow(productId, button) {
        const operationKey = `buy_now_${productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate buy now operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        button.disabled = true;
        
        try {
            // Get form data
            const formData = this.getProductFormData();
            if (!formData.isValid) {
                throw new Error(formData.error);
            }
            
            // Check stock first
            const stockCheck = await this.checkProductStockBeforeAdd(formData);
            if (!stockCheck.success) {
                throw new Error(stockCheck.message);
            }
            
            // Add to cart first
            const response = await fetch(this.config.endpoints.addToCartWithQty, {
                method: 'POST',
                body: formData.formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            if (data.success === false) {
                throw new Error(data.message || 'Failed to add to cart');
            }
            
            // Redirect to checkout
            window.location.href = '/checkout';
            
        } catch (error) {
            console.error('❌ Buy now failed:', error);
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            this.showToastr('error', error.message || 'Failed to process buy now. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    /**
     * Handle remove from cart (simple)
     */
    async handleRemoveFromCart(productId, button) {
        const operationKey = `remove_${productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate remove from cart operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Removing...';
        button.disabled = true;
        
        try {
            const response = await fetch(`${this.config.endpoints.removeFromCart}/${productId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Update UI
            this.updateCartUI(data);
            
            // Update button state
            button.innerHTML = '<i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i><span class="add__to--cart__text"> Add to cart</span>';
            button.classList.remove('removeFromCart');
            button.classList.add('addToCart');
            button.disabled = false;
            button.blur();
            
            // Show success message
            this.showToastr('error', 'Removed from cart');
            
            console.log('✅ Remove from cart successful');
            
        } catch (error) {
            console.error('❌ Remove from cart failed:', error);
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            this.showToastr('error', 'Failed to remove from cart. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    /**
     * Handle remove from cart with cart key (for variants)
     */
    async handleRemoveFromCartWithKey(productId, cartKey, button) {
        const operationKey = `remove_key_${cartKey || productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate remove from cart with key operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        // Show loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Removing...';
        button.disabled = true;
        
        try {
            // Use cart key if available, otherwise fall back to product ID
            const removeUrl = cartKey ? 
                `${this.config.endpoints.removeFromCartByKey}/${cartKey}` : 
                `${this.config.endpoints.removeFromCart}/${productId}`;
            
            const response = await fetch(removeUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Update UI
            this.updateCartUI(data);
            
            // Reset quantity to 1 if on product details page
            const quantityInput = document.getElementById('product_details_cart_qty');
            if (quantityInput) {
                quantityInput.value = 1;
            }
            
            // Update button state with translation
            const addText = window.cartButtonTexts?.addToCart || 'Add to cart';
            button.innerHTML = addText;
            button.classList.remove('removeFromCartQty');
            button.classList.add('addToCartWithQty');
            button.removeAttribute('data-cart-key');
            button.disabled = false;
            button.blur();
            
            // Show success message
            this.showToastr('error', 'Removed from cart');
            
            console.log('✅ Remove from cart with key successful');
            
        } catch (error) {
            console.error('❌ Remove from cart with key failed:', error);
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            
            // Show error message
            this.showToastr('error', 'Failed to remove from cart. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    /**
     * Handle sidebar product remove
     */
    async handleSidebarProductRemove(productId, button) {
        const operationKey = `sidebar_remove_${productId}`;
        
        if (this.cartOperationInProgress.has(operationKey)) {
            console.log('⏭️ Skipping duplicate sidebar remove operation');
            return;
        }
        
        this.cartOperationInProgress.add(operationKey);
        
        try {
            const response = await fetch(`${this.config.endpoints.removeFromCart}/${productId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            // Update UI
            this.updateCartUI(data);
            
            // Update all related buttons for this product
            this.updateProductButtonsAfterRemove(productId);
            
            console.log('✅ Sidebar product remove successful');
            
        } catch (error) {
            console.error('❌ Sidebar product remove failed:', error);
            this.showToastr('error', 'Failed to remove from cart. Please try again.');
            
        } finally {
            this.cartOperationInProgress.delete(operationKey);
        }
    }
    
    // ====================================================================
    // CART OPERATION HELPER METHODS
    // ====================================================================
    
    /**
     * Get product form data for add to cart operations
     */
    getProductFormData() {
        const productIdElement = document.getElementById('product_id');
        if (!productIdElement) {
            return { isValid: false, error: 'Product ID not found' };
        }
        
        const productId = productIdElement.value;
        let colorId = null;
        let sizeId = null;
        
        // Get selected color
        const colorFields = document.getElementsByName("color_id[]");
        for (let i = 0; i < colorFields.length; i++) {
            if (colorFields[i].checked) {
                colorId = colorFields[i].value;
                break;
            }
        }
        
        // Check if color is required but not selected
        if (colorFields.length > 0 && !colorId) {
            return { isValid: false, error: 'Please select a color' };
        }
        
        // Get selected size
        const sizeFields = document.getElementsByName("size_id[]");
        for (let i = 0; i < sizeFields.length; i++) {
            if (sizeFields[i].checked) {
                sizeId = sizeFields[i].value;
                break;
            }
        }
        
        // Check if size is required but not selected
        if (sizeFields.length > 0 && !sizeId) {
            return { isValid: false, error: 'Please select a size' };
        }
        
        // Get quantity
        const quantityInput = document.getElementById('product_details_cart_qty');
        const quantity = parseInt(quantityInput?.value) || 1;
        
        if (quantity < 1) {
            return { isValid: false, error: 'Invalid quantity' };
        }
        
        // Get prices
        const productPriceElement = document.getElementById('product_price');
        const discountPriceElement = document.getElementById('product_discount_price');
        
        const productPrice = parseFloat(productPriceElement?.value) || 0;
        const discountPrice = parseFloat(discountPriceElement?.value) || 0;
        
        if (productPrice === 0) {
            return { isValid: false, error: 'Unable to get product price' };
        }
        
        // Create form data
        const formData = new FormData();
        formData.append("product_id", productId);
        formData.append("qty", quantity);
        formData.append("price", productPrice);
        formData.append("discount_price", discountPrice);
        formData.append("color_id", colorId || '');
        formData.append("size_id", sizeId || '');
        formData.append("_token", document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
        
        return {
            isValid: true,
            formData,
            productId,
            quantity,
            colorId,
            sizeId,
            productPrice,
            discountPrice
        };
    }
    
    /**
     * Check product stock before adding to cart
     */
    async checkProductStockBeforeAdd(formData) {
        try {
            const response = await fetch('/check/product/stock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    product_id: formData.productId,
                    quantity: formData.quantity,
                    color_id: formData.colorId,
                    size_id: formData.sizeId
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            if (!data.success || !data.in_stock) {
                const errorMsg = data.message || "Insufficient stock available";
                if (data.stock_issues && data.stock_issues.length > 0) {
                    return { success: false, message: data.stock_issues.join(', ') };
                }
                return { success: false, message: errorMsg };
            }
            
            return { success: true };
            
        } catch (error) {
            console.error('Stock check error:', error);
            return { success: false, message: 'Error checking stock availability' };
        }
    }
    
    /**
     * Generate cart key for variant products
     */
    generateCartKey(formData) {
        let cartKey = formData.productId;
        if (formData.colorId) {
            cartKey += '_c' + formData.colorId;
        }
        if (formData.sizeId) {
            cartKey += '_s' + formData.sizeId;
        }
        return cartKey;
    }
    
    /**
     * Update cart UI after cart operations
     */
    updateCartUI(data) {
        // Update sidebar cart
        if (data.rendered_cart) {
            const minicart = document.querySelector(".offCanvas__minicart");
            if (minicart) {
                minicart.innerHTML = data.rendered_cart;
                
                // Only set up sidebar controls to avoid full stock checks
                // Individual operations should call their own targeted stock checks
                setTimeout(() => {
                    this.setupSidebarControls();
                }, 100);
            }
        }
        
        // Update checkout cart if present
        if (data.checkoutCartItems) {
            const checkoutTable = document.querySelector("table.cart-single-product-table tbody");
            if (checkoutTable) {
                checkoutTable.innerHTML = data.checkoutCartItems;
                
                // Reinitialize checkout after update
                setTimeout(() => {
                    this.initializeCheckout();
                }, 100);
            }
        }
        
        // Update order summary
        if (data.checkoutTotalAmount) {
            const orderSummary = document.querySelector(".order-review-summary");
            if (orderSummary) {
                orderSummary.innerHTML = data.checkoutTotalAmount;
            }
        }
        
        // Update cart counters
        if (data.cartTotalQty !== undefined) {
            document.querySelectorAll("a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count").forEach(el => {
                el.textContent = data.cartTotalQty;
            });
        }
    }
    
    /**
     * Update all product buttons after remove operation
     */
    updateProductButtonsAfterRemove(productId) {
        const addText = window.cartButtonTexts?.addToCart || 'Add to cart';
        
        // Update regular add to cart buttons
        const addToCartButtons = document.querySelectorAll(`.cart-${productId}`);
        addToCartButtons.forEach(button => {
            button.innerHTML = `<i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i><span class="add__to--cart__text"> ${addText}</span>`;
            button.classList.remove('removeFromCart');
            button.classList.add('addToCart');
            button.blur();
        });
        
        // Update quantity-based buttons
        const qtyButtons = document.querySelectorAll(`.cart-qty-${productId}`);
        qtyButtons.forEach(button => {
            button.innerHTML = addText;
            button.classList.remove('removeFromCartQty');
            button.classList.add('addToCartWithQty');
            button.removeAttribute('data-cart-key');
            button.blur();
        });
    }
    
    /**
     * Track add to cart event for Google Analytics
     */
    trackAddToCartEvent(data, productId, quantity = 1) {
        // Check if Google Tag Manager is available and enabled
        if (typeof dataLayer !== 'undefined' && data.p_name_data_layer) {
            try {
                dataLayer.push({ ecommerce: null }); // Clear previous ecommerce object
                dataLayer.push({
                    event: "add_to_cart",
                    ecommerce: {
                        items: [{
                            item_name: data.p_name_data_layer,
                            item_id: productId,
                            price: data.p_price_data_layer || 0,
                            item_brand: data.p_brand_name || '',
                            item_category: data.p_category_name || '',
                            item_category2: "",
                            item_category3: "",
                            item_category4: "",
                            item_variant: "",
                            item_list_name: "",
                            item_list_id: "",
                            index: 0,
                            quantity: data.p_qauntity || quantity
                        }]
                    }
                });
                console.log('📊 Google Analytics add_to_cart event tracked');
            } catch (error) {
                console.warn('⚠️ Failed to track Google Analytics event:', error);
            }
        }
    }
}

// Initialize the unified system when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize if not already initialized
    if (!window.unifiedStockSystem) {
        window.unifiedStockSystem = new UnifiedStockSystem();
        console.log('🎯 UnifiedStockSystem initialized on DOM ready');
    } else {
        console.log('🔄 UnifiedStockSystem already exists, skipping initialization');
    }
});

// Also handle dynamic content loading (for AJAX updates)
if (!window.unifiedStockSystemInitialized) {
    window.unifiedStockSystemInitialized = true;
    
    // Prevent multiple initializations
    const initializeUnifiedSystem = () => {
        if (!window.unifiedStockSystem) {
            window.unifiedStockSystem = new UnifiedStockSystem();
            console.log('🎯 UnifiedStockSystem initialized dynamically');
        }
    };
    
    // Initialize immediately if DOM is already ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeUnifiedSystem);
    } else {
        initializeUnifiedSystem();
    }
}

// Helper functions for compatibility with existing cart system
if (typeof updateCartQuantity === 'undefined') {
    window.updateCartQuantity = function(cartId, quantity) {
        console.log('🛒 Global cart update function called:', { cartId, quantity });
        
        // Prevent duplicate calls using the unified system's throttling
        if (window.unifiedStockSystem) {
            const updateKey = `global_update_${cartId}`;
            if (window.unifiedStockSystem.pendingRequests.has(updateKey)) {
                console.log('⏭️ Skipping duplicate global cart update for:', cartId);
                return;
            }
            window.unifiedStockSystem.pendingRequests.add(updateKey);
            
            // Clean up after a short delay
            setTimeout(() => {
                window.unifiedStockSystem.pendingRequests.delete(updateKey);
            }, 1000);
        }
        
        const formData = new FormData();
        formData.append("cart_id", cartId);
        formData.append("cart_qty", quantity);
        
        fetch(window.location.origin + '/update/cart/qty', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.rendered_cart) {
                const minicart = document.querySelector(".offCanvas__minicart");
                if (minicart) {
                    minicart.innerHTML = data.rendered_cart;
                    
                    // Only set up sidebar controls and perform targeted stock check
                    if (window.unifiedStockSystem) {
                        setTimeout(() => {
                            window.unifiedStockSystem.setupSidebarControls();
                            // Refresh stock checks for only the updated item
                            window.unifiedStockSystem.refreshStockAfterCartUpdate(cartId);
                        }, 100);
                    }
                }
            }
            if (data.checkoutCartItems) {
                const checkoutTable = document.querySelector("table.cart-single-product-table tbody");
                if (checkoutTable) {
                    checkoutTable.innerHTML = data.checkoutCartItems;
                    
                    // Reinitialize stock checking after cart update
                    setTimeout(() => {
                        if (window.unifiedStockSystem) {
                            // Restore stock attributes first
                            window.unifiedStockSystem.restoreStockAttributes();
                            // Then re-run stock check to update any missing attributes
                            window.unifiedStockSystem.performInitialStockCheck();
                        }
                    }, 100);
                }
            }
            if (data.checkoutTotalAmount) {
                const orderSummary = document.querySelector(".order-review-summary");
                if (orderSummary) {
                    orderSummary.innerHTML = data.checkoutTotalAmount;
                }
            }
            
            // Update coupon section if coupon data is available
            if (data.checkoutCoupon) {
                const couponBox = document.querySelector(".checkout-order-review-coupon-box");
                if (couponBox) {
                    console.log('🎟️ Global function updating coupon section');
                    couponBox.innerHTML = data.checkoutCoupon;
                } else {
                    console.warn('⚠️ Coupon box element not found in global function');
                }
            } else {
                console.warn('⚠️ No checkoutCoupon data in global function response');
            }
            
            // Update cart counters
            if (data.cartTotalQty !== undefined) {
                document.querySelectorAll("a.minicart__open--btn span.items__count, span.items__count.style2, span.toolbar__cart__count").forEach(el => {
                    el.textContent = data.cartTotalQty;
                });
            }
            
            // Bidirectional sync: Update product details page if present
            if (window.unifiedStockSystem && window.location.pathname.includes('/product/details/')) {
                window.unifiedStockSystem.updateProductDetailsQuantity(cartId, quantity);
            }
        })
        .catch(error => {
            console.error('Error updating cart quantity:', error);
        });
    };
}

if (typeof showToastr === 'undefined') {
    window.showToastr = function(type, message, title = '') {
        if (typeof toastr !== 'undefined') {
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 3000;
            toastr[type](message, title);
        } else {
            console.log(`${type.toUpperCase()}: ${title} - ${message}`);
        }
    };
}

// Global helper function for bidirectional sync
if (typeof window.updateSidebarQuantityIfInCart === 'undefined') {
    window.updateSidebarQuantityIfInCart = function(productId, quantity, exactCartKey = null) {
        if (window.unifiedStockSystem && typeof window.unifiedStockSystem.updateSidebarQuantityIfInCart === 'function') {
            console.log('🔄 Global bidirectional sync called for product:', productId, 'quantity:', quantity, 'exactCartKey:', exactCartKey);
            
            // Prioritize exact cart key for variant-specific updates
            if (exactCartKey) {
                console.log('🎯 Using exact cart key for variant-specific update:', exactCartKey);
            }
            
            window.unifiedStockSystem.updateSidebarQuantityIfInCart(productId, quantity, exactCartKey);
        } else {
            console.warn('⚠️ Unified stock system not available for bidirectional sync');
        }
    };
}

// Store the class globally and close the protection block
window.UnifiedStockSystem = UnifiedStockSystem;

// Debugging and testing functions
window.testAutoFallback = function(cartId, testValue = 1000) {
    console.log('🧪 Testing auto-fallback functionality...');
    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
    if (!cartItem) {
        console.error('❌ Cart item not found:', cartId);
        return;
    }
    
    const quantityInput = cartItem.querySelector('.quantity__number');
    if (!quantityInput) {
        console.error('❌ Quantity input not found for cart item:', cartId);
        return;
    }
    
    const originalValue = quantityInput.value;
    const maxStock = quantityInput.getAttribute('data-max-stock') || quantityInput.getAttribute('max');
    
    console.log('📊 Test setup:', { cartId, originalValue, maxStock, testValue });
    
    // Set test value and trigger validation
    quantityInput.value = testValue;
    const event = new Event('input', { bubbles: true });
    quantityInput.dispatchEvent(event);
    
    console.log('✅ Auto-fallback test completed. Final value:', quantityInput.value);
};

window.debugSidebarStockLimits = function() {
    console.log('🔍 Debugging sidebar stock limits...');
    const cartItems = document.querySelectorAll('.minicart__product--items[data-cart-id]');
    
    cartItems.forEach(item => {
        const cartId = item.getAttribute('data-cart-id');
        const quantityInput = item.querySelector('.quantity__number');
        const maxStock = quantityInput?.getAttribute('data-max-stock') || quantityInput?.getAttribute('max');
        const currentValue = quantityInput?.value;
        
        console.log('📦 Cart Item:', {
            cartId,
            currentValue,
            maxStock,
            hasMaxStock: !!maxStock,
            inputElement: !!quantityInput
        });
    });
};

// Add function to test single item stock checking
window.testSingleItemCheck = function(cartId) {
    console.log('🧪 Testing single item stock check for:', cartId);
    if (window.unifiedStockSystem) {
        console.log('⚡ Triggering stock check for ONLY this item (should not check others)');
        window.unifiedStockSystem.debounceStockCheck(cartId);
    } else {
        console.error('❌ Unified stock system not found');
    }
};

} // End of protection block
