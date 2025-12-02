@include('tenant.frontend.pages.product_details.name_with_wishlist', ['product' => $package])

<!-- Enhanced Price Section -->
<div class="package-price-section mb-3">
    <div class="price-container">
        @if ($package->discount_price > 0)
            <div class="price-group">
                <span class="package-current-price">৳{{ number_format($package->discount_price, 2) }}</span>
                <span class="package-old-price">৳{{ number_format($package->price, 2) }}</span>
                @php
                    $discountPercent = round((($package->price - $package->discount_price) / $package->price) * 100);
                @endphp
                <span class="discount-percent">-{{ $discountPercent }}%</span>
            </div>
        @else
            <span class="package-current-price">৳{{ number_format($package->price, 2) }}</span>
        @endif
    </div>
</div>

<!-- Enhanced Savings Badge -->
@if ($packageSavings > 0)
    <div class="savings-highlight mb-3">
        <div class="savings-card">
            <div class="savings-icon">
                <i class="bi bi-piggy-bank"></i>
            </div>
            <div class="savings-content">
                <span class="savings-label">You Save from individual items</span>
                <span class="savings-amount">৳{{ number_format($packageSavings, 2) }}</span>
            </div>
            <div class="savings-percentage">
                @php
                    $savingsPercent = round(($packageSavings / $totalPackageValue) * 100);
                @endphp
                {{ $savingsPercent }}% OFF
            </div>
        </div>
    </div>
@endif

<!-- Enhanced Package Information Cards -->
<div class="package-info-cards mb-25">
    <div class="row g-3">
        {{-- <div class="col-6">
            <div class="info-card highlight">
                <div class="info-icon">
                    <i class="bi bi-tag"></i>
                </div>
                <div class="info-content">
                    <span class="info-label">Category</span>
                    <span class="info-value">{{ $package->category_name }}</span>
                </div>
            </div>
        </div>
        
        @if ($package->brand_name)
        <div class="col-6">
            <div class="info-card highlight">
                <div class="info-icon">
                    <i class="bi bi-award"></i>
                </div>
                <div class="info-content">
                    <span class="info-label">Brand</span>
                    <span class="info-value">{{ $package->brand_name }}</span>
                </div>
            </div>
        </div>
        @endif --}}

        <div class="col-6">
            <div class="info-card highlight">
                <div class="info-icon">
                    <i class="bi bi-collection"></i>
                </div>
                <div class="info-content">
                    <span class="info-label">Items</span>
                    <span class="info-value">{{ count($packageItems) }} Products</span>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="info-card highlight">
                <div class="info-icon">
                    <i class="bi bi-calculator"></i>
                </div>
                <div class="info-content">
                    <span class="info-label">Total Value</span>
                    <span class="info-value">৳{{ number_format($totalPackageValue, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Enhanced Add to Cart Section -->
<div class="package-action-section mb-25" id="product_details_add_to_cart_section">
    <!-- Hidden fields for JavaScript compatibility -->
    <input type="hidden" id="product_id" value="{{ $package->id }}">
    <input type="hidden" id="product_price" value="{{ $package->price }}">
    <input type="hidden" id="product_discount_price" value="{{ $package->discount_price }}">

    <div class="stock-status-badge mb-15" id="package_stock_status">
        <i class="bi bi-check-circle text-success"></i>
        <span class="stock-text stock-status" id="stock_status_text">Checking Stock...</span>
    </div>

    <!-- Package Stock Details (will be populated by JavaScript) -->
    <div class="stock-details mb-15" style="display: none;">
        <!-- Stock details content will be populated by JavaScript -->
    </div>

    <!-- Package Items Stock Overview -->
    <div class="package-items-stock mb-20" id="package_items_stock_overview">
        <h6 class="stock-overview-title">Package Items Stock Status</h6>
        <div class="items-stock-grid">

            @if (isset($packageItems) && $packageItems)
                @foreach ($packageItems as $index => $item)
                    @php
                        // Create unique identifier matching backend logic
                        $uniqueId =
                            $item->product_id .
                            '_' .
                            ($item->color_id ?? 'no_color') .
                            '_' .
                            ($item->size_id ?? 'no_size') .
                            '_' .
                            $index;
                    @endphp
                    <div class="item-stock-card" id="item_stock_{{ $uniqueId }}">
                        <div class="item-info">
                            <div class="item-image">
                                @if ($item->product_image)
                                    <img src="{{ env('ADMIN_URL') . '/' . $item->product_image }}"
                                        alt="{{ $item->product_name }}" class="img-fluid">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="item-details">
                                <h6 class="item-name">{{ $item->product_name }}</h6>
                                @if ($item->color_name || $item->size_name)
                                    <div class="item-variants">
                                        @if ($item->color_name)
                                            <span class="variant-info">Color: {{ $item->color_name }}</span>
                                        @endif
                                        @if ($item->size_name)
                                            <span class="variant-info">Size: {{ $item->size_name }}</span>
                                        @endif
                                    </div>
                                @endif
                                <div class="item-quantity">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="item-stock-status" id="item_status_{{ $uniqueId }}">
                            <span class="stock-checking">
                                <i class="bi bi-clock text-muted"></i> Checking...
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @include('tenant.frontend.pages.product_details.cart_buy_button', ['product' => $package])
</div>


@include('tenant.frontend.pages.package_details.social_share')
