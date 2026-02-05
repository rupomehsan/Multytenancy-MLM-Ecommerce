<style>
    /* Modern Product Card - Matching Image Design */
    .modern-product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        border: 2px solid transparent;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        user-select: none;
    }

    .modern-product-card.clickable {
        cursor: pointer;
    }

    .modern-product-card.out-of-stock {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .modern-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-color: #667eea;
    }

    .product-image-container {
        position: relative;
        width: 100%;
        padding-top: 100%;
        overflow: hidden;
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    }

    /* Colorful Background Variations */
    .modern-product-card:nth-child(8n+1) .product-image-container {
        background: linear-gradient(135deg, #fab1a0 0%, #ff7675 100%);
    }

    .modern-product-card:nth-child(8n+2) .product-image-container {
        background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
    }

    .modern-product-card:nth-child(8n+3) .product-image-container {
        background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
    }

    .modern-product-card:nth-child(8n+4) .product-image-container {
        background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
    }

    .modern-product-card:nth-child(8n+5) .product-image-container {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    }

    .modern-product-card:nth-child(8n+6) .product-image-container {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    }

    .modern-product-card:nth-child(8n+7) .product-image-container {
        background: linear-gradient(135deg, #81ecec 0%, #00cec9 100%);
    }

    .modern-product-card:nth-child(8n+8) .product-image-container {
        background: linear-gradient(135deg, #dfe6e9 0%, #b2bec3 100%);
    }

    .product-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 85%;
        height: 85%;
        object-fit: contain;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    .discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #dc3545;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 14px;
        box-shadow: 0 3px 8px rgba(220, 53, 69, 0.4);
        z-index: 2;
    }

    .product-details {
        padding: 14px;
        text-align: center;
        background: white;
    }

    .product-name {
        font-size: 13px;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 8px 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 34px;
    }

    .product-code {
        display: none;
    }

    .variant-status {
        display: none;
    }

    .badge {
        display: none;
    }

    .price-section {
        margin-bottom: 4px;
    }

    .original-price {
        display: none;
    }

    .discounted-price {
        color: #667eea;
        font-weight: 700;
        font-size: 16px;
    }

    .regular-price {
        color: #667eea;
        font-weight: 700;
        font-size: 16px;
    }

    .stock-info {
        display: none;
    }

    .action-section {
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modern-product-card {
            max-width: 100%;
        }

        .product-name {
            font-size: 12px;
            min-height: 30px;
        }

        .discounted-price,
        .regular-price {
            font-size: 14px;
        }
    }
</style>

@foreach ($products as $product)
    @php
        $variants = DB::table('product_variants')
            ->leftJoin('products', 'product_variants.product_id', 'products.id')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select(
                'product_variants.*',
                'products.name as product_name',
                'products.image as product_image',
                'colors.name as color_name',
                'product_sizes.name as size_name',
            )
            ->where('product_variants.product_id', $product->id)
            ->get();

        $totalStock = $product->stock;
        $productPrice = $product->price;
        $productDiscountPrice = $product->discount_price;

        if (count($variants) > 0) {
            $totalStock = 0;
            $variantMinDiscountPriceArray = [];
            $variantMinPriceArray = [];

            foreach ($variants as $variant) {
                $totalStock = $totalStock + $variant->stock;
                $variantMinDiscountPriceArray[] = $variant->discounted_price;
                $variantMinPriceArray[] = $variant->price;
            }

            $productDiscountPrice = min($variantMinDiscountPriceArray);
            $productPrice = min($variantMinPriceArray);
        }
    @endphp

    <div class="modern-product-card {{ $totalStock > 0 ? 'clickable' : 'out-of-stock' }}"
        @if ($totalStock > 0) @if (count($variants) == 0)
                onclick="addToCart({{ $product->id }},0,0,0,0,0); this.style.transform='scale(0.95)'; setTimeout(()=>this.style.transform='', 100);"
            @else
                onclick="showVariant({{ $product->id }}); this.style.transform='scale(0.95)'; setTimeout(()=>this.style.transform='', 100);" @endif
        @endif
        title="{{ $totalStock > 0 ? 'Click to add to cart' : 'Out of stock' }}">
        <div class="product-image-container">
            @if ($totalStock > 0)
                <span class="discount-badge">Qty: {{ number_format($totalStock, 2) }}</span>
            @else
                <span class="discount-badge" style="background: #6c757d;">Out of Stock</span>
            @endif
            <img loading="lazy" src="{{ $product->image ? asset($product->image) : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22200%22 height=%22200%22/%3E%3Ctext fill=%22%23999%22 font-family=%22Arial%22 font-size=%2214%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E' }}" alt="{{ $product->name }}" class="product-image">
        </div>

        <div class="product-details">
            <h6 class="product-name">{{ $product->name }}</h6>
            <div class="price-section">
                @if ($productDiscountPrice > 0)
                    <span class="discounted-price">৳ {{ number_format($productDiscountPrice, 2) }}</span>
                @else
                    <span class="regular-price">৳ {{ number_format($productPrice, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
@endforeach
