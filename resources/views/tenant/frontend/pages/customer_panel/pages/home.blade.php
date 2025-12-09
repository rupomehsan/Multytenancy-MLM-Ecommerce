@extends('tenant.frontend.pages.customer_panel.layouts.customer_layouts')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('tenant/frontend/css/page_css/mlm-home.css') }}" />
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
                    <p><i class="fi-rr-envelope"></i> {{ Auth::user()->email }}</p>
                    <p><i class="fi-rr-phone-call"></i> {{ Auth::user()->phone ?? 'N/A' }}</p>

                </div>
            </div>

            <div class="mlm-header-actions text-end" style="min-width:110px;">
                <a href="{{ url('manage/profile') }}" class="btn btn-sm"
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

        <!-- Wallet Balance Section -->
        <div class="row mt-3">
            <div class="col-lg-6 col-md-12">
                <div class="mlm-wallet-balance">
                    <p class="mlm-wallet-label">
                        <i class="fi-rr-wallet"></i> Available Wallet Balance
                    </p>
                    <h2 class="mlm-wallet-amount">৳15,680.00</h2>
                    <div class="mlm-wallet-actions">
                        <a href="{{ url('/customer/mlm/withdrawal-requests') }}" class="mlm-wallet-btn">
                            <i class="fi-rr-money"></i> Withdraw
                        </a>
                        <a href="{{ url('/customer/mlm/commission-history') }}" class="mlm-wallet-btn">
                            <i class="fi-rr-document"></i> History
                        </a>
                    </div>
                </div>
            </div>
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

    <script>
        // Copy Referral Link Function
        function copyReferralLink() {
            const referralLink = document.getElementById('referralLink').textContent.trim();
            const copyBtn = document.querySelector('.mlm-copy-btn');
            const copyText = document.getElementById('copyText');

            // Copy to clipboard
            navigator.clipboard.writeText(referralLink).then(() => {
                // Success feedback
                copyBtn.classList.add('copied');
                copyText.textContent = 'Copied!';

                // Reset after 2 seconds
                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyText.textContent = 'Copy Link';
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
                    copyText.textContent = 'Copied!';

                    setTimeout(() => {
                        copyBtn.classList.remove('copied');
                        copyText.textContent = 'Copy Link';
                    }, 2000);
                } catch (err) {
                    alert('Failed to copy link');
                }

                document.body.removeChild(textArea);
            });
        }
    </script>
@endsection
