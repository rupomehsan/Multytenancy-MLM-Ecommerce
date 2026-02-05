<div class="product__details--info__meta" style="margin-bottom: 10px;">
    <p class="product__details--info__meta--list">
        <span>{{ __('home.stock_status') }}</span>
        @if($variants && count($variants) > 0)
            @if($totalStockAllVariants > 0)
                <strong id="stock_status_text" class="text-success">{{ __('home.stock_in') }}</strong>
            @else
                <strong id="stock_status_text" class="text-danger">{{ __('home.stock_out') }}</strong>
            @endif
        @else
            @if($product->stock && $product->stock > 0)
                <strong id="stock_status_text" class="text-success">{{ __('home.stock_in') }}</strong>
            @else
            <strong id="stock_status_text" class="text-danger">{{ __('home.stock_out') }}</strong>
            @endif
        @endif
    </p>

    @if($product->code)
    <p class="product__details--info__meta--list">
        <span>{{ __('home.code') }}</span> <strong>{{$product->code}}</strong>
    </p>
    @endif

    @if($product->category_name)
    <p class="product__details--info__meta--list">
        <span>{{ __('home.category') }}</span> <strong>{{$product->category_name}}</strong>
    </p>
    @endif

    @if($product->brand_name)
    <p class="product__details--info__meta--list">
        <span>{{ __('home.brand') }}</span> <strong>{{$product->brand_name}}</strong>
    </p>
    @endif

    @if($product->model_name)
    <p class="product__details--info__meta--list">
        <span>{{ __('home.model') }}</span> <strong>{{$product->model_name}}</strong>
    </p>
    @endif
</div>
