@extends('tenant.frontend.layouts.app')

@php
    use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
@endphp

@section('header_css')
<link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
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
<link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
@endif
@endpush

@section('header_css')
<style>
    .order-d-info-single-card-data-list li span {
        width: 20%;
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

                <div class="order-details-area mgTop24">
                    <div class="order-details-inner">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.order_details') }}</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{ url('my/orders') }}"><i
                                        class="fi-rr-arrow-left"></i>{{ __('customer.back_to_orders') }}</a>
                            </div>
                        </div>
                        <div class="order-details-inner">
                            <div class="order-details-information">
                                <div class="order-details-info-head">
                                    <div class="order-details-info-order-id">
                                        <h4 class="order-details-info-order-id-parent">
                                            <span> Order NO- {{ $order->order_no }} : Order Status-</span>

                                            @php
                                                $statusBadges = [
                                                    Order::STATUS_PENDING => '<span style="color: #ffc107; font-weight: 600;">' . __('customer.pending') . '</span>',
                                                    Order::STATUS_APPROVED => '<span style="color: #17a2b8; font-weight: 600;">' . __('customer.approved') . '</span>',
                                                    Order::STATUS_DISPATCH => '<span style="color: #007bff; font-weight: 600;">' . __('customer.dispatch') . '</span>',
                                                    Order::STATUS_INTRANSIT => '<span style="color: #17a2b8; font-weight: 600;">' . __('customer.intransit') . '</span>',
                                                    Order::STATUS_DELIVERED => '<span style="color: #28a745; font-weight: 600;">' . __('customer.delivered') . '</span>',
                                                    Order::STATUS_RETURN => '<span style="color: #6c757d; font-weight: 600;">' . __('customer.return') . '</span>',
                                                    Order::STATUS_CANCELLED => '<span style="color: #dc3545; font-weight: 600;">' . __('customer.cancelled') . '</span>',
                                                ];
                                            @endphp
                                            {!! $statusBadges[$order->order_status] ?? '<span style="color: #6c757d; font-weight: 600;">' . __('customer.unknown') . '</span>' !!}

                                        </h4>
                                        <ul class="order-details-info-date-time">
                                            <li>{{ date('F d, Y', strtotime($order->order_date)) }}</li>
                                            <li>{{ date('h:i A', strtotime($order->order_date)) }}</li>
                                        </ul>
                                    </div>
                                    <div class="order-details-info-head-button">
                                        <a class="theme-btn secondary-btn icon-right" href="{{ url('order/voucher/' . $order->slug) }}" target="_blank">
                                            <i class="fi-rs-receipt"></i>
                                            {{ __('customer.view_invoice') }}
                                        </a>
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
                                                {{ __('customer.personal_information') }}
                                            </h6>
                                        </div>
                                        <ul class="order-d-info-single-card-data-list">
                                            <li>
                                                <span>{{ __('customer.name') }}</span><strong>{{ $order->username }}</strong>
                                            </li>
                                            <li>
                                                <span>{{ __('customer.email') }}</span><strong>{{ $order->user_email }}</strong>
                                            </li>
                                            <li>
                                                <span>{{ __('customer.phone') }}</span><strong>{{ $order->phone }}</strong>
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
                                                {{ __('customer.shipping_information') }}
                                            </h6>
                                        </div>
                                        <ul class="order-d-info-single-card-data-list">
                                            <li><span>{{ __('customer.address') }}</span><strong>{{ $order->shipping_address }}</strong>
                                            </li>
                                            <li><span>{{ __('customer.district') }}</span><strong>{{ $order->shipping_city }}
                                                  
                                                </strong>
                                            </li>
                                            <li><span>{{ __('customer.thana') }}</span><strong>{{ $order->shipping_thana }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="order-d-info-single-card">
                                        <div class="order-d-info-single-card-head">
                                            <div class="order-d-info-single-card-head-icon">
                                                <img alt=""
                                                    src="{{ url('tenant/frontend') }}/assets/images/icons/track.svg" />
                                            </div>
                                            <h6 class="order-d-info-single-card-title">
                                                {{ __('customer.delivery_information') }}
                                            </h6>
                                        </div>
                                        <ul class="order-d-info-single-card-data-list">
                                            <li>
                                                <span>{{ __('customer.address') }}</span>
                                                <strong>
                                                    {{ $order->shipping_address }},
                                                    {{ $order->shipping_thana }},
                                                    {{ $order->shipping_city }}
                                                    @if ($order->shipping_post_code)
                                                    , {{ $order->shipping_post_code }}
                                                    @endif
                                                </strong>
                                            </li>
                                            <li>
                                                <span>{{ __('customer.method') }}</span>
                                                <strong>
                                                    @if ($order->delivery_method == 1)
                                                    {{ __('customer.cod_cash_on_delivery') }}
                                                    @else
                                                    {{ __('customer.store_pickup') }}
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
                                                {{ __('customer.payment_information') }}
                                            </h6>
                                        </div>
                                        <ul class="order-d-info-single-card-data-list">
                                            <li>
                                                <span>{{ __('customer.status') }}</span>
                                                @if ($order->payment_method == Order::PAYMENT_COD)
                                                {{-- if cash on delivery then check delivered or not --}}
                                                @if ($order->order_status == Order::STATUS_INTRANSIT)
                                                <strong style="color: #34be82">{{ __('customer.paid') }}</strong>
                                                @else
                                                <strong style="color: var(--alert-color)">{{ __('customer.unpaid') }}</strong>
                                                @endif
                                                @else
                                                @if ($order->payment_status == Order::PAYMENT_STATUS_PAID)
                                                <strong style="color: #34be82">{{ __('customer.paid') }}</strong>
                                                @else
                                                <strong style="color: var(--alert-color)">{{ __('customer.unpaid') }}</strong>
                                                @endif
                                                @endif

                                            </li>

                                            <li>
                                                <span>{{ __('customer.method') }}</span>
                                                @if ($order->payment_method == Order::PAYMENT_COD)
                                                <strong>{{ __('customer.cash_on_delivery') }}</strong>
                                                @endif
                                                @if ($order->payment_method == Order::PAYMENT_BKASH)
                                                <strong>{{ __('customer.bkash') }}</strong>
                                                @endif
                                                @if ($order->payment_method == Order::PAYMENT_NAGAD)
                                                <strong>{{ __('customer.nagad') }}</strong>
                                                @endif
                                                @if ($order->payment_method == Order::PAYMENT_SSL_COMMERZ)
                                                <strong>{{ __('customer.sslcommerz') }}</strong>
                                                @endif
                                            </li>
                                            <!-- <li>
                                                <span>TRXN ID</span>

                                                @if ($order->payment_method == Order::PAYMENT_COD)
                                                {{-- if cash on delivery then check delivered or not --}}
                                                @if ($order->order_status == Order::STATUS_INTRANSIT)
                                                <strong>{{ $order->trx_id }}</strong>
                                                @endif
                                                @else
                                                <strong>{{ $order->trx_id }}</strong>
                                                @endif

                                            </li> -->
                                            <!-- <li>
                                                <span>Date</span>
                                                <strong>{{ date('jS M, Y h:i A', strtotime($order->order_date)) }}</strong>


                                            </li> -->
                                        </ul>
                                    </div>
                                    <div class="order-d-info-single-card">
                                        <div class="order-d-info-single-card-head">
                                            <div class="order-d-info-single-card-head-icon">
                                                <img alt=""
                                                    src="{{ url('tenant/frontend') }}/assets/images/icons/note.svg" />
                                            </div>
                                            <h6 class="order-d-info-single-card-title">
                                                {{ __('customer.special_notes') }}
                                            </h6>
                                        </div>
                                        <p class="order-d-info-single-card-text">
                                            {{ $order->order_note }}
                                        </p>
                                    </div>
                                    <div class="order-d-info-tracking-card">
                                        <div class="order-d-info-tracking-card-img">
                                            <img alt=""
                                                src="{{ url('tenant/frontend') }}/assets/images/track-image.svg" />
                                        </div>
                                        <div class="order-d-info-tracking-card-content">
                                            <h6>{{ __('customer.track_order_instantly') }}</h6>
                                            <a class="theme-btn"
                                                href="{{ url('track/my/order') }}/{{ $order->order_no }}">{{ __('customer.track_order') }}</a>
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
                                    src="{{ url('tenant/frontend') }}/assets/images/icons/humberger.svg" />{{ __('customer.order_summary') }}
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="recent-order-table-data order-summary-table-data table">
                                <thead>
                                    <tr>
                                        <th>{{ __('customer.product_name') }}</th>
                                        <th>{{ __('customer.variant') }}</th>
                                        <th>{{ __('customer.price') }}</th>
                                        <th>{{ __('customer.quantity') }}</th>
                                        <th>{{ __('customer.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $item)
                                    @php
                                        // Determine which image to display (variant image takes priority)
                                        $displayImage = $item->variant_image && !empty($item->variant_image) 
                                            ? $item->variant_image 
                                            : $item->product_image;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ url('/product/details') }}/{{ $item->product_slug }}"
                                                target="_blank" class="d-flex align-items-center" style="text-decoration: none;">
                                                <img alt="{{ $item->name }}"
                                                    src="{{ url($displayImage) }}"
                                                    style="height: 60px; width: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px; border: 1px solid #e0e0e0;" />
                                                <div>
                                                    <span class="product-name" style="color: #333; font-weight: 600; display: block;">{{ $item->name }}</span>
                                                    @if($item->product_code)
                                                        <small style="color: #999; font-size: 12px;">Code: {{ $item->product_code }}</small>
                                                    @endif
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            @if($item->color_name || $item->size_name)
                                                <div style="font-size: 14px;">
                                                    @if($item->color_name)
                                                        <span style="display: block; margin-bottom: 4px;">
                                                            <strong>{{ __('customer.color') }}:</strong> {{ $item->color_name }}
                                                        </span>
                                                    @endif
                                                    @if($item->size_name)
                                                        <span style="display: block;">
                                                            <strong>{{ __('customer.size') }}:</strong> {{ $item->size_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span style="color: #999;">—</span>
                                            @endif
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
                                    <li>{{ __('customer.subtotal') }}<strong>{{ number_format($order->sub_total) }} BDT</strong>
                                    </li>
                                    <li>
                                        {{ __('customer.vat_tax') }}<span>(0%)</span><strong>0 BDT</strong>
                                    </li>
                                    <li>
                                        {{ __('customer.discount') }}<strong>{{ number_format($order->discount) }} BDT</strong>
                                    </li>
                                    <li>
                                        {{ __('customer.delivery_cost') }}<strong>{{ number_format($order->delivery_fee) }}
                                            BDT</strong>
                                    </li>
                                    <li class="total-price">
                                        {{ __('customer.total') }}<strong>{{ number_format($order->total) }} BDT</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- @if ($order->payment_status !== Order::PAYMENT_STATUS_PAID && in_array($order->order_status, [Order::STATUS_PENDING, Order::STATUS_APPROVED, Order::STATUS_DISPATCH, Order::STATUS_INTRANSIT]))
                        <form action="{{ url('payment/confirm') }}" method="POST">
                            @csrf
                            <div class="single-details-checkout-widget">
                                <h5 class="checkout-widget-title">Payment Method</h5>
                                @php
                                    $paymentGateways = DB::table('payment_gateways')->get();
                                @endphp
                                <input type="text" name="order_id" value="{{ $order->id }}" hidden />
                                <div class="checkout-payment-method-inner single-details-box-inner">
                                    <div class="payment-method-input">

                                        <label for="flexRadioDefault1">
                                            <div class="payment-method-input-main">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    value="cod" id="flexRadioDefault1" required />
                                                Cash On Delivery (COD service)
                                            </div>
                                        </label>

                                        @if ($paymentGateways[0]->status == 1)
                                            <label for="flexRadioDefault2">
                                                <div class="payment-method-input-main">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        value="sslcommerz" id="flexRadioDefault2" required />
                                                    SSLCommerz
                                                </div>
                                                <img alt="SSLCommerz"
                                                    src="{{ url(env('ADMIN_URL') . '/images/ssl_commerz.png') }}"
                                                    style="max-width: 90px;" />
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="w-100 theme-btn d-flex justify-content-center">Confirm
                                    Payment</button>
                            </div>
                        </form>
                    @endif -->

                <div class="order-actions-buttons mt-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <form action="{{ url('cancle/order/' . $order->slug) }}" method="POST"
                                class="status-form">
                                @csrf
                                <input type="hidden" name="order_delivey_men_id" value="{{ $order->id }}">
                                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                <input type="hidden" name="order_status" value="cancelled">
                                <button type="submit" class="w-100 theme-btn d-flex justify-content-center"
                                    style="background: #dc3545; {{ $order->order_status != 0 ? 'opacity: 0.6; cursor: not-allowed;' : '' }}"
                                    {{ $order->order_status != 0 ? 'disabled' : '' }}>
                                    <i class="fi-rr-cross-circle me-2"></i>
                                    {{ __('customer.cancel_order') }}
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
        // Handle the cancel order form
        const cancelForm = document.querySelector('.order-actions-buttons .status-form');

        if (cancelForm) {
            cancelForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = this.querySelector('button[type="submit"]');

                // Skip confirmation for disabled buttons
                if (btn.disabled) {
                    return false;
                }

                if (confirm('{{ __('customer.confirm_cancel_order') }}')) {
                    this.submit();
                }
            });
        }
    });

</script>