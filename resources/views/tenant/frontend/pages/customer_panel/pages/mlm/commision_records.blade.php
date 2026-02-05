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

        /* Summary Cards */
        .mlm-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .mlm-summary-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .mlm-summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .mlm-summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .mlm-summary-card.total::before {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .mlm-summary-card.pending::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .mlm-summary-card.available::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .mlm-summary-label {
            font-size: 14px;
            color: var(--gray-600);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mlm-summary-label i {
            font-size: 18px;
        }

        .mlm-summary-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .mlm-summary-change {
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .mlm-summary-change.positive {
            color: var(--success-color);
        }

        .mlm-summary-change.negative {
            color: var(--danger-color);
        }

        /* Content Card */
        .mlm-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .mlm-card-header {
            padding: 24px;
            border-bottom: 2px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
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

        /* Filters */
        .mlm-filters {
            padding: 24px;
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-100);
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .mlm-filter-group {
            flex: 1;
            min-width: 180px;
        }

        .mlm-filter-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
        }

        .mlm-filter-group select,
        .mlm-filter-group input {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }

        .mlm-filter-group select:focus,
        .mlm-filter-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
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
        }

        .mlm-btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .mlm-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
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

        /* Header action buttons - responsive stacking on small screens */
        .mlm-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .mlm-header-actions .mlm-header-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .mlm-card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .mlm-header-actions {
                flex-direction: column;
                width: 100%;
            }

            .mlm-header-actions .mlm-header-btn {
                width: 100%;
                justify-content: center;
                padding: 12px 14px;
            }
        }

        /* Table */
        .mlm-table-wrapper {
            overflow-x: auto;
        }

        .mlm-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mlm-table thead {
            background: var(--gray-50);
        }

        .mlm-table th {
            padding: 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--gray-200);
            white-space: nowrap;
        }

        .mlm-table td {
            padding: 16px;
            font-size: 14px;
            color: var(--gray-800);
            border-bottom: 1px solid var(--gray-100);
        }

        .mlm-table tbody tr {
            transition: background 0.2s;
        }

        .mlm-table tbody tr:hover {
            background: var(--gray-50);
        }

        /* Status Badges */
        .mlm-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .mlm-status-badge.approved {
            background: #d1fae5;
            color: #065f46;
        }

        .mlm-status-badge.approved::before {
            content: '●';
            color: #10b981;
        }

        .mlm-status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .mlm-status-badge.pending::before {
            content: '●';
            color: #f59e0b;
        }

        .mlm-status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .mlm-status-badge.rejected::before {
            content: '●';
            color: #ef4444;
        }

        .mlm-type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .mlm-amount {
            font-weight: 700;
            font-size: 15px;
        }

        .mlm-amount.positive {
            color: var(--success-color);
        }

        .mlm-reference {
            font-size: 12px;
            color: var(--gray-600);
        }

        /* Pagination */
        .mlm-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-top: 2px solid var(--gray-100);
            flex-wrap: wrap;
            gap: 16px;
        }

        .mlm-pagination-info {
            font-size: 14px;
            color: var(--gray-600);
        }

        .mlm-pagination-buttons {
            display: flex;
            gap: 8px;
        }

        .mlm-pagination-btn {
            padding: 8px 14px;
            border: 2px solid var(--gray-200);
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            transition: all 0.3s;
        }

        .mlm-pagination-btn:hover:not(:disabled) {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .mlm-pagination-btn.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
        }

        .mlm-pagination-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Empty State */
        .mlm-empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-600);
        }

        .mlm-empty-state i {
            font-size: 80px;
            color: var(--gray-300);
            margin-bottom: 20px;
        }

        .mlm-empty-state h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 12px;
        }

        .mlm-empty-state p {
            font-size: 16px;
            margin-bottom: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mlm-summary-grid {
                grid-template-columns: 1fr;
            }

            .mlm-filters {
                flex-direction: column;
            }

            .mlm-filter-group {
                min-width: 100%;
            }

            .mlm-table {
                font-size: 12px;
            }

            .mlm-table th,
            .mlm-table td {
                padding: 12px 8px;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Page Header -->
    <div class="mlm-page-header">
        <h1><i class="fi-rr-sack-dollar"></i> {{ __('customer.commission_history') }}</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">{{ __('customer.home') }}</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">{{ __('customer.dashboard') }}</a>
            <span>/</span>
            <span>{{ __('customer.commission_history') }}</span>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mlm-summary-grid">
        <div class="mlm-summary-card total">
            <div class="mlm-summary-label">
                <i class="fi-rr-sack-dollar"></i>
                {{ __('customer.total_earned') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($totalEarned ?? 0, 2) }}</div>
            <div class="mlm-summary-change positive">
                <i class="fi-rr-check"></i>
                {{ __('customer.approved_paid') }}
            </div>
        </div>

        <div class="mlm-summary-card pending">
            <div class="mlm-summary-label">
                <i class="fi-rr-clock"></i>
                {{ __('customer.pending_approval') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($pending ?? 0, 2) }}</div>
            <div class="mlm-summary-change">
                {{ $pendingCount ?? 0 }} {{ __('customer.transactions_pending') }}
            </div>
        </div>

        <div class="mlm-summary-card available">
            <div class="mlm-summary-label">
                <i class="fi-rr-wallet"></i>
                {{ __('customer.available_balance') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($availableBalance ?? 0, 2) }}</div>
            <div class="mlm-summary-change positive">
                <i class="fi-rr-check"></i>
                {{ __('customer.withdraw') }}
            </div>
        </div>
    </div>

    <!-- Content Card -->
    <div class="mlm-content-card">
        <!-- Card Header -->
        <div class="mlm-card-header">
            <h2 class="mlm-card-title">
                <i class="fi-rr-list"></i>
                {{ __('customer.all_commissions') }}
            </h2>
            <div class="mlm-header-actions">
                <button type="button" class="mlm-btn mlm-btn-outline mlm-header-btn" onclick="exportCommissions()">
                    <i class="fi-rr-download"></i> {{ __('customer.export') }}
                </button>
                <button type="button" class="mlm-btn mlm-btn-primary mlm-header-btn" onclick="window.location.href='{{ url('/customer/mlm/withdrawal-requests') }}'">
                    <i class="fi-rr-wallet"></i> {{ __('customer.request_withdrawal') }}
                </button>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('customer.mlm.commission_history') }}">
            <div class="mlm-filters">
                <div class="mlm-filter-group">
                    <label for="statusFilter">{{ __('customer.status') }}</label>
                    <select id="statusFilter" name="status">
                        <option value="">{{ __('customer.all_status') }}</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('customer.approved') }}</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('customer.paid') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('customer.pending') }}</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('customer.cancelled') }}</option>
                    </select>
                </div>
                <div class="mlm-filter-group">
                    <label for="levelFilter">{{ __('customer.commission_level') }}</label>
                    <select id="levelFilter" name="level">
                        <option value="">{{ __('customer.all_levels') }}</option>
                        <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>{{ __('customer.level_1_referral') }}</option>
                        <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>{{ __('customer.level') }} 2</option>
                        <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>{{ __('customer.level') }} 3</option>
                    </select>
                </div>
                <div class="mlm-filter-group">
                    <label for="dateFrom">{{ __('customer.from_date') }}</label>
                    <input type="date" id="dateFrom" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="mlm-filter-group">
                    <label for="dateTo">{{ __('customer.to_date') }}</label>
                    <input type="date" id="dateTo" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="mlm-filter-group" style="display: flex; align-items: flex-end; gap: 10px;">
                    <button type="submit" class="mlm-btn mlm-btn-primary">
                        <i class="fi-rr-filter"></i> {{ __('customer.apply_filters') }}
                    </button>
                    <a href="{{ route('customer.mlm.commission_history') }}" class="mlm-btn mlm-btn-outline">
                        <i class="fi-rr-refresh"></i> {{ __('customer.clear') }}
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="mlm-table-wrapper">
            <table id="commissionTable" class="mlm-table">
                <thead>
                    <tr>
                        <th>{{ __('customer.transaction_id') }}</th>
                        <th>{{ __('customer.date_time') }}</th>
                        <th>{{ __('customer.type') }}</th>
                        <th>{{ __('customer.from_member') }}</th>
                        <th>{{ __('customer.amount') }}</th>
                        <th>{{ __('customer.status') }}</th>
                        <th>{{ __('customer.reference') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $commission)
                        <tr>
                            <td><strong>#COM-{{ str_pad($commission->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>
                                {{ \Carbon\Carbon::parse($commission->created_at)->format('M j, Y') }}<br>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($commission->created_at)->format('h:i A') }}</small>
                            </td>
                            <td>
                                <span class="mlm-type-badge">
                                    {{ $commission->level == 1 ? 'Referral' : 'Level ' . $commission->level }}
                                </span>
                            </td>
                            <td>
                                {{ $commission->buyer_name }}<br>
                                <small class="mlm-reference">{{ $commission->buyer_email }}</small>
                            </td>
                            <td>
                                <span
                                    class="mlm-amount positive">৳{{ number_format($commission->commission_amount, 2) }}</span>
                            </td>
                            <td>
                                <span
                                    class="mlm-status-badge {{ $commission->status == 'paid' || $commission->status == 'approved' ? 'approved' : ($commission->status == 'pending' ? 'pending' : 'rejected') }}">
                                    {{ ucfirst($commission->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($commission->order_no && $commission->order_slug)
                                    <span class="mlm-reference">Order #{{ $commission->order_no }}</span>
                                @else
                                    <span class="mlm-reference">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 40px;">
                                <i class="fi-rr-sack-dollar" style="font-size: 48px; color: var(--gray-300);"></i>
                                <p style="margin-top: 16px; color: var(--gray-600);">{{ __('customer.no_commissions') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($commissions->total() > 0)
            <div class="mlm-pagination">
                <div class="mlm-pagination-info">
                    {{ __('customer.showing') }} {{ $commissions->firstItem() ?? 0 }} {{ __('customer.to') }} {{ $commissions->lastItem() ?? 0 }} {{ __('customer.of') }}
                    {{ $commissions->total() }} {{ __('customer.entries') }}
                </div>
                @if ($commissions->hasPages())
                    <div class="mlm-pagination-buttons">
                        @if ($commissions->onFirstPage())
                            <button class="mlm-pagination-btn" disabled>
                                <i class="fi-rr-angle-left"></i>
                            </button>
                        @else
                            <a href="{{ $commissions->appends(request()->query())->previousPageUrl() }}"
                                class="mlm-pagination-btn">
                                <i class="fi-rr-angle-left"></i>
                            </a>
                        @endif

                        @foreach ($commissions->appends(request()->query())->getUrlRange(1, $commissions->lastPage()) as $page => $url)
                            @if ($page == $commissions->currentPage())
                                <button class="mlm-pagination-btn active">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="mlm-pagination-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($commissions->hasMorePages())
                            <a href="{{ $commissions->appends(request()->query())->nextPageUrl() }}"
                                class="mlm-pagination-btn">
                                <i class="fi-rr-angle-right"></i>
                            </a>
                        @else
                            <button class="mlm-pagination-btn" disabled>
                                <i class="fi-rr-angle-right"></i>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <!-- DataTables will handle pagination -->
    </div>

    <!-- Empty State (Show when no data) -->
    <!-- <div class="mlm-content-card">
                                    <div class="mlm-empty-state">
                                        <i class="fi-rr-sack-dollar"></i>
                                        <h3>No Commission Records</h3>
                                        <p>Your commission history will appear here once you start earning</p>
                                        <button class="mlm-btn mlm-btn-primary" onclick="window.location.href='{{ url('/customer/mlm/referral-list') }}'">
                                            <i class="fi-rr-users-alt"></i> View Your Network
                                        </button>
                                    </div>
                                </div> -->
@endsection

@section('page_js')
    <script>
        function exportCommissions() {
            alert('Export commission history as CSV/Excel - Feature coming soon!');
            // TODO: Implement export logic
        }
    </script>
@endsection
