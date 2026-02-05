    <!-- Start header area -->
    <style>
        /* Ensure offcanvas toggle is visible on mobile */
        @media (max-width: 991px) {
            .offcanvas__header--menu__open {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .offcanvas__header--menu__open--btn {
                display: flex !important;
                align-items: center;
                justify-content: center;
                color: white;
            }
        }

        /* Ensure offcanvas menu is properly styled for mobile */
        .offcanvas__header {
            position: fixed;
            top: 0;
            left: -320px;
            width: 320px;
            height: 100vh;
            background: #fff;
            z-index: 99999;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .offcanvas__header.active {
            left: 0 !important;
        }

        .offcanvas__inner {
            padding: 20px;
        }

        /* Submenu toggle styles */
        .offcanvas__sub_menu {
            display: none;
            padding-left: 20px;
        }

        .offcanvas__sub_menu.active {
            display: block !important;
        }

        .offcanvas__menu_li {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .offcanvas__menu_item {
            display: block;
            padding: 8px 0;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        /* Custom Animated Search Bar Design */
        .header__search--form {
            background: linear-gradient(135deg, #e91e63 0%, #d81b60 100%);
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0 8px 25px rgba(233, 30, 99, 0.35);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }



        .header__search--widget {
            flex: 1;
            max-width: 700px;
            margin: 0 20px;
        }

        .custom__search--wrapper {
            flex: 1;
            width: 100%;
        }

        .custom__search--container {
            position: relative;
            background: white;
            border-radius: 45px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 0px 20px;
            min-height: 55px;
        }

        .custom__search--input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            color: #333;
            width: 100%;
            min-width: 250px;
            z-index: 2;
        }

        .custom__search--label {
            position: absolute;
            left: 35px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            font-weight: 500;
            color: transparent;
            pointer-events: none;
            z-index: 1;
            white-space: nowrap;
            overflow: hidden;
        }

        .custom__search--label::after {
            content: '{{ __('home.search_products') }}';
            position: absolute;
            left: 0;
            top: 0;
            color: gray;
            border-right: 2px solid gray;
            overflow: hidden;
            white-space: nowrap;
            animation: typeWriter 4s steps(15) infinite;
        }

        @keyframes typeWriter {

            0%,
            10% {
                width: 0;
            }

            50%,
            80% {
                width: 100%;
            }

            90%,
            100% {
                width: 0;
            }
        }

        .custom__search--input:focus+.custom__search--label,
        .custom__search--input:valid+.custom__search--label {
            opacity: 0;
            pointer-events: none;
        }

        .custom__search--input:focus+.custom__search--label::after,
        .custom__search--input:valid+.custom__search--label::after {
            animation: none;
            opacity: 0;
        }

        @keyframes labelFloat {
            0% {
                transform: translateY(-50%) scale(1);
                opacity: 0.7;
            }

            50% {
                transform: translateY(-60%) scale(1.1);
            }

            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .custom__search--button {
            background: transparent;
            border: none;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .custom__search--button i {
            color: #e91e63;
            font-size: 20px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }





        .custom__search--button:active {
            transform: scale(0.95);
        }

        .header__select--categories {
            display: none;
        }

        /* Desktop - Ensure sign-in text is visible */
        @media (min-width: 768px) {
            .welcome-sign-in-text {
                display: flex !important;
            }

            .welcome-sign-in i {
                order: 1;
            }

            .welcome-sign-in-text {
                order: 2;
            }

            /* Hide mobile track order icon on desktop */
            .track-order-mobile-icon {
                display: none !important;
            }
        }

        /* Responsive Design */
        @media (min-width: 1400px) {
            .header__search--form {
                max-width: 750px;
            }

            .header__search--widget {
                max-width: 800px;
            }
        }

        @media (max-width: 1199px) {
            .header__search--form {
                max-width: 500px;
            }

            .header__search--widget {
                margin: 0 15px;
            }

            .custom__search--input {
                min-width: 200px;
            }
        }

        @media (max-width: 991px) {
            .header__search--widget {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .header__search--form {
                max-width: 100%;
                padding: 4px;
            }

            .custom__search--container {
                padding: 10px 15px;
                min-height: 50px;
            }

            .custom__search--input {
                padding: 10px 15px;
                font-size: 14px;
                min-width: 180px;
            }

            .custom__search--label {
                font-size: 14px;
                left: 30px;
            }

            .custom__search--input:focus+.custom__search--label,
            .custom__search--input:valid+.custom__search--label {
                font-size: 11px;
            }

            .custom__search--button {
                width: 45px;
                height: 45px;
            }

            .custom__search--button i {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            .header__search--form {
                border-radius: 35px;
                padding: 3px;
                max-width: 100%;
            }

            .custom__search--container {
                padding: 8px 12px;
                min-height: 45px;
            }

            .custom__search--input {
                padding: 8px 12px;
                font-size: 13px;
                min-width: 150px;
            }

            .custom__search--label {
                font-size: 13px;
                left: 25px;
            }

            .custom__search--button {
                width: 40px;
                height: 40px;
                margin-left: 5px;
            }

            .custom__search--button i {
                font-size: 20px;
            }
        }

        /* Mobile Header Topbar Optimization */
        @media (max-width: 767px) {

            /* Remove container padding on mobile */
            .header__topbar .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            /* Show welcome message on mobile */
            .header__shipping--text:first-child {
                display: flex !important;
            }

            /* Hide email completely on mobile */
            .header__shipping--text:last-child {
                display: none !important;
            }

            /* Move track order to right side - hide from left */
            .header__shipping--text:nth-child(2) {
                display: none !important;
            }

            /* Adjust topbar spacing for mobile */
            .header__topbar--inner {
                gap: 1rem !important;
                justify-content: space-between !important;
                padding: 8px 15px !important;
                flex-wrap: nowrap;
            }

            .header__topbar {
                padding: 5px 0 !important;
                overflow: visible;
                display: block !important;
                background-color: white !important;
            }

            .header__shipping {
                flex: 1;
                overflow: visible;
                display: flex !important;
            }

            .header__shipping--wrapper {
                gap: 0.5rem;
                flex-wrap: nowrap;
                overflow: visible;
                display: flex !important;
                align-items: center;
            }

            /* Better spacing between welcome and icon */
            .header__shipping--text:first-child {
                margin-right: 0.5rem;
            }

            .header__shipping--text {
                font-size: 11px;
                white-space: nowrap;
                display: flex !important;
                align-items: center;
            }

            /* Welcome text styling */
            .header__shipping--text:first-child {
                font-size: 11px;
            }

            .header__shipping--text span {
                font-size: 11px;
            }

            .header__shipping--text i {
                font-size: 14px;
                margin-right: 4px;
            }

            /* Track order icon - larger on mobile */
            .header__shipping--text:nth-child(2) a {
                padding: 4px 8px;
            }

            .header__shipping--text:nth-child(2) i {
                font-size: 18px !important;
                margin: 0 !important;
            }

            /* Hide text in sign-in button, show only icon */
            .welcome-sign-in div {
                display: none !important;
            }

            .welcome-sign-in i {
                margin-left: 0 !important;
                font-size: 28px !important;
            }

            .welcome-sign-in {
                min-width: auto !important;
                padding: 8px !important;
            }

            /* Adjust language switcher for mobile */
            .header__account--items {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Show track order icon on mobile - right side */
            .track-order-mobile-icon {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                padding: 4px;
                text-decoration: none;
            }

            /* Hide desktop track order icon on mobile */
            .header__topbar .track-order-mobile-icon {
                display: inline-flex !important;
            }
        }

        /* Extra small mobile devices - Welcome message + Track order icon only */
        @media (max-width: 575px) {
            .header__topbar {
                display: block !important;
                background-color: white !important;
            }

            /* Remove container padding on small mobile */
            .header__topbar .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .header__topbar--inner {
                gap: 0.5rem !important;
                padding: 5px 10px;
            }

            .header__shipping--wrapper {
                gap: 0.5rem;
                justify-content: flex-start;
                display: flex !important;
                align-items: center;
                flex-wrap: nowrap;
            }

            /* Welcome text on small screens */
            .header__shipping--text:first-child {
                font-size: 9px;
                margin-right: 0.5rem;
            }

            .header__shipping {
                flex: 1;
                min-width: 0;
                display: flex !important;
            }

            .header__shipping--text {
                font-size: 9px;
                white-space: nowrap;
                display: flex !important;
                align-items: center;
            }

            .header__shipping--text span {
                font-size: 9px;
            }

            /* Show only track order icon on small screens */
            .header__shipping--text:nth-child(2) i {
                display: inline-flex !important;
                font-size: 16px !important;
                margin: 0 !important;
            }

            .header__shipping--text i {
                font-size: 12px;
                margin-right: 3px;
            }

            /* Show track order icon on right side for small mobile */
            .track-order-mobile-icon {
                display: inline-flex !important;
            }

            .track-order-mobile-icon i {
                font-size: 16px !important;
            }

            /* Style buttons and links properly */
            .header__shipping--button,
            .header__shipping--text__link {
                padding: 2px 4px;
                display: inline-flex;
                align-items: center;
                justify-content: flex-start;
                gap: 3px;
                text-decoration: none;
                color: inherit;
            }

            /* Adjust language switcher buttons on very small screens */
            .language-switcher-inline {
                gap: 0;
                margin-left: 5px;
            }

            .language-switcher-inline .lang-btn {
                padding: 4px 8px;
                font-size: 10px;
            }

            /* Right side items alignment */
            .header__account--items {
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }

            /* Optimize topbar on very small screens */
            .header__topbar {
                padding: 3px 0 !important;
            }

            .header__topbar--inner {
                padding: 5px 10px !important;
            }
        }
    </style>
    <header class="header__section">

        <div class="header__topbar bg__secondary" style="background-color: white !important;">
            <div class="container-fluid">
                <div class="header__topbar--inner d-flex align-items-center justify-content-between" style="gap: 8rem;">
                    <div class="header__shipping">


                        <ul class="header__shipping--wrapper d-flex">
                            <li class="header__shipping--text text-dark">{{ __('home.welcome_to') }}
                                {{ $generalInfo->company_name }}
                                <a href="{{ url('track/order') }}" class="track-order-mobile-icon mx-3"
                                    title="{{ __('home.track_your_order') }}" style="display: none;">
                                    <i class="bi bi-bus-front-fill" style="color: #e60064; font-size: 18px;"></i>
                                </a>
                            </li>

                            <li class="header__shipping--text text-dark d-sm-2-none">
                                <a class="header__shipping--button" href="{{ url('track/order') }}"
                                    title="{{ __('home.track_your_order') }}">
                                    <i class="bi bi-bus-front-fill" style="color: #e60064;"></i>
                                    <span>{{ __('home.track_your_order') }}</span>
                                </a>

                            </li>
                            @foreach (explode(',', $generalInfo->email) as $email)
                                <li class="header__shipping--text text-dark d-sm-2-none">
                                    <a class="header__shipping--text__link " href="mailto:{{ $email }}"
                                        title="{{ $email }}">
                                        <i class="bi bi-envelope" style="color: #e60064;"></i>
                                        <span>{{ $email }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="header__account--items">

                        @include('tenant.frontend.components.language-switcher')
                    </div>
                </div>
            </div>
        </div>

        <div class="main__header header__sticky">
            <div class="container-fluid">
                <div class="main__header--inner position__relative d-flex justify-content-between align-items-center">
                    <div class="main__logo order-0">
                        <h1 class="main__logo--title">
                            <a class="main__logo--link" href="{{ url('/') }}">
                                <img class="main__logo--img" style="max-width: 220px; max-height: 62px;"
                                    src="{{ optional($generalInfo)->logo_dark ? url(optional($generalInfo)->logo_dark) : '' }}"
                                    alt="{{ optional($generalInfo)->company_name ?? config('app.name') }}" />
                            </a>
                        </h1>
                    </div>
                    <div class="offcanvas__header--menu__open order-2">
                        <a class="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg"
                                viewBox="0 0 512 512">
                                <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352" />
                            </svg>
                            <span class="visually-hidden">Menu Open</span>
                        </a>
                    </div>
                    <div class="header__search--widget header__sticky--none d-none d-lg-block">
                        <form class="d-flex header__search--form" action="{{ url('search/for/products') }}"
                            method="GET">
                            <div class="header__select--categories select">
                                <!-- <select class="header__select--inner" name="category"
                                    onchange="if(this.value) window.location.href='{{ url('shop') }}?category=' + this.value; else window.location.href='{{ url('shop') }}';">
                                    <option selected value="">{{ __('home.all_categories') }}</option>
                                    @foreach ($categories as $category)
<option value="{{ $category->slug }}"
                                            @if (isset($category_id) && $category_id == $category->slug) selected @endif>
                                            {{ $category->name }}
                                        </option>
@endforeach
                                </select> -->
                            </div>
                            <div class="custom__search--wrapper">
                                <div class="custom__search--container">
                                    <input class="custom__search--input" name="filter_search_keyword"
                                        @if (isset($search_keyword) && $search_keyword != '') value="{{ $search_keyword }}" @endif
                                        type="text" required />
                                    <label class="custom__search--label">{{ __('home.search_products') }}</label>
                                    <button class="custom__search--button" type="submit" aria-label="search button">
                                        <i class="fi fi-rr-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="header__account header__sticky--none">
                        <ul class="d-flex align-items-center  justify-content-center">
                            <li class="header__account--items">
                                @auth('customer')
                                    <a class="header__account--btn text-white" href="{{ url('/customer/home') }}"
                                        style="display: flex; align-items: center; gap: 8px;">
                                        @if (Auth::guard('customer')->user()->image)
                                            <img src="{{ url(Auth::guard('customer')->user()->image) }}" alt="Profile"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #f0f0f0;" />
                                        @else
                                            <i class="fi fi-rr-user" style="font-size: 20px;"></i>
                                        @endif
                                        <span class="header__account--btn__text text-white"
                                            style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.2;">

                                        </span>
                                    </a>
                                @endauth
                                @guest('customer')
                                    <a class="header__account--btn text-white welcome-sign-in d-flex align-items-center justify-content-center"
                                        href="{{ url('/login') }}">
                                        <i class="fi fi-rr-user" style="font-size: 24px; margin-right: 8px;"></i>
                                        <div class="welcome-sign-in-text"
                                            style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.3;">
                                            <span
                                                style="font-size: 11px; font-weight: 400; color: #ffffff;">{{ __('home.welcome') }}</span>
                                            <span
                                                style="font-size: 14px; font-weight: 600; color: #ffffff;">{{ __('home.sign_in_join') }}</span>
                                        </div>
                                    </a>
                                @endguest
                            </li>
                            @if (Auth::guard('customer')->check())
                                <li class="header__account--items d-none d-lg-block">
                                    <a class="header__account--btn text-white" href="{{ url('my/wishlists') }}">
                                        <i class="fi fi-rr-heart"></i>
                                        <span class="header__account--btn__text text-white">
                                            {{ __('home.wish_list') }}</span>
                                        @auth('customer')
                                            <span
                                                class="items__count wishlist">{{ DB::table('wish_lists')->where('user_id', Auth::guard('customer')->id())->count() }}</span>
                                        @endauth
                                    </a>
                                </li>
                            @endif

                            @if (Request::path() != 'checkout')
                                <li class="header__account--items">
                                    <a class="header__account--btn text-white minicart__open--btn"
                                        href="javascript:void(0)" data-offcanvas>
                                        <i class="fi fi-rr-shopping-cart"></i>
                                        <span class="header__account--btn__text text-white">
                                            {{ __('home.my_cart') }}</span>
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
                                            </a>


                                        </li>
                                    @endif
                                @endforeach
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
                                    <a class="header__account--btn text-white" href="{{ url('/customer/home') }}"
                                        style="position: relative;">
                                        @if (Auth::guard('customer')->user()->image)
                                            <img src="{{ url(Auth::guard('customer')->user()->image) }}" alt="Profile"
                                                style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 2px solid #f0f0f0;" />
                                        @else
                                            <i class="fi fi-rr-user"></i>
                                        @endif
                                        <span class="visually-hidden">My Account</span>
                                    </a>
                                </li>
                            @else
                                <li class="header__account--items header__account2--items">
                                    <a class="header__account--btn text-white" href="{{ url('/login') }}">
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



        @include('tenant.frontend.layouts.partials.category')

        <!-- Start Offcanvas header menu -->
        <div class="offcanvas__header">
            <div class="offcanvas__inner">
                <div class="offcanvas__logo">
                    <a class="offcanvas__logo_link" href="{{ url('/') }}">
                        <img src="{{ optional($generalInfo)->logo_dark ? url(optional($generalInfo)->logo_dark) : '' }}"
                            alt="{{ optional($generalInfo)->company_name ?? config('app.name') }}" width="158"
                            height="36" />
                    </a>
                    <button class="offcanvas__close--btn" data-offcanvas>close</button>
                </div>
                <div class="sidebar-header" id="sidebarToggle">
                    <i>☰</i> {{ __('home.browse_categories') }}
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
                                // Toggle offcanvas menu
                                const offcanvasToggle = document.querySelector('.offcanvas__header--menu__open--btn');
                                const offcanvasMenu = document.querySelector('.offcanvas__header');
                                const offcanvasClose = document.querySelector('.offcanvas__close--btn');

                                if (offcanvasToggle && offcanvasMenu) {
                                    offcanvasToggle.addEventListener('click', function() {
                                        offcanvasMenu.classList.add('active');
                                        document.body.style.overflow = 'hidden';
                                    });
                                }

                                if (offcanvasClose && offcanvasMenu) {
                                    offcanvasClose.addEventListener('click', function() {
                                        offcanvasMenu.classList.remove('active');
                                        document.body.style.overflow = '';
                                    });
                                }

                                // Toggle submenu on mobile
                                document.querySelectorAll('.offcanvas__menu_li').forEach(function(menuItem) {
                                    const link = menuItem.querySelector('.offcanvas__menu_item');
                                    const submenu = menuItem.querySelector('.offcanvas__sub_menu');

                                    if (link && submenu) {
                                        link.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            submenu.classList.toggle('active');
                                        });
                                    }
                                });

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
                <h2 class="predictive__search--title">{{ __('home.search_products') }}</h2>
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
