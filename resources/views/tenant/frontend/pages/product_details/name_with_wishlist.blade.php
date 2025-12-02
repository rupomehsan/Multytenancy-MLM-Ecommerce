<div class="product__variant--list">
    @if(Auth::user() && DB::table('wish_lists')->where('product_id', $product->id)->where('user_id', Auth::user()->id)->exists())
    <a class="variant__wishlist--icon mb-15 text-danger ajax-wishlist-btn" 
       href="javascript:void(0)" 
       data-product-slug="{{ $product->slug }}" 
       data-action="remove"
       title="Remove from wishlist" 
       style="font-size: 14px; display: inline-block; border: 1px solid; padding: 4px 12px; border-radius: 6px;">
        <svg class="quickview__variant--wishlist__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
        </svg>
        <span class="wishlist-text">Remove from Wishlist</span>
    </a>
    @else
    <a class="variant__wishlist--icon mb-15 ajax-wishlist-btn" 
       href="javascript:void(0)" 
       data-product-slug="{{ $product->slug }}" 
       data-action="add"
       title="Add to wishlist" 
       style="font-size: 14px; display: inline-block; border: 1px solid #ddd; padding: 4px 12px; border-radius: 6px;">
        <svg class="quickview__variant--wishlist__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
        </svg>
        <span class="wishlist-text">Add to Wishlist</span>
    </a>
    @endif
</div>

<h2 class="product__details--info__title mb-15">
    {{ $product->name }}
</h2>
