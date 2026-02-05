@extends('tenant.frontend.layouts.app')

@push('site-seo')
{{-- using shared $generalInfo provided by AppServiceProvider --}}

<meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
<meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
<meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
<meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
<meta name="url" content="{{ env('APP_URL') }}">

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

<!-- Open Graph general (Facebook, Pinterest)-->
<meta property="og:title"
    content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
<meta property="og:type" content="Ecommerce" />
<meta property="og:url" content="{{ env('APP_URL') }}" />
<meta property="og:image" content="{{  $generalInfo->meta_og_image }}" />
<meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
<meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
<!-- End Open Graph general (Facebook, Pinterest)-->
@endpush


@section('header_css')
<style>
    /* Guest Order Tracking */
    .guest-order-tracking-area {
        margin-top: 40px;
    }

    .guest-order-tracking-hero {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 72px 0px;
    }

    .guest-order-tracking-hero-info {
        text-align: center;
    }

    .guest-order-tracking-hero-info h2 {
        font-size: 31px;
        margin-bottom: 24px;
    }

    .guest-order-tracking-hero-info .form-group input {
        width: 100%;
    }

    .guest-order-tracking-hero-info form input {
        width: 100%;
        height: 56px;
        border: 1px solid var(--primary-color);
        border-radius: 6px;
        padding-right: 124px;
        font-weight: 600;
        padding-left: 12px;
    }

    .guest-order-tracking-hero-info .form {
        position: relative;
    }

    .guest-order-tracking-hero-info form {
        position: relative;
    }

    .guest-order-tracking-hero-info form .theme-btn {
        position: absolute;
        right: 8px;
        top: 8px;
        padding: 8px 12px;
        border-radius: 4px;
    }



    .product-summary-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
        background: var(--white-color-2);
        border-bottom: 1px solid #0074e433;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

        /* Responsive adjustments for product summary head */
        @media only screen and (max-width: 767px) {
            .product-summary-head {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px;
            }

            .product-summary-head .order-summary-head-title {
                font-size: 16px;
                line-height: 1.2;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .product-summary-subtotal {
                width: 100%;
                text-align: right;
            }

            .product-summary-subtotal span {
                font-size: 16px;
                font-weight: 700;
            }
        }

    .product-summary-subtotal span {
        font-size: 20px;
        line-height: 150%;
        font-weight: 600;
    }

    .product-summary .order-summary-table-data.table tbody tr td {
        background: var(--white-color-3) !important;
    }

    .product-summary .recent-order-table-data.table tbody tr td:first-child {
        padding-left: 16px;
    }

    .product-summary .recent-order-table-data.table tbody tr td:last-child {
        padding-right: 16px;
    }

    .product-summary .recent-order-table-data.table img {
        width: 34px;
        height: 34px;
    }

    .product-summary .recent-order-table-data.table tbody tr td {
        font-size: 14px;
    }

    .product-summary.order-summary {
        background: var(--white-color-2);
    }

    .product-summary .order-summary-table-data.table tbody tr {
        border: 6px solid var(--white-color-2) !important;
        border-left: none !important;
        border-right: none !important;
    }

    .product-summary .table-responsive {
        padding-bottom: 0;
    }


    .order-tracking-card-group {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin-top: 32px;
        gap: 24px;
    }

    .single-order-tracking-card {
        position: relative;
        z-index: 2;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
    }

    .single-order-tracking-card::before {
        position: absolute;
        content: "";
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 16px;
    }

    .single-order-tracking-card.card-1::before {
        background-image: url('{{ url("frontend_assets/assets/images/order-tracking/card-bg-1.png") }}');
    }

    .single-order-tracking-card.card-2::before {
        background-image: url('{{ url("frontend_assets/assets/images/order-tracking/card-bg-2.png") }}');
    }

    .single-order-tracking-card.card-3::before {
        background-image: url('{{ url("frontend_assets/assets/images/order-tracking/card-bg-3.png") }}');
    }

    .order-tracking-card-icon img {
        width: 72px;
        height: 72px;
        object-fit: contain;
    }

    .order-tracking-card-icon {
        margin-bottom: 16px;
    }

    .order-tracking-card-info h6 {
        font-size: 20px;
        margin-bottom: 4px;
        font-weight: 700;
        line-height: 150%;
    }

    .order-tracking-card-info p {
        margin: 0;
        color: var(--hints-color);
        font-weight: 500;
        line-height: 150%;
    }


    .seperator-group {
        position: relative;
        display: flex;
        align-items: center;
        gap: 4px;
        justify-content: center;
    }

    .seperator {
        background: var(--primary-color);
        height: 4px;
        border-radius: 32px;
    }

    .seperator-1,
    .seperator-3 {
        width: 10px;
    }

    .seperator-2 {
        width: 30px;
    }

    @media only screen and (max-width: 767px) {
        .product-summary .order-summary-head-title {
            font-size: 14px;
            line-height: 120%;
        }

        .product-summary-subtotal span {
            font-size: 14px;
            display: block;
            line-height: 120%;
        }
    }

    /* Mobile responsiveness improvements for Track Order page */
    @media only screen and (max-width: 767px) {
        .guest-order-tracking-hero {
            padding: 28px 0px;
            background-position: center top;
        }

        .guest-order-tracking-hero-info {
            padding: 0 12px;
        }

        .guest-order-tracking-hero-info h2 {
            font-size: 20px;
            margin-bottom: 12px;
        }

        .guest-order-tracking-hero-info form input {
            height: 48px;
            padding-left: 12px;
            padding-right: 110px;
            font-size: 14px;
            font-weight: 600;
        }

        .guest-order-tracking-hero-info form .theme-btn {
            position: absolute;
            right: 8px;
            top: 6px;
            padding: 8px 10px;
            font-size: 14px;
        }

        .order-tracking-card-group {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .single-order-tracking-card {
            padding: 16px;
            border-radius: 12px;
            text-align: left;
        }

        .order-tracking-card-icon img {
            width: 56px;
            height: 56px;
        }

        .order-tracking-card-info h6 {
            font-size: 18px;
        }

        .order-tracking-card-info p {
            font-size: 13px;
        }

        .product-summary-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .product-summary-subtotal span {
            font-size: 16px;
        }

        .product-summary .recent-order-table-data.table img {
            width: 46px;
            height: 46px;
        }

        .order-status-card-group {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .single-order-status-card {
            padding: 16px;
        }

        .single-order-status-card::before,
        .single-order-status-card::after {
            display: none;
        }

        .seperator-group {
            gap: 6px;
        }
    }


    .order-status-area {
        margin-top: 40px;
    }

    .order-status-section-head {
        text-align: center;
    }

    .order-status-s-head-title {
        display: inline-block;
        margin: 0;
        font-weight: 700;
        font-size: 25px;
        margin-bottom: 12px;
    }

    .order-status-card-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0px 24px;
    }

    .single-order-status-card {
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px 52px 24px 24px;
        display: flex;
        gap: 12px;
        height: fit-content;
        position: relative;
    }

    .single-order-status-card::before,
    .single-order-status-card::after {
        position: absolute;
        content: "";
        width: 47px;
        height: 55px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    .single-order-status-card::before {
        right: -52px;
        top: 22px;
    }

    .single-order-status-card::after {
        left: -52px;
        bottom: 8px;
    }

    .single-order-status-card.card-1::before,
    .single-order-status-card.card-3::before {
        background-image: url('{{ url("frontend_assets/assets/images/order-tracking/arrow-1.svg") }}');
    }

    .single-order-status-card.card-2::after,
    .single-order-status-card.card-4::after {
        background-image: url('{{ url("frontend_assets/assets/images/order-tracking/arrow-2.svg") }}');
    }

    .single-order-status-card.card-1 {
        margin-top: 40px;
    }

    .single-order-status-card.card-2 {
        margin-top: 120px;
    }

    .single-order-status-card.card-4 {
        margin-top: 84px;
    }

    .order-status-card-icon,
    .order-status-card-icon-cross {
        width: 56px;
        height: 56px;
        background: linear-gradient(0deg, #0079ff 0%, #01a6ff 100%), #0074e4;
        border-radius: 100%;
        text-align: center;
        line-height: 62px;
        color: #fff;
        font-size: 24px;
        min-width: 56px;
    }

    .order-status-card-icon-cross {
        background: #ecf4f0;
        color: var(--primary-color);
        font-size: 18px;
    }

    .order-status-card-info h6 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--title-color);
        line-height: 150%;
    }

    .order-status-card-info p {
        color: var(--hints-color);
        font-weight: 500;
        font-size: 13px;
        margin: 0;
        line-height: 150%;
    }

    .order-status-card-info ul {
        line-height: 14px;
        margin-top: 8px;
    }

    .order-status-card-info ul li {
        display: inline-block;
        margin-right: 4px;
        font-size: 13px;
        line-height: 150%;
        font-weight: 500;
    }

    .order-status-card-info ul li:last-child {
        margin: 0;
    }
    /* Order timeline responsiveness */
    @media only screen and (max-width: 767px) {
        .order-status-area {
            margin-top: 20px;
            padding: 0 12px;
        }

        .order-status-section-head {
            text-align: center;
        }

        .order-status-card-group {
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 16px;
        }

        .single-order-status-card {
            padding: 12px;
            border-radius: 12px;
            display: flex;
            flex-direction: row;
            gap: 12px;
            align-items: center;
            padding-right: 16px;
        }

        .single-order-status-card::before,
        .single-order-status-card::after {
            display: none;
        }

        .single-order-status-card.card-1,
        .single-order-status-card.card-2,
        .single-order-status-card.card-3,
        .single-order-status-card.card-4,
        .single-order-status-card.card-5,
        .single-order-status-card.card-6,
        .single-order-status-card.card-7 {
            margin-top: 0 !important;
        }

        .order-status-card-icon,
        .order-status-card-icon-cross {
            width: 48px;
            height: 48px;
            line-height: 48px;
            font-size: 18px;
            min-width: 48px;
        }

        .order-status-card-info h6 {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .order-status-card-info p,
        .order-status-card-info ul li {
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')
<section class="getcom-user-body mb-5 pb-5">
    <!-- Guest Order Tracking Hero -->
    <div class="guest-order-tracking-hero"
        style="background-image: url('{{ url('frontend_assets') }}/img/guest-order-tracking-hero-bg.png');">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 col-12">
                    <div class="guest-order-tracking-hero-info">
                        <h2>Track your order</h2>
                        <form action="{{ url('track/order') }}" method="GET">
                            <input type="text" name="order_no" placeholder="Input Order No ex. 1719912016876"
                                value="{{ $orderInfo ? $orderInfo->order_no : '' }}" required="">
                            <button type="submit" class="theme-btn">Track order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-8 col-12">
                <div class="guest-order-tracking-area">

                    @if ($orderInfo)
                    <div class="order-tracking-card-group">
                        <div class="single-order-tracking-card card-1">
                            <div class="order-tracking-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-1.svg">
                            </div>
                            <div class="order-tracking-card-info">
                                <h6>#{{ $orderInfo->order_no }}</h6>
                                <p>Order number</p>
                            </div>
                        </div>
                        <div class="single-order-tracking-card card-2">
                            <div class="order-tracking-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-2.svg">
                            </div>
                            <div class="order-tracking-card-info">
                                <h6>{{ date('M d, Y', strtotime($orderInfo->estimated_dd)) }}</h6>
                                <p>Estimated delivery date</p>
                            </div>
                        </div>
                        <div class="single-order-tracking-card card-3">
                            <div class="order-tracking-card-icon">
                                <img alt=""
                                    src="{{ url('tenant/frontend') }}/assets/images/order-tracking/card-icon-3.svg">
                            </div>
                            <div class="order-tracking-card-info">
                                <h6>{{ count($orderdItems) }} @if (count($orderdItems) > 1)
                                    items
                                    @else
                                    item
                                    @endif
                                </h6>
                                <p>Total products</p>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-10 col-12">
                            <div class="product-summary order-summary">

                                <div class="table-responsive">
                                    <table class="recent-order-table-data order-summary-table-data table">
                                        <tbody>
                                            @foreach ($orderdItems as $orderdItem)
                                            <tr>
                                                <td>
                                                    <img alt=""
                                                        src="{{ url( $orderdItem->product_image) }}">
                                                    <span
                                                        class="product-name">{{ $orderdItem->product_name }}</span>
                                                </td>
                                                <td>
                                                    @if ($orderdItem->color_name)
                                                    <span class="product-color">Color:
                                                        <strong>{{ $orderdItem->color_name }}</strong></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($orderdItem->size_name)
                                                    <span class="product-size">Size:
                                                        <strong>Large</strong></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="product-qty">Qty:
                                                        <strong>{{ $orderdItem->qty }}
                                                            pcs</strong></span>
                                                </td>
                                                <td>
                                                    <span class="product-total-price">Price:
                                                        <strong>{{ number_format($orderdItem->total_price, 2) }}
                                                            BDT</strong></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="product-summary-head order-summary-head">
                                    <h4 class="order-summary-head-title">
                                        <img alt=""
                                            src="{{ url('tenant/frontend') }}/assets/images/icons/humberger.svg">Product
                                        summary
                                    </h4>
                                    <div class="product-summary-subtotal mb-5">
                                        <div class="product-summary-subtotal">
                                            @php
                                            $itemTotal = $orderInfo->sub_total ?? 0;
                                            $discount = $orderInfo->discount ?? 0;
                                            $vat = $orderInfo->vat ?? 0;
                                            $tax = $orderInfo->tax ?? 0;
                                            $delivery = $orderInfo->delivery_fee ?? 0;
                                            $totalOrder = $orderInfo->total ?? 0;
                                            @endphp
                                            <div style="text-align:right;">
                                                <div>Item Total: <strong>{{ number_format($itemTotal, 2) }} BDT</strong></div>
                                                <div>Discount: <strong>{{ number_format($discount, 2) }} BDT</strong></div>
                                                <div>VAT/TAX: <strong>{{ number_format($vat + $tax, 2) }} BDT</strong></div>
                                                <div>Delivery Charge: <strong>{{ number_format($delivery, 2) }} BDT</strong></div>
                                                <div style="margin-top:6px; font-size:16px;">Total Order Amount: <strong>{{ number_format($totalOrder, 2) }} BDT</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="order-status-area">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12">
                                <div class="order-status-section-head">
                                    <h4 class="order-status-s-head-title">Order timeline</h4>
                                    <div class="seperator-group">
                                        <span class="seperator seperator-1"></span><span
                                            class="seperator seperator-2"></span><span
                                            class="seperator seperator-3"></span>
                                    </div>
                                    <div class="seperator-group">
                                        <span class="seperator-sm"></span><span class="seperator-big"></span><span
                                            class="seperator-sm"></span>
                                    </div>
                                </div>
                                <div class="order-status-card-group">
                                    @php
                                    $currentStatus = $orderInfo->order_status;
                                    // Status constants
                                    $STATUS_PENDING = 0;
                                    $STATUS_APPROVED = 1;
                                    $STATUS_DISPATCH = 2;
                                    $STATUS_INTRANSIT = 3;
                                    $STATUS_CANCELLED = 4;
                                    $STATUS_DELIVERED = 5;
                                    $STATUS_RETURN = 6;
                                    @endphp

                                    {{-- Order Placed (Status 0) --}}
                                    @if ($currentStatus >= $STATUS_PENDING)
                                    <div class="single-order-status-card card-1">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Order placed</h6>
                                            <p>We have received your order</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->created_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->created_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Order Confirmed (Status 1) --}}
                                    @if ($currentStatus >= $STATUS_APPROVED && $currentStatus != $STATUS_CANCELLED)
                                    <div class="single-order-status-card card-2">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Order confirmed</h6>
                                            <p>Your order has been confirmed</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Dispatch (Status 2) --}}
                                    @if ($currentStatus >= $STATUS_DISPATCH && $currentStatus != $STATUS_CANCELLED)
                                    <div class="single-order-status-card card-3">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Dispatch</h6>
                                            <p>Order taken by delivery man.</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- On the way (Status 3) --}}
                                    @if ($currentStatus >= $STATUS_INTRANSIT && $currentStatus != $STATUS_CANCELLED && $currentStatus != $STATUS_RETURN)
                                    <div class="single-order-status-card card-4">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>On the way</h6>
                                            <p>We are on the way to your destination</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Order Delivered (Status 5) --}}
                                    @if ($currentStatus == $STATUS_DELIVERED)
                                    <div class="single-order-status-card card-5">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Order Delivered</h6>
                                            <p>You have Successfully received your order</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Order Returned (Status 6) --}}
                                    @if ($currentStatus == $STATUS_RETURN)
                                    <div class="single-order-status-card card-6">
                                        <div class="order-status-card-icon">
                                            <i class="fi-br-check"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Order Returned</h6>
                                            <p>You didn't receive your order</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Order Cancelled (Status 4) --}}
                                    @if ($currentStatus == $STATUS_CANCELLED)
                                    <div class="single-order-status-card card-7">
                                        <div class="order-status-card-icon-cross">
                                            <i class="fi-br-cross"></i>
                                        </div>
                                        <div class="order-status-card-info">
                                            <h6>Your Order is Cancelled</h6>
                                            <p>We have cancelled your order</p>
                                            <ul>
                                                <li>{{ date('d M, y', strtotime($orderInfo->updated_at)) }}</li>
                                                <li>{{ date('h:i:s a', strtotime($orderInfo->updated_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <h5 class="text-center">No Order Found</h5>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection