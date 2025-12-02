<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- to stop indexing --}}
    <meta name="robots" content="noindex, nofollow">
    <meta content="Admin Panel" name="description" />
    <meta content="Getup Ltd." name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    @if (
        $generalInfo &&
            $generalInfo->fav_icon != '' &&
            $generalInfo->fav_icon != null &&
            file_exists(public_path($generalInfo->fav_icon)))
        <link rel="shortcut icon" href="{{ url($generalInfo->fav_icon) }}">
    @else
        <link rel="shortcut icon" href="{{ url('tenant/admin/assets') }}/images/favicon.ico">
    @endif
    <!-- App css -->
    <link href="{{ url('tenant/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/theme.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/toastr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('tenant/admin/assets') }}/css/custom.css" rel="stylesheet" type="text/css" />
    @yield('header_css')
    @yield('header_js')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ url('/home') }}" class="logo mt-2" style="display: inline-block;">
                        @if (
                            $generalInfo &&
                                $generalInfo->logo != '' &&
                                $generalInfo->logo != null &&
                                file_exists(public_path($generalInfo->logo)))
                            <span>
                                <img src="{{ url($generalInfo->logo) }}" alt="" class="img-fluid"
                                    style="max-height: 100px; max-width: 150px;">
                            </span>
                        @else
                            <h3 style="color: white; margin-top: 20px">
                                {{ $generalInfo->company_name ?? config('app.name') }}</h3>
                        @endif
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    @if (Auth::user()->user_type == 1)
                        @include('tenant.admin.layouts.partials.sidebar')
                    @else
                        @include('tenant.admin.layouts.partials.sidebarWithAssignedMenu')
                    @endif

                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <!--- header menu -->
            @include('tenant.admin.layouts.partials.header')
            <!--- header menu end -->

            <!-- Start Page content -->
            <!-- Start Page content -->
            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <!-- End Page-content -->

            <!--- footer menu -->
            @include('tenant.admin.layouts.partials.footer')
            <!--- footer menu end -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Overlay-->
    <div class="menu-overlay"></div>


    <!-- jQuery  -->
    <script src="{{ url('tenant/admin/assets') }}/js/jquery.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/metismenu.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/waves.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/simplebar.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/plugins/morris-js/morris.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/pages/dashboard-demo.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/theme.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/ajax.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/ajax_two.js"></script>
    <script src="{{ url('tenant/admin/assets') }}/js/search_product_ajax.js"></script>

    <script>
        const handleScroll = () => {
            var Sidebar = document.querySelector('.simplebar-content-wrapper')
            var scrollPosition = Sidebar.scrollTop;
            localStorage.setItem('scroll_nav', scrollPosition);
        }
        document.addEventListener('DOMContentLoaded', function() {
            var Sidebar = document.querySelector('.simplebar-content-wrapper');
            const Location = window.location.pathname;
            Sidebar.onscroll = handleScroll;

            let scroll_nav = localStorage.getItem('scroll_nav');
            if (scroll_nav && Location != '/dashboard') {
                Sidebar.scrollTop = scroll_nav;
            } else {
                Sidebar.scrollTop = 0;
                localStorage.setItem('scroll_nav', 0);
            }
        });

        function guestCheckout() {
            $.get("{{ url('change/guest/checkout/status') }}", function(data) {
                const checkbox = document.getElementById("guest_checkout");
                if (checkbox.checked) {
                    toastr.success("Guest Checkout has Enabled");
                } else {
                    console.log("Checkbox is not checked.");
                    toastr.error("Guest Checkout has Disabled");
                }
            })
        }

        //for demo user checking
        function check_demo_user() {
            const DEMO_MODE = @json(env('DEMO_MODE'));
            if (DEMO_MODE == true && @json(auth()->user()->email) == 'demo@example.com') {
                toastr.error("You cannot change content.", "You're using Demo Mode!");
                return true;
            }
        }
    </script>

    <script src="{{ url('tenant/admin/assets') }}/js/toastr.min.js"></script>

    {!! Toastr::message() !!}

    @yield('footer_js')
</body>

</html>
