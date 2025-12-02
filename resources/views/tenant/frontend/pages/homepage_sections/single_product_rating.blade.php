@php
    $productReviews = DB::table('product_reviews')->where('product_id', $product->id)->get();
    $productRating = DB::table('product_reviews')->where('product_id', $product->id)->sum('rating');
@endphp

<ul class="rating product__rating d-flex">
    <li class="rating__list">
        <span class="rating__list--icon">
            @if(count($productReviews) > 0)
                @for ($i=1;$i<=round($productRating/count($productReviews));$i++)
                <i class="fi fi-ss-star rating__list--icon__svg"></i>
                @endfor

                @for ($i=1;$i<=5-round($productRating/count($productReviews));$i++)
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
                @endfor
            @else
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
                <i class="fi fi-ss-star rating__list--icon__svg" style="color: var(--border-color);"></i>
            @endif
        </span>
        <span>
              ({{$productReviews->count() }})
        </span>
    </li>
</ul>
