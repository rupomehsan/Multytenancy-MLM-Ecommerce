<div class="product__details--tab__inner">
    <!-- Enhanced Header Section -->
    <div class="package-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="package-title-section">
                    <div class="package-icon-title">
                        <i class="bi bi-box-seam package-header-icon"></i>
                        <h4 class="package-main-title">Package Contents</h4>
                    </div>
                    <p class="package-subtitle">
                        <span class="item-count-badge">{{ count($packageItems) }} items</span> 
                        included in this package deal.
                    </p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="package-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ count($packageItems) }}</span>
                        <span class="stat-label">Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Package Items Grid -->
    <div class="package-items-compact">
        @foreach($packageItems as $index => $item)
            <div class="compact-item-card" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <div class="item-badge">{{ $index + 1 }}</div>
                
                <div class="item-content">
                    <div class="item-image-section">
                        <div class="compact-item-image">
                            <img src="{{  $item->product_image }}" 
                                 alt="{{ $item->product_name }}"
                                 loading="lazy">
                        </div>
                    </div>
                    
                    <div class="item-info-section">
                        <div class="item-header">
                            <h6 class="compact-item-name">
                                <a href="{{ url('product/details') }}/{{ $item->product_slug }}" 
                                   target="_blank" title="{{ $item->product_name }}">
                                    {{ Str::limit($item->product_name, 30) }}
                                </a>
                            </h6>
                            @if($item->product_discount_price > 0)
                                @php
                                    $discount = round((($item->product_price - $item->product_discount_price) / $item->product_price) * 100);
                                @endphp
                                <span class="mini-discount-badge">-{{ $discount }}%</span>
                            @endif
                        </div>
                        
                        @if($item->color_name || $item->size_name)
                        <div class="compact-specs">
                            @if($item->color_name)
                                <span class="mini-spec">{{ $item->color_name }}</span>
                            @endif
                            @if($item->size_name)
                                <span class="mini-spec">{{ $item->size_name }}</span>
                            @endif
                        </div>
                        @endif
                        
                        <div class="item-pricing-compact">
                            <div class="price-qty-row">
                                <div class="compact-price">
                                    @if($item->product_discount_price > 0)
                                        <span class="price-current">৳{{ number_format($item->product_discount_price, 0) }}</span>
                                        <span class="price-old">৳{{ number_format($item->product_price, 0) }}</span>
                                    @else
                                        <span class="price-current">৳{{ number_format($item->product_price, 0) }}</span>
                                    @endif
                                </div>
                                <div class="compact-qty">
                                    <i class="bi bi-x-lg multiply-icon"></i>
                                    <span class="qty-value">{{ $item->quantity }}</span>
                                </div>
                            </div>
                            <div class="item-subtotal">
                                <span class="subtotal-value">
                                    ৳{{ number_format(($item->product_discount_price > 0 ? $item->product_discount_price : $item->product_price) * $item->quantity, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="package-summary-enhanced">
                <div class="summary-header">
                    <div class="summary-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h5 class="summary-title">Package Summary</h5>
                </div>
                <div class="summary-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="summary-details">
                                <div class="detail-item">
                                    <span class="detail-icon"><i class="bi bi-collection"></i></span>
                                    <span class="detail-label">Total Items:</span>
                                    <span class="detail-value">{{ count($packageItems) }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon"><i class="bi bi-calculator"></i></span>
                                    <span class="detail-label">Individual Value:</span>
                                    <span class="detail-value">৳{{ number_format($totalPackageValue, 2) }}</span>
                                </div>
                                <div class="detail-item highlight">
                                    <span class="detail-icon"><i class="bi bi-tag"></i></span>
                                    <span class="detail-label">Package Price:</span>
                                    <span class="detail-value">৳{{ number_format($package->discount_price > 0 ? $package->discount_price : $package->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($packageSavings > 0)
                                <div class="savings-showcase">
                                    <div class="savings-header">
                                        <i class="bi bi-piggy-bank savings-icon"></i>
                                        <h6 class="savings-title">Your Savings</h6>
                                    </div>
                                    <div class="savings-amount-display">
                                        ৳{{ number_format($packageSavings, 2) }}
                                    </div>
                                    <div class="savings-percentage">
                                        {{ round(($packageSavings / $totalPackageValue) * 100, 1) }}% off individual prices
                                    </div>
                                    <div class="savings-visual">
                                        <div class="savings-bar">
                                            <div class="savings-fill" style="width: {{ round(($packageSavings / $totalPackageValue) * 100, 1) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Package Items CSS -->
<style>
/* ======================================
   Enhanced Package Header Styling
   ====================================== */
.package-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.package-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    z-index: 1;
}

.package-title-section {
    position: relative;
    z-index: 2;
}

.package-icon-title {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

.package-header-icon {
    font-size: 32px;
    background: rgba(255,255,255,0.2);
    padding: 12px;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.package-main-title {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.package-subtitle {
    margin: 0;
    font-size: 16px;
    opacity: 0.9;
    color: #fff;
}

.item-count-badge {
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}

.package-stats {
    position: relative;
    z-index: 2;
}

.stat-item {
    text-align: center;
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.stat-value {
    display: block;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ======================================
   Compact Package Items Grid
   ====================================== */
.package-items-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.compact-item-card {
    background: #fff;
    border-radius: 12px;
    border: 1.5px solid #e8ecf4;
    padding: 16px;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.compact-item-card:hover {
    /* transform: translateY(-4px); */
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.12);
    border-color: #667eea;
}

.item-badge {
    position: absolute;
    top: -8px;
    left: -8px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    z-index: 2;
}

.item-content {
    display: flex;
    gap: 12px;
    align-items: start;
}

.item-image-section {
    flex-shrink: 0;
}

.compact-item-image {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #f8faff, #e8f0ff);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    border: 1px solid #e8ecf4;
}

.compact-item-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 6px;
}

.item-info-section {
    flex: 1;
    min-width: 0;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 6px;
    gap: 8px;
}

.compact-item-name {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.3;
    flex: 1;
}

.compact-item-name a {
    color: #2d3748;
    text-decoration: none;
    transition: color 0.2s;
}

.compact-item-name a:hover {
    color: #667eea;
}

.mini-discount-badge {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 2px 6px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 600;
    flex-shrink: 0;
}

.compact-specs {
    display: flex;
    gap: 4px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.mini-spec {
    background: #f1f5f9;
    color: #4a5568;
    padding: 2px 6px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 500;
    border: 1px solid #e2e8f0;
}

.item-pricing-compact {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.price-qty-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.compact-price {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.price-current {
    color: #667eea;
    font-weight: 700;
    font-size: 14px;
}

.price-old {
    color: #a0aec0;
    text-decoration: line-through;
    font-size: 12px;
}

.compact-qty {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f8faff;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #e8ecf4;
}

.multiply-icon {
    font-size: 8px;
    color: #718096;
}

.qty-value {
    font-size: 12px;
    font-weight: 600;
    color: #2d3748;
}

.item-subtotal {
    text-align: right;
}

.subtotal-value {
    background: linear-gradient(135deg, #e8f4fd, #f0f8ff);
    color: #2d3748;
    font-weight: 700;
    font-size: 13px;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #dbeafe;
    display: inline-block;
}

/* ======================================
   Enhanced Package Summary
   ====================================== */
.package-summary-enhanced {
    background: linear-gradient(135deg, #ffffff, #f8faff);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.1);
    border: 2px solid #e8ecf4;
}

.summary-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.summary-icon {
    background: rgba(255,255,255,0.2);
    padding: 12px;
    border-radius: 50%;
    font-size: 24px;
}

.summary-title {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
}

.summary-content {
    padding: 32px;
}

.summary-details {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: #f8faff;
    border-radius: 12px;
    border: 1px solid #e8ecf4;
    transition: all 0.3s ease;
}

.detail-item:hover {
    transform: translateX(4px);
    border-color: #667eea;
}

.detail-item.highlight {
    background: linear-gradient(135deg, #e8f4fd, #667eea15);
    border-color: #667eea;
}

.detail-icon {
    background: #667eea;
    color: white;
    padding: 8px;
    border-radius: 8px;
    font-size: 16px;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-label {
    color: #4a5568;
    font-weight: 500;
    flex: 1;
}

.detail-value {
    color: #2d3748;
    font-weight: 700;
    font-size: 16px;
}

.savings-showcase {
    background: linear-gradient(135deg, #f0fff4, #dcfce7);
    border-radius: 20px;
    padding: 24px;
    text-align: center;
    border: 2px solid #bbf7d0;
    position: relative;
    overflow: hidden;
}

.savings-showcase::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200px;
    height: 200px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 50%;
}

.savings-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 16px;
    position: relative;
    z-index: 2;
}

.savings-icon {
    background: #22c55e;
    color: white;
    padding: 12px;
    border-radius: 50%;
    font-size: 24px;
}

.savings-title {
    margin: 0;
    color: #166534;
    font-weight: 600;
}

.savings-amount-display {
    font-size: 36px;
    font-weight: 700;
    color: #22c55e;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.savings-percentage {
    /* color: #166534; */
    color: white;
    font-weight: 500;
    margin-bottom: 16px;
    position: relative;
    z-index: 2;
}

.savings-visual {
    position: relative;
    z-index: 2;
}

.savings-bar {
    background: rgba(34, 197, 94, 0.2);
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
}

.savings-fill {
    background: linear-gradient(90deg, #22c55e, #16a34a);
    height: 100%;
    border-radius: 4px;
    transition: width 1s ease-in-out;
}

/* ======================================
   Responsive Design
   ====================================== */
@media (max-width: 768px) {
    .package-header {
        padding: 20px;
        text-align: center;
    }
    
    .package-icon-title {
        justify-content: center;
    }
    
    .package-main-title {
        font-size: 24px;
    }
    
    .package-items-compact {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .compact-item-card {
        padding: 12px;
    }
    
    .summary-content {
        padding: 20px;
    }
    
    .savings-showcase {
        margin-top: 20px;
    }
}

@media (max-width: 576px) {
    .compact-item-image {
        width: 50px;
        height: 50px;
        padding: 6px;
    }
    
    .item-badge {
        width: 24px;
        height: 24px;
        font-size: 10px;
    }
    
    .compact-item-name {
        font-size: 13px;
    }
    
    .price-current {
        font-size: 13px;
    }
    
    .package-items-compact {
        grid-template-columns: 1fr;
    }
}
</style>
