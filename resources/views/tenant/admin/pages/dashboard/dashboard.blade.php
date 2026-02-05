@extends('tenant.admin.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.css">
    <style>
        /* Modern Dashboard Styling - Professional Analytics */
        :root {
            --primary-blue: #4e73df;
            --secondary-blue: #36b9cc;
            --success-green: #1cc88a;
            --warning-yellow: #f6c23e;
            --danger-red: #e74a3b;
            --info-cyan: #36b9cc;
            --dark-navy: #1a2332;
            --gray-text: #858796;
            --light-bg: #f8f9fc;
            --purple: #6f42c1;
            --teal: #20c9a6;
            --orange: #fd7e14;
        }

        /* Card Title Styling - Modern Gradient */
        h4.card-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        h4.card-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        h4.card-title:hover::before {
            left: 100%;
        }

        .section-header {
            margin: 30px 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 3px solid transparent;
            border-image: linear-gradient(to right, #667eea, #764ba2);
            border-image-slice: 1;
        }

        .section-header h3 {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        /* KPI Card Styling - Enhanced 3D Effect */
        .kpi-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        }

        .kpi-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.4s;
        }

        .kpi-card:hover::before {
            transform: scaleX(1);
        }

        .kpi-card .card-body {
            padding: 25px;
        }

        .kpi-icon {
            position: absolute;
            top: 25px;
            right: 25px;
            font-size: 42px;
            height: 70px;
            width: 70px;
            line-height: 70px;
            text-align: center;
            border-radius: 15px;
            font-weight: 300;
            opacity: 0.15;
            transition: all 0.4s;
        }

        .kpi-card:hover .kpi-icon {
            opacity: 0.25;
            transform: rotate(10deg) scale(1.1);
        }

        .kpi-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #858796;
            margin-bottom: 10px;
        }

        .kpi-value {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .kpi-comparison {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            margin-top: 8px;
        }

        .kpi-growth {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }

        .kpi-growth i {
            animation: pulse 2s infinite;
        }

        .kpi-growth.positive {
            background: linear-gradient(135deg, rgba(28, 200, 138, 0.15), rgba(28, 200, 138, 0.05));
            color: #1cc88a;
            border: 1px solid rgba(28, 200, 138, 0.3);
        }

        .kpi-growth.negative {
            background: linear-gradient(135deg, rgba(231, 74, 59, 0.15), rgba(231, 74, 59, 0.05));
            color: #e74a3b;
            border: 1px solid rgba(231, 74, 59, 0.3);
        }

        .kpi-growth.neutral {
            background: linear-gradient(135deg, rgba(98, 120, 152, 0.15), rgba(98, 120, 152, 0.05));
            color: #858796;
            border: 1px solid rgba(98, 120, 152, 0.3);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .kpi-comparison-text {
            color: #858796;
            font-size: 11px;
            font-weight: 500;
            margin-left: 4px;
            letter-spacing: 0.3px;
        }

        font-size: 12px;
        }

        /* Chart Container Styling - Modern Glass Effect */
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
            overflow: hidden;
        }

        .chart-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* Table Styling */
        .table-modern {
            font-size: 13px;
        }

        .table-modern thead th {
            background: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            color: #627898;
            border: none;
            padding: 12px 15px;
        }

        .table-modern tbody tr {
            transition: background 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8f9fa;
        }

        .table-modern tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }

        /* Badge Styling */
        .badge-modern {
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 4px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .kpi-value {
                font-size: 22px;
            }

            .kpi-icon {
                font-size: 24px;
                height: 40px;
                width: 40px;
                line-height: 40px;
            }
        }

        /* Loading State */
        .chart-loading {
            text-align: center;
            padding: 40px;
            color: #627898;
        }
    </style>
@endsection

@section('page_title')
    Dashboard
@endsection

@section('page_heading')
    Analytics Overview
@endsection

@section('content')
    {{-- KPI Overview Section --}}
    <div class="section-header">
        <h3><i class="feather-trending-up"></i> Key Performance Indicators</h3>
    </div>

    <div class="row">
        {{-- Total Revenue (Monthly) --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Total Revenue (Monthly)</div>
                    <div class="kpi-value">৳ {{ number_format($totalOrderAmount[0], 2) }}</div>
                    <div class="kpi-comparison">
                        @php
                            $revGrowth =
                                $totalOrderAmount[1] > 0
                                    ? (($totalOrderAmount[0] - $totalOrderAmount[1]) / $totalOrderAmount[1]) * 100
                                    : 0;
                        @endphp
                        <span class="kpi-growth {{ $revGrowth >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-{{ $revGrowth >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($revGrowth), 1) }}%
                        </span>
                        <span class="kpi-comparison-text">vs last month</span>
                    </div>
                    <div id="sparkline-revenue" class="mt-3"></div>
                </div>
                <i class="kpi-icon feather-dollar-sign" style="color: #00C2B2; background: rgba(0, 194, 178, 0.1);"></i>
            </div>
        </div>

        {{-- Total Orders (Monthly) --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Total Orders (Monthly)</div>
                    <div class="kpi-value">{{ number_format($countOrders[0]) }}</div>
                    <div class="kpi-comparison">
                        @php
                            $orderGrowth =
                                $countOrders[1] > 0 ? (($countOrders[0] - $countOrders[1]) / $countOrders[1]) * 100 : 0;
                        @endphp
                        <span class="kpi-growth {{ $orderGrowth >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-{{ $orderGrowth >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($orderGrowth), 1) }}%
                        </span>
                        <span class="kpi-comparison-text">vs last month</span>
                    </div>
                    <div id="sparkline-orders" class="mt-3"></div>
                </div>
                <i class="kpi-icon feather-shopping-cart" style="color: #0074E4; background: rgba(0, 116, 228, 0.1);"></i>
            </div>
        </div>

        {{-- Average Order Value --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Average Order Value</div>
                    <div class="kpi-value">
                        ৳ {{ $countOrders[0] > 0 ? number_format($totalOrderAmount[0] / $countOrders[0], 2) : '0.00' }}
                    </div>
                    <div class="kpi-comparison">
                        @php
                            $currentAOV = $countOrders[0] > 0 ? $totalOrderAmount[0] / $countOrders[0] : 0;
                            $previousAOV = $countOrders[1] > 0 ? $totalOrderAmount[1] / $countOrders[1] : 0;
                            $aovGrowth = $previousAOV > 0 ? (($currentAOV - $previousAOV) / $previousAOV) * 100 : 0;
                        @endphp
                        <span class="kpi-growth {{ $aovGrowth >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-{{ $aovGrowth >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($aovGrowth), 1) }}%
                        </span>
                        <span class="kpi-comparison-text">vs last month</span>
                    </div>
                    <div id="sparkline-aov" class="mt-3"></div>
                </div>
                <i class="kpi-icon feather-trending-up" style="color: #F1BF43; background: rgba(241, 191, 67, 0.1);"></i>
            </div>
        </div>

        {{-- Today's Orders --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Today's Orders</div>
                    <div class="kpi-value">{{ number_format($todaysOrder[0]) }}</div>
                    <div class="kpi-comparison">
                        <a href="{{ route('ViewPendingOrders') }}" target="_blank" class="btn btn-sm btn-success"
                            style="padding: 4px 12px; font-size: 11px;">
                            <i class="feather-eye"></i> View All Orders
                        </a>
                    </div>
                    <div id="sparkline-today" class="mt-3"></div>
                </div>
                <i class="kpi-icon feather-package" style="color: #DF3554; background: rgba(223, 53, 84, 0.1);"></i>
            </div>
        </div>
    </div>

    {{-- Additional KPIs Row --}}
    <div class="row mt-3">
        {{-- New Users (Monthly) --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">New Customers (Monthly)</div>
                    <div class="kpi-value">{{ number_format($registeredUsers[0]) }}</div>
                    <div class="kpi-comparison">
                        @php
                            $userGrowth =
                                $registeredUsers[1] > 0
                                    ? (($registeredUsers[0] - $registeredUsers[1]) / $registeredUsers[1]) * 100
                                    : 0;
                        @endphp
                        <span class="kpi-growth {{ $userGrowth >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-{{ $userGrowth >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($userGrowth), 1) }}%
                        </span>
                        <span class="kpi-comparison-text">vs last month</span>
                    </div>
                    <div id="sparkline-users" class="mt-3"></div>
                </div>
                <i class="kpi-icon feather-users" style="color: #627898; background: rgba(98, 120, 152, 0.1);"></i>
            </div>
        </div>

        {{-- Conversion Rate --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Success Rate</div>
                    @php
                        $totalOrdersRatio = $countOrdersRatioSuccess[0] + $countOrdersRatioFailed[0];
                        $conversionRate =
                            $totalOrdersRatio > 0 ? ($countOrdersRatioSuccess[0] / $totalOrdersRatio) * 100 : 0;
                    @endphp
                    <div class="kpi-value">{{ number_format($conversionRate, 1) }}%</div>
                    <div class="kpi-comparison">
                        <span class="kpi-comparison-text">{{ $countOrdersRatioSuccess[0] }} successful of
                            {{ $totalOrdersRatio }} orders</span>
                    </div>
                </div>
                <i class="kpi-icon feather-check-circle" style="color: #00C2B2; background: rgba(0, 194, 178, 0.1);"></i>
            </div>
        </div>

        {{-- Revenue Growth --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Revenue Growth (MoM)</div>
                    @php
                        $revenueGrowthPercent =
                            $totalOrderAmount[1] > 0
                                ? (($totalOrderAmount[0] - $totalOrderAmount[1]) / $totalOrderAmount[1]) * 100
                                : 0;
                    @endphp
                    <div class="kpi-value">{{ number_format($revenueGrowthPercent, 1) }}%</div>
                    <div class="kpi-comparison">
                        <span class="kpi-comparison-text">
                            {{ $revenueGrowthPercent >= 0 ? 'Increased' : 'Decreased' }} by
                            ৳{{ number_format(abs($totalOrderAmount[0] - $totalOrderAmount[1]), 2) }}
                        </span>
                    </div>
                </div>
                <i class="kpi-icon feather-bar-chart-2" style="color: #0074E4; background: rgba(0, 116, 228, 0.1);"></i>
            </div>
        </div>

        {{-- Orders Growth --}}
        <div class="col-lg-6 col-xl-3">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="kpi-label">Orders Growth (MoM)</div>
                    @php
                        $ordersGrowthPercent =
                            $countOrders[1] > 0 ? (($countOrders[0] - $countOrders[1]) / $countOrders[1]) * 100 : 0;
                    @endphp
                    <div class="kpi-value">{{ number_format($ordersGrowthPercent, 1) }}%</div>
                    <div class="kpi-comparison">
                        <span class="kpi-comparison-text">
                            {{ $ordersGrowthPercent >= 0 ? 'Increased' : 'Decreased' }} by
                            {{ abs($countOrders[0] - $countOrders[1]) }} orders
                        </span>
                    </div>
                </div>
                <i class="kpi-icon feather-activity" style="color: #F1BF43; background: rgba(241, 191, 67, 0.1);"></i>
            </div>
        </div>
    </div>

    {{-- Sales & Revenue Analytics Section --}}
    <div class="section-header mt-4">
        <h3><i class="feather-bar-chart"></i> Sales & Revenue Analytics</h3>
    </div>

    <div class="row">
        {{-- Revenue Trend Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Revenue Trend Analysis</h4>
                    <p class="text-muted mb-4">Monthly revenue performance - Last 9 months</p>
                    <div style="height: 350px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Products Doughnut Chart --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Selling Products</h4>
                    <p class="text-muted mb-4">Best sellers since {{ date('jS M, Y', strtotime($queryStartDate)) }}</p>
                    <div style="height: 350px;">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders & Customers Analytics Section --}}
    <div class="section-header mt-4">
        <h3><i class="feather-trending-up"></i> Orders & Customer Analytics</h3>
    </div>

    <div class="row">
        {{-- Orders Performance Bar Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Performance Analysis</h4>
                    <p class="text-muted mb-4">Success vs Failed Orders - Last 9 months</p>
                    <div style="height: 350px;">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer Growth Line Chart --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customer Growth</h4>
                    <p class="text-muted mb-4">New customer registrations</p>
                    <div style="height: 350px;">
                        <canvas id="customerGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Status Distribution --}}
    <div class="section-header mt-4">
        <h3><i class="feather-pie-chart"></i> Order Status Distribution</h3>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Status Breakdown</h4>
                    <p class="text-muted mb-4">Current order status distribution</p>
                    <div style="height: 350px;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Analytics Card --}}
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Quick Stats Overview</h4>
                    <p class="text-muted mb-4">Current month performance metrics</p>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="mr-3">
                                    <i class="feather-trending-up" style="font-size: 32px; color: #1cc88a;"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Completed Orders</div>
                                    <div class="h4 mb-0">
                                        {{ DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_DELIVERED)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="mr-3">
                                    <i class="feather-clock" style="font-size: 32px; color: #f6c23e;"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Pending Orders</div>
                                    <div class="h4 mb-0">
                                        {{ DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_PENDING)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="mr-3">
                                    <i class="feather-check-circle" style="font-size: 32px; color: #36b9cc;"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Approved Orders</div>
                                    <div class="h4 mb-0">
                                        {{ DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_APPROVED)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="mr-3">
                                    <i class="feather-x-circle" style="font-size: 32px; color: #e74a3b;"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Cancelled Orders</div>
                                    <div class="h4 mb-0">
                                        {{ DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_CANCELLED)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3 mt-2">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-muted small">Success Rate</div>
                                <div class="h5 mb-0 text-success">{{ number_format($conversionRate, 1) }}%</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small">Total Products</div>
                                <div class="h5 mb-0 text-primary">{{ DB::table('products')->count() }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small">Total Customers</div>
                                <div class="h5 mb-0 text-info">{{ DB::table('users')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer & Geographic Analytics Section --}}
    <div class="section-header mt-4">
        <h3><i class="feather-users"></i> Customer & Geographic Insights</h3>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Customers</h4>
                    <p class="text-muted mb-3">Latest registered customers</p>
                    <div class="table-responsive">
                        <table class="table table-modern table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($recentCustomers) > 0)
                                    @foreach ($recentCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($customer->image && file_exists(public_path($customer->image)))
                                                        <img src="{{ $customer->image }}" alt="avatar"
                                                            class="rounded-circle mr-2"
                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                            style="width: 32px; height: 32px; background: #e9ecef; color: #627898; font-weight: 600;">
                                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="font-weight-semibold">{{ $customer->name }}</div>
                                                        <small class="text-muted">{{ $customer->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-medium">{{ $customer->phone }}</div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($customer->address, 30) }}</small>
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ date('M j, Y', strtotime($customer->created_at)) }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="feather-users" style="font-size: 32px; opacity: 0.3;"></i>
                                            <p class="mt-2 mb-0">No customers found</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customer Sources</h4>
                    <p class="text-muted mb-3">Acquisition channels</p>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th class="text-right">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($ordersBySource) > 0)
                                    @foreach ($ordersBySource as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-modern badge-primary mr-2">
                                                        {{ strtoupper(substr($order->customerSourceType->title ?? 'Unknown', 0, 2)) }}
                                                    </span>
                                                    {{ $order->customerSourceType->title ?? 'Unknown' }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <span class="badge badge-soft-primary">{{ $order->order_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No data available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Geographic Analytics --}}
    <div class="row mt-3">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Cities</h4>
                    <p class="text-muted mb-3">Orders by city</p>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>City</th>
                                    <th class="text-right">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cityOrders) > 0)
                                    @foreach ($cityOrders as $index => $cityOrder)
                                        <tr>
                                            <td>
                                                <span class="font-weight-medium">
                                                    @if ($index < 3)
                                                        <i class="fas fa-medal mr-1"
                                                            style="color: {{ $index == 0 ? '#FFD700' : ($index == 1 ? '#C0C0C0' : '#CD7F32') }}"></i>
                                                    @endif
                                                    {{ $cityOrder->city }}
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <span class="badge badge-soft-info">{{ $cityOrder->order_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No data available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Thanas</h4>
                    <p class="text-muted mb-3">Orders by thana</p>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Thana</th>
                                    <th class="text-right">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($thanaOrders) > 0)
                                    @foreach ($thanaOrders as $index => $thanaOrder)
                                        <tr>
                                            <td>
                                                <span class="font-weight-medium">
                                                    @if ($index < 3)
                                                        <i class="fas fa-medal mr-1"
                                                            style="color: {{ $index == 0 ? '#FFD700' : ($index == 1 ? '#C0C0C0' : '#CD7F32') }}"></i>
                                                    @endif
                                                    {{ $thanaOrder->thana }}
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <span
                                                    class="badge badge-soft-success">{{ $thanaOrder->order_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No data available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Transactions</h4>
                    <p class="text-muted mb-3">Latest payment activities</p>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Transaction</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($orderPayments) > 0)
                                    @foreach ($orderPayments->take(5) as $payment)
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="font-weight-medium" style="font-size: 12px;">
                                                        {{ Str::limit($payment->tran_id, 15) }}</div>
                                                    <small class="text-muted">{{ $payment->payment_through }}</small>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="font-weight-semibold">
                                                    ৳{{ number_format($payment->amount, 2) }}</div>
                                                <small
                                                    class="text-{{ $payment->status == 'Success' ? 'success' : 'danger' }}">
                                                    {{ $payment->status }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No transactions found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        /**
         * Modern Dashboard Analytics with Chart.js
         * Senior Developer Implementation - Production Ready
         */

        // Global Chart Configuration
        Chart.defaults.font.family = "'Inter', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif";
        Chart.defaults.color = '#858796';
        Chart.defaults.plugins.legend.display = true;
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0,0,0,0.9)';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;

        const chartColors = {
            primary: '#4e73df',
            secondary: '#858796',
            success: '#1cc88a',
            danger: '#e74a3b',
            warning: '#f6c23e',
            info: '#36b9cc',
            purple: '#6f42c1',
            teal: '#20c9a6',
            orange: '#fd7e14',
            gradient1: ['#667eea', '#764ba2'],
            gradient2: ['#f093fb', '#f5576c'],
            gradient3: ['#4facfe', '#00f2fe']
        };

        /**
         * Create Gradient Background
         */
        function createGradient(ctx, color1, color2) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, color1);
            gradient.addColorStop(1, color2);
            return gradient;
        }

        /**
         * Revenue Trend Line Chart (Enhanced)
         */
        function initRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            const gradient = createGradient(ctx.getContext('2d'), 'rgba(102, 126, 234, 0.4)', 'rgba(102, 126, 234, 0.01)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @for ($i = 8; $i >= 0; $i--)
                            '{{ $countOrdersRatioDate[$i] }}'
                            {{ $i > 0 ? ',' : '' }}
                        @endfor
                    ],
                    datasets: [{
                        label: 'Revenue (৳)',
                        data: [
                            @for ($i = 8; $i >= 0; $i--)
                                {{ $totalOrderAmount[$i] }}{{ $i > 0 ? ',' : '' }}
                            @endfor
                        ],
                        borderColor: chartColors.gradient1[0],
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: chartColors.gradient1[0],
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: ৳' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '৳' + (value / 1000).toFixed(0) + 'k';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        /**
         * Orders Performance Bar Chart
         */
        function initOrdersChart() {
            const ctx = document.getElementById('ordersChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @for ($i = 8; $i >= 0; $i--)
                            '{{ $countOrdersRatioDate[$i] }}'
                            {{ $i > 0 ? ',' : '' }}
                        @endfor
                    ],
                    datasets: [{
                        label: 'Successful Orders',
                        data: [
                            @for ($i = 8; $i >= 0; $i--)
                                {{ $countOrdersRatioSuccess[$i] }}{{ $i > 0 ? ',' : '' }}
                            @endfor
                        ],
                        backgroundColor: chartColors.success,
                        borderRadius: 8,
                        borderSkipped: false
                    }, {
                        label: 'Failed Orders',
                        data: [
                            @for ($i = 8; $i >= 0; $i--)
                                {{ $countOrdersRatioFailed[$i] }}{{ $i > 0 ? ',' : '' }}
                            @endfor
                        ],
                        backgroundColor: chartColors.danger,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            stacked: false
                        }
                    }
                }
            });
        }

        /**
         * Top Products Doughnut Chart (Enhanced)
         */
        function initProductsChart() {
            const ctx = document.getElementById('productsChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        '{{ isset($bestSelling[0]) ? Str::limit($bestSelling[0]->name, 20) : 'N/A' }}',
                        '{{ isset($bestSelling[1]) ? Str::limit($bestSelling[1]->name, 20) : 'N/A' }}',
                        '{{ isset($bestSelling[2]) ? Str::limit($bestSelling[2]->name, 20) : 'N/A' }}',
                        '{{ isset($bestSelling[3]) ? Str::limit($bestSelling[3]->name, 20) : 'N/A' }}',
                        '{{ isset($bestSelling[4]) ? Str::limit($bestSelling[4]->name, 20) : 'N/A' }}'
                    ],
                    datasets: [{
                        data: [
                            {{ isset($bestSelling[0]) ? $bestSelling[0]->total_qty : 0 }},
                            {{ isset($bestSelling[1]) ? $bestSelling[1]->total_qty : 0 }},
                            {{ isset($bestSelling[2]) ? $bestSelling[2]->total_qty : 0 }},
                            {{ isset($bestSelling[3]) ? $bestSelling[3]->total_qty : 0 }},
                            {{ isset($bestSelling[4]) ? $bestSelling[4]->total_qty : 0 }}
                        ],
                        backgroundColor: [
                            chartColors.primary,
                            chartColors.success,
                            chartColors.warning,
                            chartColors.info,
                            chartColors.purple
                        ],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' units';
                                }
                            }
                        }
                    }
                }
            });
        }

        /**
         * Customer Growth Line Chart
         */
        function initCustomerGrowthChart() {
            const ctx = document.getElementById('customerGrowthChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @for ($i = 8; $i >= 0; $i--)
                            '{{ $countOrdersRatioDate[$i] }}'
                            {{ $i > 0 ? ',' : '' }}
                        @endfor
                    ],
                    datasets: [{
                        label: 'New Customers',
                        data: [
                            @for ($i = 8; $i >= 0; $i--)
                                {{ $registeredUsers[$i] }}{{ $i > 0 ? ',' : '' }}
                            @endfor
                        ],
                        borderColor: chartColors.teal,
                        backgroundColor: 'rgba(32, 201, 166, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        /**
         * Order Status Pie Chart
         */
        function initOrderStatusChart() {
            const ctx = document.getElementById('orderStatusChart');
            if (!ctx) return;

            @php
                $pending = DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_PENDING)->count();
                $approved = DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_APPROVED)->count();
                $delivered = DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_DELIVERED)->count();
                $cancelled = DB::table('orders')->where('order_status', App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order::STATUS_CANCELLED)->count();
            @endphp

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pending', 'Approved', 'Delivered', 'Cancelled'],
                    datasets: [{
                        data: [{{ $pending }}, {{ $approved }}, {{ $delivered }},
                            {{ $cancelled }}
                        ],
                        backgroundColor: [
                            chartColors.warning,
                            chartColors.info,
                            chartColors.success,
                            chartColors.danger
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        /**
         * Sparkline Charts
         */
        function initSparkline(selector, data, color) {
            $(selector).sparkline(data, {
                type: 'line',
                width: '100%',
                height: '60',
                chartRangeMax: Math.max(...data) * 1.2,
                lineColor: color,
                fillColor: color.replace(')', ', 0.15)').replace('rgb', 'rgba'),
                highlightLineColor: 'rgba(0,0,0,.1)',
                highlightSpotColor: color,
                maxSpotColor: color,
                minSpotColor: color,
                spotColor: color,
                lineWidth: 2.5,
                spotRadius: 3
            });
        }

        /**
         * Initialize All Charts
         */
        $(document).ready(function() {
            // Initialize Chart.js charts
            initRevenueChart();
            initOrdersChart();
            initProductsChart();
            initCustomerGrowthChart();
            initOrderStatusChart();

            // Initialize Sparklines
            initSparkline('#sparkline-revenue', [
                @for ($i = 8; $i >= 0; $i--)
                    {{ $totalOrderAmount[$i] }}{{ $i > 0 ? ',' : '' }}
                @endfor
            ], '#667eea');
            initSparkline('#sparkline-orders', [
                @for ($i = 8; $i >= 0; $i--)
                    {{ $countOrders[$i] }}{{ $i > 0 ? ',' : '' }}
                @endfor
            ], '#4e73df');
            initSparkline('#sparkline-today', [
                @for ($i = 8; $i >= 0; $i--)
                    {{ $todaysOrder[$i] }}{{ $i > 0 ? ',' : '' }}
                @endfor
            ], '#e74a3b');
            initSparkline('#sparkline-users', [
                @for ($i = 8; $i >= 0; $i--)
                    {{ $registeredUsers[$i] }}{{ $i > 0 ? ',' : '' }}
                @endfor
            ], '#1cc88a');

            @php
                $aovData = [];
                for ($i = 8; $i >= 0; $i--) {
                    $aovData[] = $countOrders[$i] > 0 ? round($totalOrderAmount[$i] / $countOrders[$i], 2) : 0;
                }
            @endphp
            initSparkline('#sparkline-aov', [{{ implode(',', $aovData) }}], '#f6c23e');
        });
    </script>
@endsection
