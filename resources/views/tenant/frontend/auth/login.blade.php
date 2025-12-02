@extends('tenant.frontend.layouts.app')

@push('site-seo')
    @php

        $socialLogin = DB::table('social_logins')->select('gmail_login_status')->where('id', 1)->first();
    @endphp

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

@section('content')
    <!-- Auth Page  Area -->
    <section class="auth-page-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 col-xl-5 col-xxl-5">
                    <div class="auth-card">
                        <div class="auth-card-head">
                            <div class="auth-card-head-icon">
                                <img src="{{ url('tenant/frontend/frontend_assets') }}/img/icon/lock.svg" alt="Login" />
                            </div>
                            <h4 class="auth-card-title">Sign in</h4>
                        </div>
                        <div class="auth-card-form-body">
                            <form method="POST" action="{{ route('login') }}" class="auth-card-form">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group-icon">
                                        <i class="fi fi-ss-user"></i>
                                    </div>
                                    <input type="email" id="email" name="email"
                                        class="form-control 
                                    @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Email" required=""
                                        autocomplete="email" />
                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $message)
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group position-relative">
                                    <div class="form-group-icon">
                                        <i class="fi fi-ss-lock"></i>
                                    </div>
                                    <input type="password" id="password" name="password" autocomplete="current-password"
                                        class="form-control @error('password') is-invalid @enderror" value=""
                                        placeholder="Password" required="" />
                                    <div class="password-toggle-icon" onclick="togglePassword()">
                                        <i id="password-toggle" class="fi fi-rs-eye" style="cursor: pointer;"></i>
                                    </div>
                                </div>
                                <div class="auth-card-info">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                            {{ old('remember') ? 'checked' : '' }} />
                                        <label for="remember" class="form-check-label">Remember me</label>
                                    </div>

                                    <a href="{{ url('forget/password') }}">Forgotten password?</a>
                                </div>
                                <button type="submit" class="auth-card-form-btn primary__btn">
                                    Sign in
                                </button>
                            </form>
                            <div class="auth-card-bottom">

                                @if (!empty($socialLogin) && $socialLogin->gmail_login_status)
                                    <span>or</span>
                                    <div class="auth-card-google-btn">
                                        <a href="{{ url('auth/google') }}">
                                            <img src="{{ url('tenant/frontend/frontend_assets') }}/img/icon/google.svg"
                                                alt="Google" />
                                            Sign in with Google
                                        </a>
                                    </div>
                                @endif

                                <p class="auth-card-bottom-link">
                                    Don’t have any account?<a href="{{ url('register') }}">Register account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Auth Page  Area -->
@endsection

<style>
    .password-toggle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        color: #666;
        transition: color 0.3s ease;
    }

    .password-toggle-icon:hover {
        color: #333;
    }

    .form-group.position-relative {
        position: relative;
    }
</style>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("password-toggle");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fi-rs-eye");
            toggleIcon.classList.add("fi-rs-eye-crossed");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fi-rs-eye-crossed");
            toggleIcon.classList.add("fi-rs-eye");
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const rememberCheckbox = document.getElementById("remember");

        // Load from localStorage if "remember me" was checked
        if (localStorage.getItem("rememberMe") === "true") {
            usernameInput.value = localStorage.getItem("savedUsername") || "";
            passwordInput.value = localStorage.getItem("savedPassword") || "";
            rememberCheckbox.checked = true;
        }

        // On form submit, store or clear based on checkbox
        document.querySelector("form.auth-card-form").addEventListener("submit", function() {
            if (rememberCheckbox.checked) {
                localStorage.setItem("savedUsername", usernameInput.value);
                localStorage.setItem("savedPassword", passwordInput.value);
                localStorage.setItem("rememberMe", "true");
            } else {
                localStorage.removeItem("savedUsername");
                localStorage.removeItem("savedPassword");
                localStorage.setItem("rememberMe", "false");
            }
        });
    });
</script>
