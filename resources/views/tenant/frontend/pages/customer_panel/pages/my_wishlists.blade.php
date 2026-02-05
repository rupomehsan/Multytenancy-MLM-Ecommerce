@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
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
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
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

                    <div class="wishlist-page-area mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.wishlist') }}</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn" href="{{ url('clear/all/wishlist') }}">{{ __('customer.delete') }}</a>
                            </div>
                        </div>
                        <div class="wishlist-items-area" style="margin-top: 32px">
                            <div class="dashboard-wishlist-inner">

                                @if (count($wishlistedItems) > 0)
                                    @foreach ($wishlistedItems as $wishlistedItem)
                                        <div class="wishlist-card">
                                            <div class="wishlist-card-data">
                                                <div class="wishlist-card-img">
                                                    <img alt=""
                                                        src="/{{  $wishlistedItem->image }}" />
                                                    <div class="wishlist-card-remove">
                                                        <a href="{{ url('remove/from/wishlist') }}/{{ $wishlistedItem->product_slug }}"
                                                            class="d-block">
                                                            <span><i class="fi-br-cross-small"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="wishlist-card-info">
                                                    <h6>{{ $wishlistedItem->name }}</h6>
                                                    <p>{{ $wishlistedItem->discount_price > 0 ? $wishlistedItem->discount_price : $wishlistedItem->price }}
                                                        BDT<span>
                                                            @if ($wishlistedItem->unit_name)
                                                                /{{ $wishlistedItem->unit_name }}
                                                            @endif
                                                        </span></p>
                                                </div>
                                            </div>
                                            <div class="wishlist-card-btn">
                                                <a href="{{ url('product/details') }}/{{ $wishlistedItem->product_slug }}"
                                                    target="_blank"><i class="fi-rr-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <style>
                                        .dashboard-wishlist-inner {
                                            display: block;
                                        }
                                    </style>
                                    <h3 class="text-center">{{ __('customer.no_wishlist_items') }}</h3>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
