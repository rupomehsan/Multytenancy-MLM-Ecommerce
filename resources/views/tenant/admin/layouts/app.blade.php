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
    <style>
        :root {
            --sidebar-width: 220px;
            --topbar-h: 64px;
        }

        /* Resizable sidebar base styles (scoped to avoid conflicts) */
        .vertical-menu {
            width: var(--sidebar-width) !important;
            position: fixed !important;
            left: 0;
            top: 0;
            bottom: 0;
            overflow: visible;
            transition: width 120ms linear;
            z-index: 50
        }

        /* Ensure main content shifts to the right of sidebar */
        .main-content {
            margin-left: var(--sidebar-width) !important;
            transition: margin-left 120ms linear
        }

        /* Make topbar fixed and aligned with main content (to the right of sidebar) */
        #page-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-h);
            z-index: 90;
            background: linear-gradient(180deg, #0b2a44, #0e2f4d);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }

        /* Push page content below fixed topbar */

        /* Drag handle */
        .vertical-menu .drag-handle {
            position: absolute;
            top: 0;
            right: 0;
            /* keep handle fully inside the sidebar */
            width: 12px;
            height: 100%;
            cursor: col-resize;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* make sure it's above scroll container */
            background: transparent;
            /* invisible but captures pointer */
            touch-action: none;
            /* allow smooth pointer events */
        }

        .vertical-menu .drag-handle .bar {
            width: 3px;
            height: 48px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 2px;
            transition: background 120ms
        }

        .vertical-menu .drag-handle:hover .bar {
            background: rgba(255, 255, 255, 0.14)
        }

        /* Visual feedback while resizing */
        .vertical-menu.resizing .drag-handle .bar {
            background: var(--accent, #06b6d4)
        }

        /* Make sure the page content doesn't jump under the fixed sidebar on smaller widths */
        @media (max-width: 800px) {
            .vertical-menu {
                position: relative !important;
                width: var(--sidebar-width) !important
            }

            .main-content {
                margin-left: 0 !important
            }

            #page-topbar {
                left: 0;
            }


        }

        /* Collapsed sidebar styles */
        .sidebar-collapsed .vertical-menu {
            width: 0 !important;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar-collapsed .main-content {
            margin-left: 0 !important;
        }

        .sidebar-collapsed #page-topbar {
            left: 0;
        }

        /* Smooth transitions for sidebar collapse */
        .vertical-menu,
        .main-content,
        #page-topbar {
            transition: all 0.3s ease-in-out;
        }
    </style>
    <style>
        /* Override any large-screen padding that pushes topbar content — keep it fixed at 0 */
        @media (min-width: 992px) {
            #page-topbar {
                padding-left: 0 !important;
            }
        }
    </style>
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
            <div class="drag-handle" aria-hidden="true">
                <div class="bar"></div>
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
        // Auto-scroll to active menu item
        function scrollToActiveMenuItem() {
            const sidebarContainer = document.querySelector('.simplebar-content-wrapper');
            if (!sidebarContainer) return;

            // Find the active menu item - check multiple possible selectors
            let activeMenuItem = document.querySelector('#side-menu a.active');

            // If not found, check for active parent menu item
            if (!activeMenuItem) {
                const activeLi = document.querySelector('#side-menu li.mm-active');
                if (activeLi) {
                    activeMenuItem = activeLi.querySelector('a');
                }
            }

            // If still not found, check for sub-menu active items
            if (!activeMenuItem) {
                activeMenuItem = document.querySelector('#side-menu .sub-menu a.active');
            }

            if (activeMenuItem) {
                // Get the actual offset relative to the scrollable container
                const menuRect = activeMenuItem.getBoundingClientRect();
                const containerRect = sidebarContainer.getBoundingClientRect();
                const currentScroll = sidebarContainer.scrollTop;

                // Calculate offset from top of container
                const relativeTop = menuRect.top - containerRect.top + currentScroll;
                const containerHeight = sidebarContainer.clientHeight;
                const itemHeight = activeMenuItem.offsetHeight;

                // Center the active item in the viewport
                const scrollPosition = relativeTop - (containerHeight / 2) + (itemHeight / 2);

                // Scroll to position
                sidebarContainer.scrollTo({
                    top: Math.max(0, scrollPosition),
                    behavior: 'smooth'
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const Sidebar = document.querySelector('.simplebar-content-wrapper');
            if (!Sidebar) return;

            // Scroll to active menu item after page loads and menu initializes
            // Use multiple timeouts to ensure it works even with slow initialization
            setTimeout(() => scrollToActiveMenuItem(), 100);
            setTimeout(() => scrollToActiveMenuItem(), 500);
            setTimeout(() => scrollToActiveMenuItem(), 1000);

            // Also monitor for menu class changes (when expanding/collapsing)
            const observer = new MutationObserver(() => {
                setTimeout(() => scrollToActiveMenuItem(), 100);
            });

            const sideMenu = document.getElementById('side-menu');
            if (sideMenu) {
                observer.observe(sideMenu, {
                    attributes: true,
                    attributeFilter: ['class'],
                    subtree: true,
                    childList: true
                });
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

    <script>
        (function() {
            const sidebar = document.querySelector('.vertical-menu');
            if (!sidebar) return;

            const storageKey = 'sidebarWidth';
            const minW = 120,
                maxW = 400;
            const docEl = document.documentElement;

            // Apply stored width (if any)
            try {
                const stored = localStorage.getItem(storageKey);
                if (stored) {
                    let w = parseInt(stored, 10);
                    if (!isNaN(w)) {
                        w = Math.max(minW, Math.min(maxW, w));
                        docEl.style.setProperty('--sidebar-width', w + 'px');
                    }
                }
            } catch (e) {
                console.warn('sidebar restore failed', e)
            }

            // Ensure handle exists (in case server-side changes)
            let handle = sidebar.querySelector('.drag-handle');
            if (!handle) {
                handle = document.createElement('div');
                handle.className = 'drag-handle';
                handle.innerHTML = '<div class="bar"></div>';
                sidebar.appendChild(handle);
            }

            let dragging = false,
                startX = 0,
                startW = 0,
                pointerId = null;

            const onPointerDown = function(e) {
                dragging = true;
                pointerId = e.pointerId;
                startX = e.clientX;
                startW = sidebar.getBoundingClientRect().width;
                sidebar.classList.add('resizing');
                if (handle.setPointerCapture) handle.setPointerCapture(pointerId);
                e.preventDefault();
            };

            const onPointerMove = function(e) {
                if (!dragging) return;
                const dx = e.clientX - startX;
                let newW = Math.round(startW + dx);
                newW = Math.max(minW, Math.min(maxW, newW));
                docEl.style.setProperty('--sidebar-width', newW + 'px');
            };

            const onPointerUp = function(e) {
                if (!dragging) return;
                dragging = false;
                sidebar.classList.remove('resizing');
                try {
                    if (handle.releasePointerCapture) handle.releasePointerCapture(pointerId);
                } catch (e) {}
                const finalW = Math.round(sidebar.getBoundingClientRect().width);
                try {
                    localStorage.setItem(storageKey, finalW);
                } catch (e) {
                    console.warn('save failed', e)
                }
            };

            handle.addEventListener('pointerdown', onPointerDown);
            window.addEventListener('pointermove', onPointerMove);
            window.addEventListener('pointerup', onPointerUp);
            // prevent text selection while dragging
            window.addEventListener('selectstart', function(e) {
                if (dragging) e.preventDefault();
            });
        })();
    </script>

    @yield('footer_js')
</body>

</html>
