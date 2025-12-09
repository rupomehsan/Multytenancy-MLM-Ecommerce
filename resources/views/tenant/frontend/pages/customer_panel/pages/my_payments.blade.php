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

                    <div class="dashboard-payment mgTop24">
                        <div class="dashboard-head-widget style-2" style="margin: 0px">
                            <h5 class="dashboard-head-widget-title">Payments</h5>
                        </div>
                        <div class="payment-card-group">
                            <div class="payment-single-card card-1">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-1.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($currentMonthSpent) }} BDT</h4>
                                    <p>This month spent</p>
                                </div>
                            </div>

                            <div class="payment-single-card card-2">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-3.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($lastSixMonthSpent) }} BDT</h4>
                                    <p>Last 6 month spent</p>
                                </div>
                            </div>

                            <div class="payment-single-card card-3">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-2.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($totalSpent) }} BDT</h4>
                                    <p>Total spent</p>
                                </div>
                            </div>

                        </div>
                        <div class="payment-history">
                            <div class="payment-history-head">
                                <h4 class="payment-history-head-title">Payments history</h4>
                                {{-- <div class="payment-history-head-select">
                                    <span>Sort by:</span><select aria-label="This month, Aug 2023" class="form-select"
                                        style="display: none;">
                                        <option>This month, Aug 2023</option>
                                        <option value="1">This month, Aug 2023</option>
                                        <option value="2">This month, Aug 2023</option>
                                        <option value="3">This month, Aug 2023</option>
                                    </select>
                                    <div class="nice-select form-select" tabindex="0"><span class="current">This month,
                                            Aug 2023</span>
                                        <ul class="list">
                                            <li data-value="This month, Aug 2023" class="option selected">This month, Aug
                                                2023</li>
                                            <li data-value="1" class="option">This month, Aug 2023</li>
                                            <li data-value="2" class="option">This month, Aug 2023</li>
                                            <li data-value="3" class="option">This month, Aug 2023</li>
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="payment-history-table-data table">
                                    <thead>
                                        <tr>
                                            <th>Date &amp; time</th>
                                            <th>TXN id</th>
                                            <th>Method</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($orders) > 0)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ date('jS M, Y h:i A', strtotime($order->order_date)) }}</td>
                                                    <td>{{ $order->trx_id }}</td>
                                                    <td>
                                                        @if ($order->payment_method == 1)
                                                            <strong>Cash On Delivery</strong>
                                                        @endif
                                                        @if ($order->payment_method == 2)
                                                            <strong>bKash</strong>
                                                        @endif
                                                        @if ($order->payment_method == 3)
                                                            <strong>Nagad</strong>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($order->total) }} BDT</td>
                                                    <td class="order-details-info-order-id-parent">
                                                        @if ($order->payment_status == 0)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--warning-color) !important;">Unpaid
                                                            </div>
                                                        @elseif($order->payment_status == 1)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--success-color) !important;">Success
                                                            </div>
                                                        @elseif($order->payment_status == 2)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--alert-color) !important;">Failed
                                                            </div>
                                                        @endif
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
                                                <td colspan="5" class="text-center"
                                                    style="padding: 10px; font-weight: 600; color: gray;">No Payment Record
                                                    Found</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-area">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
