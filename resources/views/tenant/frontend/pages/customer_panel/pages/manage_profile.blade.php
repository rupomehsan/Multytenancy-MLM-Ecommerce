@extends('tenant.frontend.pages.customer_panel.layouts.customer_layouts')


@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pages.css" />
    <style>
        .manage-profile-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .profile-image-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .profile-image-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .profile-image-wrapper img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .profile-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 48px;
            font-weight: 600;
            border: 5px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .manage-profile-form .form-group {
            margin-bottom: 20px;
        }
        
        .manage-profile-form .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .manage-profile-form .form-control {
            font-size: 15px;
            height: 48px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .manage-profile-form .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .manage-profile-form button.theme-btn {
            font-size: 15px;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .manage-profile-form button.theme-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .remove-photo-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 20px;
            background: #ef4444;
            color: #fff;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .remove-photo-btn:hover {
            background: #dc2626;
            color: #fff;
            transform: translateY(-2px);
        }
        
        .form-control::file-selector-button {
            padding: 8px 16px;
            margin-right: 12px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .form-control::file-selector-button:hover {
            background: #5568d3;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }
        
        .readonly-field-wrapper {
            position: relative;
        }
        
        .readonly-field-wrapper .form-control {
            background-color: #f8f9fa;
            padding-right: 100px;
        }
        
        .change-field-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            padding: 6px 16px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .change-field-btn:hover {
            background: #5568d3;
        }
        
        .widget-box {
            margin-top: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }
        
        .widget-box .btn {
            margin-right: 10px;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .otp-input-field {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin: 0 5px;
        }
        
        .otp-input-field:focus {
            border-color: #667eea;
            outline: none;
        }
        
        .linked-account-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .linked-account-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .linked-account-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .linked-account-info img {
            width: 32px;
            height: 32px;
        }
        
        .unlink-btn {
            padding: 6px 16px;
            background: #ef4444;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s;
        }
        
        .unlink-btn:hover {
            background: #dc2626;
            color: #fff;
        }
    </style>
@endsection


@push('site-seo')

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
@endpush

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.customer_panel.layouts.partials.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('tenant/frontend') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('tenant.frontend.pages.customer_panel.layouts.partials.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="dashboard-mange-profile mgTop24">
                        <div class="dashboard-head-widget style-2 m-0">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.manage_profile') }}</h5>
                        </div>
                        <div class="dashboard-mange-profile-inner">
                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-md-11 col-12">
                                    <div class="manage-profile-card">

                                        <!-- Profile Image Section -->
                                        <div class="profile-image-section">
                                            <div class="profile-image-wrapper">
                                                @if (Auth::user()->image)
                                                    <img src="{{ url(Auth::user()->image) }}" alt="Profile Picture">
                                                @else
                                                    <div class="profile-placeholder">
                                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            @if (Auth::user()->image)
                                                <div>
                                                    <a href="{{ url('remove/user/image') }}" class="remove-photo-btn">
                                                        <i class="fi-rr-trash"></i> {{ __('customer.remove_photo') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <form action="{{ url('update/profile') }}" method="post"
                                            class="manage-profile-form" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <!-- Personal Information -->
                                            <div class="section-title">
                                                <i class="fi-rr-user"></i> {{ __('customer.personal_information') }}
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">
                                                            {{ __('customer.full_name') }} <span class="text-danger">*</span>
                                                        </label>
                                                        <input name="name" placeholder="{{ __('customer.enter_full_name') }}" type="text"
                                                            id="name" value="{{ Auth::user()->name }}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="image">{{ __('customer.profile_photo') }}</label>
                                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                                        <small class="text-muted">{{ __('customer.profile_photo_hint') }}</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contact Information -->
                                            <div class="section-title" style="margin-top: 30px;">
                                                <i class="fi-rr-envelope"></i> {{ __('customer.contact_information') }}
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="phone">
                                                            {{ __('customer.phone_number') }}
                                                        </label>
                                                        <input name="phone" placeholder="{{ __('customer.enter_phone_number') }}" type="tel"
                                                            id="phone" value="{{ Auth::user()->phone }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email">
                                                            {{ __('customer.email_address') }}
                                                        </label>
                                                        <input name="email" placeholder="{{ __('customer.enter_email_address') }}" type="email"
                                                            id="email" value="{{ Auth::user()->email }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="manage-profile-form-button" style="margin-top: 30px;">
                                                <button type="submit" class="theme-btn btn btn-primary">
                                                    <i class="fi-rr-disk"></i> {{ __('customer.save_changes') }}
                                                </button>
                                            </div>
                                        </form>

                                        <!-- Linked Accounts Section -->
                                        @if (Auth::user()->provider_id)
                                            <div class="linked-account-section">
                                                <div class="section-title" style="border: none; margin-bottom: 15px;">
                                                    <i class="fi-rr-link"></i> {{ __('customer.linked_accounts') }}
                                                </div>
                                                <div class="linked-account-item">
                                                    <div class="linked-account-info">
                                                        <img src="{{ url('tenant/frontend') }}/assets/images/icons/google.svg" alt="Google">
                                                        <div>
                                                            <strong>{{ __('customer.google_account') }}</strong>
                                                            <p style="margin: 0; font-size: 13px; color: #718096;">{{ __('customer.connected') }}</p>
                                                        </div>
                                                    </div>
                                                    <a href="{{ url('unlink/google/account') }}" class="unlink-btn">
                                                        <i class="fi-rr-cross-small"></i> {{ __('customer.unlink') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection

@section('footer_js')
@endsection
