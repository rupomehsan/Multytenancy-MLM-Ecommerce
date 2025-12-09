<div class="single__widget widget__bg">
    <h2 class="widget__title h3">Categories</h2>
    <ul class="widget__categories--menu">
        @foreach ($categories as $category)
            <li class="widget__categories--menu__list"
                @if (isset($category_id) && $category_id == $category->slug) style="box-shadow: 2px 2px 5px lightgray" @endif>
                <label class="widget__categories--menu__label d-flex align-items-center">
                    @if ($category->icon)
                        <img class="widget__categories--menu__img lazy"
                            src="{{ url('tenant/frontend') }}/img/product-load.gif"
                            data-src="{{ url(env('ADMIN_URL') . '/' . $category->icon) }}" alt="" />
                    @endif
                    <span class="widget__categories--menu__text">{{ $category->name }}</span>
                    <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                        width="12.355" height="8.394">
                        <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                            transform="translate(-6 -8.59)" fill="currentColor"></path>
                    </svg>
                </label>
                @php
                    $subcategories = DB::table('subcategories')
                        ->where('category_id', $category->id)
                        ->where('status', 1)
                        ->orderBy('id', 'desc')
                        ->get();
                @endphp
                <ul class="widget__categories--sub__menu">
                    @if (count($subcategories) > 0)
                        @foreach ($subcategories as $subcategory)
                            <li class="widget__categories--sub__menu--list">
                                <label
                                    class="checkbox-container widget__categories--sub__menu--link d-flex align-items-center justify-content-between w-100">
                                    <span>
                                        @if ($subcategory->icon)
                                            <img class="widget__categories--sub__menu--img lazy"
                                                src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                                data-src="{{ url(env('ADMIN_URL') . '/' . $subcategory->icon) }}"
                                                alt="" />
                                        @endif
                                        <span
                                            class="widget__categories--sub__menu--text">{{ $subcategory->name }}</span>
                                    </span>
                                    <span>
                                        <input class="widget__categories--check__input" value="{{ $subcategory->id }}"
                                            name="filter_subcategory_id[]"
                                            @if (isset($subcategoryId) && in_array($subcategory->id, explode(',', $subcategoryId))) checked @endif type="checkbox"
                                            onchange="filterProducts()" />
                                        <span class="widget__categories--checkmark"></span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    @else
                        <li class="widget__categories--sub__menu--list">
                            <label
                                class="checkbox-container widget__categories--sub__menu--link d-flex align-items-center justify-content-between w-100">
                                <span>
                                    <span class="widget__categories--sub__menu--text">No Subcategory Found</span>
                                </span>
                            </label>
                        </li>
                    @endif
                </ul>
            </li>
        @endforeach
    </ul>
</div>
