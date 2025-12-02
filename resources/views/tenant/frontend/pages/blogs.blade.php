@extends('tenant.frontend.layouts.app')


@push('site-seo')


    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush


@section('header_css')
    <style>
        .breadcrumb__content {
            background: transparent;
        }

        .blog__section img {
            /* max-height: 300px;
                        min-height: 280px; */
            background-size: cover;
            object-fit: contain;
        }
    </style>
@endsection


@section('content')
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">
                            Blog
                        </h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Blog</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start blog section -->
    <section class="blog__section section--padding">
        <div class="container">

            @if (isset($sectionTitle))
                <div class="section__heading text-center mb-50">
                    <h2 class="section__heading--maintitle">{{ $sectionTitle }}</h2>
                </div>
            @endif
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="blog__section--inner ">
                        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-sm-u-2 row-cols-1 mb--n30">

                            @foreach ($blogs as $blog)
                                <div class="col mb-30">
                                    <div class="blog__items">
                                        <div class="blog__thumbnail">
                                            <a class="blog__thumbnail--link"
                                                href="{{ url('blog/details') }}/{{ $blog->slug }}">
                                                <img class="blog__thumbnail--img"
                                                    src="{{ url(env('ADMIN_URL') . '/' . $blog->image) }}"
                                                    alt="blog-img" />
                                            </a>
                                        </div>
                                        <div class="blog__content">
                                            <span class="blog__content--meta">
                                                {{ date('F d, Y', strtotime($blog->created_at)) }}
                                            </span>
                                            <h3 class="blog__content--title">
                                                <a
                                                    href="{{ url('blog/details') }}/{{ $blog->slug }}">{{ substr($blog->title, 0, 60) }}..</a>
                                            </h3>
                                            <a class="blog__content--btn primary__btn"
                                                href="{{ url('blog/details') }}/{{ $blog->slug }}">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if ($blogs->total() > 6)
                            <div class="pagination__area bg__gray--color">
                                <nav class="pagination justify-content-center">
                                    <ul class="pagination__wrapper d-flex align-items-center justify-content-center">

                                        {{ $blogs->links() }}

                                    </ul>
                                </nav>
                            </div>
                        @endif


                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-4">

                    <div class="blog__sidebar--widget left widget__area">

                        <div class="single__widget widget__search widget__bg">
                            <h2 class="widget__title h3">Search</h2>
                            <form class="widget__search--form" action="{{ url('search/blogs') }}" method="GET">
                                <label>
                                    <input class="widget__search--form__input" name="search_keyword" placeholder="Search..."
                                        type="text" value="{{ $searchKeyword ?? '' }}" />
                                </label>
                                <button class="widget__search--form__btn" aria-label="search button" type="submit">
                                    <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg"
                                        width="22.51" height="20.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                            fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32">
                                        </path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Blog Categories</h2>
                            <ul class="widget__categories--menu">

                                @foreach ($blogCategories as $blogCategory)
                                    <li
                                        style="border: 1px solid var(--border-color2); margin-bottom: 1.5rem; border-radius: 0.5rem;">
                                        <a href="{{ url('category/wise/blogs') }}/{{ $blogCategory->id }}"
                                            class="d-block">
                                            <label class="widget__categories--menu__label d-flex align-items-center">
                                                <span class="widget__categories--menu__text">{{ $blogCategory->name }}
                                                    ({{ DB::table('blogs')->where('category_id', $blogCategory->id)->count() }})
                                                </span>
                                            </label>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Recent Blogs</h2>
                            <div class="product__grid--inner">

                                @foreach ($recentBlogs as $blog)
                                    <div class="product__items product__items--grid d-flex align-items-center">
                                        <div class="product__items--grid__thumbnail position__relative">
                                            <a class="product__items--link"
                                                href="{{ url('blog/details') }}/{{ $blog->slug }}">
                                                <img class="product__grid--items__img product__primary--img"
                                                    src="{{ url(env('ADMIN_URL') . '/' . $blog->image) }}"
                                                    alt="product-img" />
                                            </a>
                                        </div>
                                        <div class="product__items--grid__content">
                                            <h3 class="product__items--content__title h4">
                                                <a
                                                    href="{{ url('blog/details') }}/{{ $blog->slug }}">{{ substr($blog->title, 0, 45) }}..</a>
                                            </h3>
                                            <span
                                                class="meta__deta">{{ date('F d, Y', strtotime($blog->created_at)) }}</span>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End blog section -->
@endsection
