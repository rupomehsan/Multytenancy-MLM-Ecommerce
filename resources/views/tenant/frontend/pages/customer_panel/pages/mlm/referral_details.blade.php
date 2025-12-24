@extends('tenant.frontend.pages.customer_panel.layouts.customer_layouts')

@section('page_css')
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        .mlm-page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .mlm-page-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .mlm-breadcrumb {
            display: flex;
            gap: 8px;
            font-size: 14px;
            opacity: 0.9;
            flex-wrap: wrap;
        }

        .mlm-breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .mlm-breadcrumb a:hover {
            opacity: 0.7;
        }

        .mlm-detail-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .mlm-profile-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .mlm-profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            border: 4px solid var(--gray-200);
            overflow: hidden;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .mlm-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mlm-profile-card h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 8px 0;
        }

        .mlm-profile-card p {
            color: var(--gray-600);
            font-size: 14px;
            margin: 0 0 20px 0;
        }

        .mlm-profile-info {
            text-align: left;
            padding-top: 20px;
            border-top: 2px solid var(--gray-100);
        }

        .mlm-info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .mlm-info-row:last-child {
            border-bottom: none;
        }

        .mlm-info-label {
            font-size: 13px;
            color: var(--gray-600);
            font-weight: 600;
        }

        .mlm-info-value {
            font-size: 14px;
            color: var(--gray-900);
            font-weight: 600;
        }

        .mlm-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .mlm-stat-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
        }

        .mlm-stat-box.success {
            border-left-color: var(--success-color);
        }

        .mlm-stat-box.warning {
            border-left-color: var(--warning-color);
        }

        .mlm-stat-box.info {
            border-left-color: var(--info-color);
        }

        .mlm-stat-box h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 4px 0;
        }

        .mlm-stat-box p {
            font-size: 13px;
            color: var(--gray-600);
            margin: 0;
        }

        .mlm-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .mlm-card-header {
            padding: 24px;
            border-bottom: 2px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mlm-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mlm-btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .mlm-btn-outline {
            background: white;
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .mlm-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Tree Styles */
        .mlm-tree {
            padding: 32px;
            overflow-x: auto;
        }

        .mlm-tree-node {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .mlm-tree-node-content {
            background: white;
            border: 3px solid var(--gray-200);
            border-radius: 16px;
            padding: 20px;
            margin: 0 20px 40px 20px;
            min-width: 200px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .mlm-tree-node-content:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
            transform: translateY(-4px);
        }

        .mlm-tree-node-content.root {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        }

        .mlm-node-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 16px;
            border: 4px solid var(--gray-200);
            overflow: hidden;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .mlm-tree-node-content.root .mlm-node-avatar {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .mlm-node-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mlm-node-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .mlm-node-email {
            font-size: 12px;
            color: var(--gray-600);
            margin-bottom: 8px;
        }

        .mlm-node-level {
            display: inline-block;
            padding: 4px 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .mlm-node-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid var(--gray-100);
        }

        .mlm-node-stat {
            text-align: center;
        }

        .mlm-node-stat-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .mlm-node-stat-label {
            font-size: 10px;
            color: var(--gray-600);
            text-transform: uppercase;
        }

        .mlm-tree-children {
            display: flex;
            justify-content: center;
            gap: 40px;
            position: relative;
        }

        .mlm-tree-children::before {
            content: '';
            position: absolute;
            top: -40px;
            left: 50%;
            width: 2px;
            height: 40px;
            background: var(--gray-300);
            transform: translateX(-50%);
        }

        .mlm-tree-node>.mlm-tree-children>.mlm-tree-node::before {
            content: '';
            position: absolute;
            top: -40px;
            left: 50%;
            width: 2px;
            height: 40px;
            background: var(--gray-300);
        }

        .mlm-tree-node>.mlm-tree-children::after {
            content: '';
            position: absolute;
            top: -40px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gray-300);
        }

        /* Direct Referrals List */
        .mlm-referral-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border-bottom: 1px solid var(--gray-100);
            transition: background 0.2s;
        }

        .mlm-referral-item:hover {
            background: var(--gray-50);
        }

        .mlm-referral-item:last-child {
            border-bottom: none;
        }

        .mlm-referral-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--gray-200);
            flex-shrink: 0;
        }

        .mlm-referral-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mlm-referral-info {
            flex: 1;
        }

        .mlm-referral-info h4 {
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0 0 4px 0;
        }

        .mlm-referral-info p {
            font-size: 13px;
            color: var(--gray-600);
            margin: 0;
        }

        .mlm-referral-date {
            font-size: 12px;
            color: var(--gray-600);
        }

        @media (max-width: 768px) {
            .mlm-detail-grid {
                grid-template-columns: 1fr;
            }

            .mlm-tree-children {
                flex-direction: column;
                gap: 60px;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Page Header -->
    <div class="mlm-page-header">
        <h1><i class="fi-rr-user"></i> Referral Details</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ url('/customer/mlm/referral-list') }}">Referral List</a>
            <span>/</span>
            <span>{{ $referral->name }}</span>
        </div>
    </div>

    <div class="mlm-detail-grid">
        <!-- Profile Card -->
        <div class="mlm-profile-card">
            <div class="mlm-profile-avatar">
                @if ($referral->image)
                    <img src="{{ asset($referral->image) }}" alt="{{ $referral->name }}">
                @else
                    {{ strtoupper(substr($referral->name, 0, 1)) }}
                @endif
            </div>
            <h2>{{ $referral->name }}</h2>
            <p>{{ $referral->email }}</p>

            <div class="mlm-profile-info">
                <div class="mlm-info-row">
                    <span class="mlm-info-label">Member ID</span>
                    <span class="mlm-info-value">#{{ $referral->id }}</span>
                </div>
                <div class="mlm-info-row">
                    <span class="mlm-info-label">Status</span>
                    <span class="mlm-info-value"
                        style="color: {{ $referral->status == 1 ? 'var(--success-color)' : 'var(--danger-color)' }}">
                        {{ $referral->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="mlm-info-row">
                    <span class="mlm-info-label">Phone</span>
                    <span class="mlm-info-value">{{ $referral->phone ?? 'N/A' }}</span>
                </div>
                <div class="mlm-info-row">
                    <span class="mlm-info-label">Joined</span>
                    <span class="mlm-info-value">{{ $referral->created_at->format('M d, Y') }}</span>
                </div>
                @if ($parent)
                    <div class="mlm-info-row">
                        <span class="mlm-info-label">Referred By</span>
                        <span class="mlm-info-value">{{ $parent->name }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div>
            <div class="mlm-stats-grid">
                <div class="mlm-stat-box">
                    <h3>{{ $stats['direct_referrals'] ?? 0 }}</h3>
                    <p>Direct Referrals</p>
                </div>
                <div class="mlm-stat-box success">
                    <h3>{{ $stats['total_network'] ?? 0 }}</h3>
                    <p>Total Network</p>
                </div>
                <div class="mlm-stat-box warning">
                    <h3>{{ $stats['level_1_count'] ?? 0 }}</h3>
                    <p>Level 1 Members</p>
                </div>
                <div class="mlm-stat-box info">
                    <h3>{{ ($stats['level_2_count'] ?? 0) + ($stats['level_3_count'] ?? 0) }}</h3>
                    <p>Level 2-3 Members</p>
                </div>
            </div>

            <!-- Back Button -->
            <a href="{{ url('/customer/mlm/referral-lists') }}" class="mlm-btn mlm-btn-outline">
                <i class="fi-rr-angle-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Referral Network Tree -->
    <div class="mlm-content-card">
        <div class="mlm-card-header">
            <h2 class="mlm-card-title">
                <i class="fi-rr-sitemap"></i>
                Network Tree
            </h2>
        </div>
        <div class="mlm-tree">
            @if (isset($tree) && !empty($tree))
                @include('tenant.frontend.pages.customer_panel.pages.mlm.partials._tree_node', [
                    'node' => $tree,
                    'depth' => 0,
                ])
            @else
                <div style="text-align: center; padding: 40px; color: var(--gray-600);">
                    <i class="fi-rr-sitemap" style="font-size: 48px; opacity: 0.3;"></i>
                    <p style="margin-top: 16px;">No referrals yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Direct Referrals List -->
    <div class="mlm-content-card">
        <div class="mlm-card-header">
            <h2 class="mlm-card-title">
                <i class="fi-rr-users-alt"></i>
                Direct Referrals ({{ $directReferrals->count() }})
            </h2>
        </div>
        <div>
            @forelse($directReferrals as $direct)
                <div class="mlm-referral-item">
                    <div class="mlm-referral-avatar">
                        @if ($direct->image)
                            <img src="{{ asset($direct->image) }}" alt="{{ $direct->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($direct->name) }}&background=667eea&color=fff"
                                alt="{{ $direct->name }}">
                        @endif
                    </div>
                    <div class="mlm-referral-info">
                        <h4>{{ $direct->name }}</h4>
                        <p>{{ $direct->email }}</p>
                    </div>
                    <div class="mlm-referral-date">
                        Joined: {{ $direct->created_at->format('M d, Y') }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: var(--gray-600);">
                    <i class="fi-rr-users-alt" style="font-size: 48px; opacity: 0.3;"></i>
                    <p style="margin-top: 16px;">No direct referrals yet</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
