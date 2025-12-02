<div class="product__view--mode__list product__view--search d-none d-lg-block">
    <form class="product__view--search__form" action="#">
        <label>
            <input class="product__view--search__input border-0" name="filter_search_keyword" onkeyup="filterProducts()" @if(isset($search_keyword) && $search_keyword != '') value="{{$search_keyword}}" @endif id="filter_search_keyword" placeholder="Search by" type="text" />
        </label>
        <button class="product__view--search__btn" aria-label="shop button" type="button" onclick="filterProducts()">
            <svg class="product__view--search__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
            </svg>
        </button>
    </form>
</div>
