@extends('tenant.admin.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
    <style>
        /* Modern MLM Dashboard Styles */
        :root {
            --mlm-accent-1: #667eea;
            --mlm-accent-2: #764ba2;
            --card-bg: rgba(255, 255, 255, 0.85);
            --muted: #6b7280;
        }

        .mlm-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1rem;
        }

        .mlm-col-4 {
            grid-column: span 4;
        }

        .mlm-col-6 {
            grid-column: span 6;
        }

        .mlm-col-12 {
            grid-column: span 12;
        }

        h4.card-title {
            font-size: 13px;
            margin: 0 0 8px 0;
            padding: 6px 10px;
            color: #0f172a;
            font-weight: 700;
            letter-spacing: 0.6px;
        }

        .graph_card {
            position: relative;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.55));
            border: 1px solid rgba(15, 23, 42, 0.04);
            border-radius: 12px;
            padding: 18px;
            transition: transform .18s ease, box-shadow .18s ease;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        .graph_card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .graph_card .metric {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .graph_card .metric .icon-bubble {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--mlm-accent-1), var(--mlm-accent-2));
            box-shadow: 0 6px 18px rgba(118, 75, 162, 0.12);
        }

        .graph_card h2 {
            font-size: 28px;
            margin: 0;
            color: #0b1220;
            font-weight: 700;
        }

        .graph_card small {
            color: var(--muted);
            display: block;
            margin-top: 6px;
        }

        /* card icon variants */
        .graph_card .icon-bubble.bg-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .graph_card .icon-bubble.bg-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .graph_card .icon-bubble.bg-warning {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }

        .graph_card .icon-bubble.bg-info {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .graph_card .icon-bubble.bg-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        /* Table modern styling */
        .table thead th {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.03));
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.03);
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* Recent activities list */
        .list-group-item {
            border: none;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .list-group-item strong {
            display: block;
            font-weight: 700;
            color: #0b1220;
        }

        .list-group-item .muted {
            color: var(--muted);
        }

        /* Responsive fallback for older layouts */
        @media(max-width:991px) {

            .mlm-col-4,
            .mlm-col-6,
            .mlm-col-12 {
                grid-column: 1 / -1;
            }
        }
    </style>
@endsection

@section('page_title')
    Dashboard
@endsection

@section('page_heading')
    Overview
@endsection
@section('content')
    {{-- KEY STATISTICS CARDS --}}
    <div class="mlm-grid">
        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Total Users</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-primary"><i class="fa fa-users"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $stats['total_users'] }}</h2>
                            <small class="text-muted">Registered Users</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Active Referrers</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-success"><i class="fa fa-user-check"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $stats['active_referrers'] }}</h2>
                            <small class="text-muted">Earning Members</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Total Referrals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-info"><i class="fa fa-user-plus"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $stats['total_referrals'] }}</h2>
                            <small class="text-muted">All Levels</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- COMMISSION STATISTICS --}}
    <div class="mlm-grid mt-4">
        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Total Commissions</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-primary"><i class="fa fa-chart-line"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['total_commissions'], 2) }}</h2>
                            <small class="text-muted">All-time Total</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Approved Commissions</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-success"><i class="fa fa-check-circle"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['approved_commissions'], 2) }}</h2>
                            <small class="text-muted">Credited to Wallets</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Pending Commissions</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-warning"><i class="fa fa-clock"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['pending_commissions'], 2) }}</h2>
                            <small class="text-muted">Awaiting Approval</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- WITHDRAWAL STATISTICS --}}
    <div class="mlm-grid mt-4">
        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Total Withdrawals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-info"><i class="fa fa-money-bill-wave"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['total_withdrawals'], 2) }}</h2>
                            <small class="text-muted">Paid Out</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Pending Withdrawals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-danger"><i class="fa fa-spinner"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['pending_withdrawals'], 2) }}</h2>
                            <small class="text-muted">{{ $stats['pending_withdrawal_count'] }} Requests</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Wallet Transactions</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-success"><i class="fa fa-wallet"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ number_format($stats['total_wallet_transactions'], 2) }}</h2>
                            <small class="text-muted">Total Activity</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LEVEL-WISE REFERRAL BREAKDOWN --}}
    <div class="mlm-grid mt-4">
        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Level 1 Referrals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-primary"><i class="fa fa-user-friends"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $levelStats['level1'] }}</h2>
                            <small class="text-muted">Direct Referrals</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Level 2 Referrals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-success"><i class="fa fa-users"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $levelStats['level2'] }}</h2>
                            <small class="text-muted">Second Level</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Level 3 Referrals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-warning"><i class="fa fa-user-shield"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $levelStats['level3'] }}</h2>
                            <small class="text-muted">Third Level</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ANALYTICS CHARTS --}}
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Commission Trends (Last 12 Months)</h4>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="commissionTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Level-wise Commission</h4>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="levelCommissionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATUS DISTRIBUTION & RECENT WITHDRAWALS --}}
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Commission Status</h4>
                    <div style="position: relative; height: 250px; width: 100%;">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                    <div class="mt-3">
                        @foreach ($statusDistribution as $status)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $status['status'] }}</span>
                                <span><strong>{{ $status['count'] }}</strong>
                                    (৳{{ number_format($status['total'], 2) }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Withdrawal Requests</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentWithdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal['user_name'] }}</td>
                                        <td>৳{{ $withdrawal['amount'] }}</td>
                                        <td>{{ $withdrawal['payment_method'] ?? 'N/A' }}</td>
                                        <td>
                                            @if ($withdrawal['status'] == 'Pending')
                                                <span class="badge badge-warning">{{ $withdrawal['status'] }}</span>
                                            @elseif($withdrawal['status'] == 'Approved')
                                                <span class="badge badge-success">{{ $withdrawal['status'] }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $withdrawal['status'] }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $withdrawal['created_at']->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No withdrawal requests yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- TOP EARNERS --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Earners</h4>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Wallet Balance</th>
                                    <th>Level 1</th>
                                    <th>Level 2</th>
                                    <th>Level 3</th>
                                    <th>Total Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topEarners as $index => $earner)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $earner->name }}</td>
                                        <td>{{ $earner->email }}</td>
                                        <td>৳{{ number_format($earner->wallet_balance ?? 0, 2) }}</td>
                                        <td><span class="badge badge-primary">{{ $earner->level1_count }}</span></td>
                                        <td><span class="badge badge-success">{{ $earner->level2_count }}</span></td>
                                        <td><span class="badge badge-warning">{{ $earner->level3_count }}</span></td>
                                        <td><span class="badge badge-pill"
                                                style="background:linear-gradient(90deg,var(--mlm-accent-1),var(--mlm-accent-2));color:#fff;font-weight:700;">৳
                                                {{ number_format($earner->total_earned, 2) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    {{-- RECENT COMMISSION ACTIVITIES --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Commission Activities</h4>

                    <ul class="list-group mt-3">
                        @forelse($recentActivities as $activity)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $activity['user_name'] }}</strong>
                                    <div class="muted">
                                        {{ $activity['activity_type'] }} • Level {{ $activity['level'] }} •
                                        <small>{{ $activity['created_at']->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge badge-pill"
                                        style="background:linear-gradient(90deg,var(--mlm-accent-1),var(--mlm-accent-2));color:#fff;padding:8px 12px;font-weight:700;">৳
                                        {{ $activity['commission_amount'] }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">
                                No recent activities
                            </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const safeArray = (v) => Array.isArray(v) ? v : [];
            const toNumberArray = (arr) => safeArray(arr).map(x => {
                const n = Number(x);
                return Number.isFinite(n) ? n : 0;
            });

            const renderEmptyMessage = (canvas, message) => {
                try {
                    const parent = canvas.closest('.card-body') || canvas.parentElement;
                    if (!parent) return;
                    let el = parent.querySelector('.chart-empty-message');
                    if (!el) {
                        el = document.createElement('div');
                        el.className = 'chart-empty-message';
                        el.style.padding = '20px';
                        el.style.textAlign = 'center';
                        el.style.color = '#6b7280';
                        el.style.fontSize = '14px';
                        parent.appendChild(el);
                    }
                    el.textContent = message;
                } catch (e) {
                    console.error('renderEmptyMessage error', e);
                }
            };

            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            // Commission Trend Chart
            try {
                const trendCanvas = document.getElementById('commissionTrendChart');
                if (trendCanvas) {
                    const labels = safeArray(@json($monthlyTrends['labels'] ?? []));
                    const data = toNumberArray(@json($monthlyTrends['data'] ?? []));

                    if (!labels.length || !data.length || data.every(v => v === 0)) {
                        renderEmptyMessage(trendCanvas, 'No commission trend data available');
                    } else {
                        new Chart(trendCanvas, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Commission Amount (৳)',
                                    data: data,
                                    borderColor: 'rgb(102, 126, 234)',
                                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                                    tension: 0.4,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const y = context.parsed && context.parsed.y != null ?
                                                    context.parsed.y : context.parsed;
                                                return '৳' + (y ? Number(y).toFixed(2) : '0.00');
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: v => '৳' + v
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Commission trend chart error', e);
            }

            // Level Commission Chart (Doughnut)
            try {
                const levelCanvas = document.getElementById('levelCommissionChart');
                if (levelCanvas) {
                    const levelDataRaw = @json($levelCommissions ?? []);
                    const labels = safeArray(levelDataRaw).map(i => i.level || 'Level');
                    const data = safeArray(levelDataRaw).map(i => Number(i.total) || 0);

                    if (!labels.length || data.every(v => v === 0)) {
                        renderEmptyMessage(levelCanvas, 'No level commission data available');
                    } else {
                        new Chart(levelCanvas, {
                            type: 'doughnut',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: ['rgb(102, 126, 234)', 'rgb(16, 185, 129)',
                                        'rgb(245, 158, 11)'
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
                                        display: true,
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Level commission chart error', e);
            }

            // Status Distribution Chart
            try {
                const statusCanvas = document.getElementById('statusDistributionChart');
                if (statusCanvas) {
                    const statusRaw = @json($statusDistribution ?? []);
                    const labels = safeArray(statusRaw).map(i => i.status || 'Status');
                    const data = safeArray(statusRaw).map(i => Number(i.count) || 0);

                    if (!labels.length || data.every(v => v === 0)) {
                        renderEmptyMessage(statusCanvas, 'No commission status data available');
                    } else {
                        new Chart(statusCanvas, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: ['rgb(245, 158, 11)', 'rgb(16, 185, 129)',
                                        'rgb(102, 126, 234)', 'rgb(239, 68, 68)'
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
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Status distribution chart error', e);
            }
        });
    </script>
@endsection
