@extends('tenant.frontend.layouts.app')

@php
    use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
@endphp

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <style>
        .pagination {
            justify-content: center;
            align-items: center;
        }

        .recent-order-table-data thead {
            background: #f8f9fa;
        }

        .recent-order-table-data thead th {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            padding: 12px 15px;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }

        .recent-order-table-data tbody td {
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
        }

        .order-status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d1ecf1; color: #0c5460; }
        .status-dispatch { background: #cce5ff; color: #004085; }
        .status-intransit { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-return { background: #e2e3e5; color: #383d41; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .payment-paid { background: #d4edda; color: #155724; }
        .payment-unpaid { background: #fff3cd; color: #856404; }
        .payment-failed { background: #f8d7da; color: #721c24; }

        .view-order-btn {
            display: inline-block;
            padding: 8px 20px;
            background: #28a745;
            color: #ffffff !important;
            border-radius: 5px;
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .view-order-btn:hover {
            background: #218838;
            color: #ffffff !important;
            text-decoration: none !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .view-order-btn i {
            margin-right: 5px;
        }

        .voucher-btn {
            display: inline-block;
            padding: 8px 20px;
            background: #667eea;
            color: #ffffff !important;
            border-radius: 5px;
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .voucher-btn:hover {
            background: #5568d3;
            color: #ffffff !important;
            text-decoration: none !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        .voucher-btn i {
            margin-right: 5px;
        }

        .order-number {
            font-weight: 600;
            color: #333;
        }

        .order-icon {
            width: 35px;
            height: 35px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .dashboard-my-order-table .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .recent-order-table-data {
                font-size: 12px;
            }
            
            .recent-order-table-data thead th,
            .recent-order-table-data tbody td {
                padding: 10px 8px;
            }

            .order-icon {
                width: 25px;
                height: 25px;
            }
        }
        /* Mobile: convert order table rows into stacked cards */
        @media (max-width: 767px) {
            .recent-order-table-data thead {
                display: none;
            }

            .recent-order-table-data tbody tr {
                display: block;
                border: 1px solid #eee;
                border-radius: 8px;
                margin-bottom: 12px;
                padding: 10px;
                background: #fff;
            }

            .recent-order-table-data tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 6px;
                font-size: 13px;
                white-space: normal;
                border: none;
            }

            .recent-order-table-data tbody td:nth-child(1)::before { content: "Order"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(2)::before { content: "Date"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(3)::before { content: "Status"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(4)::before { content: "Payment"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(5)::before { content: "Qty"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(6)::before { content: "Total"; font-weight:600; margin-right:8px; }
            .recent-order-table-data tbody td:nth-child(7)::before { content: "Actions"; font-weight:600; margin-right:8px; }

            .recent-order-table-data tbody td::before {
                display: inline-block;
                color: #6c757d;
                width: 90px;
                flex: 0 0 90px;
                text-align: left;
            }

            .recent-order-table-data tbody td .order-number,
            .recent-order-table-data tbody td .order-status-badge,
            .recent-order-table-data tbody td .view-order-btn {
                margin-left: 8px;
            }

            .recent-order-table-data tbody td:last-child {
                justify-content: flex-end;
            }
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
        <link rel="icon" href="{{ $generalInfo->fav_icon }}" type="image/x-icon" />
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
                    <div class="dashboard-my-order mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.my_orders') }}</h5>
                            <div class="dashboard-head-widget-select">
                                <span>{{ __('customer.filter') }}:</span>
                                <form action="{{ url('my/orders') }}" method="GET">
                                    <select aria-label="Show All Orders" class="form-select" name="order_status"
                                        onchange='this.form.submit()'>
                                        <option value="">{{ __('customer.total_orders') }}</option>
                                        <option value="{{ Order::STATUS_PENDING }}" @if (isset($order_status) && $order_status == Order::STATUS_PENDING) selected @endif>{{ __('customer.pending') }}</option>
                                        <option value="{{ Order::STATUS_APPROVED }}" @if (isset($order_status) && $order_status == Order::STATUS_APPROVED) selected @endif>{{ __('customer.approved') }}</option>
                                        <option value="{{ Order::STATUS_DISPATCH }}" @if (isset($order_status) && $order_status == Order::STATUS_DISPATCH) selected @endif>{{ __('customer.processing') }}</option>
                                        <option value="{{ Order::STATUS_INTRANSIT }}" @if (isset($order_status) && $order_status == Order::STATUS_INTRANSIT) selected @endif>{{ __('customer.on_delivery') }}</option>
                                        <option value="{{ Order::STATUS_CANCELLED }}" @if (isset($order_status) && $order_status == Order::STATUS_CANCELLED) selected @endif>{{ __('customer.cancelled') }}</option>
                                        <option value="{{ Order::STATUS_DELIVERED }}" @if (isset($order_status) && $order_status == Order::STATUS_DELIVERED) selected @endif>{{ __('customer.delivered') }}</option>
                                        <option value="{{ Order::STATUS_RETURN }}" @if (isset($order_status) && $order_status == Order::STATUS_RETURN) selected @endif>{{ __('customer.refunded') }}</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="dashboard-my-order-table">
                            <div class="table-responsive">
                                <table class="recent-order-table-data table text-center ">
                                    <thead>
                                        <tr>
                                            <th>{{ __('customer.order_number') }}</th>
                                            <th>{{ __('customer.date') }}</th>
                                            <th>{{ __('customer.order_status') }}</th>
                                            <th>{{ __('customer.payment_status') }}</th>
                                            <th>{{ __('customer.quantity') }}</th>
                                            <th>{{ __('customer.total') }}</th>
                                            <th>{{ __('customer.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>
                                                    <img class="order-icon" alt="Order"
                                                        src="{{ url('tenant/frontend') }}/assets/images/dashboard-data-card-images/icon-1.svg" />
                                                    <span class="order-number">#{{ $order->order_no }}</span>
                                                </td>
                                                <td>{{ date('d M, Y', strtotime($order->order_date)) }}<br>
                                                    <small class="text-muted">{{ date('h:i A', strtotime($order->order_date)) }}</small>
                                                </td>
                                                <td>
                                                    @php
                                                        $statusClasses = [
                                                            Order::STATUS_PENDING => 'status-pending',
                                                            Order::STATUS_APPROVED => 'status-approved',
                                                            Order::STATUS_DISPATCH => 'status-dispatch',
                                                            Order::STATUS_INTRANSIT => 'status-intransit',
                                                            Order::STATUS_CANCELLED => 'status-cancelled',
                                                            Order::STATUS_DELIVERED => 'status-delivered',
                                                            Order::STATUS_RETURN => 'status-return',
                                                        ];
                                                        
                                                        $statusLabels = [
                                                            Order::STATUS_PENDING => __('customer.pending'),
                                                            Order::STATUS_APPROVED => __('customer.approved'),
                                                            Order::STATUS_DISPATCH => __('customer.processing'),
                                                            Order::STATUS_INTRANSIT => __('customer.on_delivery'),
                                                            Order::STATUS_CANCELLED => __('customer.cancelled'),
                                                            Order::STATUS_DELIVERED => __('customer.delivered'),
                                                            Order::STATUS_RETURN => __('customer.refunded'),
                                                        ];
                                                    @endphp
                                                    <span class="order-status-badge {{ $statusClasses[$order->order_status] ?? 'status-pending' }}">
                                                        {{ $statusLabels[$order->order_status] ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        // Determine payment status
                                                        if ($order->payment_method == Order::PAYMENT_COD) {
                                                            // For COD, check if delivered
                                                            if ($order->order_status == Order::STATUS_DELIVERED) {
                                                                $paymentClass = 'payment-paid';
                                                                $paymentLabel = __('customer.paid');
                                                            } else {
                                                                $paymentClass = 'payment-unpaid';
                                                                $paymentLabel = __('customer.unpaid');
                                                            }
                                                        } else {
                                                            // For other payment methods
                                                            if ($order->payment_status == Order::PAYMENT_STATUS_PAID) {
                                                                $paymentClass = 'payment-paid';
                                                                $paymentLabel = __('customer.paid');
                                                            } elseif ($order->payment_status == Order::PAYMENT_STATUS_FAILED) {
                                                                $paymentClass = 'payment-failed';
                                                                $paymentLabel = __('customer.payment_failed');
                                                            } else {
                                                                $paymentClass = 'payment-unpaid';
                                                                $paymentLabel = __('customer.unpaid');
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="order-status-badge {{ $paymentClass }}">
                                                        {{ $paymentLabel }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ DB::table('order_details')->where('order_id', $order->id)->sum('qty') }}</strong> {{ __('customer.cart_items') }}
                                                </td>
                                                <td>
                                                    <strong style="color: #28a745;">{{ number_format($order->total) }} BDT</strong>
                                                </td>
                                                <td>
                                                    <a class="view-order-btn" href="{{ url('order/details') }}/{{ $order->slug }}">
                                                        <i class="fi-rr-eye"></i> {{ __('customer.view') }}
                                                    </a>
                                                   
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center" style="padding: 50px 20px;">
                                                    <img src="{{ url('tenant/frontend') }}/assets/images/empty-cart.svg" alt="No Orders" 
                                                         style="max-width: 150px; opacity: 0.5; margin-bottom: 20px;">
                                                    <h5 style="color: #999;">{{ __('customer.no_orders') }}</h5>
                                                    <p style="color: #999;">{{ __('customer.no_orders_message') }}</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($orders->hasPages())
                                <div class="dashboard-my-order-bottom">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
