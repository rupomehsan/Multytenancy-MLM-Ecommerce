<style>
    .getcom-user-sidebar {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-top: 0px !important;
    }

    .user-sidebar-head {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 20px;
        text-align: center;
        color: white;
    }

    .user-sidebar-profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        margin: 0 auto 15px;
        display: block;
    }

    .user-sidebar-profile-info h5 {
        color: white;
        margin-bottom: 5px;
        font-size: 18px;
        font-weight: 700;
    }

    .user-sidebar-profile-info p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        margin-bottom: 3px;
    }

    .user-sidebar-profile-btn a {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 10px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .user-sidebar-profile-btn a:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .user-sidebar-menus {
        padding: 10px 0;
    }

    .user-sidebar-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .user-sidebar-menu-list li {
        margin: 0;
    }

    .user-sidebar-menu-list li a {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: #4a5568;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .user-sidebar-menu-list li a i {
        margin-right: 12px;
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .user-sidebar-menu-list li a:hover {
        background: #f7fafc;
        color: #667eea;
        border-left-color: #667eea;
    }

    .user-sidebar-menu-list li a.active {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        color: #667eea;
        border-left-color: #667eea;
        font-weight: 600;
    }

    /* MLM Specific Styles */
    .mlm-menu-section {
        margin: 15px 20px 10px;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
    }

    .mlm-menu-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #a0aec0;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
</style>

<div class="getcom-user-sidebar">

    <div class="user-sidebar-menus">

        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ Request::path() == 'customer/home' ? 'active' : '' }}" href="{{ url('customer/home') }}">
                    <i class="fi-ss-dashboard"></i>Dashboard
                </a>
            </li>
        </ul>

        <div class="mlm-menu-section">
            <div class="mlm-menu-section-title">MLM Management</div>
        </div>

        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ str_contains(Request::path(), 'customer/mlm/referral-tree') ? 'active' : '' }}"
                    href="{{ url('/customer/mlm/referral-tree') }}">
                    <i class="fi-ss-apps"></i>My Network
                </a>
            </li>
            <li>
                <a class="{{ str_contains(Request::path(), 'customer/mlm/referral-lists') ? 'active' : '' }}"
                    href="{{ url('/customer/mlm/referral-lists') }}">
                    <i class="fi-ss-users-alt"></i>Referrals
                </a>
            </li>
            <li>
                <a class="{{ str_contains(Request::path(), 'customer/mlm/commission-history') ? 'active' : '' }}"
                    href="{{ url('/customer/mlm/commission-history') }}">
                    <i class="fi-ss-dollar"></i>Commissions
                </a>
            </li>
            <li>
                <a class="{{ str_contains(Request::path(), 'customer/mlm/earning-reports') ? 'active' : '' }}"
                    href="{{ url('/customer/mlm/earning-reports') }}">
                    <i class="fi-ss-stats"></i>Earnings Report
                </a>
            </li>
            <li>
                <a class="{{ str_contains(Request::path(), 'customer/mlm/withdrawal-requests') || str_contains(Request::path(), 'customer/mlm/withdraw-history') ? 'active' : '' }}"
                    href="{{ url('/customer/mlm/withdrawal-requests') }}">
                    <i class="fi-ss-money"></i>Withdrawals
                </a>
            </li>
        </ul>

        <div class="mlm-menu-section">
            <div class="mlm-menu-section-title">Orders & Shopping</div>
        </div>

        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ Request::path() == 'my/orders' || str_contains(Request::path(), 'order/details') || str_contains(Request::path(), 'track/my/order') ? 'active' : '' }}"
                    href="{{ url('/my/orders') }}">
                    <i class="fi-ss-shopping-cart"></i>My Orders
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'my/wishlists' ? 'active' : '' }}" href="{{ url('/my/wishlists') }}">
                    <i class="fi-ss-heart"></i>Wishlist
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'promo/coupons' ? 'active' : '' }}"
                    href="{{ url('/promo/coupons') }}">
                    <i class="fi-ss-ticket"></i>Coupons
                </a>
            </li>
        </ul>

        <div class="mlm-menu-section">
            <div class="mlm-menu-section-title">Account Settings</div>
        </div>

        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ Request::path() == 'manage/profile' ? 'active' : '' }}"
                    href="{{ url('/manage/profile') }}">
                    <i class="fi-ss-user"></i>My Profile
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'user/address' ? 'active' : '' }}" href="{{ url('user/address') }}">
                    <i class="fi-ss-map-marker"></i>Addresses
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'my/payments' ? 'active' : '' }}" href="{{ url('/my/payments') }}">
                    <i class="fi-ss-credit-card"></i>Payments
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'change/password' ? 'active' : '' }}"
                    href="{{ url('change/password') }}">
                    <i class="fi-ss-lock"></i>Security
                </a>
            </li>
        </ul>

        <div class="mlm-menu-section">
            <div class="mlm-menu-section-title">Support</div>
        </div>

        <ul class="user-sidebar-menu-list">
            <li>
            <li>
                <a class="{{ Request::path() == 'support/tickets' || Request::path() == 'create/ticket' || str_contains(Request::path(), 'support/ticket/message') ? 'active' : '' }}"
                    href="{{ url('/support/tickets') }}">
                    <i class="fi-ss-headset"></i>Support Tickets
                </a>
            </li>
            <li>
                <a class="{{ Request::path() == 'product/reviews' ? 'active' : '' }}"
                    href="{{ url('/product/reviews') }}">
                    <i class="fi-ss-star"></i>Reviews
                </a>
            </li>
        </ul>
    </div>
</div>
