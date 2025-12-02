@extends('tenant.frontend.layouts.app')


@push('site-seo')
    {{-- using shared $generalInfo provided by AppServiceProvider --}}

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
    </style>
@endsection


@section('content')
    <section class="faq__section section--padding">
        <div class="container">
            <div class="faq__section--inner">
                <div class="face__step one border-bottom" id="accordionExample">
                    <h2 class="face__step--title h3 mb-30">Frequently Asked Questions</h2>
                    <div class="row">
                        @foreach ($data as $item)
                            <div class="col-md-12">
                                <div class="accordion__container">
                                    <div class="accordion__items " style="margin-bottom: 20px;">
                                        <h2 class="accordion__items--title">
                                            <button
                                                class="faq__accordion--btn accordion__items--button">{{ $item->question }}
                                                <svg class="accordion__items--button__icon"
                                                    xmlns="http://www.w3.org/2000/svg" width="20.355" height="13.394"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M98 190.06l139.78 163.12a24 24 0 0036.44 0L414 190.06c13.34-15.57 2.28-39.62-18.22-39.62h-279.6c-20.5 0-31.56 24.05-18.18 39.62z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </h2>
                                        <div class="accordion__items--body" style="display: none; padding: 0px 20px;">
                                            <p class="accordion__items--body__desc">{{ $item->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
