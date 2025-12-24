@extends('tenant.frontend.pages.customer_panel.layouts.customer_layouts')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('tenant/frontend/css/page_css/mlm-home.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Professional Design Enhancements */
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
        }

        .toast {
            background: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            animation: slideIn 0.3s ease-out;
            border-left: 4px solid #10b981;
        }

        .toast.error {
            border-left-color: #ef4444;
        }

        .toast-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #10b981;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .toast.error .toast-icon {
            background: #ef4444;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        /* Enhanced Referral Card */
        .referral-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.25);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: auto;
        }

        .referral-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px rgba(102, 126, 234, 0.35);
        }

        /* Enhanced Wallet Balance Card */
        .wallet-card {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(17, 153, 142, 0.25);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            color: white;
            min-height: auto;
        }

        .wallet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px rgba(17, 153, 142, 0.35);
        }

        .wallet-label {
            color: rgba(255, 255, 255, 0.95);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .wallet-amount {
            font-size: 38px;
            font-weight: 700;
            color: white;
            margin: 8px 0 16px 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .wallet-actions {
            display: flex;
            gap: 10px;
            margin-top: 0;
        }

        .wallet-btn {
            flex: 1;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .wallet-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.02);
            color: white;
            text-decoration: none;
        }

        .wallet-btn:active {
            transform: scale(0.98);
        }

        /* Copy Button Enhancement */
        .copy-btn {
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .copy-btn:active {
            transform: scale(0.98);
        }

        .copy-btn.copied {
            background: rgba(16, 185, 129, 0.9);
            border-color: rgba(16, 185, 129, 1);
        }

        /* Referral Code Display */
        .referral-code-display {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            margin: 10px 0;
        }

        .referral-code-text {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 3px;
            color: white;
            text-align: center;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            line-height: 1.3;
        }

        .referral-link-display {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            word-break: break-all;
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 1.4;
        }

        .section-label {
            color: rgba(255, 255, 255, 0.95);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 16px 0;
        }

        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 20px 0;
        }

        /* Icon Animations */
        .copy-icon {
            transition: transform 0.2s ease;
        }

        .copy-btn:hover .copy-icon {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .referral-code-text {
                font-size: 24px;
                letter-spacing: 2px;
            }

            .copy-btn {
                padding: 8px 16px;
                font-size: 13px;
            }

            .toast-container {
                top: 16px;
                right: 16px;
                left: 16px;
            }

            .wallet-amount {
                font-size: 36px;
            }

            .wallet-actions {
                flex-direction: column;
            }

            .wallet-btn {
                width: 100%;
            }
        }

        @media (max-width: 992px) {

            .wallet-card,
            .referral-card {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Referral Link Card -->

    <!-- User Profile Header -->
    <div class="mlm-user-header">

        <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap: 20px;">
            <div class="mlm-user-info">
                <img src="{{ Auth::user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=120&background=667eea&color=fff' }}"
                    alt="{{ Auth::user()->name }}" class="mlm-user-avatar">
                <div class="mlm-user-details">
                    <h3>{{ Auth::user()->name }}</h3>
                    <p class="text-white"><i class="fi-rr-envelope"></i> {{ Auth::user()->email }}</p>
                    <p class="text-white"><i class="fi-rr-phone-call"></i> {{ Auth::user()->phone ?? 'N/A' }}</p>

                </div>
            </div>

            <div class="mlm-header-actions text-end" style="min-width:110px;">
                <a href="{{ url('manage/profile') }}" class="btn btn-success"
                    style="background: rgba(255,255,255,0.15); color: #fff; border-radius:10px; margin-bottom:10px; display:inline-block; padding: 10px 20px;">
                    <i class="fi-rr-edit"></i> Edit Profile
                </a>
                <br />
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); if (confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }"
                    class="btn btn-sm"
                    style="background: rgba(255,255,255,0.2); color: #fff; border-radius:10px; padding: 10px 20px;">
                    <i class="fi-rr-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Wallet Balance & Referral Section -->
        <div class="row mt-4">
            <!-- Wallet Balance Card -->
            <div class="{{ Auth::user()->user_type == 3 ? 'col-lg-6' : 'col-lg-12' }} col-md-12 mb-3">
                <div class="wallet-card">
                    <div class="wallet-label">
                        <i class="fi-rr-wallet"></i>
                        <span>Available Wallet Balance</span>
                    </div>
                    <h2 class="wallet-amount"> {{ Auth::user()->wallet_balance ?? 0 }} ৳</h2>
                    <div class="wallet-actions">
                        <a href="{{ url('/customer/mlm/withdrawal-requests') }}" class="wallet-btn">
                            <i class="fi-rr-money"></i> Withdraw
                        </a>
                        <a href="{{ url('/customer/mlm/commission-history') }}" class="wallet-btn">
                            <i class="fi-rr-document"></i> History
                        </a>
                    </div>
                </div>
            </div>

            <!-- Referral Section - Only for Customer (user_type 3) -->
            @if (Auth::user()->user_type == 3)
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="referral-card">
                        <!-- Referral Code Section -->
                        <div class="section-label">
                            <i class="fi-rr-share"></i>
                            <span>Your Referral Code</span>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px; margin: 8px 0;">
                            <div class="referral-code-display" style="flex: 1; margin: 0; padding: 10px 14px;">
                                <h2 class="referral-code-text" id="referralCode"
                                    style="font-size: 20px; letter-spacing: 2px;">
                                    {{ Auth::user()->referral_code ?? 'N/A' }}
                                </h2>
                            </div>
                            <button onclick="copyReferralCode()" class="copy-btn" id="copyCodeBtn"
                                style="padding: 10px 16px;">
                                <i class="fi-rr-copy copy-icon"></i>
                                <span id="copyCodeText">Copy</span>
                            </button>
                        </div>

                        <div class="divider"></div>

                        <!-- Referral Link Section -->
                        <div class="section-label">
                            <i class="fi-rr-link"></i>
                            <span>Your Referral Link</span>
                        </div>

                        <div style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
                            <div class="referral-link-display" id="referralLink" style="flex: 1;">
                                {{ url('/register?ref=' . (Auth::user()->referral_code ?? '')) }}
                            </div>
                            <button onclick="copyReferralLink()" class="copy-btn" id="copyLinkBtn"
                                style="padding: 10px 16px;">
                                <i class="fi-rr-copy copy-icon"></i>
                                <span id="copyLinkText">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Modern Stats Grid -->
    <div class="mlm-stats-grid">
        <div class="mlm-stat-card blue">
            <div class="mlm-stat-icon">
                <i class="fi-rr-shopping-bag"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">{{ $totalOrderPlaced }}</h2>
                <p class="mlm-stat-label">Total order placed</p>
            </div>
        </div>

        <div class="mlm-stat-card orange">
            <div class="mlm-stat-icon">
                <i class="fi-rr-box-open"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">{{ $totalRunningOrder }}</h2>
                <p class="mlm-stat-label">Running orders</p>
            </div>
        </div>

        <div class="mlm-stat-card green">
            <div class="mlm-stat-icon">
                <i class="fi-rr-shopping-cart"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">0</h2>
                <p class="mlm-stat-label">Items in cart</p>
            </div>
        </div>

        <div class="mlm-stat-card purple">
            <div class="mlm-stat-icon">
                <i class="fi-rr-heart"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">{{ $itemsInWishList }}</h2>
                <p class="mlm-stat-label">Product in wishlist's</p>
            </div>
        </div>

        <div class="mlm-stat-card cyan">
            <div class="mlm-stat-icon">
                <i class="fi-rr-sack-dollar"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">{{ number_format($totalAmountSpent) }}</h2>
                <p class="mlm-stat-label">Amount spent</p>
            </div>
        </div>

        <div class="mlm-stat-card pink">
            <div class="mlm-stat-icon">
                <i class="fi-rr-comment-alt"></i>
            </div>
            <div class="mlm-stat-content">
                <h2 class="mlm-stat-value">0</h2>
                <p class="mlm-stat-label">Opened Tickets</p>
            </div>
        </div>
    </div>

    <!-- MLM Network Preview -->
    <div class="mlm-network-preview">
        <h4><i class="fi-rr-sitemap"></i> Your MLM Network Levels</h4>
        <div class="mlm-tree-levels">
            <div class="mlm-level-badge">
                <strong>{{ rand(5, 15) }}</strong>
                <span>Level 1</span>
            </div>
            <div class="mlm-level-badge">
                <strong>{{ rand(10, 30) }}</strong>
                <span>Level 2</span>
            </div>
            <div class="mlm-level-badge">
                <strong>{{ rand(20, 50) }}</strong>
                <span>Level 3</span>
            </div>
            <div class="mlm-level-badge">
                <strong>{{ rand(30, 80) }}</strong>
                <span>Level 4</span>
            </div>
        </div>
        <a href="{{ url('/customer/mlm/referral-tree') }}" class="mlm-btn-primary">View Full Network Tree</a>
    </div>

    <!-- Commission Widget -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="mlm-commission-widget">
                <h5><i class="fi-rr-money"></i> This Month Commission</h5>
                <div class="mlm-commission-amount">৳{{ number_format(rand(5000, 50000), 2) }}</div>
                <small>+12% from last month</small>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="mlm-commission-widget" style="background: var(--warning-gradient);">
                <h5><i class="fi-rr-piggy-bank"></i> Pending Withdrawal</h5>
                <div class="mlm-commission-amount">৳{{ number_format(rand(1000, 10000), 2) }}</div>
                <small>Ready to withdraw</small>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mlm-content-card">
        <div class="mlm-card-header">
            <h5 class="mlm-card-title"><i class="fi-rr-shopping-cart"></i> Recent Orders</h5>
            <a href="{{ url('my/orders') }}" class="mlm-btn-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="mlm-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($recentOrders) > 0)
                        @foreach ($recentOrders as $recentOrder)
                            <tr>
                                <td>
                                    <strong>#{{ $recentOrder->order_no }}</strong>
                                </td>
                                <td>
                                    {{ date('M d, Y', strtotime($recentOrder->order_date)) }}
                                </td>
                                <td>
                                    @if ($recentOrder->order_status == 0)
                                        <span class="mlm-status-badge status-pending">Pending</span>
                                    @elseif($recentOrder->order_status == 1)
                                        <span class="mlm-status-badge status-approved">Approved</span>
                                    @elseif($recentOrder->order_status == 4)
                                        <span class="mlm-status-badge status-delivered">Delivered</span>
                                    @else
                                        <span class="mlm-status-badge status-cancelled">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    {{ DB::table('order_details')->where('order_id', $recentOrder->id)->sum('qty') }}
                                </td>
                                <td>
                                    <strong>৳{{ number_format($recentOrder->total) }}</strong>
                                </td>
                                <td>
                                    <a class="mlm-btn-primary" style="padding: 5px 15px; font-size: 12px;"
                                        href="{{ url('order/details') }}/{{ $recentOrder->slug }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="mlm-empty-state">
                                    <i class="fi-rr-shopping-cart"></i>
                                    <h4>No Orders Yet</h4>
                                    <p>You haven't placed any orders yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Wishlist Items -->
    <div class="mlm-content-card">
        <div class="mlm-card-header">
            <h5 class="mlm-card-title"><i class="fi-rr-heart"></i> Wishlist Items</h5>
            <a href="{{ url('my/wishlists') }}" class="mlm-btn-primary">View All</a>
        </div>
        <div class="row">
            @if (count($wishlistedItems) > 0)
                @foreach ($wishlistedItems as $wishlistedItem)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100"
                            style="border-radius: 10px; overflow: hidden; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <img src="{{ env('ADMIN_URL') . '/' . $wishlistedItem->image }}" class="card-img-top"
                                alt="{{ $wishlistedItem->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title" style="font-size: 14px; font-weight: 600;">
                                    {{ Str::limit($wishlistedItem->name, 50) }}
                                </h6>
                                <p class="card-text" style="font-size: 16px; font-weight: 700; color: #667eea;">
                                    ৳{{ $wishlistedItem->discount_price > 0 ? number_format($wishlistedItem->discount_price) : number_format($wishlistedItem->price) }}
                                    @if ($wishlistedItem->unit_name)
                                        <span
                                            style="font-size: 12px; color: #718096;">/{{ $wishlistedItem->unit_name }}</span>
                                    @endif
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('product/details') }}/{{ $wishlistedItem->product_slug }}"
                                        class="btn btn-sm mlm-btn-primary flex-grow-1" target="_blank">
                                        <i class="fi-rr-eye"></i> View
                                    </a>
                                    <a href="{{ url('remove/from/wishlist') }}/{{ $wishlistedItem->product_slug }}"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fi-rr-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="mlm-empty-state">
                        <i class="fi-rr-heart"></i>
                        <h4>No Products in Wishlist</h4>
                        <p>Start adding products to your wishlist.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Toast Notification System
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icon = type === 'success' ? '✓' : '✕';

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div style="flex: 1; font-weight: 500; color: #1f2937;">${message}</div>
            `;

            toastContainer.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    toastContainer.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Enhanced Copy Referral Code Function
        function copyReferralCode() {
            const referralCode = document.getElementById('referralCode').textContent.trim();
            const copyBtn = document.getElementById('copyCodeBtn');
            const copyText = document.getElementById('copyCodeText');
            const originalText = copyText.textContent;

            // Copy to clipboard
            navigator.clipboard.writeText(referralCode).then(() => {
                // Success feedback
                copyBtn.classList.add('copied');
                copyText.innerHTML = '<i class="fi-rr-check"></i> Copied!';
                showToast('Referral code copied to clipboard!', 'success');

                // Reset after 2 seconds
                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyText.innerHTML = '<i class="fi-rr-copy copy-icon"></i> Copy Code';
                }, 2000);
            }).catch(err => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = referralCode;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();

                try {
                    document.execCommand('copy');
                    copyBtn.classList.add('copied');
                    copyText.innerHTML = '<i class="fi-rr-check"></i> Copied!';
                    showToast('Referral code copied to clipboard!', 'success');

                    setTimeout(() => {
                        copyBtn.classList.remove('copied');
                        copyText.innerHTML = '<i class="fi-rr-copy copy-icon"></i> Copy Code';
                    }, 2000);
                } catch (err) {
                    showToast('Failed to copy referral code', 'error');
                }

                document.body.removeChild(textArea);
            });
        }

        // Enhanced Copy Referral Link Function
        function copyReferralLink() {
            const referralLink = document.getElementById('referralLink').textContent.trim();
            const copyBtn = document.getElementById('copyLinkBtn');
            const copyText = document.getElementById('copyLinkText');

            // Copy to clipboard
            navigator.clipboard.writeText(referralLink).then(() => {
                // Success feedback
                copyBtn.classList.add('copied');
                copyText.innerHTML = '<i class="fi-rr-check"></i> Copied!';
                showToast('Referral link copied to clipboard!', 'success');

                // Reset after 2 seconds
                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyText.innerHTML = 'Copy';
                }, 2000);
            }).catch(err => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = referralLink;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();

                try {
                    document.execCommand('copy');
                    copyBtn.classList.add('copied');
                    copyText.innerHTML = '<i class="fi-rr-check"></i> Copied!';
                    showToast('Referral link copied to clipboard!', 'success');

                    setTimeout(() => {
                        copyBtn.classList.remove('copied');
                        copyText.innerHTML = 'Copy';
                    }, 2000);
                } catch (err) {
                    showToast('Failed to copy referral link', 'error');
                }

                document.body.removeChild(textArea);
            });
        }
    </script>
@endsection
