@extends('tenant.frontend.layouts.app')


@push('site-seo')


    @if ($data->meta_title)
        <meta name="title" content="{{ $data->meta_title }}" />
    @endif

    @if ($data->meta_keyword)
        <meta property="keywords" content="{{ $data->meta_keyword }}" />
    @endif

    @if ($data->meta_description)
        <meta property="description" content="{{ $data->meta_description }}" />
    @endif

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
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{  $generalInfo->meta_og_image }}" />
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
        @if ($data && $data->image) style="background: url({{ url( $data->image) }})" @endif>
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">
                            {{ $data->page_title ?? '' }}
                        </h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">{{ $data->page_title ?? '' }}</span>
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
                    {{-- <div class="about__thumb d-flex">
                        <div class="about__thumb--items">
                            @if ($data && $data->image)
                                <img class="about__thumb--img border-radius-5 display-block" src="{{url(env('ADMIN_URL')."/".$data->image)}}" alt="about-thumb" />
                            @endif
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-12">
                    <div class="about__content">
                        <span class="about__content--subtitle text__secondary mb-20"
                            style="font-size: 2rem; font-weight: 600;">{{ $data->section_sub_title ?? '' }}</span>
                        {{-- <h2 class="about__content--maintitle mb-25">
                            {{$data->page_title ?? ''}}
                        </h2> --}}
                        {!! $data->description ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End about section -->
@endsection
