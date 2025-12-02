<!-- Start Package Products section -->
<section class="container-fluid package__products--section">
    <div class="section__heading" style="margin-bottom: 40px">
        <h2 class="section__heading--maintitle text-center">Package Products</h2>
        {{-- <p class="section__heading--desc text-center">Save more with our carefully curated product bundles</p> --}}
    </div>

    <section class="section--padding pt-0">
        <div class="row">
            <div class="col-12">
                <div class="product__section-inner">
                    @foreach ($packageProducts as $product)
                        @include('tenant.frontend.pages.homepage_sections.single_package_product', [
                            'product' => $product,
                        ])
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <div class="d-inline-block">
                        <button class="product_show_btn show_more"
                            onclick="window.location.href='{{ url('shop') }}/?category=&filter=packages'">
                            <span class="add__to--cart__text">View All Package Products</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<!-- End Package Products section -->

<style>
    /* Package Stock Status Styling */
    .package-stock-status {
        font-size: 12px;
        line-height: 1.2;
    }

    .stock-checking {
        color: #6c757d;
    }

    .stock-available {
        color: #28a745;
    }

    .stock-issue {
        color: #dc3545;
    }

    .package-items-count {
        font-size: 11px;
        color: #6c757d;
        margin-top: 2px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check stock for all packages on homepage
        checkAllPackageStock();
    });

    function checkAllPackageStock() {
        console.log('Checking stock for all packages on homepage...');

        const packageCards = document.querySelectorAll('[data-package-id]');

        packageCards.forEach(card => {
            const packageId = card.getAttribute('data-package-id');
            if (packageId) {
                checkHomepagePackageStock(packageId);
            }
        });
    }

    function checkHomepagePackageStock(packageId) {
        console.log('Checking stock for package:', packageId);

        const statusElement = document.getElementById(`package_stock_${packageId}`);
        const actionElement = document.getElementById(`package_action_${packageId}`);

        if (!statusElement || !actionElement) {
            console.error('Stock status or action elements not found for package:', packageId);
            return;
        }

        // Set loading state
        statusElement.innerHTML =
            '<small class="stock-checking text-muted"><i class="bi bi-clock"></i> Checking stock...</small>';

        // AJAX request to check stock
        fetch('{{ url('check/package/stock') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    package_id: packageId,
                    quantity: 1 // Default quantity for homepage display
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Stock check response for package', packageId, ':', data);

                if (data.success && data.in_stock) {
                    // All items in stock
                    statusElement.innerHTML = `
                <small class="stock-available">
                    <i class="bi bi-check-circle"></i> All items available
                </small>
                ${data.item_details ? `<div class="package-items-count">${data.item_details.length} items in package</div>` : ''}
            `;

                    // Enable add to cart button
                    updateHomepagePackageAction(packageId, 'available');

                } else if (data.success && !data.in_stock) {
                    // Some items out of stock
                    const issueCount = data.stock_issues ? data.stock_issues.length : 0;
                    statusElement.innerHTML = `
                <small class="stock-issue">
                    <i class="bi bi-exclamation-triangle"></i> ${issueCount} item(s) unavailable
                </small>
                ${data.item_details ? `<div class="package-items-count">${data.item_details.length} items in package</div>` : ''}
            `;

                    // Disable add to cart button
                    updateHomepagePackageAction(packageId, 'unavailable');

                } else {
                    // Error in response
                    statusElement.innerHTML =
                        '<small class="stock-issue"><i class="bi bi-exclamation-triangle"></i> Stock check failed</small>';
                    updateHomepagePackageAction(packageId, 'error');
                }
            })
            .catch(error => {
                console.error('Error checking package stock:', error);
                statusElement.innerHTML =
                    '<small class="stock-issue"><i class="bi bi-exclamation-triangle"></i> Unable to check stock</small>';
                updateHomepagePackageAction(packageId, 'error');
            });
    }

    // Function to check if package is in cart using server-side data
    function checkIfPackageInCart(packageId) {
        // Get cart data from server-side session
        @if (session('cart'))
            const cartData = @json(session('cart'));

            // Check if any cart item matches this package ID
            for (const [cartId, details] of Object.entries(cartData)) {
                if (details.is_package && details.product_id == packageId) {
                    return true;
                }
            }
        @endif

        return false;
    }

    function updateHomepagePackageAction(packageId, status) {
        const actionElement = document.getElementById(`package_action_${packageId}`);
        if (!actionElement) return;

        // Check if package is in cart by checking server-side cart data
        const isInCart = checkIfPackageInCart(packageId);

        switch (status) {
            case 'available':
                if (isInCart) {
                    actionElement.innerHTML = `
                    <a href="javascript:void(0)" class="product__items--action__btn add__to--cart minicart__open--btn removeFromCart" data-id="${packageId}">
                        <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
                        <span class="add__to--cart__text">Remove</span>
                    </a>
                `;
                } else {
                    actionElement.innerHTML = `
                    <a href="javascript:void(0)" class="product__items--action__btn add__to--cart minicart__open--btn addToCart" data-id="${packageId}">
                        <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
                        <span class="add__to--cart__text">Add to cart</span>
                    </a>
                `;
                }
                break;

            case 'unavailable':
                actionElement.innerHTML = `
                <a href="javascript:void(0)" class="product__items--action__btn add__to--cart" style="opacity: 0.6; pointer-events: none; background-color: #f8f9fa; color: #6c757d;">
                    <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
                    <span class="add__to--cart__text">Out of Stock</span>
                </a>
            `;
                break;

            case 'error':
            default:
                actionElement.innerHTML = `
                <a href="javascript:void(0)" class="product__items--action__btn add__to--cart" style="opacity: 0.6; pointer-events: none;">
                    <i class="fi fi-rr-shopping-cart product__items--action__btn--svg"></i>
                    <span class="add__to--cart__text">Unavailable</span>
                </a>
            `;
                break;
        }
    }

    // Global function to refresh package stock when needed
    window.refreshHomepagePackageStock = function() {
        checkAllPackageStock();
    };

    // Function to update package buttons after cart changes
    window.updatePackageButtonsAfterCartChange = function() {
        const packageCards = document.querySelectorAll('[data-package-id]');

        packageCards.forEach(card => {
            const packageId = card.getAttribute('data-package-id');
            if (packageId) {
                // Re-check the current stock status and update button accordingly
                updateHomepagePackageAction(packageId, 'available');
            }
        });
    };

    // Listen for cart changes to update package buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for add to cart events
        $(document).on('click', '.addToCart', function() {
            const packageId = $(this).data('id');
            console.log('Package added to cart:', packageId);

            // Small delay to allow cart update to complete
            setTimeout(() => {
                window.location.reload(); // Reload to get fresh cart data
            }, 500);
        });

        // Listen for remove from cart events
        $(document).on('click', '.removeFromCart', function() {
            const packageId = $(this).data('id');
            console.log('Package removed from cart:', packageId);

            // Small delay to allow cart update to complete
            setTimeout(() => {
                window.location.reload(); // Reload to get fresh cart data
            }, 500);
        });
    });
</script>
