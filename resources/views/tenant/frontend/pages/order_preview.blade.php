@extends('tenant.frontend.layouts.app')

@push('site-seo')
    {{-- $generalInfo is provided globally by AppServiceProvider --}}
    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    {{-- Page Title & Favicon --}}
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

@section('content')
    <section class="auth-page-area" style="padding: 80px 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="auth-card verifyOTP-card">
                        <div class="auth-card-head" style="margin-top: 0">
                            <div class="auth-card-head-icon">
                                <img src="{{ url('tenant/frontend') }}/img/order_successfull.svg" alt="Order Successfull">
                            </div>
                            <h4 class="auth-card-title">Order Successful</h4>
                            <p>
                                Thanks for your order. We receive your order. We will be in touch and contact you
                                soon!
                            </p>
                            <h5 class="mb-5" style="font-weight: 600;font-size: 18px;">Order NO:
                                {{ $orderInfo ? $orderInfo->order_no : '' }}</h5>

                            @auth('customer')
                                <a href="{{ url('/my/orders') }}" class="auth-card-form-btn primary__btn d-inline-block"
                                    style="width: 220px; margin: auto;">View My Orders</a>
                            @endauth

                            @guest('customer')
                                <a href="{{ url('track/order') }}/{{ $orderInfo->order_no }}"
                                    class="auth-card-form-btn primary__btn d-inline-block"
                                    style="width: 220px; margin: auto;">Track Order</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    @if ($generalInfo->google_tag_manager_status)
        <script type="text/javascript">
            dataLayer.push({
                ecommerce: null
            }); // Clear the previous ecommerce object.
            dataLayer.push({
                event: "purchase",
                ecommerce: {
                    transaction_id: "{{ $orderInfo->order_no }}",
                    affiliation: "Fejmo",
                    value: "{{ $orderInfo->total }}",
                    tax: "{{ $orderInfo->tax }}",
                    shipping: "{{ $orderInfo->delivery_fee }}",
                    currency: "BDT",
                    coupon: "{{ $orderInfo->coupon_code }}",

                    // added later start
                    name: "{{ $shippingInfo->full_name }}",
                    email: "{{ $shippingInfo->email }}",
                    phone: "{{ $shippingInfo->phone }}",
                    shipping_address: "{{ $shippingInfo->address }}",
                    shipping_district_id: "{{ $shippingInfo->city }}",
                    shipping_thana_id: "{{ $shippingInfo->thana }}",
                    shipping_postal_code: "{{ $shippingInfo->post_code }}",
                    billing_address: "{{ $billingInfo->address }}",
                    billing_district_id: "{{ $billingInfo->city }}",
                    billing_thana_id: "{{ $billingInfo->thana }}",
                    billing_postal_code: "{{ $billingInfo->post_code }}",
                    // added later end

                    items: [
                        @foreach ($orderdItems as $orderdItem)
                            {
                                item_name: "{{ $orderdItem->product_name }}",
                                item_id: "{{ $orderdItem->product_id }}",
                                price: "{{ $orderdItem->total_price }}",
                                item_brand: "{{ $orderdItem->brand_name }}",
                                item_category: "{{ $orderdItem->category_name ?? '' }}",
                                item_variant: "",
                                quantity: {{ $orderdItem->qty }}
                            },
                        @endforeach
                    ]
                }
            });
        </script>
    @endif
@endsection
