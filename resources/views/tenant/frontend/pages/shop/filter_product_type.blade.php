<div class="single__widget widget__bg">
    <h2 class="widget__title h3">Product Type</h2>
    <ul class="widget__form--check">
        <li class="widget__form--check__list">
            <label class="widget__form--check__label" for="filter_all_products">All Products</label>
            <input class="widget__form--check__input" value="" name="filter_product_type" 
                @if(!isset($filter) || $filter == '') checked @endif 
                id="filter_all_products" type="radio" onchange="filterProducts()"/>
            <span class="widget__form--checkmark"></span>
        </li>
        <li class="widget__form--check__list">
            <label class="widget__form--check__label" for="filter_regular_products">Regular Products</label>
            <input class="widget__form--check__input" value="products" name="filter_product_type" 
                @if(isset($filter) && $filter == 'products') checked @endif 
                id="filter_regular_products" type="radio" onchange="filterProducts()"/>
            <span class="widget__form--checkmark"></span>
        </li>
        <li class="widget__form--check__list">
            <label class="widget__form--check__label" for="filter_package_products">📦 Package Deals</label>
            <input class="widget__form--check__input" value="packages" name="filter_product_type" 
                @if(isset($filter) && $filter == 'packages') checked @endif 
                id="filter_package_products" type="radio" onchange="filterProducts()"/>
            <span class="widget__form--checkmark"></span>
        </li>
    </ul>
</div>
