@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend/frontend_assets') }}/css/user-pannel.css" />
    <style>
        .coupon-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .coupon-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .coupon-discount {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .coupon-info {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .coupon-code {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .coupon-code input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .copy-btn {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .status-badge {
            float: right;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
        }

        .status-badge.active {
            background: #28a745;
        }

        .expired {
            background: #dc3545;
        }

        .applied {
            background: #17a2b8;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .no-coupons {
            text-align: center;
            padding: 30px;
            color: #666;
        }
    </style>
@endsection

@push('site-seo')
    @php
        // using shared $generalInfo provided by AppServiceProvider
    @endphp
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
@endpush

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.dashboard.mobile_menu_offcanvus')
@endpush


@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt=""
                            src="{{ url('tenant/frontend/frontend_assets') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('tenant.frontend.pages.dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="promo-coupon-area mgTop24">
                        <div class="dashboard-head-widget style-2" style="margin: 0">
                            <h5 class="dashboard-head-widget-title">Promo or Coupon</h5>
                            <div class="dashboard-head-widget-btn">
                                {{-- <button type="button"
                                    class="theme-btn secondary-btn icon-right btn btn-primary widget-show-btn">
                                    <i class="fi-rr-plus"></i>Add coupon
                                </button> --}}
                            </div>
                            <!-- Coupon Widget Area -->
                            {{-- <div class="add-coupon-code-widget">
                                <form action="#" method="post" class="add-coupon-code-form">
                                    <div>
                                        <label class="form-label">Type promo/ coupon code</label><input
                                            placeholder="Enter promo" type="text" class="form-control" required="">
                                    </div>
                                    <button type="button" class="theme-btn btn btn-primary">
                                        Apply coupon
                                    </button>
                                </form>
                            </div> --}}
                            <!-- End Coupon Widget Area -->
                        </div>
                        <div class="promo-coupon-inner">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="promo-coupon-group-widget card-left">
                                        <h6 class="section-title">Available Coupons</h6>
                                        @if (count($promoCoupons) > 0)
                                            @foreach ($promoCoupons as $promoCoupon)
                                                @if (!DB::table('orders')->where('coupon_code', $promoCoupon->code)->where('user_id', Auth::user()->id)->exists())
                                                    <div class="coupon-card">
                                                        <span
                                                            class="status-badge {{ $promoCoupon->status == 1 && strtotime($promoCoupon->expire_date) >= strtotime(date('Y-m-d')) ? 'active' : 'expired' }}">
                                                            {{ $promoCoupon->status == 1 && strtotime($promoCoupon->expire_date) >= strtotime(date('Y-m-d')) ? 'Active' : 'Expired' }}
                                                        </span>

                                                        <div class="coupon-title">{{ $promoCoupon->title }}</div>

                                                        <div class="coupon-discount">
                                                            @if ($promoCoupon->type == 1)
                                                                ৳{{ number_format($promoCoupon->value, 0) }} OFF
                                                            @else
                                                                {{ $promoCoupon->value }}% OFF
                                                            @endif
                                                        </div>

                                                        <div class="coupon-info">
                                                            @if ($promoCoupon->minimum_order_amount)
                                                                <div>Minimum Order:
                                                                    ৳{{ number_format($promoCoupon->minimum_order_amount, 0) }}
                                                                </div>
                                                            @endif
                                                            <div>Valid:
                                                                {{ date('d M, Y', strtotime($promoCoupon->effective_date)) }}
                                                                -
                                                                {{ date('d M, Y', strtotime($promoCoupon->expire_date)) }}
                                                            </div>
                                                            @if ($promoCoupon->description)
                                                                <div>{{ $promoCoupon->description }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="coupon-code">
                                                            <input type="text" readonly
                                                                value="{{ $promoCoupon->code }}">
                                                            <button class="copy-btn"
                                                                onclick="copyToClipboard('{{ $promoCoupon->code }}')">Copy</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="no-coupons">No Coupons Available</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="promo-coupon-group-widget card-right">
                                        <h6 class="section-title">Applied Coupons</h6>
                                        @if (count($appliedCoupons) > 0)
                                            @foreach ($appliedCoupons as $appliedCoupon)
                                                <div class="coupon-card" style="opacity: 0.8;">
                                                    <span class="status-badge applied">Applied</span>

                                                    <div class="coupon-title">{{ $appliedCoupon->title }}</div>

                                                    <div class="coupon-discount">
                                                        @if ($appliedCoupon->type == 1)
                                                            ৳{{ number_format($appliedCoupon->value, 0) }} OFF
                                                        @else
                                                            {{ $appliedCoupon->value }}% OFF
                                                        @endif
                                                    </div>

                                                    <div class="coupon-info">
                                                        @if ($appliedCoupon->minimum_order_amount)
                                                            <div>Minimum Order:
                                                                ৳{{ number_format($appliedCoupon->minimum_order_amount, 0) }}
                                                            </div>
                                                        @endif
                                                        <div>Valid Until:
                                                            {{ date('d M, Y', strtotime($appliedCoupon->expire_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="coupon-code">
                                                        <input type="text" readonly value="{{ $appliedCoupon->code }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="no-coupons">No Coupons Applied</div>
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
    <script>
        function copyToClipboard(code) {
            var copyText = code;
            navigator.clipboard.writeText(copyText);
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1000;
            toastr.success("Copied to Clipboard")
        }
    </script>
@endsection
