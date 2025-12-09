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
                    <div class="dashboard-my-order mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">My orders</h5>
                            <div class="dashboard-head-widget-select">
                                <span>Sort by:</span>
                                <form action="{{ url('my/orders') }}" method="GET">
                                    <select aria-label="Show All Orders" class="form-select" name="order_status"
                                        onchange='this.form.submit()'>
                                        <option value="">Show All Orders</option>
                                        <option value="0" @if (isset($order_status) && $order_status == 0) selected @endif>Pending
                                        </option>
                                        <option value="1" @if (isset($order_status) && $order_status == 1) selected @endif>Approved
                                        </option>
                                        <option value="2" @if (isset($order_status) && $order_status == 2) selected @endif>Dispatch
                                        </option>
                                        <option value="3" @if (isset($order_status) && $order_status == 3) selected @endif>Intransit
                                        </option>
                                        <option value="4" @if (isset($order_status) && $order_status == 4) selected @endif>Delivered
                                        </option>
                                        <option value="5" @if (isset($order_status) && $order_status == 5) selected @endif>Return
                                        </option>
                                        <option value="6" @if (isset($order_status) && $order_status == 6) selected @endif>Cancelled
                                        </option>
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
                                                        @if ($order->order_status == 0)
                                                            <span class="alert alert-warning"
                                                                style="padding: 2px 10px !important;">Pending</span>
                                                        @elseif($order->order_status == 1)
                                                            <span class="alert alert-info"
                                                                style="padding: 2px 10px !important;">Approved</span>
                                                        @elseif($order->order_status == 2)
                                                            <span class="alert alert-primary"
                                                                style="padding: 2px 10px !important;">Dispatch</span>
                                                        @elseif($order->order_status == 3)
                                                            <span class="alert alert-secondary"
                                                                style="padding: 2px 10px !important;">Intransit</span>
                                                        @elseif($order->order_status == 4)
                                                            <span class="alert alert-success"
                                                                style="padding: 2px 10px !important;">Delivered</span>
                                                        @elseif($order->order_status == 5)
                                                            <span class="alert alert-dark"
                                                                style="padding: 2px 10px !important;">Return</span>
                                                        @else
                                                            <span class="alert alert-danger"
                                                                style="padding: 2px 10px !important;">Cancelled</span>
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
