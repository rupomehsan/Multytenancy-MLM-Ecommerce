@extends('tenant.admin.layouts.app')

@section('header_css')
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
    <div class="mlm-grid">

        {{-- LEVEL REFERRAL CARDS --}}
        <div class="mlm-col-4">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Level 1 Referrals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-primary"><i class="fa fa-users"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $level1 ?? 0 }}</h2>
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
                            <h2 class="mt-0 mb-0">{{ $level2 ?? 0 }}</h2>
                            <small class="text-muted">Team Referrals</small>
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
                        <div class="icon-bubble bg-warning"><i class="fa fa-users"></i></div>
                        <div>
                            <h2 class="mt-0 mb-0">{{ $level3 ?? 0 }}</h2>
                            <small class="text-muted">Extended Referrals</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- COMMISSIONS + WITHDRAWALS --}}
    <div class="mlm-grid mt-4">

        <div class="mlm-col-6">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Total Commissions Distributed</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-info"><i class="fa fa-money-bill"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ $totalCommission ?? 0 }}</h2>
                            <small class="text-muted">All-time distributed commissions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mlm-col-6">
            <div class="card graph_card">
                <div class="card-body">
                    <h4 class="card-title">Pending Withdrawals</h4>
                    <div class="metric">
                        <div class="icon-bubble bg-danger"><i class="fa fa-spinner"></i></div>
                        <div>
                            <h2 class="mt-0 mb-1">৳ {{ $pendingWithdrawals ?? 0 }}</h2>
                            <small class="text-muted">Awaiting approval</small>
                        </div>
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
                                    <th>User</th>
                                    <th>Level 1</th>
                                    <th>Level 2</th>
                                    <th>Level 3</th>
                                    <th>Total Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topEarners ?? [] as $earner)
                                    <tr>
                                        <td>{{ $earner->name }}</td>
                                        <td>{{ $earner->level1_count }}</td>
                                        <td>{{ $earner->level2_count }}</td>
                                        <td>{{ $earner->level3_count }}</td>
                                        <td><span class="badge badge-pill"
                                                style="background:linear-gradient(90deg,var(--mlm-accent-1),var(--mlm-accent-2));color:#fff;font-weight:700;">৳
                                                {{ $earner->total_earned }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    {{-- RECENT REFERRAL ACTIVITIES --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Referral Activities</h4>

                    <ul class="list-group mt-3">
                        @forelse($recentActivities ?? [] as $activity)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $activity->user_name }}</strong>
                                    <div class="muted">From Level {{ $activity->level }} •
                                        <small>{{ $activity->created_at->diffForHumans() }}</small></div>
                                </div>
                                <div>
                                    <span class="badge badge-pill"
                                        style="background:linear-gradient(90deg,var(--mlm-accent-1),var(--mlm-accent-2));color:#fff;padding:8px 12px;font-weight:700;">৳
                                        {{ $activity->commission_amount }}</span>
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
@endsection
