    <!-- Start header area -->
    <header class="header__section">

        @stack('top_header')

        <div class="main__header header__sticky">
            <div class="container-fluid">
                <div class="main__header--inner position__relative d-flex justify-content-between align-items-center">
                    <div class="offcanvas__header--menu__open">
                        <a class="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg"
                                viewBox="0 0 512 512">
                                <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352" />
                            </svg>
                            <span class="visually-hidden">Menu Open</span>
                        </a>
                    </div>
                    <div class="main__logo">
                        <h1 class="main__logo--title">
                            <a class="main__logo--link" href="{{ url('/') }}">
                                <img class="main__logo--img" style="max-width: 220px; max-height: 62px;"
                                    src="{{ $generalInfo->logo_dark }}" alt="{{ $generalInfo->company_name }}" />
                            </a>
                        </h1>
                    </div>
                    <div class="header__search--widget header__sticky--none d-none d-lg-block">
                        <form class="d-flex header__search--form" action="{{ url('search/for/products') }}"
                            method="GET">
                            <div class="header__select--categories select">
                                <select class="header__select--inner" name="category"
                                    onchange="if(this.value) window.location.href='{{ url('shop') }}?category=' + this.value; else window.location.href='{{ url('shop') }}';">
                                    <option selected value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}"
                                            @if (isset($category_id) && $category_id == $category->slug) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="header__search--box">
                                <label>
                                    <input class="header__search--input" name="filter_search_keyword"
                                        @if (isset($search_keyword) && $search_keyword != '') value="{{ $search_keyword }}" @endif
                                        placeholder="Keyword here..." type="text" />
                                </label>
                                <button class="header__search--button bg__secondary text-white" type="submit"
                                    aria-label="search button">
                                    <i class="fi fi-rr-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="header__account header__sticky--none">
                        <ul class="d-flex">
                            <li class="header__account--items">
                                @auth('customer')
                                    <a class="header__account--btn" href="{{ url('/customer/home') }}">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="header__account--btn__text">
                                            My Account
                                        </span>
                                    </a>
                                @endauth
                                @guest('customer')
                                    <a class="header__account--btn" href="{{ url('/login') }}">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="header__account--btn__text">
                                            Login/Register
                                        </span>
                                    </a>
                                @endguest
                            </li>
                            @if (Auth::guard('customer')->check())
                                <li class="header__account--items d-none d-lg-block">
                                    <a class="header__account--btn" href="{{ url('my/wishlists') }}">
                                        <i class="fi fi-rr-heart"></i>
                                        <span class="header__account--btn__text"> Wish List</span>
                                        @auth('customer')
                                            <span
                                                class="items__count wishlist">{{ DB::table('wish_lists')->where('user_id', Auth::guard('customer')->id())->count() }}</span>
                                        @endauth
                                    </a>
                                </li>
                            @endif

                            @if (Request::path() != 'checkout')
                                <li class="header__account--items">
                                    <a class="header__account--btn minicart__open--btn" href="javascript:void(0)"
                                        data-offcanvas>
                                        <i class="fi fi-rr-shopping-cart"></i>
                                        <span class="header__account--btn__text"> My cart</span>
                                        <span
                                            class="items__count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                    <div class="header__menu d-none header__sticky--block d-lg-block">
                        <nav class="header__menu--navigation">
                            <ul class="d-flex">
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == '/') style="font-weight: 600" @endif
                                        href="{{ url('/') }}"> Home </a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'shop') style="font-weight: 600" @endif
                                        href="{{ url('shop') }}"> Shop </a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'shop') style="font-weight: 600" @endif
                                        href="{{ url('shop') }}/?category=&filter=packages"> Package </a>
                                </li>

                                @foreach ($categories as $category)
                                    @if ($category->show_on_navbar == 1)
                                        @php
                                            $subcategories = DB::table('subcategories')
                                                ->where('category_id', $category->id)
                                                ->get();
                                        @endphp

                                        <li class="header__menu--items">
                                            <a class="header__menu--link"
                                                @if (str_contains(Request::fullUrl(), '=' . $category->slug)) style="font-weight: 600" @endif
                                                href="{{ url('shop') }}?category={{ $category->slug }}">
                                                {{ $category->name }}

                                                @if (count($subcategories) > 0)
                                                    <svg class="menu__arrowdown--icon"
                                                        xmlns="http://www.w3.org/2000/svg" width="12" height="7.41"
                                                        viewBox="0 0 12 7.41">
                                                        <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z"
                                                            transform="translate(-6 -8.59)" fill="currentColor"
                                                            opacity="0.7" />
                                                    </svg>
                                                @endif
                                            </a>

                                            @if (count($subcategories) > 0)
                                                <ul class="header__sub--menu">
                                                    @foreach ($subcategories as $subcategory)
                                                        <li class="header__sub--menu__items">
                                                            <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                                                class="header__sub--menu__link">{{ $subcategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach




                                {{-- <li class="header__menu--items">
                                    <a class="header__menu--link" @if (Request::path() == 'about') style="font-weight: 600" @endif href="{{ url('about') }}">About</a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link" @if (Request::path() == 'blogs') style="font-weight: 600" @endif href="{{ url('blogs') }}"> Blog </a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link" @if (Request::path() == 'contact') style="font-weight: 600" @endif href="{{ url('contact') }}">Contact </a>
                                </li> --}}
                            </ul>
                        </nav>
                    </div>
                    <div class="header__account header__account2 header__sticky--block">
                        <ul class="d-flex align-items-center">
                            <li
                                class="header__account--items header__account2--items header__account--search__items d-none d-lg-block">
                                <a class="header__account--btn search__open--btn" href="javascript:void(0)"
                                    data-offcanvas>
                                    <i class="fi fi-rr-search"></i>
                                    <span class="visually-hidden">Search</span>
                                </a>
                            </li>

                            @auth('customer')
                                <li class="header__account--items header__account2--items">
                                    <a class="header__account--btn" href="{{ url('/customer/home') }}">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="visually-hidden">My Account</span>
                                    </a>
                                </li>
                            @else
                                <li class="header__account--items header__account2--items">
                                    <a class="header__account--btn" href="{{ url('/login') }}">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="visually-hidden">Login</span>
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="header__bottom">
            <div class="container-fluid">
                <div
                    class="header__bottom--inner position__relative d-none d-lg-flex justify-content-between align-items-center">
                    <div class="sidebar-header" id="sidebarToggle">
                        <i>☰</i> BROWSE CATEGORIES
                    </div>
                    <div class="header__menu">
                        <nav class="header__menu--navigation">
                            <ul class="d-flex">
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == '/') style="font-weight: 600" @endif
                                        href="{{ url('/') }}"> Home </a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'shop') style="font-weight: 600" @endif
                                        href="{{ url('shop') }}"> Shop </a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'shop') style="font-weight: 600" @endif
                                        href="{{ url('shop') }}/?category=&filter=packages"> Package </a>
                                </li>

                                {{-- @foreach ($categories as $category)
                                    @if ($category->show_on_navbar == 1)
                                        @php
                                            $subcategories = DB::table('subcategories')
                                                ->where('category_id', $category->id)
                                                ->get();
                                        @endphp

                                        <li class="header__menu--items">
                                            <a class="header__menu--link"
                                                @if (str_contains(Request::fullUrl(), '=' . $category->slug)) style="font-weight: 600" @endif
                                                href="{{ url('shop') }}?category={{ $category->slug }}">
                                                {{ $category->name }}

                                                @if (count($subcategories) > 0)
                                                    <svg class="menu__arrowdown--icon"
                                                        xmlns="http://www.w3.org/2000/svg" width="12"
                                                        height="7.41" viewBox="0 0 12 7.41">
                                                        <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z"
                                                            transform="translate(-6 -8.59)" fill="currentColor"
                                                            opacity="0.7" />
                                                    </svg>
                                                @endif
                                            </a>

                                            @if (count($subcategories) > 0)
                                                <ul class="header__sub--menu">
                                                    @foreach ($subcategories as $subcategory)
                                                        <li class="header__sub--menu__items">
                                                            <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                                                class="header__sub--menu__link">{{ $subcategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach --}}
                                {{-- <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        href="{{ route('PhotoAlbum', [
                                            'sort' => request('sort', 'desc'),
                                            'category' => request('category'),
                                            'subcategory_id' => request('subcategory_id'),
                                        ]) }}">
                                        Album
                                    </a>
                                </li> --}}

                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'video-gallery') style="font-weight: 600" @endif
                                        href="{{ url('/video-gallery') }}">Video Gallery</a>
                                </li>

                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'outlet') style="font-weight: 600" @endif
                                        href="{{ url('/outlet') }}">Outlet</a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link"
                                        @if (Request::path() == 'blogs') style="font-weight: 600" @endif
                                        href="{{ url('blogs') }}"> Blog </a>
                                </li>
                                @if ($custom_pages->count() > 0)
                                    <li class="header__menu--items">
                                        <a class="header__menu--link"
                                            href="{{ url('custom-page') }}/{{ $custom_pages[0]->slug }}">
                                            Custom Page
                                            <svg class="menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg"
                                                width="12" height="7.41" viewBox="0 0 12 7.41">
                                                <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z"
                                                    transform="translate(-6 -8.59)" fill="currentColor"
                                                    opacity="0.7" />
                                            </svg>
                                        </a>
                                        <ul class="header__sub--menu">
                                            @foreach ($custom_pages as $page)
                                                <li class="header__sub--menu__items">
                                                    <a href="{{ url('custom-page') }}/{{ $page->slug }}"
                                                        class="header__sub--menu__link">{{ ucfirst($page->page_title) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                {{-- <li class="header__menu--items">
                                    <a class="header__menu--link" @if (Request::path() == 'contact') style="font-weight: 600" @endif href="{{ url('contact') }}">Contact </a>
                                </li> --}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('tenant.frontend.layouts.partials.category')


        <!-- Start Offcanvas header menu -->
        <div class="offcanvas__header">
            <div class="offcanvas__inner">
                <div class="offcanvas__logo">
                    <a class="offcanvas__logo_link" href="{{ url('/') }}">
                        <img src="{{ url(env('ADMIN_URL') . '/' . $generalInfo->logo_dark) }}"
                            alt="{{ $generalInfo->company_name }}" width="158" height="36" />
                    </a>
                    <button class="offcanvas__close--btn" data-offcanvas>close</button>
                </div>
                <div class="sidebar-header" id="sidebarToggle">
                    <i>☰</i> BROWSE CATEGORIES
                </div>
                <nav class="offcanvas__menu">
                    <ul class="offcanvas__menu_ul">
                        @foreach ($categories as $category)
                            @if ($category->show_on_navbar == 1)
                                @php
                                    $subcategories = DB::table('subcategories')
                                        ->where('category_id', $category->id)
                                        ->get();
                                @endphp

                                <li class="offcanvas__menu_li">
                                    <a class="offcanvas__menu_item"
                                        href="{{ url('shop') }}?category={{ $category->slug }}">
                                        {{ $category->name }}
                                    </a>
                                    @if (count($subcategories) > 0)
                                        <ul class="offcanvas__sub_menu">
                                            @foreach ($subcategories as $subcategory)
                                                @php
                                                    $childcategories = DB::table('child_categories')
                                                        ->where('subcategory_id', $subcategory->id)
                                                        ->get();
                                                @endphp
                                                <li class="offcanvas__sub_menu_li">
                                                    <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                                        class="offcanvas__sub_menu_item">{{ $subcategory->name }}</a>

                                                    @if (count($childcategories) > 0)
                                                        <button class="offcanvas__child_menu_toggle"
                                                            type="button"></button>
                                                        <ul class="offcanvas__child_menu">
                                                            @foreach ($childcategories as $childcategory)
                                                                <li class="offcanvas__child_menu_li">
                                                                    <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}&childcategory_id={{ $childcategory->id }}"
                                                                        class="offcanvas__child_menu_item">{{ $childcategory->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Toggle child menus
                                document.querySelectorAll(".offcanvas__child_menu_toggle").forEach(function(btn) {
                                    btn.addEventListener("click", function() {
                                        const childmenu = this.nextElementSibling;
                                        if (childmenu && childmenu.classList.contains("offcanvas__child_menu")) {
                                            childmenu.style.display = childmenu.style.display === "block" ? "none" :
                                                "block";
                                            this.classList.toggle("active");
                                        }
                                    });
                                });
                            });
                        </script>

                        <div class="sidebar-header mt-5" id="sidebarToggle">
                            <i>☰</i> BROWSE Website
                        </div>

                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="{{ url('shop') }}">Shop</a>
                        </li>

                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="{{ url('/about') }}">About</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="{{ url('blogs') }}">Blog</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="{{ url('contact') }}">Contact</a>
                        </li>
                    </ul>
                    <div class="offcanvas__account--items">
                        <a class="offcanvas__account--items__btn d-flex align-items-center"
                            href="{{ url('/login') }}">
                            <span class="offcanvas__account--items__icon">
                                <i class="bi bi-person mobile-canvas"></i>
                            </span>
                            <span class="offcanvas__account--items__label">Login / Register</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        <!-- End Offcanvas header menu -->

        <!-- Start Offcanvas stikcy toolbar -->
        <div class="offcanvas__stikcy--toolbar">
            <ul class="d-flex justify-content-between">
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="{{ url('/') }}">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <i class="fi fi-rr-home"></i>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Home</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="{{ url('shop') }}">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <i class="fi fi-rr-shop"></i>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Shop</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn search__open--btn" href="javascript:void(0)"
                        data-offcanvas>
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <i class="fi fi-rr-search"></i>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Search</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn minicart__open--btn" href="javascript:void(0)"
                        data-offcanvas>
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <i class="fi fi-rr-shopping-bag"></i>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Cart</span>
                        <span
                            class="items__count toolbar__cart__count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="{{ url('my/wishlists') }}">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <i class="fi fi-rr-heart"></i>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Wishlist</span>
                        @auth
                            <span
                                class="items__count wishlist__count">{{ DB::table('wish_lists')->where('user_id', Auth::user()->id)->count() }}</span>
                        @endauth
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Offcanvas stikcy toolbar -->


        <!-- Start offCanvas minicart -->
        <div class="offCanvas__minicart">
            @include('tenant.frontend.layouts.partials.sidebar_cart')
        </div>
        <!-- End offCanvas minicart -->


        <!-- Start serch box area -->
        <div class="predictive__search--box">
            <div class="predictive__search--box__inner">
                <h2 class="predictive__search--title">Search Products</h2>
                <form class="predictive__search--form" action="{{ url('search/for/products') }}" method="GET">
                    <label>
                        <input class="predictive__search--input" name="filter_search_keyword"
                            @if (isset($search_keyword) && $search_keyword != '') value="{{ $search_keyword }}" @endif
                            placeholder="Search Here" type="text" />
                    </label>
                    <button class="predictive__search--button" aria-label="search button" type="submit">
                        <i class="fi fi-rr-search"></i>
                    </button>
                </form>
            </div>
            <button class="predictive__search--close__btn" aria-label="search close button" data-offcanvas>
                <svg class="predictive__search--close__icon" xmlns="http://www.w3.org/2000/svg" width="40.51"
                    height="30.443" viewBox="0 0 512 512">
                    <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                </svg>
            </button>
        </div>
        <!-- End serch box area -->
    </header>
    <!-- End header area -->
