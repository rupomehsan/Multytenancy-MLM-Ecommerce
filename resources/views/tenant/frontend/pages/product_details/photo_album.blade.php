@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/lightbox.min.css">
    <style>

    </style>
@endsection

@section('content')
    <section class="product__details--section section--padding" style="padding-top: 56px;">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center mb-3 my_nav_dropdown_row">
                <div class="col-md-9">
                    <ul
                        class="header__menu border-top border-bottom bg-light rounded p-3 shadow-sm d-flex align-items-center">
                        @foreach ($categories as $category)
                            @if ($category->show_on_navbar == 1)
                                @php
                                    $subcategories = DB::table('subcategories')
                                        ->where('category_id', $category->id)
                                        ->get();
                                @endphp

                                <li class="header__menu--items position-relative">
                                    <a class="header__menu--link text-dark d-inline-block py-2 px-3 rounded hover-bg-primary transition-all"
                                        @if (str_contains(Request::fullUrl(), '=' . $category->slug)) style="font-weight: 600" @endif
                                        href="{{ route('PhotoAlbum', ['sort' => request('sort', 'desc'), 'category' => $category->slug]) }}">
                                        {{ $category->name }}

                                        @if (count($subcategories) > 0)
                                            <svg class="menu__arrowdown--icon position-absolute end-10 top-50  translate-middle-y"
                                                xmlns="http://www.w3.org/2000/svg" width="12" height="7.41"
                                                viewBox="0 0 12 7.41">
                                                <path d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z"
                                                    transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7" />
                                            </svg>
                                        @endif
                                    </a>

                                    @if (count($subcategories) > 0)
                                        <ul class="header__sub--menu mt-2 rounded p-2 shadow-sm bg-white">
                                            @foreach ($subcategories as $subcategory)
                                                <li class="header__sub--menu__items">
                                                    <a href="{{ route('PhotoAlbum', ['sort' => request('sort', 'desc'), 'category' => $category->slug, 'subcategory_id' => $subcategory->id]) }}"
                                                        class="header__sub--menu__link d-block py-2 px-3 text-dark hover-bg-light rounded transition-all">{{ $subcategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- FIXED SORT DROPDOWN -->
                <div class="col-md-3 d-flex align-items-center my_md_dropdown">
                    <label class="album_sort-label me-2 mb-0 fw-bold" for="sortOrder">Sort By:</label>
                    <div class="album_custom-dropdown bg-white border rounded shadow-sm">
                        <select id="sortOrder" class="album_custom-select form-control border-0 rounded">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>New to Old</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Old to New</option>
                        </select>
                    </div>
                </div>
            </div>




            {{-- row-cols-lg-2 row-cols-md-2 --}}

            <div class="row ">
                @foreach ($images as $imageData)
                    <div class="col-md-3 mb-4 text-center">
                        <!-- Lightbox link on image -->
                        <a href="{{ env('ADMIN_URL') . '/uploads/productImages/' . $imageData['image'] }}"
                            data-lightbox="product_gallery">
                            <img class="product__media--preview__items--img lazy img-fluid p-2 border rounded"
                                src="{{ url('tenant/frontend') }}/img/product-load.gif"
                                data-src="{{ env('ADMIN_URL') . '/uploads/productImages/' . $imageData['image'] }}"
                                alt="{{ $imageData['product_name'] }}" />
                        </a>
                        <!-- Product details link on title -->
                        <a href="{{ url('product/details') }}/{{ $imageData['product_slug'] }}"
                            class="d-block mt-2 text-decoration-none text-dark">
                            <strong>{{ $imageData['product_name'] }}</strong>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Centered Pagination -->
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            {{ $images->appends(request()->query())->links() }}
        </div>
    </section>
@endsection


@section('footer_js')
    <script src="{{ url('tenant/frontend') }}/js/jquery.zoom.js"></script>
    <script src="{{ url('tenant/frontend') }}/js/lightbox.min.js"></script>

    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.header__menu--items').hover(
                function() {
                    $(this).children('.header__sub--menu').stop(true, true).fadeIn(200);
                },
                function() {
                    $(this).children('.header__sub--menu').stop(true, true).fadeOut(200);
                }
            );
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.header__menu--items').hover(function() {
                $(this).children('.header__sub--menu').stop(true, true).fadeIn(200);
            }, function() {
                $(this).children('.header__sub--menu').stop(true, true).fadeOut(200);
            });
        });
    </script>


    <script>
        document.getElementById('sortOrder').addEventListener('change', function() {
            var selectedValue = this.value; // Get the selected value (desc or asc)
            var url = new URL(window.location.href); // Get the current URL
            url.searchParams.set('sort', selectedValue); // Set the 'sort' parameter in the URL

            window.location.href = url; // Reload the page with the new 'sort' parameter
        });
    </script>
@endsection
