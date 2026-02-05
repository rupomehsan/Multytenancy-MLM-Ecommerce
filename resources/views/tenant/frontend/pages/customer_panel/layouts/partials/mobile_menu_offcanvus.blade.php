<!-- Mobile Menu Button Trigger -->
<button type="button" class="mobile-menu-sidebar-icon btn btn-primary" data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
    <i class="fi fi-rr-user"></i>
</button>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBothOptions"
    aria-labelledby="offcanvasWithBothOptionsLabel" data-bs-scroll="false" style="z-index: 9999999 !important;">
    <style>
        /* Scoped styles to make offcanvas content scrollable and touch-friendly */
        #offcanvasWithBothOptions .offcanvas-dialog {
            height: 100vh;
            display: flex;
            margin: 0;
            max-width: 360px;
        }

        #offcanvasWithBothOptions .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 0 !important;
        }

        #offcanvasWithBothOptions .getcom-user-sidebar {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 0 !important;
        }

        /* Ensure the dialog and offcanvas container have no rounding */
        #offcanvasWithBothOptions .offcanvas-dialog,
        #offcanvasWithBothOptions .modal-dialog,
        #offcanvasWithBothOptions,
        #offcanvasWithBothOptions .user-mobile-menu-sidebar {
            border-radius: 0 !important;
        }

        /* Make the menu list scroll if content is long */
        #offcanvasWithBothOptions .user-sidebar-menus {
            flex: 1 1 auto;
            overflow: auto;
            padding-bottom: 20px;
        }

        /* Ensure header stays visible */
        #offcanvasWithBothOptions .user-sidebar-head {
            z-index: 5;
            flex: 0 0 auto;
        }

        /* Smooth small-screen width handling */
        @media (max-width: 420px) {
            #offcanvasWithBothOptions .offcanvas-dialog { max-width: 100%; }
        }
    </style>
    <div class="modal-dialog offcanvas-dialog">
        <div class="modal-content">
            <div class="getcom-user-sidebar user-mobile-menu-sidebar">
                <div class="user-sidebar-head">
                    <div class="user-sidebar-profile">
                        @if(Auth::user()->image)
                        <img alt="" src="{{env('ADMIN_URL')."/".Auth::user()->image}}" />
                        @endif
                    </div>
                    <div class="user-sidebar-profile-info">
                        <h5>{{Auth::user()->name}}</h5>
                        <p>{{Auth::user()->email}}</p>
                        <p>{{Auth::user()->phone}}</p>
                        <div class="user-sidebar-profile-btn">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fi-rr-sign-out-alt"></i>Logout</a>
                        </div>
                    </div>
                    <!-- Offcanvas Close Button -->
                    <button type="button" class="mobile-menu-sidebar-close" data-bs-dismiss="offcanvas"
                        aria-label="Close">
                        <i class="fi fi-rr-cross-small"></i>
                    </button>
                </div>
                <div class="user-sidebar-menus">

                    <ul class="user-sidebar-menu-list">
                        <li>
                            <a class="{{ Request::path() == 'customer/home' ? 'active' : '' }}" href="{{ url('customer/home') }}">
                                <i class="fi-ss-dashboard"></i>{{ __('customer.dashboard') }}
                            </a>
                        </li>
                    </ul>

                    <div class="mlm-menu-section">
                        <div class="mlm-menu-section-title">{{ __('customer.mlm_dashboard') }}</div>
                    </div>

                    <ul class="user-sidebar-menu-list">
                        <li>
                            <a class="{{ str_contains(Request::path(), 'customer/mlm/referral-tree') ? 'active' : '' }}"
                                href="{{ url('/customer/mlm/referral-tree') }}">
                                <i class="fi-ss-apps"></i>{{ __('customer.network_tree') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ str_contains(Request::path(), 'customer/mlm/referral-lists') ? 'active' : '' }}"
                                href="{{ url('/customer/mlm/referral-lists') }}">
                                <i class="fi-ss-users-alt"></i>{{ __('customer.referral_list') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ str_contains(Request::path(), 'customer/mlm/commission-history') ? 'active' : '' }}"
                                href="{{ url('/customer/mlm/commission-history') }}">
                                <i class="fi-ss-dollar"></i>{{ __('customer.commission_history') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ str_contains(Request::path(), 'customer/mlm/earning-reports') ? 'active' : '' }}"
                                href="{{ url('/customer/mlm/earning-reports') }}">
                                <i class="fi-ss-stats"></i>{{ __('customer.earnings_report') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ str_contains(Request::path(), 'customer/mlm/withdrawal-requests') || str_contains(Request::path(), 'customer/mlm/withdraw-history') ? 'active' : '' }}"
                                href="{{ url('/customer/mlm/withdrawal-requests') }}">
                                <i class="fi-ss-money"></i>{{ __('customer.withdrawal_requests') }}
                            </a>
                        </li>
                    </ul>

                    <div class="mlm-menu-section">
                        <div class="mlm-menu-section-title">{{ __('customer.my_orders') }}</div>
                    </div>

                    <ul class="user-sidebar-menu-list">
                        <li>
                            <a class="{{ Request::path() == 'my/orders' || str_contains(Request::path(), 'order/details') || str_contains(Request::path(), 'track/my/order') ? 'active' : '' }}"
                                href="{{ url('/my/orders') }}">
                                <i class="fi-ss-shopping-cart"></i>{{ __('customer.my_orders') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'my/wishlists' ? 'active' : '' }}" href="{{ url('/my/wishlists') }}">
                                <i class="fi-ss-heart"></i>{{ __('customer.wishlist') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'promo/coupons' ? 'active' : '' }}"
                                href="{{ url('/promo/coupons') }}">
                                <i class="fi-ss-ticket"></i>{{ __('customer.promo_coupons') }}
                            </a>
                        </li>
                    </ul>

                    <div class="mlm-menu-section">
                        <div class="mlm-menu-section-title">{{ __('customer.profile') }}</div>
                    </div>

                    <ul class="user-sidebar-menu-list">
                        <li>
                            <a class="{{ Request::path() == 'manage/profile' ? 'active' : '' }}"
                                href="{{ url('/manage/profile') }}">
                                <i class="fi-ss-user"></i>{{ __('customer.manage_profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'user/address' ? 'active' : '' }}" href="{{ url('user/address') }}">
                                <i class="fi-ss-map-marker"></i>{{ __('customer.my_address') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'my/payments' ? 'active' : '' }}" href="{{ url('/my/payments') }}">
                                <i class="fi-ss-credit-card"></i>{{ __('customer.my_payments') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'change/password' ? 'active' : '' }}"
                                href="{{ url('change/password') }}">
                                <i class="fi-ss-lock"></i>{{ __('customer.change_password') }}
                            </a>
                        </li>
                    </ul>

                    <div class="mlm-menu-section">
                        <div class="mlm-menu-section-title">{{ __('customer.support_tickets') }}</div>
                    </div>

                    <ul class="user-sidebar-menu-list">
                        <li>
                        <li>
                            <a class="{{ Request::path() == 'support/tickets' || Request::path() == 'create/ticket' || str_contains(Request::path(), 'support/ticket/message') ? 'active' : '' }}"
                                href="{{ url('/support/tickets') }}">
                                <i class="fi-ss-headset"></i>{{ __('customer.support_tickets') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ Request::path() == 'product/reviews' ? 'active' : '' }}"
                                href="{{ url('/product/reviews') }}">
                                <i class="fi-ss-star"></i>{{ __('customer.product_reviews') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Mobile Menu Offcanvas -->