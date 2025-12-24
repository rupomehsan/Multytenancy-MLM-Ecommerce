@extends('tenant.frontend.layouts.app')

@section('header_css')
    <style>
        /* Referral Info Badge */
        .referral-info-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .referral-info-badge i {
            font-size: 20px;
        }

        .referral-info-badge .text {
            flex: 1;
        }

        .referral-info-badge .text strong {
            display: block;
            font-size: 14px;
            margin-bottom: 2px;
            opacity: 0.9;
        }

        .referral-info-badge .text span {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .form-group.referral-field {
            position: relative;
        }

        .form-group.referral-field input:disabled {
            background-color: #f3f4f6;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .referral-verified-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #10b981;
            font-size: 20px;
        }

        /* Form Labels */
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-label span {
            color: #dc3545;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
        }

        .form-group {
            margin-bottom: 20px;
        }

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

        /* Inline Validation Styles */
        .form-control.is-valid {
            border-color: #10b981 !important;
            padding-right: 45px !important;
        }

        .form-control.is-invalid {
            border-color: #dc3545 !important;
            padding-right: 45px !important;
        }

        . {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            display: none;
        }

        ..success {
            color: #10b981;
            display: block;
        }

        ..error {
            color: #dc3545;
            display: block;
        }

        .password-field-wrapper . {
            right: 45px !important;
        }

        .valid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 16px;
            color: #10b981;
        }

        .valid-feedback.d-block {
            display: block !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 16px;
            color: #dc3545;
        }

        .invalid-feedback.d-block {
            display: block !important;
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
                            <form class="auth-card-form" action="{{ url('register') }}" method="post"
                                id="registrationForm">
                                @csrf

                                <!-- Referral Info Badge (shown when ref parameter exists) -->
                                <div id="referralInfoBadge" class="referral-info-badge" style="display: none;">
                                    <i class="fi fi-ss-user-add"></i>
                                    <div class="text">
                                        <strong>Referred by</strong>
                                        <span id="referralCodeDisplay"></span>
                                    </div>
                                    <i class="" style="color: #fff; font-size: 24px;"></i>
                                </div>

                                <!-- Hidden input for referral code -->
                                <input type="hidden" name="referral_code" id="referralCodeInput" value="">

                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name <span
                                            style="color: #dc3545;">*</span></label>
                                    <div class="input-wrapper">
                                        <div class="form-group-icon">
                                            <i class="fi fi-ss-user"></i>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="Enter your full name"
                                            required="" />
                                        <i class=" " id="nameValidIcon"></i>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <span class="invalid-feedback" id="nameError" role="alert"></span>
                                        <span class="valid-feedback" id="nameSuccess" role="alert">Name looks good!</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email <span
                                            style="color: #dc3545;">*</span></label>
                                    <div class="input-wrapper">
                                        <div class="form-group-icon">
                                            <i class="fi fi-ss-envelope"></i>
                                        </div>
                                        <input type="text" id="email" name="email"
                                            class="form-control 
                                        @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="Enter your email " required="" />
                                        <i class=" " id="emailValidIcon"></i>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <span class="invalid-feedback" id="emailError" role="alert"></span>
                                        <span class="valid-feedback" id="emailSuccess" role="alert">Email/Phone looks
                                            good!</span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label for="address" class="form-label">Address <span
                                            style="color: #dc3545;">*</span></label>
                                    <div class="input-wrapper">
                                        <div class="form-group-icon">
                                            <i class="fi-ss-home-location-alt"></i>
                                        </div>
                                        <input type="text" id="address" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address') }}" placeholder="Enter your address" required="" />
                                    </div>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="form-group password-field-wrapper">
                                    <label for="password" class="form-label">Password <span
                                            style="color: #dc3545;">*</span></label>
                                    <div class="input-wrapper">
                                        <div class="form-group-icon">
                                            <i class="fi fi-ss-lock"></i>
                                        </div>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid  @enderror" value=""
                                            placeholder="Enter your password" required="" />
                                        <i class=" " id="passwordValidIcon"></i>
                                        <i class="fi-rs-eye-crossed password-toggle-icon" id="togglePassword"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <span class="invalid-feedback" id="passwordError" role="alert"></span>
                                        <span class="valid-feedback" id="passwordSuccess" role="alert">Password is
                                            strong!</span>
                                    @enderror
                                </div>

                                <div class="form-group password-field-wrapper">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span
                                            style="color: #dc3545;">*</span></label>
                                    <div class="input-wrapper">
                                        <div class="form-group-icon">
                                            <i class="fi fi-ss-lock"></i>
                                        </div>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid  @enderror"
                                            value="" placeholder="Re-enter your password" required="" />
                                        <i class="fi fi-ss-check-circle validation-icon"
                                            id="passwordConfirmValidIcon"></i>
                                        <i class="fi-rs-eye-crossed password-toggle-icon"
                                            id="togglePasswordConfirmation"></i>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @else
                                        <span class="invalid-feedback" id="passwordConfirmError" role="alert"></span>
                                        <span class="valid-feedback" id="passwordConfirmSuccess" role="alert">Passwords
                                            match!</span>
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
        // Referral System: Extract and validate referral code from URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const referralCode = urlParams.get('ref');

            if (referralCode) {
                // Validate referral code via AJAX
                validateReferralCode(referralCode);
            }
        });

        function validateReferralCode(code) {
            fetch(`{{ url('/api/validate-referral') }}?code=${code}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        // Show referral info badge
                        document.getElementById('referralInfoBadge').style.display = 'flex';
                        document.getElementById('referralCodeDisplay').textContent = code;
                        document.getElementById('referralCodeInput').value = code;
                    } else {
                        console.warn('Invalid referral code:', code);
                        // Optionally show a warning to the user
                    }
                })
                .catch(error => {
                    console.error('Error validating referral code:', error);
                });
        }

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

        const togglePasswordConfirmation = document.querySelector("#togglePasswordConfirmation");
        const passwordConfirmation = document.querySelector("#password_confirmation");

        if (togglePasswordConfirmation && passwordConfirmation) {
            togglePasswordConfirmation.addEventListener("click", function() {
                // toggle the type attribute
                const type = passwordConfirmation.getAttribute("type") === "password" ? "text" : "password";
                passwordConfirmation.setAttribute("type", type);

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

            // Run complete validation
            if (!validateAllFields()) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.options.timeOut = 2000;
                toastr.error("Please fix all validation errors before continuing");
                return false;
            }

            var username = $("#email").val();

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

        // Extract and handle referral code from URL
        function handleReferralCode() {
            const urlParams = new URLSearchParams(window.location.search);
            const referralCode = urlParams.get('ref');

            if (referralCode) {
                // Set the referral code in hidden input
                document.getElementById('referralCodeInput').value = referralCode;

                // Display the referral info badge
                document.getElementById('referralInfoBadge').style.display = 'flex';
                document.getElementById('referralCodeDisplay').textContent = referralCode;

                // Validate referral code exists (optional AJAX call)
                validateReferralCode(referralCode);
            }
        }

        // Optional: Validate referral code via AJAX
        function validateReferralCode(code) {
            fetch(`/api/validate-referral?code=${code}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.valid) {
                        // Show warning if code is invalid
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.timeOut = 4000;
                        toastr.warning("The referral code may be invalid or expired");

                        // Hide the referral badge if invalid
                        document.getElementById('referralInfoBadge').style.display = 'none';
                        document.getElementById('referralCodeInput').value = '';
                    }
                })
                .catch(error => {
                    console.log('Referral validation skipped');
                });
        }

        // Call on page load
        document.addEventListener('DOMContentLoaded', function() {
            handleReferralCode();
            initializeInlineValidation();
        });

        // ========================================
        // INLINE VALIDATION IMPLEMENTATION
        // ========================================
        function initializeInlineValidation() {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            // Name validation
            if (nameInput) {
                nameInput.addEventListener('input', debounce(function() {
                    validateName();
                }, 300));
                nameInput.addEventListener('blur', function() {
                    validateName();
                });
            }

            // Email validation
            if (emailInput) {
                emailInput.addEventListener('input', debounce(function() {
                    validateEmail();
                }, 300));
                emailInput.addEventListener('blur', function() {
                    validateEmail();
                });
            }

            // Password validation
            if (passwordInput) {
                passwordInput.addEventListener('input', debounce(function() {
                    validatePassword();
                    if (passwordConfirmInput.value) {
                        validatePasswordConfirmation();
                    }
                }, 300));
                passwordInput.addEventListener('blur', function() {
                    validatePassword();
                });
            }

            // Password confirmation validation
            if (passwordConfirmInput) {
                passwordConfirmInput.addEventListener('input', debounce(function() {
                    validatePasswordConfirmation();
                }, 300));
                passwordConfirmInput.addEventListener('blur', function() {
                    validatePasswordConfirmation();
                });
            }
        }

        // Debounce function to limit validation calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Name validation
        function validateName() {
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const nameSuccess = document.getElementById('nameSuccess');
            const nameValidIcon = document.getElementById('nameValidIcon');
            const name = nameInput.value.trim();

            // Clear previous states
            nameInput.classList.remove('is-valid', 'is-invalid');
            nameValidIcon.classList.remove('success', 'error');
            nameError.classList.remove('d-block');
            nameSuccess.classList.remove('d-block');

            if (name === '') {
                setFieldInvalid(nameInput, nameError, nameValidIcon, 'Name is required');
                return false;
            }

            if (name.length < 2) {
                setFieldInvalid(nameInput, nameError, nameValidIcon, 'Name must be at least 2 characters');
                return false;
            }

            if (name.length > 255) {
                setFieldInvalid(nameInput, nameError, nameValidIcon, 'Name must not exceed 255 characters');
                return false;
            }

            setFieldValid(nameInput, nameSuccess, nameValidIcon);
            return true;
        }

        // Email/Phone validation
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailSuccess = document.getElementById('emailSuccess');
            const emailValidIcon = document.getElementById('emailValidIcon');
            const value = emailInput.value.trim();

            // Clear previous states
            emailInput.classList.remove('is-valid', 'is-invalid');
            emailValidIcon.classList.remove('success', 'error');
            emailError.classList.remove('d-block');
            emailSuccess.classList.remove('d-block');

            if (value === '') {
                setFieldInvalid(emailInput, emailError, emailValidIcon, 'Email or phone is required');
                return false;
            }

            // Check if it contains @, then validate as email
            if (containsAtSymbol(value)) {
                if (!isValidEmail(value)) {
                    setFieldInvalid(emailInput, emailError, emailValidIcon, 'Please enter a valid email address');
                    return false;
                }
            } else {
                // Validate as phone number
                if (!isValidBangladeshiMobileNumber(value)) {
                    setFieldInvalid(emailInput, emailError, emailValidIcon,
                        'Please enter a valid Bangladeshi mobile number (01XXXXXXXXX)');
                    return false;
                }
            }

            setFieldValid(emailInput, emailSuccess, emailValidIcon);
            return true;
        }

        // Password validation
        function validatePassword() {
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');
            const passwordSuccess = document.getElementById('passwordSuccess');
            const passwordValidIcon = document.getElementById('passwordValidIcon');
            const password = passwordInput.value;

            // Clear previous states
            passwordInput.classList.remove('is-valid', 'is-invalid');
            passwordValidIcon.classList.remove('success', 'error');
            passwordError.classList.remove('d-block');
            passwordSuccess.classList.remove('d-block');

            if (password === '') {
                setFieldInvalid(passwordInput, passwordError, passwordValidIcon, 'Password is required');
                return false;
            }

            if (password.length < 8) {
                setFieldInvalid(passwordInput, passwordError, passwordValidIcon, 'Password must be at least 8 characters');
                return false;
            }

            setFieldValid(passwordInput, passwordSuccess, passwordValidIcon);
            return true;
        }

        // Password confirmation validation
        function validatePasswordConfirmation() {
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const passwordConfirmError = document.getElementById('passwordConfirmError');
            const passwordConfirmSuccess = document.getElementById('passwordConfirmSuccess');
            const passwordConfirmValidIcon = document.getElementById('passwordConfirmValidIcon');
            const password = passwordInput.value;
            const passwordConfirm = passwordConfirmInput.value;

            // Clear previous states completely
            passwordConfirmInput.classList.remove('is-valid', 'is-invalid');
            passwordConfirmValidIcon.classList.remove('success', 'error');
            passwordConfirmError.classList.remove('d-block');
            passwordConfirmSuccess.classList.remove('d-block');
            passwordConfirmError.textContent = ''; // Clear error text
            passwordConfirmSuccess.textContent = ''; // Clear success text

            if (passwordConfirm === '') {
                setFieldInvalid(passwordConfirmInput, passwordConfirmError, passwordConfirmValidIcon,
                    'Please confirm your password');
                return false;
            }

            if (password !== passwordConfirm) {
                setFieldInvalid(passwordConfirmInput, passwordConfirmError, passwordConfirmValidIcon,
                    'Passwords do not match');
                return false;
            }

            // Set success message
            passwordConfirmSuccess.textContent = 'Passwords match!';
            setFieldValid(passwordConfirmInput, passwordConfirmSuccess, passwordConfirmValidIcon);
            return true;
        }

        // Helper function to set field as invalid
        function setFieldInvalid(input, errorElement, iconElement, message) {
            // Remove valid state
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');

            // Show error message
            errorElement.textContent = message;
            errorElement.classList.add('d-block');

            // Update icon
            iconElement.classList.remove('success');
            iconElement.classList.add('error');
            iconElement.classList.remove('fi-ss-check-circle');
            iconElement.classList.add('fi-ss-cross-circle');
        }

        // Helper function to set field as valid
        function setFieldValid(input, successElement, iconElement) {
            // Remove invalid state
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');

            // Show success message
            successElement.classList.add('d-block');

            // Update icon
            iconElement.classList.remove('error');
            iconElement.classList.add('success');
            iconElement.classList.remove('fi-ss-cross-circle');
            iconElement.classList.add('fi-ss-check-circle');
        }

        // Validate all fields before showing confirmation modal
        function validateAllFields() {
            const nameValid = validateName();
            const emailValid = validateEmail();
            const passwordValid = validatePassword();
            const passwordConfirmValid = validatePasswordConfirmation();

            return nameValid && emailValid && passwordValid && passwordConfirmValid;
        }
    </script>
@endsection
