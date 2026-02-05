<div class="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
    <label class="product__view--label">{{ __('home.sort_by') }}</label>
    <div class="select shop__header--select">
        <select class="product__view--select" name="filter_sort_by" id="filter_sort_by" onchange="filterProducts()">
            <option value="">{{ __('home.select_one') }}</option>
            <option value="1" @if(isset($sort_by) && $sort_by == 1) checked @endif>{{ __('home.sort_by_latest') }}</option>
            <option value="2" @if(isset($sort_by) && $sort_by == 2) checked @endif>{{ __('home.price_low_to_high') }}</option>
            <option value="3" @if(isset($sort_by) && $sort_by == 3) checked @endif>{{ __('home.price_high_to_low') }}</option>
        </select>
    </div>
</div>
