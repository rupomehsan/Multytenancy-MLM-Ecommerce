@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <style>
        .pagination {
            justify-content: center;
            align-items: center;
        }

        /* Responsive payment cards */
        @media (max-width: 768px) {
            .payment-card-group {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .payment-single-card {
                padding: 16px !important;
            }

            .payment-card-info h4 {
                font-size: 18px !important;
            }

            .payment-card-info p {
                font-size: 12px !important;
            }

            /* Make table responsive - convert to cards on mobile */
            .table-responsive {
                overflow-x: visible;
            }

            .payment-history-table-data thead {
                display: none;
            }

            .payment-history-table-data tbody tr {
                display: block;
                margin-bottom: 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                background: white;
            }

            .payment-history-table-data tbody td {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #f1f5f9;
                text-align: right;
            }

            .payment-history-table-data tbody td:last-child {
                border-bottom: none;
            }

            .payment-history-table-data tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                flex: 1;
            }
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
                            <h5 class="dashboard-head-widget-title">{{ __('customer.my_payments') }}</h5>
                        </div>
                        <div class="payment-card-group">
                            <div class="payment-single-card card-1">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-1.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($currentMonthSpent) }} BDT</h4>
                                    <p>{{ __('customer.this_month_spent') }}</p>
                                </div>
                            </div>

                            <div class="payment-single-card card-2">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-3.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($lastSixMonthSpent) }} BDT</h4>
                                    <p>{{ __('customer.last_6_month_spent') }}</p>
                                </div>
                            </div>

                            <div class="payment-single-card card-3">
                                <div class="payment-card-icon">
                                    <img alt=""
                                        src="{{ url('tenant/frontend') }}/assets/images/payment/card-icon-2.svg">
                                </div>
                                <div class="payment-card-info">
                                    <h4>{{ number_format($totalSpent) }} BDT</h4>
                                    <p>{{ __('customer.total_spent') }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="payment-history">
                            <div class="payment-history-head">
                                <h4 class="payment-history-head-title">{{ __('customer.payments_history') }}</h4>
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
                                            <th>{{ __('customer.date_time') }}</th>
                                            <th>{{ __('customer.txn_id') }}</th>
                                            <th>{{ __('customer.method') }}</th>
                                            <th>{{ __('customer.amount') }}</th>
                                            <th>{{ __('customer.status') }}</th>
                                            <th>{{ __('customer.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($orders) > 0)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td data-label="{{ __('customer.date_time') }}">{{ date('jS M, Y h:i A', strtotime($order->order_date)) }}</td>
                                                    <td data-label="{{ __('customer.txn_id') }}">{{ $order->trx_id }}</td>
                                                    <td data-label="{{ __('customer.method') }}">
                                                        @if ($order->payment_method == 1)
                                                            <strong>{{ __('customer.cash_on_delivery') }}</strong>
                                                        @endif
                                                        @if ($order->payment_method == 2)
                                                            <strong>bKash</strong>
                                                        @endif
                                                        @if ($order->payment_method == 3)
                                                            <strong>Nagad</strong>
                                                        @endif
                                                    </td>
                                                    <td data-label="{{ __('customer.amount') }}">{{ number_format($order->total) }} BDT</td>
                                                    <td data-label="{{ __('customer.status') }}" class="order-details-info-order-id-parent">
                                                        @if ($order->payment_status == 0)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--warning-color) !important;">{{ __('customer.unpaid') }}
                                                            </div>
                                                        @elseif($order->payment_status == 1)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--success-color) !important;">{{ __('customer.success') }}
                                                            </div>
                                                        @elseif($order->payment_status == 2)
                                                            <div class="order-details-info-status"
                                                                style="background: var(--alert-color) !important;">{{ __('customer.failed') }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td data-label="{{ __('customer.action') }}">
                                                        <a class="view-order-btn"
                                                            href="{{ url('order/details') }}/{{ $order->slug }}">{{ __('customer.view_order') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center"
                                                    style="padding: 10px; font-weight: 600; color: gray;">{{ __('customer.no_payment_record') }}</td>
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
