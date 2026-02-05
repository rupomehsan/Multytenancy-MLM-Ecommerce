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
        <link rel="icon" href="{{ $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush


@section('header_css')
    <style>
        .breadcrumb__section.breadcrumb__bg {
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 300px;

            @if ($blog && $blog->image)
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ url($blog->image) }}');
            @else
                background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            @endif
        }

        .breadcrumb__content {
            background: transparent;
        }

        .breadcrumb__content--title,
        .breadcrumb__content--menu__items a,
        .breadcrumb__content--menu__items span {
            color: #ffffff !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .blog__details--content blockquote {
            padding: 20px 30px;
            border-radius: 10px;
        }

        .related__post--area .related__post--items .related__post--img {
            object-fit: contain;
        }

        .blog__thumbnail--img {
            height: unset !important;
            object-fit: contain !important;
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
                        <h1 class="breadcrumb__content--title mb-25">
                            {{ __('home.blog_details') }}
                        </h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items">
                                <a href="{{ url('/') }}">{{ __('home.home') }}</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <a href="{{ url('/blogs') }}">{{ __('home.blog') }}</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span>{{ __('home.blog_details') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start blog details section  -->
    <section class="blog__details--section section--padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-8 col-xl-7 col-lg-7">
                    <div class="blog__details--wrapper">
                        <div class="entry__blog">
                            <div class="blog__post--header mb-30">
                                <h2 class="post__header--title mb-15 d-flex align-items-center justify-content-between">
                                    <div>
                                        {{ $blog->title }}
                                    </div>
                                    {{-- <div class="text-end" id="backButtonContainermbl" style="display: none;">
                                        <a href="{{ url('/blogs') }}" class="btn btn-primary"
                                            style="background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; transition: background-color 0.3s ease;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-arrow-left" viewBox="0 0 16 16" style="margin-right: 5px;">
                                                <path fill-rule="evenodd"
                                                    d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5a.5.5 0 0 1 .5.5z" />
                                            </svg>
                                            Back
                                        </a>
                                    </div> --}}
                                </h2>

                                {{-- <script>
                                    if (window.innerWidth < 991) {
                                        document.getElementById('backButtonContainermbl').style.display = 'block';
                                    }
                                </script> --}}
                                <p class="blog__post--meta">
                                    {{ __('home.posted_by') }} admin / {{ __('home.on') }}
                                    {{ date('F d, Y', strtotime($blog->created_at)) }} / {{ __('home.in') }}
                                    <a class="blog__post--meta__link"
                                        href="{{ url('category/wise/blogs') }}/{{ $blog->category_id }}">{{ $blog->category_name }}</a>
                                </p>
                            </div>
                            <div class="blog__thumbnail mb-30">
                                <img class="blog__thumbnail--img border-radius-10"
                                    src="{{ $blog->image ? url($blog->image) : 'https://ui-avatars.com/api/?name=' . urlencode($blog->title) . '&size=800&background=667eea&color=fff' }}"
                                    style="height: 420px; object-fit: cover;" alt="blog-img"
                                    onerror="this.src='https://ui-avatars.com/api/?name=Blog&size=800&background=667eea&color=fff'" />
                            </div>
                            <div class="blog__details--content">
                                {{ $blog->short_description }}<br><br>

                                {!! $blog->description !!}
                            </div>
                        </div>
                        <div class="blog__tags--social__media d-flex align-items-center justify-content-between">
                            <div class="blog__tags--media d-flex align-items-center">
                                <label class="blog__tags--media__title">{{ __('home.related_tags') }}</label>
                                <ul class="d-flex">

                                    @foreach (explode(',', $blog->tags) as $tag)
                                        <li class="blog__tags--media__list">
                                            <a class="blog__tags--media__link"
                                                href="{{ url('tag/wise/blogs') }}/{{ $tag }}">{{ $tag }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                            <div class="blog__social--media d-flex align-items-center">
                                @php
                                    $socialShare = Share::page(url()->current(), env('APP_NAME'))
                                        ->facebook()
                                        ->twitter()
                                        ->linkedin(env('APP_NAME'))
                                        ->whatsapp()
                                        ->getRawLinks();
                                @endphp
                                <label class="blog__social--media__title">{{ __('home.social_share') }}</label>
                                <ul class="d-flex">
                                    <li class="blog__social--media__list">
                                        <a class="blog__social--media__link" target="_blank"
                                            href="{{ $socialShare['facebook'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524"
                                                viewBox="0 0 7.667 16.524">
                                                <path data-name="Path 237"
                                                    d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z"
                                                    transform="translate(-960.13 -345.407)" fill="currentColor"></path>
                                            </svg>
                                            <span class="visually-hidden">Facebook</span>
                                        </a>
                                    </li>
                                    <li class="blog__social--media__list">
                                        <a class="blog__social--media__link" target="_blank"
                                            href="{{ $socialShare['twitter'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16.489" height="13.384"
                                                viewBox="0 0 16.489 13.384">
                                                <path data-name="Path 303"
                                                    d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z"
                                                    transform="translate(-951.23 -1140.849)" fill="currentColor"></path>
                                            </svg>
                                            <span class="visually-hidden">Twitter</span>
                                        </a>
                                    </li>
                                    <li class="blog__social--media__list">
                                        <a class="blog__social--media__link" target="_blank"
                                            href="{{ $socialShare['linkedin'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                                x="0" y="0" viewBox="0 0 100 100" style="enable-background:new 0 0 512 512"
                                                xml:space="preserve">
                                                <g>
                                                    <path
                                                        d="M90 90V60.7c0-14.4-3.1-25.4-19.9-25.4-8.1 0-13.5 4.4-15.7 8.6h-.2v-7.3H38.3V90h16.6V63.5c0-7 1.3-13.7 9.9-13.7 8.5 0 8.6 7.9 8.6 14.1v26H90zM11.3 36.6h16.6V90H11.3zM19.6 10c-5.3 0-9.6 4.3-9.6 9.6s4.3 9.7 9.6 9.7 9.6-4.4 9.6-9.7-4.3-9.6-9.6-9.6z"
                                                        fill="currentColor"></path>
                                                </g>
                                            </svg>
                                            <span class="visually-hidden">Linkedin</span>
                                        </a>
                                    </li>
                                    <li class="blog__social--media__list">
                                        <a class="blog__social--media__link" target="_blank"
                                            href="{{ $socialShare['whatsapp'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                                x="0" y="0" viewBox="0 0 512 512"
                                                style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                <g>
                                                    <path
                                                        d="M256.064 0h-.128C114.784 0 0 114.816 0 256c0 56 18.048 107.904 48.736 150.048l-31.904 95.104 98.4-31.456C155.712 496.512 204 512 256.064 512 397.216 512 512 397.152 512 256S397.216 0 256.064 0zm148.96 361.504c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.616-127.456-112.576-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016.16 8.576.288 7.52.32 11.296.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744-3.776 4.352-7.36 7.68-11.136 12.352-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z"
                                                        fill="currentColor"></path>
                                                </g>
                                            </svg>
                                            <span class="visually-hidden">Whatsapp</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="related__post--area">
                            <div class="section__heading text-center mb-30">
                                <h2 class="section__heading--maintitle">
                                    {{ __('home.related_blogs') }}
                                </h2>
                            </div>
                            <div class="row row-cols-md-3 row-cols-sm-3 row-cols-sm-u-3 row-cols-1 mb--n28">

                                @foreach ($randomBlogs as $blog)
                                    <div class="col mb-28">
                                        <div class="related__post--items">
                                            <div class="related__post--thumb border-radius-10 mb-15">
                                                <a class="display-block"
                                                    href="{{ url('blog/details') }}/{{ $blog->slug }}">
                                                    <img class="related__post--img display-block border-radius-10"
                                                        src="{{ $blog->image ? url($blog->image) : 'https://ui-avatars.com/api/?name=' . urlencode($blog->title) . '&size=400&background=667eea&color=fff' }}"
                                                        alt="related-post"
                                                        onerror="this.src='https://ui-avatars.com/api/?name=Blog&size=400&background=667eea&color=fff'" />
                                                </a>
                                            </div>
                                            <div class="related__post--text">
                                                <h3 class="related__post--title">
                                                    <a class="related__post--title__link"
                                                        href="{{ url('blog/details') }}/{{ $blog->slug }}">{{ substr($blog->title, 0, 60) }}..</a>
                                                </h3>
                                                <span
                                                    class="related__post--deta">{{ date('F d, Y', strtotime($blog->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 offset-lg-1">

                    <div class="blog__sidebar--widget left widget__area">
                        {{-- <div class="text-end" id="backButtonContainer" style="display: none;">
                            <a href="{{ url('/blogs') }}" class="btn btn-primary"
                                style="background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; transition: background-color 0.3s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-left" viewBox="0 0 16 16" style="margin-right: 5px;">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5a.5.5 0 0 1 .5.5z" />
                                </svg>
                                Back
                            </a>
                        </div>
                        <script>
                            if (window.innerWidth > 991) {
                                document.getElementById('backButtonContainer').style.display = 'block';
                            }
                        </script> --}}


                        <div class="single__widget widget__search widget__bg">
                            <h2 class="widget__title h3">{{ __('home.search') }}</h2>
                            <form class="widget__search--form" action="{{ url('search/blogs') }}" method="GET">
                                <label>
                                    <input class="widget__search--form__input" name="search_keyword"
                                        placeholder="{{ __('home.search_placeholder') }}" type="text" />
                                </label>
                                <button class="widget__search--form__btn" aria-label="search button" type="submit">
                                    <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg"
                                        width="22.51" height="20.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                            fill="none" stroke="currentColor" stroke-miterlimit="10"
                                            stroke-width="32">
                                        </path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">{{ __('home.blog_categories') }}</h2>
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
                            <h2 class="widget__title h3">{{ __('home.recent_blogs') }}</h2>
                            <div class="product__grid--inner">

                                @foreach ($recentBlogs as $blog)
                                    <div class="product__items product__items--grid d-flex align-items-center">
                                        <div class="product__items--grid__thumbnail position__relative">
                                            <a class="product__items--link"
                                                href="{{ url('blog/details') }}/{{ $blog->slug }}">
                                                <img class="product__grid--items__img product__primary--img"
                                                    src="{{ $blog->image ? url($blog->image) : 'https://ui-avatars.com/api/?name=' . urlencode($blog->title) . '&size=200&background=667eea&color=fff' }}"
                                                    alt="product-img"
                                                    onerror="this.src='https://ui-avatars.com/api/?name=Blog&size=200&background=667eea&color=fff'" />
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
    <!-- End Start blog details section  -->
@endsection
