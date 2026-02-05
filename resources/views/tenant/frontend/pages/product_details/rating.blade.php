<div class="product__details--info__rating d-flex align-items-center mb-15">
    <ul class="rating d-flex justify-content-center">

        @for ($i=1;$i<=round($averageRating);$i++)
        <li class="rating__list" style="margin-right: 4px !important">
            <span class="rating__list--icon"><i class="fi fi-ss-star" style="color: var(--yellow-color);"></i></span>
        </li>
        @endfor
        @for ($i=1;$i<=5-round($averageRating);$i++)
        <li class="rating__list" style="margin-right: 4px !important">
            <span class="rating__list--icon"><i class="fi fi-rs-star" style="color: var(--border-color);"></i></span>
        </li>
        @endfor

    </ul>
    <span class="product__items--rating__count--number" style="font-size: 16px">({{$productReviews->total()}})</span>
</div>
