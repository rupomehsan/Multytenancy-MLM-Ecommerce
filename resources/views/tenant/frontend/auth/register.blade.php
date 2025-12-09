@extends('tenant.frontend.layouts.app')

@section('header_css')
    <style>
        /* Confirmation Email Modal  */
        #backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            z-index: 999;
            opacity: 0.5;
        }

        #confirmation-email-modal {
            display: none;
            padding: 32px 24px;
            background-color: var(--white-color);
            margin-top: 20px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            border-radius: 24px;
            text-align: center;
            /* width: 648px; */
            width: 500px;
        }

        #close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .c-email-modal-icon img {
            width: 200px;
            height: 176x;
            object-fit: contain;
        }

        .c-email-modal-content {
            margin-top: 24px;
        }

        .c-email-modal-content h4 {
            font-size: 25px;
            font-weight: 600;
            line-height: 120%;
            margin: 0;
        }

        .c-email-modal-content p {
            font-size: 16px;
            font-weight: 500;
            line-height: 150%;
            margin: 0;
            margin-top: 16px;
        }

        .c-email-modal-buttons {
            display: flex;
            align-items: center;
            gap: 24px;
            justify-content: center;
            margin-top: 32px;
        }

        .single-c-email-modal-btn {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            line-height: 150%;
            width: 100%;
            border-radius: 8px;
            transition: all 0.4s ease;
        }

        .single-c-email-modal-btn.edit {
            background: #EBF4FD;
            color: var(--primary-color);
        }

        .single-c-email-modal-btn.edit:hover {
            background: var(--primary-color);
            color: var(--white-color);
        }

        .single-c-email-modal-btn.confirm {
            background: var(--primary-color);
            color: var(--white-color);
        }

        .single-c-email-modal-btn.confirm:hover {
            background: var(--secondary-color);
        }

        .c-email-modal-content span {
            background: #EBF4FD;
            display: inline-block;
            border-radius: 8px;
            line-height: 150%;
            font-weight: 500;

            padding: 8px 24px;
            font-size: 18px;
            margin-top: 20px;
        }

        #close-icon {
            width: 32px;
            height: 32px;
            line-height: 39px;
            background: #EBF4FD;
            color: var(--primary-color);
            border-radius: 100%;
            font-size: 18px;
            transition: all 0.4s ease;
            text-align: center;
        }

        #close-icon:hover {
            background: var(--primary-color);
            color: var(--white-color);
        }

        /* Password field specific styles - Complete override */
        .password-field-wrapper {
            position: relative !important;
        }

        /* Force consistent styling for all validation states */
        .password-field-wrapper input[type="password"],
        .password-field-wrapper input[type="text"] {
            padding-right: 50px !important;
            background-image: none !important;
            background-position: unset !important;
            background-repeat: unset !important;
            background-size: unset !important;
        }

        /* Override Bootstrap validation background images completely */
        .password-field-wrapper .form-control.is-invalid,
        .password-field-wrapper .form-control.is-valid,
        .password-field-wrapper .form-control:invalid,
        .password-field-wrapper .form-control:valid {
            background-image: none !important;
            background-position: unset !important;
            background-repeat: unset !important;
            background-size: unset !important;
            padding-right: 50px !important;
        }

        /* Eye icon with absolute positioning inside input field */
        .password-toggle-icon {
            position: absolute !important;
            top: 50% !important;
            right: 15px !important;
            transform: translateY(-50%) !important;
            cursor: pointer !important;
            color: var(--primary-color) !important;
            z-index: 999 !important;
            font-size: 18px !important;
            line-height: 1 !important;
            pointer-events: auto !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Adjust eye icon position when there's an error */
        .password-field-wrapper .form-control.is-invalid+.password-toggle-icon {
            top: 25% !important;
        }

        /* Ensure error messages display properly */
        .password-field-wrapper .invalid-feedback {
            display: block !important;
        }

        /* Make sure the wrapper doesn't get affected by form validation */
        .password-field-wrapper::before,
        .password-field-wrapper::after {
            display: none !important;
        }

        /* Responsive CSS */
        @media only screen and (min-width: 992px) and (max-width: 1240px) {
            .c-email-modal-icon img {
                width: 172px;
                height: 152px;
            }
        }

        @media only screen and (max-width: 767px) {

            #confirmation-email-modal {
                width: 90%;
            }

            .c-email-modal-icon img {
                width: 124px;
                height: 100px;
            }

            .c-email-modal-content h4 {
                font-size: 20px;
            }

            .c-email-modal-content p {
                font-size: 14px;
            }

            .c-email-modal-content span {
                padding: 12px;
                font-size: 16px;
                margin-top: 18px;
            }

            .c-email-modal-buttons {
                margin-top: 24px;
            }

            .single-c-email-modal-btn {
                padding: 12px 8px;
                font-size: 14px;
            }

            #close-icon {
                line-height: 36px;
                text-align: center;
            }

            .c-email-modal-content p br {
                display: none;
            }
        }
    </style>
@endsection


@push('site-seo')
    @php
        // using shared $generalInfo provided by AppServiceProvider
        $socialLogin = DB::table('social_logins')->select('gmail_login_status')->where('id', 1)->first();
    @endphp
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
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" />
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

@section('content')
    <!-- Auth Page  Area -->
    <section class="auth-page-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 col-xl-5 col-xxl-5">
                    <div class="auth-card">
                        <div class="auth-card-head">
                            <div class="auth-card-head-icon">
                                <img src="{{ url('tenant/frontend') }}/img/icon/edit.svg" alt="Registration" />
                            </div>
                            <h4 class="auth-card-title">Register Account</h4>
                        </div>
                        <div class="auth-card-form-body">
                            <form class="auth-card-form" action="{{ url('register') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <div class="form-group-icon">
                                        <i class="fi fi-ss-user"></i>
                                    </div>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Full Name" required="" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-group-icon">
                                        <i class="fi fi-ss-envelope"></i>
                                    </div>
                                    <input type="text" id="email" name="email"
                                        class="form-control 
                                    @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Email" required="" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-group-icon">
                                        <i class="fi-ss-home-location-alt"></i>
                                    </div>
                                    <input type="text" id="address" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}" placeholder="Address" />
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group password-field-wrapper">
                                    <div class="form-group-icon">
                                        <i class="fi fi-ss-lock"></i>
                                    </div>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid  @enderror" value=""
                                        placeholder="Set Password" required="" />
                                    <i class="fi-rs-eye-crossed password-toggle-icon" id="togglePassword"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="button" id="show-confirmation-email-modal"
                                    class="auth-card-form-btn primary__btn">
                                    Register account
                                </button>
                                <button type="submit" id="registration_button"
                                    class="auth-card-form-btn primary__btn d-none">
                                    Register account
                                </button>

                            </form>
                            <div class="auth-card-bottom">

                                @if (!empty($socialLogin) && $socialLogin->gmail_login_status)
                                    <span>or</span>
                                    <div class="auth-card-google-btn">
                                        <a target="_blank" href="{{ url('auth/google') }}">
                                            <img src="{{ url('tenant/frontend') }}/img/icon/google.svg" alt="Google" />
                                            Register with Google
                                        </a>
                                    </div>
                                @endif

                                <p class="auth-card-bottom-link">
                                    Already have an account?<a href="{{ url('login') }}">Sign in</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Auth Page  Area -->


    <div id="backdrop"></div>
    <!-- Confimation Email Modal -->
    <div id="confirmation-email-modal">
        {{-- <span id="close-icon" onclick="closeWidget()"><i class="fi-rr-cross-small"></i></span> --}}
        <div class="c-email-modal-icon">
            <img src="{{ url('tenant/frontend') }}/img/confirm-notification-icon.svg" alt="" />
        </div>
        <div class="c-email-modal-content">
            <h4>Confirm Your Email</h4>
            <p>
                A verification code will be sent to your email to<br />
                verify your account. Please confirm your email.
            </p>
            <span id="confirmationEmailOrPhone"></span>
            <div class="c-email-modal-buttons">
                <a href="javascript:void(0)" class="single-c-email-modal-btn edit" onclick="closeWidget()">Edit</a>
                <a href="javascript:void(0)" class="single-c-email-modal-btn confirm"
                    onclick="submitRegistrationForm()">Yes, confirm</a>
            </div>
        </div>
    </div>
    <!-- End Confimation Email Modal -->
@endsection


@section('footer_js')
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        if (togglePassword && password) {
            togglePassword.addEventListener("click", function() {
                // toggle the type attribute
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);

                // toggle the icon using classList
                if (this.classList.contains("fi-rs-eye-crossed")) {
                    this.classList.remove("fi-rs-eye-crossed");
                    this.classList.add("fi-rs-eye");
                } else {
                    this.classList.remove("fi-rs-eye");
                    this.classList.add("fi-rs-eye-crossed");
                }
            });
        }

        // prevent form submit
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });
        }
    </script>

    <!-- Confirmation Email Modal JS -->
    <script type="text/javascript">
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function containsAtSymbol(inputString) {
            return inputString.indexOf('@') !== -1; // or inputString.includes('@');
        }

        function isValidBangladeshiMobileNumber(mobileNumber) {
            // Bangladeshi mobile numbers can start with 01, and the total length should be 11 digits
            const mobileRegex = /^01[0-9]{9}$/;
            return mobileRegex.test(mobileNumber);
        }

        // JavaScript to handle button click and show/hide the modal
        document.getElementById("show-confirmation-email-modal").addEventListener("click", function() {

            var name = $("#name").val();
            var username = $("#email").val();
            var password = $("#password").val();
            var address = $("#address").val();

            if (name == '' || username == '' || password == '' || address == '') {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 2000;
                toastr.error("Please fill up all the input fields");
                return false;
            }

            if (containsAtSymbol(username)) {
                if (!isValidEmail(username)) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 2000;
                    toastr.error("Email is not in a valid format");
                    return false;
                }
            } else {
                if (!isValidBangladeshiMobileNumber(username)) {
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.timeOut = 2000;
                    toastr.error("Mobile number is not in a valid Bangladeshi format");
                    return false;
                }
            }

            $("#confirmationEmailOrPhone").html(username);

            var backdrop = document.getElementById("backdrop");
            var widget = document.getElementById("confirmation-email-modal");

            // Toggle the display property of the backdrop and modal
            backdrop.style.display = backdrop.style.display === "none" || backdrop.style.display === "" ? "block" :
                "none";
            widget.style.display = widget.style.display === "none" || widget.style.display === "" ? "block" :
                "none";
        });

        function submitRegistrationForm() {
            $('#show-confirmation-email-modal').prop('disabled', true);
            $('#show-confirmation-email-modal').css('cursor', 'wait');
            closeWidget();
            $("#show-confirmation-email-modal").html("Sending Code...");
            document.getElementById('registration_button').click();
        }

        // Function to close the modal
        function closeWidget() {
            var backdrop = document.getElementById("backdrop");
            var widget = document.getElementById("confirmation-email-modal");
            $('#email').focus();

            // Hide the backdrop and modal
            backdrop.style.display = "none";
            widget.style.display = "none";
        }
    </script>
@endsection
