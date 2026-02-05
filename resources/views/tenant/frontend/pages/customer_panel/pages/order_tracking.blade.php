@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
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
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif
@endpush

@section('header_css')
    <style>
        .single-order-status-card:last-child::after {
            background: none
        }

        .single-order-status-card:last-child::before {
            background: none
        }
    </style>
@endsection

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

                    <div class="order-tracking-area">
                        <div class="dashboard-head-widget style-2" style="margin-top: 25px;">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.order_tracking') }}</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right"
                                    href="{{ url('order/details') }}/{{ $order->slug }}"><i
                                        class="fi-rr-arrow-left"></i>{{ __('customer.back') }}</a>
                            </div>
                        </div>
                        <div class="order-tracking-card-group">
                            <div class="single-order-tracking-card card-1">
                                <div class="order-tracking-card-icon">
                                    <img alt="#"
                                        src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-1.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>#{{ $order->order_no }}</h6>
                                    <p>{{ __('customer.order_number') }}</p>
                                </div>
                            </div>
                            <div class="single-order-tracking-card card-2">
                                <div class="order-tracking-card-icon">
                                    <img alt="#"
                                        src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-2.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>{{ date('F d, Y', strtotime($order->estimated_dd)) }}</h6>
                                    <p>{{ __('customer.estimated_delivery') }}</p>
                                </div>
                            </div>
                            <div class="single-order-tracking-card card-3">
                                <div class="order-tracking-card-icon">
                                    <img alt="#"
                                        src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-3.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>{{ $totalItems }} {{ __('customer.cart_items') }}</h6>
                                    <p>{{ __('customer.total') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-status-area">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-12">
                                    <div class="order-status-section-head">
                                        <h4 class="order-status-s-head-title">{{ __('customer.order_status') }}</h4>
                                        <div class="seperator-group">
                                            <span class="seperator-sm"></span><span class="seperator-big"></span><span
                                                class="seperator-sm"></span>
                                        </div>
                                    </div>
                                    <div class="order-status-card-group">

                                        @php
                                            use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
                                            $currentStatus = $order->order_status;
                                        @endphp

                                        {{-- Order Placed (Status 0) --}}
                                        @if ($currentStatus >= Order::STATUS_PENDING)
                                            <div class="single-order-status-card card-1">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order placed</h6>
                                                    <p>We have received your order</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->created_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->created_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Order Confirmed (Status 1) --}}
                                        @if ($currentStatus >= Order::STATUS_APPROVED && $currentStatus != Order::STATUS_CANCELLED)
                                            <div class="single-order-status-card card-2">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order confirmed</h6>
                                                    <p>Your order has been confirmed</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Dispatch (Status 2) --}}
                                        @if ($currentStatus >= Order::STATUS_DISPATCH && $currentStatus != Order::STATUS_CANCELLED)
                                            <div class="single-order-status-card card-3">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Dispatch</h6>
                                                    <p>Order taken by delivery man.</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- On the way (Status 3) --}}
                                        @if ($currentStatus >= Order::STATUS_INTRANSIT && $currentStatus != Order::STATUS_CANCELLED && $currentStatus != Order::STATUS_RETURN)
                                            <div class="single-order-status-card card-4">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>On the way</h6>
                                                    <p>We are on the way to your destination</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Order Delivered (Status 5) --}}
                                        @if ($currentStatus == Order::STATUS_DELIVERED)
                                            <div class="single-order-status-card card-5">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order Delivered</h6>
                                                    <p>You have Successfully received your order</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Order Returned (Status 6) --}}
                                        @if ($currentStatus == Order::STATUS_RETURN)
                                            <div class="single-order-status-card card-6">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order Returned</h6>
                                                    <p>You didn't receive your order</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Order Cancelled (Status 4) --}}
                                        @if ($currentStatus == Order::STATUS_CANCELLED)
                                            <div class="single-order-status-card card-7">
                                                <div class="order-status-card-icon-cross">
                                                    <i class="fi-br-cross"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Your Order is Cancelled</h6>
                                                    <p>We have cancelled your order</p>
                                                    <ul>
                                                        <li>{{ date('d M, y', strtotime($order->updated_at)) }}</li>
                                                        <li>{{ date('h:i:s a', strtotime($order->updated_at)) }}</li>
                                                    </ul>
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
