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
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .mlm-summary-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
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

        .mlm-summary-card.available::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .mlm-summary-card.pending::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .mlm-summary-card.completed::before {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .mlm-summary-card.rejected::before {
            background: linear-gradient(90deg, #ef4444, #dc2626);
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
            font-size: 32px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .mlm-summary-subtitle {
            font-size: 13px;
            color: var(--gray-600);
        }

        /* Content Card */
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

        .mlm-btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .mlm-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
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

        .mlm-status-badge.completed {
            background: #d1fae5;
            color: #065f46;
        }

        .mlm-status-badge.completed::before {
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

        .mlm-status-badge.processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .mlm-status-badge.processing::before {
            content: '●';
            color: #3b82f6;
        }

        .mlm-amount {
            font-weight: 700;
            font-size: 15px;
            color: var(--gray-900);
        }

        /* Modal */
        .mlm-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s;
        }

        .mlm-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mlm-modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .mlm-modal-header {
            padding: 28px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mlm-modal-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mlm-modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mlm-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .mlm-modal-body {
            padding: 32px;
        }

        .mlm-form-group {
            margin-bottom: 24px;
        }

        .mlm-form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 10px;
        }

        .mlm-form-label span {
            color: var(--danger-color);
        }

        .mlm-form-input,
        .mlm-form-select,
        .mlm-form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
        }

        .mlm-form-input:focus,
        .mlm-form-select:focus,
        .mlm-form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .mlm-form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .mlm-form-help {
            font-size: 12px;
            color: var(--gray-600);
            margin-top: 6px;
        }

        .mlm-balance-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 2px solid var(--primary-color);
        }

        .mlm-balance-info h4 {
            font-size: 14px;
            color: var(--gray-700);
            margin: 0 0 8px 0;
        }

        .mlm-balance-info .amount {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .mlm-modal-footer {
            padding: 20px 32px;
            border-top: 2px solid var(--gray-100);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
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

        /* Alert Messages */
        .mlm-alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .mlm-alert.success {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #10b981;
        }

        .mlm-alert.error {
            background: #fee2e2;
            color: #991b1b;
            border: 2px solid #ef4444;
        }

        .mlm-alert i {
            font-size: 20px;
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

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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

            .mlm-modal-content {
                width: 95%;
                margin: 20px;
            }

            .mlm-modal-body {
                padding: 24px;
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
        <h1><i class="fi-rr-wallet"></i> {{ __('customer.withdrawal_requests') }}</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">{{ __('customer.home') }}</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">{{ __('customer.dashboard') }}</a>
            <span>/</span>
            <span>{{ __('customer.withdrawal_requests') }}</span>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mlm-summary-grid">
        <div class="mlm-summary-card available">
            <div class="mlm-summary-label">
                <i class="fi-rr-piggy-bank"></i>
                {{ __('customer.available_balance') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($availableBalance, 2) }}</div>
            <div class="mlm-summary-subtitle">{{ __('customer.withdraw') }}</div>
        </div>

        <div class="mlm-summary-card pending">
            <div class="mlm-summary-label">
                <i class="fi-rr-clock"></i>
                {{ __('customer.pending_orders') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($pendingAmount, 2) }}</div>
            <div class="mlm-summary-subtitle">{{ $pendingCount }} {{ __('customer.pending') }}
            </div>
        </div>

        <div class="mlm-summary-card completed">
            <div class="mlm-summary-label">
                <i class="fi-rr-check-circle"></i>
                {{ __('customer.total_commission') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($totalWithdrawn, 2) }}</div>
            <div class="mlm-summary-subtitle">{{ __('customer.total') }}</div>
        </div>

        <div class="mlm-summary-card rejected">
            <div class="mlm-summary-label">
                <i class="fi-rr-cross-circle"></i>
                {{ __('customer.cancelled') }}
            </div>
            <div class="mlm-summary-value">৳{{ number_format($rejectedAmount, 2) }}</div>
            <div class="mlm-summary-subtitle">{{ $rejectedCount }} {{ __('customer.cancelled') }}
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mlm-alert success">
            <i class="fi-rr-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mlm-alert error">
            <i class="fi-rr-cross-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Content Card -->
    <div class="mlm-content-card">
        <!-- Card Header -->
        <div class="mlm-card-header">
            <h2 class="mlm-card-title">
                <i class="fi-rr-list"></i>
                {{ __('customer.withdrawal_history') }}
            </h2>
            <button class="mlm-btn mlm-btn-success" onclick="openWithdrawalModal()">
                <i class="fi-rr-plus"></i> {{ __('customer.request_withdrawal') }}
            </button>
        </div>

        <!-- Filters -->
        <div class="mlm-filters">
            <form method="GET" action="{{ route('customer.mlm.withdrawal_requests') }}" style="display: contents;">
                <div class="mlm-filter-group">
                    <label for="statusFilter">{{ __('customer.status') }}</label>
                    <select id="statusFilter" name="status" onchange="this.form.submit()">
                        <option value="">{{ __('customer.all_status') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('customer.pending') }}</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('customer.processing') }}
                        </option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('customer.approved') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('customer.completed') }}
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('customer.cancelled') }}</option>
                    </select>
                </div>
                <div class="mlm-filter-group">
                    <label for="dateFrom">{{ __('customer.from_date') }}</label>
                    <input type="date" id="dateFrom" name="date_from" value="{{ request('date_from') }}"
                        onchange="this.form.submit()">
                </div>
                <div class="mlm-filter-group">
                    <label for="dateTo">{{ __('customer.to_date') }}</label>
                    <input type="date" id="dateTo" name="date_to" value="{{ request('date_to') }}"
                        onchange="this.form.submit()">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="mlm-table-wrapper">
            <table class="mlm-table">
                <thead>
                    <tr>
                        <th>{{ __('customer.order_id') }}</th>
                        <th>{{ __('customer.date') }}</th>
                        <th>{{ __('customer.amount') }}</th>
                        <th>{{ __('customer.method') }}</th>
                        <th>{{ __('customer.account') }}</th>
                        <th>{{ __('customer.status') }}</th>
                        <th>{{ __('customer.processed_date') }}</th>
                        <th>{{ __('customer.notes') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawalRequests as $request)
                        @php
                            $paymentDetails = json_decode($request->payment_details, true);
                            $accountNumber = $paymentDetails['account_number'] ?? 'N/A';
                            // Mask account number
                            if (strlen($accountNumber) > 4) {
                                $maskedAccount = substr($accountNumber, 0, 3) . '****' . substr($accountNumber, -2);
                            } else {
                                $maskedAccount = $accountNumber;
                            }
                        @endphp
                        <tr>
                            <td><strong>#WD-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>
                                {{ \Carbon\Carbon::parse($request->created_at)->format('M j, Y') }}<br>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($request->created_at)->format('h:i A') }}</small>
                            </td>
                            <td><span class="mlm-amount">৳{{ number_format($request->amount, 2) }}</span></td>
                            <td>{{ $request->payment_method }}</td>
                            <td>{{ $maskedAccount }}</td>
                            <td>
                                <span class="mlm-status-badge {{ $request->status }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($request->processed_at)
                                    {{ \Carbon\Carbon::parse($request->processed_at)->format('M j, Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($request->admin_notes)
                                    <small>{{ $request->admin_notes }}</small>
                                @else
                                    <small>{{ $request->status == 'pending' ? 'Awaiting approval' : '-' }}</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 40px;">
                                <i class="fi-rr-wallet" style="font-size: 48px; color: var(--gray-300);"></i>
                                <p style="margin-top: 16px; color: var(--gray-600);">{{ __('customer.no_withdrawal_found') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($withdrawalRequests->total() > 0)
            <div class="mlm-pagination">
                <div class="mlm-pagination-info">
                    {{ __('customer.showing') }} {{ $withdrawalRequests->firstItem() ?? 0 }} {{ __('customer.to') }} {{ $withdrawalRequests->lastItem() ?? 0 }} {{ __('customer.of') }}
                    {{ $withdrawalRequests->total() }} {{ __('customer.entries') }}
                </div>
                @if ($withdrawalRequests->hasPages())
                    <div class="mlm-pagination-buttons">
                        @if ($withdrawalRequests->onFirstPage())
                            <button class="mlm-pagination-btn" disabled>
                                <i class="fi-rr-angle-left"></i>
                            </button>
                        @else
                            <a href="{{ $withdrawalRequests->appends(request()->query())->previousPageUrl() }}"
                                class="mlm-pagination-btn">
                                <i class="fi-rr-angle-left"></i>
                            </a>
                        @endif

                        @foreach ($withdrawalRequests->appends(request()->query())->getUrlRange(1, $withdrawalRequests->lastPage()) as $page => $url)
                            @if ($page == $withdrawalRequests->currentPage())
                                <button class="mlm-pagination-btn active">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="mlm-pagination-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($withdrawalRequests->hasMorePages())
                            <a href="{{ $withdrawalRequests->appends(request()->query())->nextPageUrl() }}"
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
    </div>

    <!-- Withdrawal Modal -->
    <div id="withdrawalModal" class="mlm-modal">
        <div class="mlm-modal-content">
            <div class="mlm-modal-header">
                <h3><i class="fi-rr-wallet"></i> {{ __('customer.request_withdrawal') }}</h3>
                <button class="mlm-modal-close" onclick="closeWithdrawalModal()">×</button>
            </div>
            <form action="{{ url('/customer/mlm/submit-withdrawal-request') }}" method="POST" id="withdrawalForm">
                @csrf
                <div class="mlm-modal-body">
                    <!-- Balance Info -->
                    <div class="mlm-balance-info">
                        <h4>{{ __('customer.available_balance') }}</h4>
                        <p class="amount">৳{{ number_format($availableBalance, 2) }}</p>
                        @if ($availableBalance < $minimumWithdraw)
                            <p style="color: var(--danger-color); font-size: 14px; margin-top: 8px;">
                                <i class="fi-rr-info"></i> {{ __('customer.insufficient_balance_min') }}: ৳{{ number_format($minimumWithdraw, 2) }})
                            </p>
                        @endif
                    </div>

                    <!-- Amount -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            {{ __('customer.withdrawal_amount') }} <span>*</span>
                        </label>
                        <input type="number" name="amount" id="withdrawalAmount"
                            class="mlm-form-input @error('amount') is-invalid @enderror" placeholder="{{ __('customer.enter_amount') }}"
                            required min="{{ $minimumWithdraw }}" max="{{ $availableBalance }}" step="0.01"
                            value="{{ old('amount') }}" {{ $availableBalance < $minimumWithdraw ? 'disabled' : '' }}>
                        <p class="mlm-form-help">
                            {{ __('customer.minimum') }}: ৳{{ number_format($minimumWithdraw, 2) }} | {{ __('customer.available') }}:
                            ৳{{ number_format($availableBalance, 2) }}
                        </p>
                        @error('amount')
                            <span class="invalid-feedback"
                                style="color: var(--danger-color); font-size: 13px; display: block; margin-top: 4px;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Method -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            {{ __('customer.withdrawal_method') }} <span>*</span>
                        </label>
                        <select name="method" class="mlm-form-select @error('method') is-invalid @enderror" required
                            {{ $availableBalance < $minimumWithdraw ? 'disabled' : '' }}>
                            <option value="">{{ __('customer.select_method') }}</option>
                            <option value="Bank Transfer" {{ old('method') == 'Bank Transfer' ? 'selected' : '' }}>{{ __('customer.bank_transfer') }}</option>
                            <option value="bKash" {{ old('method') == 'bKash' ? 'selected' : '' }}>bKash</option>
                            <option value="Nagad" {{ old('method') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                            <option value="Rocket" {{ old('method') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                        </select>
                        @error('method')
                            <span class="invalid-feedback"
                                style="color: var(--danger-color); font-size: 13px; display: block; margin-top: 4px;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <!-- Account Number -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            {{ __('customer.account_number') }} <span>*</span>
                        </label>
                        <input type="text" name="account_number"
                            class="mlm-form-input @error('account_number') is-invalid @enderror"
                            placeholder="{{ __('customer.enter_account_number') }}" required value="{{ old('account_number') }}"
                            {{ $availableBalance < $minimumWithdraw ? 'disabled' : '' }}>
                        <p class="mlm-form-help">{{ __('customer.mobile_banking_help') }}</p>
                        @error('account_number')
                            <span class="invalid-feedback"
                                style="color: var(--danger-color); font-size: 13px; display: block; margin-top: 4px;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <!-- Account Holder Name -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            {{ __('customer.account_holder_name') }} <span>*</span>
                        </label>
                        <input type="text" name="account_holder"
                            class="mlm-form-input @error('account_holder') is-invalid @enderror"
                            placeholder="{{ __('customer.enter_holder_name') }}" required
                            value="{{ old('account_holder', auth('customer')->user()->name ?? '') }}"
                            {{ $availableBalance < $minimumWithdraw ? 'disabled' : '' }}>
                        @error('account_holder')
                            <span class="invalid-feedback"
                                style="color: var(--danger-color); font-size: 13px; display: block; margin-top: 4px;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                </div>
                <div class="mlm-modal-footer">
                    <button type="button" class="mlm-btn mlm-btn-outline" onclick="closeWithdrawalModal()">
                        {{ __('customer.cancel') }}
                    </button>
                    <button type="submit" class="mlm-btn mlm-btn-success"
                        {{ $availableBalance < $minimumWithdraw ? 'disabled' : '' }} id="submitWithdrawalBtn">
                        <i class="fi-rr-check"></i> {{ __('customer.submit_request') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open withdrawal modal
        function openWithdrawalModal() {
            document.getElementById('withdrawalModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close withdrawal modal
        function closeWithdrawalModal() {
            document.getElementById('withdrawalModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('withdrawalModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWithdrawalModal();
            }
        });

        // Auto-open modal if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openWithdrawalModal();
            });
        @endif

        // Form validation
        const withdrawalForm = document.getElementById('withdrawalForm');
        const amountInput = document.getElementById('withdrawalAmount');
        const availableBalance = {{ $availableBalance }};
        const minimumWithdraw = {{ $minimumWithdraw }};

        if (withdrawalForm) {
            withdrawalForm.addEventListener('submit', function(e) {
                const amount = parseFloat(amountInput.value);

                if (amount < minimumWithdraw) {
                    e.preventDefault();
                    alert('Minimum withdrawal amount is ৳' + minimumWithdraw.toFixed(2));
                    amountInput.focus();
                    return false;
                }

                if (amount > availableBalance) {
                    e.preventDefault();
                    alert('Insufficient balance. Available: ৳' + availableBalance.toFixed(2));
                    amountInput.focus();
                    return false;
                }
            });

            // Real-time validation
            if (amountInput) {
                amountInput.addEventListener('input', function() {
                    const amount = parseFloat(this.value);
                    const submitBtn = document.getElementById('submitWithdrawalBtn');

                    if (amount < minimumWithdraw) {
                        this.style.borderColor = 'var(--danger-color)';
                        if (submitBtn) submitBtn.disabled = true;
                    } else if (amount > availableBalance) {
                        this.style.borderColor = 'var(--danger-color)';
                        if (submitBtn) submitBtn.disabled = true;
                    } else {
                        this.style.borderColor = 'var(--success-color)';
                        if (submitBtn) submitBtn.disabled = false;
                    }
                });
            }
        }
    </script>
@endsection
