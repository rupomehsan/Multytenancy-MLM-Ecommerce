@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- using shared $generalInfo provided by AppServiceProvider --}}
    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    {{-- Page Title & Favicon --}}
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

    {{-- open graph meta --}}
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
@endpush

@section('header_css')
    <style>
        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        input[type="tel"],
        input[type="range"],
        input[type="date"],
        input[type="month"],
        input[type="week"],
        input[type="time"],
        input[type="datetime"],
        input[type="datetime-local"],
        input[type="color"],
        textarea {
            color: #1e1e1e;
        }
    </style>
@endsection

@section('content')
    <section class="auth-page-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-xl-5 col-xxl-6">
                    <div class="auth-card">
                        <div class="auth-card-head">
                            <div class="auth-card-head-icon">
                                <img src="{{ url('tenant/frontend') }}/img/icon/edit.svg" alt="#" />
                            </div>
                            <h4 class="auth-card-title">Change Password</h4>
                        </div>
                        <div class="auth-card-form-body">
                            <form class="auth-card-form" action="{{ url('change/forgotten/password') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group-icon">
                                        <i class="fi fi-rs-edit"></i>
                                    </div>
                                    <input name="code" type="text"
                                        class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}" placeholder="Verification Code" required="" />
                                    @error('code')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group" style="position: relative">
                                    <div class="form-group-icon">
                                        <i class="fi fi-rs-lock"></i>
                                    </div>
                                    <input name="password" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}" placeholder="Set New Password" required="" />
                                    <i class="fi-rs-eye-crossed" id="togglePassword"
                                        style="position: absolute; top: 50%; right: 15px; transform: translateY(-40%); cursor: pointer; color: var(--primary-color)"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button class="auth-card-form-btn primary__btn" type="submit">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer_js')
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            if (this.className == "fi-rs-eye-crossed") {
                this.className = "fi-rs-eye";
            } else {
                this.className = "fi-rs-eye-crossed";
            }
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
