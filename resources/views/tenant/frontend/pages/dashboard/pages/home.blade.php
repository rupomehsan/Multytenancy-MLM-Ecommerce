@extends('tenant.frontend.pages.dashboard.layouts.customer_layouts')

@section('page_css')
    <style>
        /* Stats Cards */
        .mlm-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .mlm-stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mlm-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .mlm-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .mlm-stat-card.success::before {
            background: var(--success-gradient);
        }

        .mlm-stat-card.warning::before {
            background: var(--warning-gradient);
        }

        .mlm-stat-card.info::before {
            background: var(--info-gradient);
        }

        .mlm-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
            background: var(--primary-gradient);
            color: white;
        }

        .mlm-stat-card.success .mlm-stat-icon {
            background: var(--success-gradient);
        }

        .mlm-stat-card.warning .mlm-stat-icon {
            background: var(--warning-gradient);
        }

        .mlm-stat-card.info .mlm-stat-icon {
            background: var(--info-gradient);
        }

        .mlm-stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .mlm-stat-label {
            color: #718096;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        /* MLM Network Tree Section */
        .mlm-network-preview {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 25px;
        }

        .mlm-network-preview h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .mlm-tree-levels {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .mlm-level-badge {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mlm-level-badge strong {
            display: block;
            font-size: 24px;
            color: #667eea;
            margin-bottom: 5px;
        }

        .mlm-level-badge span {
            font-size: 12px;
            color: #718096;
        }

        /* Commission Widget */
        .mlm-commission-widget {
            background: var(--success-gradient);
            color: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
        }

        .mlm-commission-widget h5 {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .mlm-commission-amount {
            font-size: 36px;
            font-weight: 700;
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .mlm-stats-grid {
                grid-template-columns: 1fr;
            }

            .mlm-tree-levels {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- MLM Stats Grid -->
    <div class="mlm-stats-grid">
        <div class="mlm-stat-card">
            <div class="mlm-stat-icon">
                <i class="fi-rr-users-alt"></i>
            </div>
            <h2 class="mlm-stat-value">{{ $totalOrderPlaced }}</h2>
            <p class="mlm-stat-label">Total Network</p>
        </div>

        <div class="mlm-stat-card success">
            <div class="mlm-stat-icon">
                <i class="fi-rr-check-circle"></i>
            </div>
            <h2 class="mlm-stat-value">{{ $totalRunningOrder }}</h2>
            <p class="mlm-stat-label">Active Members</p>
        </div>

        <div class="mlm-stat-card warning">
            <div class="mlm-stat-icon">
                <i class="fi-rr-sack-dollar"></i>
            </div>
            <h2 class="mlm-stat-value">৳{{ number_format($totalAmountSpent) }}</h2>
            <p class="mlm-stat-label">Total Earnings</p>
        </div>

        <div class="mlm-stat-card info">
            <div class="mlm-stat-icon">
                <i class="fi-rr-chart-line-up"></i>
            </div>
            <h2 class="mlm-stat-value">{{ $itemsInWishList }}</h2>
            <p class="mlm-stat-label">Team Sales</p>
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
        <a href="{{ url('/mlm/referral-tree') }}" class="mlm-btn-primary">View Full Network Tree</a>
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
                                        <span style="font-size: 12px; color: #718096;">/{{ $wishlistedItem->unit_name }}</span>
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
@endsection
