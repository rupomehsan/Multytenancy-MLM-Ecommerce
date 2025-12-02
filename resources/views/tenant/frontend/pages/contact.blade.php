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
    </style>
@endsection


@section('content')
    @php
        $contactInfo =
            $contactInfo ??
            ($generalInfo ??
                (object) [
                    'contact' => '',
                    'email' => '',
                    'address' => '',
                    'facebook' => null,
                    'twitter' => null,
                    'instagram' => null,
                    'linkedin' => null,
                    'messenger' => null,
                    'youtube' => null,
                    'whatsapp' => null,
                    'telegram' => null,
                    'tiktok' => null,
                    'pinterest' => null,
                    'viber' => null,
                ]);
    @endphp
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">
                            Contact Us
                        </h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">Contact Us</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start contact section -->
    <section class="contact__section section--padding">
        <div class="container">
            <div class="section__heading text-center mb-40">
                <h2 class="section__heading--maintitle">Get In Touch</h2>
            </div>
            <div class="main__contact--area position__relative">
                <div class="contact__form">
                    <h3 class="contact__form--title mb-40">Contact Me</h3>
                    <form class="contact__form--inner" action="{{ url('submit/contact/request') }}" method="POST">
                        @csrf
                        @honeypot
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input1">First Name <span
                                            class="contact__form--label__star">*</span></label>
                                    <input class="contact__form--input @error('firstname') is-invalid @enderror"
                                        name="firstname" id="input1" placeholder="Your First Name" type="text"
                                        required />
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input2">Last Name <span
                                            class="contact__form--label__star">*</span></label>
                                    <input class="contact__form--input @error('lastname') is-invalid @enderror"
                                        name="lastname" id="input2" placeholder="Your Last Name" type="text"
                                        required />
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input3">Phone Number <span
                                            class="contact__form--label__star">*</span></label>
                                    <input class="contact__form--input @error('number') is-invalid @enderror" name="number"
                                        id="input3" placeholder="+8801*********" type="text" required />
                                    @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="contact__form--label" for="input4">Email <span
                                            class="contact__form--label__star">*</span></label>
                                    <input class="contact__form--input @error('email') is-invalid @enderror" name="email"
                                        id="input4" placeholder="demo@email.com" type="email" required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact__form--list mb-15">
                                    <label class="contact__form--label" for="input5">Write Your Message <span
                                            class="contact__form--label__star">*</span></label>
                                    <textarea class="contact__form--textarea @error('message') is-invalid @enderror" name="message" id="input5"
                                        placeholder="Write Your Message" required></textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="contact__form--btn primary__btn" type="submit">
                            Submit Now
                        </button>
                    </form>
                </div>
                <div class="contact__info border-radius-5">
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">
                            Contact Us
                        </h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.568" height="31.128"
                                    viewBox="0 0 31.568 31.128">
                                    <path id="ic_phone_forwarded_24px"
                                        d="M26.676,16.564l7.892-7.782L26.676,1V5.669H20.362v6.226h6.314Zm3.157,7a18.162,18.162,0,0,1-5.635-.887,1.627,1.627,0,0,0-1.61.374l-3.472,3.424a23.585,23.585,0,0,1-10.4-10.257l3.472-3.44a1.48,1.48,0,0,0,.395-1.556,17.457,17.457,0,0,1-.9-5.556A1.572,1.572,0,0,0,10.1,4.113H4.578A1.572,1.572,0,0,0,3,5.669,26.645,26.645,0,0,0,29.832,32.128a1.572,1.572,0,0,0,1.578-1.556V25.124A1.572,1.572,0,0,0,29.832,23.568Z"
                                        transform="translate(-3 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white">
                                    @php
                                        $contactNumbers = '';
                                        foreach (explode(',', data_get($contactInfo, 'contact', '')) as $contact) {
                                            if (!trim($contact)) {
                                                continue;
                                            }
                                            $contactNumbers .=
                                                "<a href='tel:" . trim($contact) . "'>" . trim($contact) . '</a><br>';
                                        }
                                    @endphp
                                    {!! $contactNumbers !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">
                            Email Address
                        </h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13"
                                    viewBox="0 0 31.57 31.13">
                                    <path id="ic_email_24px"
                                        d="M30.413,4H5.157C3.421,4,2.016,5.751,2.016,7.891L2,31.239c0,2.14,1.421,3.891,3.157,3.891H30.413c1.736,0,3.157-1.751,3.157-3.891V7.891C33.57,5.751,32.149,4,30.413,4Zm0,7.783L17.785,21.511,5.157,11.783V7.891l12.628,9.728L30.413,7.891Z"
                                        transform="translate(-2 -4)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white">
                                    @php
                                        $emailIds = '';
                                        foreach (explode(',', data_get($contactInfo, 'email', '')) as $email) {
                                            if (!trim($email)) {
                                                continue;
                                            }
                                            $emailIds .=
                                                "<a href='mailto:" . trim($email) . "'>" . trim($email) . '</a><br>';
                                        }
                                    @endphp
                                    {!! $emailIds !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">
                            Office Location
                        </h3>
                        <div class="contact__info--items__inner d-flex">
                            <div class="contact__info--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13"
                                    viewBox="0 0 31.57 31.13">
                                    <path id="ic_account_balance_24px"
                                        d="M5.323,14.341V24.718h4.985V14.341Zm9.969,0V24.718h4.985V14.341ZM2,32.13H33.57V27.683H2ZM25.262,14.341V24.718h4.985V14.341ZM17.785,1,2,8.412v2.965H33.57V8.412Z"
                                        transform="translate(-2 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white">
                                    {{ data_get($contactInfo, 'address', '') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">
                            Follow Us
                        </h3>

                        <ul class="contact__info--social d-flex">
                            @if (data_get($contactInfo, 'facebook'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'facebook') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524"
                                            viewBox="0 0 7.667 16.524">
                                            <path data-name="Path 237"
                                                d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z"
                                                transform="translate(-960.13 -345.407)" fill="currentColor"></path>
                                        </svg>
                                        <span class="visually-hidden">Facebook</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'twitter'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'twitter') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.489" height="13.384"
                                            viewBox="0 0 16.489 13.384">
                                            <path data-name="Path 303"
                                                d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z"
                                                transform="translate(-951.23 -1140.849)" fill="currentColor"></path>
                                        </svg>
                                        <span class="visually-hidden">Twitter</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'instagram'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'instagram') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492"
                                            viewBox="0 0 19.497 19.492">
                                            <path data-name="Icon awesome-instagram"
                                                d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z"
                                                transform="translate(0.004 -1.492)" fill="currentColor" />
                                        </svg>
                                        <span class="visually-hidden">Instagram</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'youtube'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'youtube') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="11.582"
                                            viewBox="0 0 16.49 11.582">
                                            <path data-name="Path 321"
                                                d="M967.759,1365.592q0,1.377-.019,1.717-.076,1.114-.151,1.622a3.981,3.981,0,0,1-.245.925,1.847,1.847,0,0,1-.453.717,2.171,2.171,0,0,1-1.151.6q-3.585.265-7.641.189-2.377-.038-3.387-.085a11.337,11.337,0,0,1-1.5-.142,2.206,2.206,0,0,1-1.113-.585,2.562,2.562,0,0,1-.528-1.037,3.523,3.523,0,0,1-.141-.585c-.032-.2-.06-.5-.085-.906a38.894,38.894,0,0,1,0-4.867l.113-.925a4.382,4.382,0,0,1,.208-.906,2.069,2.069,0,0,1,.491-.755,2.409,2.409,0,0,1,1.113-.566,19.2,19.2,0,0,1,2.292-.151q1.82-.056,3.953-.056t3.952.066q1.821.067,2.311.142a2.3,2.3,0,0,1,.726.283,1.865,1.865,0,0,1,.557.49,3.425,3.425,0,0,1,.434,1.019,5.72,5.72,0,0,1,.189,1.075q0,.095.057,1C967.752,1364.1,967.759,1364.677,967.759,1365.592Zm-7.6.925q1.49-.754,2.113-1.094l-4.434-2.339v4.66Q958.609,1367.311,960.156,1366.517Z"
                                                transform="translate(-951.269 -1359.8)" fill="currentColor"></path>
                                        </svg>
                                        <span class="visually-hidden">Youtube</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'linkedin'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'linkedin') }}">
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
                            @endif

                            @if (data_get($contactInfo, 'messenger'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'messenger') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path
                                                    d="M256 0C114.624 0 0 106.112 0 237.024c0 74.592 37.216 141.12 95.392 184.576V512l87.168-47.84c23.264 6.432 47.904 9.92 73.44 9.92 141.376 0 256-106.112 256-237.024S397.376 0 256 0zm25.44 319.2-65.184-69.536-127.2 69.536 139.936-148.544 66.784 69.536 125.6-69.536L281.44 319.2z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">Messenger</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'whatsapp'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'whatsapp') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M256.064 0h-.128C114.784 0 0 114.816 0 256c0 56 18.048 107.904 48.736 150.048l-31.904 95.104 98.4-31.456C155.712 496.512 204 512 256.064 512 397.216 512 512 397.152 512 256S397.216 0 256.064 0zm148.96 361.504c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.616-127.456-112.576-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016.16 8.576.288 7.52.32 11.296.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744-3.776 4.352-7.36 7.68-11.136 12.352-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">Whatsapp</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'telegram'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'telegram') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path
                                                    d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931L23.93 3.821l.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693L18.953 5.78c.595-.394 1.136-.176.691.218z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">Telegram</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'tiktok'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'tiktok') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M480.32 128.39c-29.22 0-56.18-9.68-77.83-26.01-24.83-18.72-42.67-46.18-48.97-77.83A129.78 129.78 0 0 1 351.04.39h-83.47v228.08l-.1 124.93c0 33.4-21.75 61.72-51.9 71.68a75.905 75.905 0 0 1-28.04 3.72c-12.56-.69-24.33-4.48-34.56-10.6-21.77-13.02-36.53-36.64-36.93-63.66-.63-42.23 33.51-76.66 75.71-76.66 8.33 0 16.33 1.36 23.82 3.83v-84.75c-7.9-1.17-15.94-1.78-24.07-1.78-46.19 0-89.39 19.2-120.27 53.79-23.34 26.14-37.34 59.49-39.5 94.46-2.83 45.94 13.98 89.61 46.58 121.83 4.79 4.73 9.82 9.12 15.08 13.17 27.95 21.51 62.12 33.17 98.11 33.17 8.13 0 16.17-.6 24.07-1.77 33.62-4.98 64.64-20.37 89.12-44.57 30.08-29.73 46.7-69.2 46.88-111.21l-.43-186.56a210.864 210.864 0 0 0 46.88 27.34c26.19 11.05 53.96 16.65 82.54 16.64v-83.1c.02.02-.22.02-.24.02z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">TikTok</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'pinterest'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'pinterest') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 310.05 310.05"
                                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M245.265 31.772C223.923 11.284 194.388 0 162.101 0c-49.32 0-79.654 20.217-96.416 37.176-20.658 20.9-32.504 48.651-32.504 76.139 0 34.513 14.436 61.003 38.611 70.858 1.623.665 3.256 1 4.857 1 5.1 0 9.141-3.337 10.541-8.69.816-3.071 2.707-10.647 3.529-13.936 1.76-6.495.338-9.619-3.5-14.142-6.992-8.273-10.248-18.056-10.248-30.788 0-37.818 28.16-78.011 80.352-78.011 41.412 0 67.137 23.537 67.137 61.425 0 23.909-5.15 46.051-14.504 62.35-6.5 11.325-17.93 24.825-35.477 24.825-7.588 0-14.404-3.117-18.705-8.551-4.063-5.137-5.402-11.773-3.768-18.689 1.846-7.814 4.363-15.965 6.799-23.845 4.443-14.392 8.643-27.985 8.643-38.83 0-18.55-11.404-31.014-28.375-31.014-21.568 0-38.465 21.906-38.465 49.871 0 13.715 3.645 23.973 5.295 27.912-2.717 11.512-18.865 79.953-21.928 92.859-1.771 7.534-12.44 67.039 5.219 71.784 19.841 5.331 37.576-52.623 39.381-59.172 1.463-5.326 6.582-25.465 9.719-37.845 9.578 9.226 25 15.463 40.006 15.463 28.289 0 53.73-12.73 71.637-35.843 17.367-22.418 26.932-53.664 26.932-87.978 0-26.826-11.52-53.272-31.604-72.556z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">Pinterest</span>
                                    </a>
                                </li>
                            @endif

                            @if (data_get($contactInfo, 'viber'))
                                <li class="contact__info--social__list">
                                    <a class="contact__info--social__icon" target="_blank"
                                        href="{{ data_get($contactInfo, 'viber') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16"
                                            x="0" y="0" viewBox="0 0 152 152" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve">
                                            <g>
                                                <path
                                                    d="M89 11H63c-25.2 0-45.5 20.3-45.5 45.5V76c0 17.6 10.1 33.6 26 41.1v21.8c0 1.1 1 2.1 2.3 2.1.5 0 1.1-.2 1.5-.6l18.8-18.9H89c25.2 0 45.5-20.3 45.5-45.5V56.5C134.5 31.3 114.2 11 89 11zm17.1 85.3-6.5 6.5c-7 6.8-25-1-40.9-17.2s-23-34.5-16.3-41.3l6.5-6.5c2.6-2.4 6.7-2.3 9.3.2l9.4 9.8c2.4 2.6 2.4 6.5-.2 9.1-.7.7-1.5 1.1-2.4 1.5-3.3 1-5 4.2-4.2 7.5 1.6 7.2 10.7 16.2 17.6 18 3.2.8 6.5-1 7.6-4.1 1.1-3.2 4.7-5 8.1-3.9 1 .3 1.8 1 2.6 1.6l9.4 9.8c2.4 2.4 2.4 6.4 0 9zM81.8 41.9c-.7 0-1.3 0-1.9.2-1.1.2-2.3-.7-2.4-2s.7-2.3 1.9-2.4c.8-.2 1.6-.2 2.4-.2 12 0 21.6 9.8 21.8 21.6 0 .8 0 1.6-.2 2.4-.2 1.1-1.1 2.1-2.4 1.9s-2.1-1.1-1.9-2.4c0-.7.2-1.3.2-1.9-.1-9.4-7.9-17.2-17.5-17.2zm13 17.4c-.2 1.1-1.1 2.1-2.4 1.9-1-.2-1.9-1-1.9-1.9 0-4.7-3.9-8.6-8.6-8.6-1.1.2-2.3-.8-2.4-2-.2-1.1.8-2.3 1.9-2.4h.3c7.5 0 13.1 5.8 13.1 13zm16.6 6.9c-.2 1.1-1.3 1.9-2.4 1.8s-1.9-1.3-1.8-2.4v-.3c.5-1.9.7-3.9.7-6 0-14.3-11.7-26-26-26H80c-1.1.2-2.3-.8-2.3-2-.2-1.1.8-2.3 1.9-2.3.8 0 1.6-.2 2.3-.2 16.7 0 30.4 13.6 30.4 30.4-.1 2.3-.4 4.8-.9 7z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span class="visually-hidden">Viber</span>
                                    </a>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End contact section -->


    <!--  brand logo section -->
    <section class="brand__logo--section bg__secondary section--padding" style="background-color: #f8f8f8;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand__logo--section__inner swiper">
                        <div class="swiper-wrapper">
                            @foreach ($brands as $brand)
                                <div class="swiper-slide">
                                    <div class="brand__logo--items">
                                        <img class="brand__logo--items__thumbnail--img display-block"
                                            src="{{ url(env('ADMIN_URL') . '/' . $brand->logo) }}" alt="brand logo" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End brand logo section -->
@endsection
