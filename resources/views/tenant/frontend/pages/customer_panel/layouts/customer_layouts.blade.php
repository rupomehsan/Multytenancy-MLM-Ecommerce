@extends('tenant.frontend.layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/page_css/customer-layouts.css" />
    @yield('page_css')
@endsection

@push('site-seo')
    @php
        // using shared $generalInfo provided by AppServiceProvider
    @endphp
    <title>
        @if (isset($pageTitle))
            {{ $pageTitle }} - {{ $generalInfo->company_name ?? 'Dashboard' }}
        @elseif ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name ?? 'Dashboard' }}
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
    <div class="mlm-dashboard-wrapper">
        <div class="container-fluid">

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="mlm-sidebar-wrapper">
                        @include('tenant.frontend.pages.customer_panel.layouts.partials.menu')
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-8 col-12">
                    @yield('dashboard_content')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    @yield('page_js')
@endsection
