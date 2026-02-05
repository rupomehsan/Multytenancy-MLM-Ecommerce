@extends('tenant.admin.layouts.app')

@section('header_css')
    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }

        .tree-container {
            padding: 25px;
            overflow-x: auto;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            padding-left: 0;
            display: flex;
            justify-content: center;
        }

        .tree li {
            list-style-type: none;
            margin: 0 25px;
            text-align: center;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #cbd5e0;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #cbd5e0;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 1px solid #cbd5e0;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree li div {
            padding: 10px 20px;
            display: inline-block;
            background: #17263A;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            min-width: 170px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .level-tag {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            opacity: 0.75;
        }

        .stats-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .stats-card .stat-item {
            display: inline-block;
            margin-right: 20px;
        }

        .stats-card .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #17263A;
        }

        .stats-card .stat-label {
            font-size: 13px;
            color: #6c757d;
        }
    </style>
@endsection

@section('page_title')
    Referral Tree
@endsection

@section('page_heading')
    Referral Management
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Referral Tree (3 Level Structure)</h4>

            @if (isset($stats))
                <div class="stats-card">
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['total_referrals'] ?? 0 }}</div>
                        <div class="stat-label">Total Referrals</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['level1_count'] ?? 0 }}</div>
                        <div class="stat-label">Level 1</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['level2_count'] ?? 0 }}</div>
                        <div class="stat-label">Level 2</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['level3_count'] ?? 0 }}</div>
                        <div class="stat-label">Level 3</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($stats['total_commission'] ?? 0, 2) }} BDT</div>
                        <div class="stat-label">Total Commission</div>
                    </div>
                </div>
            @endif

            <div class="tree-container">
                <div class="tree">
                    <ul>
                        <li>
                            <div>
                                <strong>{{ $rootCustomer->name ?? 'Root User' }}</strong>
                                <span class="level-tag">Root (#{{ $rootCustomer->id ?? '' }})</span>
                            </div>

                            @if (isset($tree['children']) && count($tree['children']) > 0)
                                <ul>
                                    @foreach ($tree['children'] as $level1)
                                        <li>
                                            <div>
                                                <strong>{{ $level1['name'] }}</strong>
                                                <span class="level-tag">Level 1 (#{{ $level1['id'] }})</span>
                                                @if (isset($level1['direct_count']))
                                                    <span class="level-tag">Direct: {{ $level1['direct_count'] }}</span>
                                                @endif
                                            </div>

                                            @if (isset($level1['children']) && count($level1['children']) > 0)
                                                <ul>
                                                    @foreach ($level1['children'] as $level2)
                                                        <li>
                                                            <div>
                                                                <strong>{{ $level2['name'] }}</strong>
                                                                <span class="level-tag">Level 2
                                                                    (#{{ $level2['id'] }})
                                                                </span>
                                                                @if (isset($level2['direct_count']))
                                                                    <span class="level-tag">Direct:
                                                                        {{ $level2['direct_count'] }}</span>
                                                                @endif
                                                            </div>

                                                            @if (isset($level2['children']) && count($level2['children']) > 0)
                                                                <ul>
                                                                    @foreach ($level2['children'] as $level3)
                                                                        <li>
                                                                            <div>
                                                                                <strong>{{ $level3['name'] }}</strong>
                                                                                <span class="level-tag">Level 3
                                                                                    (#{{ $level3['id'] }})
                                                                                </span>
                                                                                @if (isset($level3['direct_count']))
                                                                                    <span class="level-tag">Direct:
                                                                                        {{ $level3['direct_count'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center mt-3 text-muted">
                                    <p>No referrals yet</p>
                                </div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer_js')
@endsection
