<div class="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
    <label class="product__view--label">Sort By :</label>
    <div class="select shop__header--select">
        <select class="product__view--select" name="filter_sort_by" id="filter_sort_by" onchange="filterProducts()">
            <option value="">Select One</option>
            <option value="1" @if(isset($sort_by) && $sort_by == 1) checked @endif>Sort by Latest</option>
            <option value="2" @if(isset($sort_by) && $sort_by == 2) checked @endif>Price Low to High</option>
            <option value="3" @if(isset($sort_by) && $sort_by == 3) checked @endif>Price High to Low</option>
        </select>
    </div>
</div>
