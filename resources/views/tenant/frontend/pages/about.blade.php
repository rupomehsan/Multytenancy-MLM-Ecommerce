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

        .about__thumb--items {
            width: 100%;
        }

        img.testimonial__items--thumbnail__img {
            height: 95px;
            width: 95px;
        }

        .breadcrumb__section {
            width: 100vw;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg"
        @if ($data && $data->banner_bg) style="background: url({{ url(env('ADMIN_URL') . '/' . $data->banner_bg) }})" @endif>
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">
                            About Us
                        </h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">About Us</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start about section -->
    <section class="about__section section--padding mb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__thumb d-flex">
                        <div class="about__thumb--items">
                            @if ($data && $data->image)
                                <img class="about__thumb--img border-radius-5 display-block"
                                    src="{{ url(env('ADMIN_URL') . '/' . $data->image) }}" alt="about-thumb" />
                            @endif
                        </div>
                        {{-- <div class="about__thumb--items position__relative">
                            <img class="about__thumb--img border-radius-5 display-block"
                                src="{{url('frontend_assets')}}/img/other/about-thumb-list2.png" alt="about-thumb" />
                            <div class="banner__bideo--play about__thumb--play">
                                <a class="banner__bideo--play__icon about__thumb--play__icon glightbox"
                                    href="https://vimeo.com/115041822" data-gallery="video">
                                    <svg id="play" xmlns="http://www.w3.org/2000/svg" width="40.302" height="40.302"
                                        viewBox="0 0 46.302 46.302">
                                        <g id="Group_193" data-name="Group 193" transform="translate(0 0)">
                                            <path id="Path_116" data-name="Path 116"
                                                d="M39.521,6.781a23.151,23.151,0,0,0-32.74,32.74,23.151,23.151,0,0,0,32.74-32.74ZM23.151,44.457A21.306,21.306,0,1,1,44.457,23.151,21.33,21.33,0,0,1,23.151,44.457Z"
                                                fill="currentColor" />
                                            <g id="Group_188" data-name="Group 188" transform="translate(15.588 11.19)">
                                                <g id="Group_187" data-name="Group 187">
                                                    <path id="Path_117" data-name="Path 117"
                                                        d="M190.3,133.213l-13.256-8.964a3,3,0,0,0-4.674,2.482v17.929a2.994,2.994,0,0,0,4.674,2.481l13.256-8.964a3,3,0,0,0,0-4.963Zm-1.033,3.435-13.256,8.964a1.151,1.151,0,0,1-1.8-.953V126.73a1.134,1.134,0,0,1,.611-1.017,1.134,1.134,0,0,1,1.185.063l13.256,8.964a1.151,1.151,0,0,1,0,1.907Z"
                                                        transform="translate(-172.366 -123.734)" fill="currentColor" />
                                                </g>
                                            </g>
                                            <g id="Group_190" data-name="Group 190" transform="translate(28.593 5.401)">
                                                <g id="Group_189" data-name="Group 189">
                                                    <path id="Path_118" data-name="Path 118"
                                                        d="M328.31,70.492a18.965,18.965,0,0,0-10.886-10.708.922.922,0,1,0-.653,1.725,17.117,17.117,0,0,1,9.825,9.664.922.922,0,1,0,1.714-.682Z"
                                                        transform="translate(-316.174 -59.724)" fill="currentColor" />
                                                </g>
                                            </g>
                                            <g id="Group_192" data-name="Group 192" transform="translate(22.228 4.243)">
                                                <g id="Group_191" data-name="Group 191">
                                                    <path id="Path_119" data-name="Path 119"
                                                        d="M249.922,47.187a19.08,19.08,0,0,0-3.2-.27.922.922,0,0,0,0,1.845,17.245,17.245,0,0,1,2.889.243.922.922,0,1,0,.31-1.818Z"
                                                        transform="translate(-245.801 -46.917)" fill="currentColor" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="visually-hidden">Video Play</span>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__content">
                        <span class="about__content--subtitle text__secondary mb-20"
                            style="font-size: 2rem; font-weight: 600;">{{ $data->section_sub_title ?? '' }}</span>
                        <h2 class="about__content--maintitle mb-25">
                            {{ $data->section_title ?? '' }}
                        </h2>
                        {!! $data->section_description ?? '' !!}
                    </div>
                    <div class="text-center mt-4">
                        @if ($data && $data->btn_link)
                            <a href="{{ $data->btn_link ?? '#' }}" class="btn btn-warning btn-lg px-4 py-2"
                                style="border-radius: 50px; font-size: 1.2rem; font-weight: bold;">
                                <i class="{{ $data->btn_icon_class ?? '' }}" style="margin-right: 8px;"></i>
                                {{ $data->btn_text ?? 'button' }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End about section -->


    <!-- Start testimonial section -->
    <section class="testimonial__section bg__gray--color section--padding">
        <div class="container-fluid">
            <div class="section__heading text-center mb-40">
                <h2 class="section__heading--maintitle">Customer Feedback</h2>
            </div>
            <div class="testimonial__section--inner testimonial__swiper--activation swiper">
                <div class="swiper-wrapper">

                    @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial__items text-center">
                                <div class="testimonial__items--thumbnail">
                                    @if ($testimonial && $testimonial->customer_image)
                                        <img class="testimonial__items--thumbnail__img border-radius-50"
                                            src="{{ url(env('ADMIN_URL') . '/' . $testimonial->customer_image) }}"
                                            alt="" />
                                    @endif
                                </div>
                                <div class="testimonial__items--content">
                                    <h3 class="testimonial__items--title">{{ $testimonial->customer_name ?? '' }}</h3>
                                    <span class="testimonial__items--subtitle"
                                        style="font-size: 1.6rem;">{{ $testimonial->designation ?? '' }}</span>
                                    <p class="testimonial__items--desc">
                                        {{ $testimonial->description ?? '' }}
                                    </p>
                                    <ul class="rating testimonial__rating d-flex justify-content-center">
                                        @if ($testimonial->rating)
                                            @for ($i = 1; $i <= $testimonial->rating; $i++)
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg"
                                                            xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                            height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy"
                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z"
                                                                transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                            @endfor
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="testimonial__pagination swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- End testimonial section -->

    <!--  brand logo section -->
    {{-- <section class="brand__logo--section bg__secondary section--padding" style="background-color: #f8f8f8;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand__logo--section__inner swiper">
                        <div class="swiper-wrapper">
                            @foreach ($brands as $brand)
                                <div class="swiper-slide">
                                    <div class="brand__logo--items">
                                        @if ($brand && $brand->logo)
                                            <img class="brand__logo--items__thumbnail--img display-block"
                                                src="{{ url(env('ADMIN_URL') . '/' . $brand->logo) }}" alt="brand logo" />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End brand logo section -->
@endsection
