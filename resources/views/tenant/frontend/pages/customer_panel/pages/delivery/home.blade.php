@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/user-pannel.css" />
@endsection

@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}
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
                    <div class="getcom-user-sidebar">
                        <div class="user-sidebar-head">
                            <div class="user-sidebar-profile">
                                @if (Auth::user()->image)
                                    <img alt="" src="{{ env('ADMIN_URL') . '/' . Auth::user()->image }}" />
                                @endif
                            </div>
                            <div class="user-sidebar-profile-info">
                                <h5>{{ Auth::user()->name }}</h5>
                                <p>{{ Auth::user()->email }}</p>
                                <p>{{ Auth::user()->phone }}</p>
                                <div class="user-sidebar-profile-btn">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="fi-rr-sign-out-alt"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                        <div class="user-sidebar-menus">
                            <ul class="user-sidebar-menu-list">
                                <li>
                                    <a class="{{ Request::path() == 'home' ? 'active' : '' }}"
                                        href="{{ url('/home') }}"><i class="fi-ss-apps"></i>Dashboard</a>
                                </li>
                                <li>
                                    <a class="{{ Request::path() == 'my/delivery/orders' || str_contains(Request::path(), 'order/details') || str_contains(Request::path(), 'track/my/order') ? 'active' : '' }}"
                                        href="{{ url('/my/delivery/orders') }}"><i class="fi-ss-shopping-cart"></i>My
                                        orders</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="dasboard-data-card mgTop24">
                        <div class="single-data-card card-1">
                            <div class="data-card-info">
                                <h3>{{ $totalPendingOrders }}</h3>
                                <p>Pending Orders</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-1.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-2">
                            <div class="data-card-info">
                                <h3>{{ $totalProcessingOrders }}</h3>
                                <p>Processing Orders</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-2.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-3">
                            <div class="data-card-info">
                                <h3>{{ $totalReturnedOrders }}</h3>
                                <p>Returned Orders</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-3.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-4">
                            <div class="data-card-info">
                                <h3>{{ $totalDeliveredOrders }}</h3>
                                <p>Delivered Orders</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-4.svg" />
                            </div>
                        </div>

                    </div>
                    <div class="recent-order-table-area">
                        <div class="dashboard-head-widget">
                            <h5 class="dashboard-head-widget-title">Pending orders</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn" href="{{ url('my/delivery/orders') }}">View more</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="recent-order-table-data table">
                                <tbody>

                                    @if (count($orders) > 0)
                                        @foreach ($orders as $recentOrder)
                                            <tr>
                                                <td>
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-1.svg"
                                                        style="height: 30px; width: 30px" />
                                                    <span class="product-name" style="margin-left: 0px">
                                                        Order No #{{ $recentOrder->order_no }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ date('jS M, Y h:i A', strtotime($recentOrder->order_date)) }}
                                                </td>
                                                <td>
                                                    @if ($recentOrder->status == 'pending')
                                                        <span class="alert alert-warning"
                                                            style="padding: 2px 10px !important;">Pending</span>
                                                    @elseif($recentOrder->status == 'accepted')
                                                        <span class="alert alert-info"
                                                            style="padding: 2px 10px !important;">Accepted</span>
                                                    @elseif($recentOrder->status == 'rejected')
                                                        <span class="alert alert-danger"
                                                            style="padding: 2px 10px !important;">Rejected</span>
                                                    @elseif($recentOrder->status == 'delivered')
                                                        <span class="alert alert-success"
                                                            style="padding: 2px 10px !important;">Delivered</span>
                                                    @elseif($recentOrder->status == 'returned')
                                                        <span class="alert alert-dark"
                                                            style="padding: 2px 10px !important;">Returned</span>
                                                    @else
                                                        <span class="alert alert-secondary"
                                                            style="padding: 2px 10px !important;">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    Qty:
                                                    <span class="product-quantity">
                                                        {{ DB::table('order_details')->where('order_id', $recentOrder->id)->sum('qty') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    Amount:<span
                                                        class="product-price">{{ number_format($recentOrder->total) }}
                                                        BDT</span>
                                                </td>
                                                <td>
                                                    <a class="view-order-btn"
                                                        href="{{ url('order/details') }}/{{ $recentOrder->slug }}">View
                                                        order</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="product-price" style="font-size: 18px;">No Order Found</span>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
