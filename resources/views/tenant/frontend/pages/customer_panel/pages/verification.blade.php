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
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    {{-- open graph meta --}}
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{  $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
@endpush

@push('user_dashboard_menu')
    {{-- @include('dashboard.mobile_menu_offcanvus') --}}
@endpush

@section('content')
    <section class="auth-page-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 col-xl-5 col-xxl-5">
                    <div class="auth-card verifyOTP-card">
                        <div class="auth-card-head">
                            <div class="auth-card-head-icon">
                                <img src="{{ url('tenant/frontend') }}/img/icon/edit.svg" alt="OTP" />
                            </div>
                            <h4 class="auth-card-title">{{ __('customer.verify') }}</h4>
                            <p class="auth-card-head-title-text">
                                {{ __('customer.verification_sent') }}
                                <span
                                    class="otp-number">"{{ Auth::user()->email ? Auth::user()->email : Auth::user()->phone }}"</span>
                                {{ __('customer.enter_code_verify') }}
                            </p>
                        </div>
                        <form class="auth-card-form" action="{{ url('user/verify/check') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Enter code</label>
                                <div class="otp-input" id="otp-input">
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                    <input type="text" name="code[]" maxlength="1" class="otp-input-field is-invalid"
                                        value="" required />
                                </div>
                            </div>
                            <div class="auth-form-btn mt-20">
                                <button id="verify-btn" class="auth-card-form-btn primary__btn" type="submit">
                                    {{ __('customer.verify') }}
                                </button>
                                <p id="verification-result"></p>
                            </div>
                        </form>
                        <div class="auth-card-bottom">
                            <p class="OTP-send-again m-0">
                                {{ __('customer.no_code_received') }} <a href="{{ url('user/verification/resend') }}">{{ __('customer.send_again') }}</a>
                            </p>
                            <p class="OTP-send-again m-0">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="border: 1px solid var(--secondary-color); padding: 2px 15px; border-radius: 4px;"><i
                                        class="fi-rr-sign-out-alt"></i> {{ __('customer.logout') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer_js')
    <script>
        document.addEventListener("paste", function(e) {
            // if the target is a text input
            if (e.target.type === "text") {
                var data = e.clipboardData.getData('Text');
                // split clipboard text into single characters
                data = data.split('');
                // find all other text inputs
                [].forEach.call(document.querySelectorAll("input.otp-input-field"), (node, index) => {
                    // And set input value to the relative character
                    node.value = data[index];
                    checkFilled();
                });
            }
        });

        $('input.otp-input-field').on('keyup', function() {
            if ($(this).val()) {
                $(this).next().focus();
                checkFilled();
            }
        });

        function checkFilled() {
            var interests = document.getElementsByClassName("otp-input-field");
            var emptyBoxCount = 0;
            for (var i = 0; i < interests.length; i++) {
                if (interests[i].value == '') {
                    interests[i].style.borderColor = 'red';
                } else {
                    interests[i].style.borderColor = 'green';
                    emptyBoxCount = emptyBoxCount + 1
                }
            }

            if (emptyBoxCount == 6) {
                document.getElementById("verify-btn").style.cursor = "pointer";
                document.getElementById("verify-btn").click();
            } else {
                document.getElementById("verify-btn").style.cursor = "no-drop";
            }
        }
    </script>
@endsection
