<div class="product__details--info__meta" style="margin-bottom: 10px;">
    <p class="product__details--info__meta--list">
        <span>Stock Status:</span>
        @if($variants && count($variants) > 0)
            @if($totalStockAllVariants > 0)
                <strong id="stock_status_text" class="text-success">Stock In</strong>
            @else
                <strong id="stock_status_text" class="text-danger">Stock Out</strong>
            @endif
        @else
            @if($product->stock && $product->stock > 0)
                <strong id="stock_status_text" class="text-success">Stock In</strong>
            @else
            <strong id="stock_status_text" class="text-danger">Stock Out</strong>
            @endif
        @endif
    </p>

    @if($product->code)
    <p class="product__details--info__meta--list">
        <span>Code:</span> <strong>{{$product->code}}</strong>
    </p>
    @endif

    @if($product->category_name)
    <p class="product__details--info__meta--list">
        <span>Categroy:</span> <strong>{{$product->category_name}}</strong>
    </p>
    @endif

    @if($product->brand_name)
    <p class="product__details--info__meta--list">
        <span>Brand:</span> <strong>{{$product->brand_name}}</strong>
    </p>
    @endif

    @if($product->model_name)
    <p class="product__details--info__meta--list">
        <span>Model:</span> <strong>{{$product->model_name}}</strong>
    </p>
    @endif
</div>
