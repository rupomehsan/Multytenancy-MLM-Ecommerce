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

@section('header_css')
    <style>
        .pagination {
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.customer_panel.pages.home.delivery.mobile_menu_offcanvus')
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
                    @include('tenant.frontend.pages.customer_panel.pages.home.delivery.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="dashboard-my-order mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">My orders</h5>
                            <div class="dashboard-head-widget-select">
                                <span>Sort by:</span>
                                <form action="{{ url('my/delivery/orders') }}" method="GET">
                                    <select aria-label="Show All Orders" class="form-select" name="order_status"
                                        onchange='this.form.submit()'>
                                        <option value="">Show All Orders</option>
                                        <option value="pending" @if (isset($order_status) && $order_status == 'pending') selected @endif>
                                            Pending</option>
                                        <option value="accepted" @if (isset($order_status) && $order_status == 'accepted') selected @endif>
                                            Accepted</option>
                                        {{-- <option value="rejected" @if (isset($order_status) && $order_status == 'rejected') selected @endif>
                                            Rejected</option> --}}
                                        <option value="delivered" @if (isset($order_status) && $order_status == 'delivered') selected @endif>
                                            Delivered</option>
                                        <option value="returned" @if (isset($order_status) && $order_status == 'returned') selected @endif>
                                            Returned</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="dashboard-my-order-table">
                            <div class="table-responsive">
                                <table class="recent-order-table-data table">
                                    <tbody>
                                        @if (count($orders) > 0)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <img alt=""
                                                            src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-1.svg"
                                                            style="height: 30px; width: 30px" />
                                                        <span class="product-name" style="margin-left: 0px">
                                                            Order No #{{ $order->order_no }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ date('jS M, Y h:i A', strtotime($order->order_date)) }}
                                                    </td>

                                                    <td>
                                                        @if ($order->status == 'pending')
                                                            <span class="alert alert-warning"
                                                                style="padding: 2px 10px !important;">Pending</span>
                                                        @elseif($order->status == 'accepted')
                                                            <span class="alert alert-info"
                                                                style="padding: 2px 10px !important;">Accepted</span>
                                                        @elseif($order->status == 'rejected')
                                                            <span class="alert alert-danger"
                                                                style="padding: 2px 10px !important;">Rejected</span>
                                                        @elseif($order->status == 'delivered')
                                                            <span class="alert alert-success"
                                                                style="padding: 2px 10px !important;">Delivered</span>
                                                        @elseif($order->status == 'returned')
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
                                                            {{ DB::table('order_details')->where('order_id', $order->id)->sum('qty') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        Amount:<span
                                                            class="product-price">{{ number_format($order->total) }}
                                                            BDT</span>
                                                    </td>
                                                    <td>
                                                        <a class="view-order-btn"
                                                            href="{{ url('order/details') }}/{{ $order->slug }}">View
                                                            order</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center"
                                                    style="padding: 10px 0px; background: transparent;">
                                                    <span class="product-price" style="font-size: 20px;">No Orders
                                                        Found</span>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="dashboard-my-order-bottom">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
