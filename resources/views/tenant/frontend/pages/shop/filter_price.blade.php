<div class="single__widget price__filter widget__bg">
    <h2 class="widget__title h3">Filter By Price</h2>
    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
        <div class="price__filter--group">
            <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                <span class="price__filter--currency">৳</span>
                <label>
                    <input class="price__filter--input__field border-0" name="filter_min_price" type="number" @if(isset($min_price)) value="{{$min_price}}" @endif id="filter_min_price" placeholder="0" min="0" />
                </label>
            </div>
        </div>
        <div class="price__divider">
            <span>-</span>
        </div>
        <div class="price__filter--group">
            <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                <span class="price__filter--currency">৳</span>
                <label>
                    <input class="price__filter--input__field border-0" name="filter_max_price" type="number" @if(isset($max_price)) value="{{$max_price}}" @endif id="filter_max_price" min="0" placeholder="0" />
                </label>
            </div>
        </div>
    </div>
    <button class="price__filter--btn primary__btn" type="button" onclick="filterProducts()">
        Filter
    </button>
</div>
