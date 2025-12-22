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

        .order-d-info-single-card-data-list li span {
            width: 20%;
        }

        .order-actions-buttons .theme-btn {
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, opacity 0.2s;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .order-actions-buttons .theme-btn:hover:not(:disabled) {
            filter: brightness(1.1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.13);
            color: #fff;
            opacity: 1;
        }

        .order-actions-buttons .theme-btn:disabled,
        .order-actions-buttons .theme-btn[disabled] {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            background: #bdbdbd !important;
            color: #fff !important;
            box-shadow: none;
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

                    <div class="order-details-area mgTop24">
                        <div class="order-details-inner">
                            <div class="dashboard-head-widget style-2">
                                <h5 class="dashboard-head-widget-title">Order details</h5>
                                <div class="dashboard-head-widget-btn">
                                    <a class="theme-btn secondary-btn icon-right" href="{{ url('my/delivery/orders') }}"><i
                                            class="fi-rr-arrow-left"></i>Back to orders</a>
                                </div>
                            </div>
                            <div class="order-details-inner">
                                <div class="order-details-information">
                                    <div class="order-details-info-head">
                                        <div class="order-details-info-order-id">
                                            <h4 class="order-details-info-order-id-parent">
                                                Order NO <span>#{{ $order->order_no }}</span>
                                                @if ($order->status == 'pending')
                                                    <div class="order-details-info-status"
                                                        style="background: var(--warning-color) !important;">pending</div>
                                                @elseif($order->status == 'accepted')
                                                    <div class="order-details-info-status"
                                                        style="background: var(--primary-color) !important;">Accepted</div>
                                                @elseif($order->order_status == 'rejected')
                                                    <div class="order-details-info-status"
                                                        style="background: var(--hints-color) !important;">Rejected</div>
                                                @elseif($order->status == 'delivered')
                                                    <div class="order-details-info-status"
                                                        style="background: var(--success-color) !important;">Delivered</div>
                                                @elseif($order->status == 'returned')
                                                    <div class="order-details-info-status"
                                                        style="background: var(--success-color) !important;">Returned</div>
                                                @else
                                                    <div class="order-details-info-status"
                                                        style="background: var(--alert-color) !important;">Cancelled</div>
                                                @endif

                                            </h4>
                                            <ul class="order-details-info-date-time">
                                                <li>{{ date('F d, Y', strtotime($order->order_date)) }}</li>
                                                <li>{{ date('h:i A', strtotime($order->order_date)) }}</li>
                                            </ul>
                                        </div>
                                        <div class="order-details-info-head-button">
                                            {{-- <a class="theme-btn secondary-btn icon-right" href="#">
                                                <i class="fi-rs-cloud-download"></i>
                                                Download invoice
                                            </a>
                                            <a class="theme-btn icon-right" href="#">
                                                <i class="fi fi-rr-shopping-cart-add"></i>
                                                Re-order products
                                            </a> --}}
                                        </div>
                                    </div>
                                    <div class="order-details-info-card-group">
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/user.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Personal information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Name</span><strong>{{ $order->username }}</strong>
                                                </li>
                                                <li>
                                                    <span>Email</span><strong>{{ $order->user_email }}</strong>
                                                </li>
                                                <li>
                                                    <span>Phone</span><strong>{{ $order->phone }}</strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/shipping-box.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Shipping information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li><span>Address</span><strong>{{ $order->shipping_address }}</strong>
                                                </li>
                                                <li><span>District</span><strong>{{ $order->shipping_city }}
                                                        @if ($order->shipping_post_code)
                                                            -
                                                            {{ $order->shipping_post_code }}
                                                        @endif
                                                    </strong>
                                                </li>
                                                <li><span>Thana</span><strong>{{ $order->shipping_thana }}</strong></li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/track.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Delivery information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Address</span>
                                                    <strong>
                                                        {{ $order->shipping_address }}, {{ $order->shipping_city }}
                                                        @if ($order->shipping_post_code)
                                                            -
                                                            {{ $order->shipping_post_code }}
                                                        @endif, {{ $order->shipping_thana }}
                                                    </strong>
                                                </li>
                                                <li>
                                                    <span>Method</span>
                                                    <strong>
                                                        @if ($order->delivery_method == 1)
                                                            COD (Cash on delivery)
                                                        @else
                                                            Store Pickup
                                                        @endif
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="#"
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/card-information.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Payment information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Status</span>
                                                    @if ($order->payment_method == 1)
                                                        {{-- if cash on delivery then check delivered or not --}}
                                                        @if ($order->order_status == 4)
                                                            <strong style="color: #34be82">Paid</strong>
                                                        @else
                                                            <strong style="color: var(--alert-color)">Unpaid</strong>
                                                        @endif
                                                    @else
                                                        @if ($order->payment_status == 1)
                                                            <strong style="color: #34be82">Paid</strong>
                                                        @else
                                                            <strong style="color: var(--alert-color)">Unpaid</strong>
                                                        @endif
                                                    @endif

                                                </li>
                                                <li>
                                                    <span>Method</span>
                                                    @if ($order->payment_method == 1)
                                                        <strong>Cash On Delivery</strong>
                                                    @endif
                                                    @if ($order->payment_method == 2)
                                                        <strong>bKash</strong>
                                                    @endif
                                                    @if ($order->payment_method == 3)
                                                        <strong>Nagad</strong>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span>TRXN ID</span>

                                                    @if ($order->payment_method == 1)
                                                        {{-- if cash on delivery then check delivered or not --}}
                                                        @if ($order->order_status == 3)
                                                            <strong>{{ $order->trx_id }}</strong>
                                                        @endif
                                                    @else
                                                        <strong>{{ $order->trx_id }}</strong>
                                                    @endif

                                                </li>
                                                <li>
                                                    <span>Date</span>

                                                    {{-- if cash on delivery then check delivered or not --}}
                                                    {{-- @if ($order->payment_method == 1)
                                                        @if ($order->order_status == 4)
                                                            @php
                                                                $orderProgressInfo = DB::table('order_progress')->where('order_id', $order->id)
                                                                ->where('order_status', 4)->first();
                                                            @endphp
                                                            @dd($orderProgressInfo)
                                                        
                                                            <strong>{{date("jS M, Y h:i A", strtotime($orderProgressInfo->created_at))}}</strong>
                                                        @endif
                                                    @else --}}
                                                    <strong>{{ date('jS M, Y h:i A', strtotime($order->order_date)) }}</strong>
                                                    {{-- @endif --}}

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/note.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Special Notes
                                                </h6>
                                            </div>
                                            <p class="order-d-info-single-card-text">
                                                {{ $order->order_note }}
                                            </p>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt=""
                                                        src="{{ url('tenant/frontend') }}/assets/images/icons/track.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Order Status Management
                                                </h6>
                                            </div>
                                            <div class="order-status-update-form">
                                                <form action="{{ url('delivery/update-order-status') }}" method="POST"
                                                    class="status-form">
                                                    @csrf
                                                    <input type="hidden" name="order_delivey_men_id"
                                                        value="{{ $order->id }}">
                                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">

                                                    <div class="form-group mb-3">
                                                        <label for="order_status"
                                                            class="form-label fw-semibold mb-2">Current Status</label>
                                                        <select name="order_status" id="order_status"
                                                            class="form-select status-select">
                                                            <option value="pending"
                                                                {{ $order->status == 'pending' ? 'selected' : '' }}
                                                                {{ $order->status != 'pending' ? 'disabled' : '' }}>
                                                                📋 Pending
                                                            </option>
                                                            <option value="accepted"
                                                                {{ $order->status == 'accepted' ? 'selected' : '' }}
                                                                {{ in_array($order->status, ['delivered', 'returned']) ? 'disabled' : '' }}>
                                                                ✅ Accepted
                                                            </option>
                                                            {{-- <option value="4" {{$order->order_status == '' ? 'selected' : ''}}>
                                                                ❌ Rejected
                                                            </option> --}}
                                                            @if ($order->status != 'pending')
                                                                @if ($order->status == 'delivered')
                                                                    <option value="delivered"
                                                                        {{ $order->status == 'delivered' ? 'selected' : '' }}
                                                                        {{ in_array($order->status, ['pending', 'accepted', 'returned']) ? 'disabled' : '' }}>
                                                                        🎉 Delivered
                                                                    </option>
                                                                @endif
                                                                @if ($order->status == 'returned')
                                                                    <option value="returned"
                                                                        {{ $order->status == 'returned' ? 'selected' : '' }}
                                                                        {{ in_array($order->status, ['pending', 'accepted', 'delivered']) ? 'disabled' : '' }}>
                                                                        ↩️ Returned
                                                                    </option>
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <button type="submit" class="theme-btn primary-btn btn-sm"
                                                            {{ $order->status != 'accepted' && !in_array($order->status, ['pending']) ? 'disabled' : '' }}
                                                            style="{{ $order->status != 'accepted' && !in_array($order->status, ['pending']) ? 'opacity: 0.6; cursor: not-allowed;' : '' }}">
                                                            Update Status
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="order-summary-head">
                                <h4 class="order-summary-head-title">
                                    <img alt="#"
                                        src="{{ url('tenant/frontend') }}/assets/images/icons/humberger.svg" />Order
                                    summary
                                </h4>
                            </div>
                            <div class="table-responsive">
                                <table class="recent-order-table-data order-summary-table-data table">
                                    <thead>
                                        <tr>
                                            <th>Product name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('/product/details') }}/{{ $item->product_slug }}"
                                                        target="_blank" class="d-block">
                                                        <img alt=""
                                                            src="{{ env('ADMIN_URL') . '/' . $item->product_image }}"
                                                            style="height: 30px; width: 30px; object-fit: contain;" />
                                                        <span class="product-name">{{ $item->name }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="product-price">{{ number_format($item->product_price) }}
                                                        BDT
                                                        @if ($item->unit_name)
                                                            / {{ $item->unit_name }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td><span class="product-quantity">{{ $item->qty }}</span></td>
                                                <td>
                                                    <span
                                                        class="product-total-price">{{ number_format($item->product_price * $item->qty) }}
                                                        BDT</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="order-summary-total" style="float: none">
                                    <ul class="order-summary-total-list">
                                        <li>Subtotal<strong>{{ number_format($order->sub_total) }} BDT</strong></li>
                                        <li>
                                            VAT/Tax<span>(0%)</span><strong>0 BDT</strong>
                                        </li>
                                        <li>
                                            Discount<strong>{{ number_format($order->discount) }} BDT</strong>
                                        </li>
                                        <li>
                                            Delivery Cost<strong>{{ number_format($order->delivery_fee) }} BDT</strong>
                                        </li>
                                        <li class="total-price">
                                            Total<strong>{{ number_format($order->total) }} BDT</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-actions-buttons mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <form action="{{ url('delivery/update-order-status') }}" method="POST"
                                    class="status-form">
                                    @csrf
                                    <input type="hidden" name="order_delivey_men_id" value="{{ $order->id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                    <input type="hidden" name="order_status" value="delivered">
                                    <button type="submit"
                                        class="w-100 theme-btn text-center d-flex justify-content-center"
                                        style="background: green; {{ $order->status != 'accepted' ? 'opacity: 0.6; cursor: not-allowed;' : '' }}"
                                        {{ $order->status != 'accepted' ? 'disabled' : '' }}>
                                        <i class="fi-rr-check-circle me-2"></i>
                                        🎉 Mark as Delivered
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 mb-3">
                                <form action="{{ url('delivery/update-order-status') }}" method="POST"
                                    class="status-form">
                                    @csrf
                                    <input type="hidden" name="order_delivey_men_id" value="{{ $order->id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                    <input type="hidden" name="order_status" value="returned">
                                    <button type="submit" class="w-100 theme-btn d-flex justify-content-center"
                                        style="background: #d43b15; {{ $order->status != 'accepted' ? 'opacity: 0.6; cursor: not-allowed;' : '' }}"
                                        {{ $order->status != 'accepted' ? 'disabled' : '' }}>
                                        <i class="fi-rr-undo me-2"></i>
                                        ↩️ Mark as Returned
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle all status forms
        document.querySelectorAll('.status-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                const orderStatus = this.querySelector('input[name="order_status"]') || this
                    .querySelector('select[name="order_status"]');

                // Skip confirmation for disabled buttons
                if (btn && btn.disabled) {
                    e.preventDefault();
                    return false;
                }

                // For dropdown form (status update), don't prevent - let it submit
                if (orderStatus && orderStatus.tagName === 'SELECT') {
                    return true;
                }

                // For quick action buttons, show confirmation
                e.preventDefault();

                let message = 'Are you sure you want to update the order status?';
                if (orderStatus && orderStatus.value === 'delivered') {
                    message = 'Are you sure you want to mark this order as delivered?';
                } else if (orderStatus && orderStatus.value === 'returned') {
                    message = 'Are you sure you want to mark this order as returned?';
                }

                if (confirm(message)) {
                    this.submit();
                }
            });
        });
    });
</script>
