@extends('tenant.admin.layouts.auth')

@section('content')
    <style>
        .bg-login {
            @php $bgImage =$generalInfo->admin_login_bg_image ?? null;
            $bgColor =$generalInfo->admin_login_bg_color ?? '#0b2a44';
            $hasImage = !empty($bgImage) && file_exists(public_path($bgImage));
        @endphp

        position: relative;
        overflow: hidden;


        @if ($hasImage)
            background-image: url('{{ asset($bgImage) }}?v={{ time() }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        @else
            background: {{ $bgColor }};
            background: linear-gradient(135deg, {{ $bgColor }} 0%, {{ $bgColor }}dd 100%);
        @endif
        }

        @if ($hasImage)
            .bg-login::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.2));
                z-index: 1;
            }
        @endif

        .bg-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, {{ $bgColor }}33 0%, {{ $bgColor }}11 100%);
            z-index: 2;
        }

        /* Responsive optimization */
        @media (max-width: 991px) {
            .bg-login {
                display: none !important;
            }
        }
    </style>
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login rounded-left"></div>
        <div class="col-lg-6">
            <div class="p-3 p-md-5 my-5 mx-auto">
                <div class="text-center">
                    <a href="{{ route('admin.login') }}" class="d-block mb-5">
                        {{-- $generalInfo is provided globally by AppServiceProvider --}}
                        <h3>{{ $generalInfo->company_name ?? '' }}</h3>
                        <h3>Admin Panel</h3>
                    </a>
                </div>
                <h1 class="h5 mb-1">Welcome Back!</h1>
                <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                <form class="user" method="POST" action="{{ route('admin.login.post') }}" style="padding-bottom: 20px;">
                    @csrf
                    <div class="form-group">
                        <input type="email" id="email"
                            @if (env('APP_NAME') == 'TpMart') value="admin@gmail.com" @else
                        value="{{ old('email') }}" @endif
                            name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                            required autocomplete="email" autofocus placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" id="password" @if (env('APP_NAME') == 'TpMart') value="11111111" @endif
                            name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                            required autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Remember Me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">{{ __('Login') }}</button>

                    <!-- Demo Mode Credentials -->
                    <div class="mt-3 d-none">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="word-break:break-all;">demo@example.com</td>
                                        <td class="align-middle" style="word-break:break-all;">12345678</td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-info btn-sm px-3 w-100 w-md-auto"
                                                onclick="autoFillAdmin()">Copy</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @media (max-width: 576px) {
                                .table-responsive table td {
                                    font-size: 12px;
                                }
                            }
                        </style>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script>
    // Password Toggle
    document.querySelector('.password-toggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    // Auto Fill Admin Credentials
    function autoFillAdmin() {
        document.getElementById('email').value = 'demo@example.com';
        document.getElementById('password').value = '12345678';
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-fill remembered email/password
        const remembered = localStorage.getItem('rememberMebasic');
        const email = localStorage.getItem('rememberedEmailbasic');
        const password = localStorage.getItem('passwordbasic');

        if (remembered === 'true' && email && password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('remember').checked = true;
        }

        // On form submit, store/remove email/password
        document.querySelector('form').addEventListener('submit', function() {
            const remember = document.getElementById('remember').checked;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (remember) {
                localStorage.setItem('rememberMebasic', 'true');
                localStorage.setItem('rememberedEmailbasic', email);
                localStorage.setItem('passwordbasic', password);
            } else {
                localStorage.removeItem('rememberMebasic');
                localStorage.removeItem('rememberedEmailbasic');
                localStorage.removeItem('passwordbasic');
            }
        });
    });

    function autoFillAdmin() {
        document.getElementById('email').value = 'demo@example.com';
        document.getElementById('password').value = '12345678';
    }
</script>
