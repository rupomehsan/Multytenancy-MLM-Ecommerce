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
        <h1><i class="fi-rr-wallet"></i> Withdrawal Requests</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Withdrawal Requests</span>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mlm-summary-grid">
        <div class="mlm-summary-card available">
            <div class="mlm-summary-label">
                <i class="fi-rr-piggy-bank"></i>
                Available Balance
            </div>
            <div class="mlm-summary-value">৳15,680</div>
            <div class="mlm-summary-subtitle">Ready to withdraw</div>
        </div>

        <div class="mlm-summary-card pending">
            <div class="mlm-summary-label">
                <i class="fi-rr-clock"></i>
                Pending Requests
            </div>
            <div class="mlm-summary-value">৳4,200</div>
            <div class="mlm-summary-subtitle">3 requests pending</div>
        </div>

        <div class="mlm-summary-card completed">
            <div class="mlm-summary-label">
                <i class="fi-rr-check-circle"></i>
                Total Withdrawn
            </div>
            <div class="mlm-summary-value">৳85,450</div>
            <div class="mlm-summary-subtitle">All time</div>
        </div>

        <div class="mlm-summary-card rejected">
            <div class="mlm-summary-label">
                <i class="fi-rr-cross-circle"></i>
                Rejected Amount
            </div>
            <div class="mlm-summary-value">৳2,800</div>
            <div class="mlm-summary-subtitle">2 requests rejected</div>
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
                All Withdrawal Requests
            </h2>
            <button class="mlm-btn mlm-btn-success" onclick="openWithdrawalModal()">
                <i class="fi-rr-plus"></i> New Withdrawal Request
            </button>
        </div>

        <!-- Filters -->
        <div class="mlm-filters">
            <div class="mlm-filter-group">
                <label for="statusFilter">Status</label>
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="mlm-filter-group">
                <label for="dateFrom">Date From</label>
                <input type="date" id="dateFrom">
            </div>
            <div class="mlm-filter-group">
                <label for="dateTo">Date To</label>
                <input type="date" id="dateTo">
            </div>
        </div>

        <!-- Table -->
        <div class="mlm-table-wrapper">
            <table class="mlm-table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Account</th>
                        <th>Status</th>
                        <th>Processed Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td><strong>#WD-1058</strong></td>
                        <td>Dec 5, 2024<br><small class="text-muted">10:30 AM</small></td>
                        <td><span class="mlm-amount">৳5,000.00</span></td>
                        <td>Bank Transfer</td>
                        <td>ACC-****4582</td>
                        <td><span class="mlm-status-badge completed">Completed</span></td>
                        <td>Dec 6, 2024</td>
                        <td><small>Transferred successfully</small></td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td><strong>#WD-1057</strong></td>
                        <td>Dec 4, 2024<br><small class="text-muted">02:15 PM</small></td>
                        <td><span class="mlm-amount">৳2,500.00</span></td>
                        <td>bKash</td>
                        <td>01712****56</td>
                        <td><span class="mlm-status-badge processing">Processing</span></td>
                        <td>-</td>
                        <td><small>Under review</small></td>
                    </tr>

                    <!-- Row 3 -->
                    <tr>
                        <td><strong>#WD-1056</strong></td>
                        <td>Dec 3, 2024<br><small class="text-muted">11:45 AM</small></td>
                        <td><span class="mlm-amount">৳1,700.00</span></td>
                        <td>Nagad</td>
                        <td>01812****89</td>
                        <td><span class="mlm-status-badge pending">Pending</span></td>
                        <td>-</td>
                        <td><small>Awaiting approval</small></td>
                    </tr>

                    <!-- Row 4 -->
                    <tr>
                        <td><strong>#WD-1055</strong></td>
                        <td>Dec 1, 2024<br><small class="text-muted">04:20 PM</small></td>
                        <td><span class="mlm-amount">৳3,200.00</span></td>
                        <td>Bank Transfer</td>
                        <td>ACC-****7823</td>
                        <td><span class="mlm-status-badge completed">Completed</span></td>
                        <td>Dec 2, 2024</td>
                        <td><small>Transferred successfully</small></td>
                    </tr>

                    <!-- Row 5 -->
                    <tr>
                        <td><strong>#WD-1054</strong></td>
                        <td>Nov 28, 2024<br><small class="text-muted">09:15 AM</small></td>
                        <td><span class="mlm-amount">৳1,500.00</span></td>
                        <td>Rocket</td>
                        <td>01912****34</td>
                        <td><span class="mlm-status-badge rejected">Rejected</span></td>
                        <td>Nov 29, 2024</td>
                        <td><small>Invalid account details</small></td>
                    </tr>

                    <!-- Row 6 -->
                    <tr>
                        <td><strong>#WD-1053</strong></td>
                        <td>Nov 25, 2024<br><small class="text-muted">03:30 PM</small></td>
                        <td><span class="mlm-amount">৳4,800.00</span></td>
                        <td>bKash</td>
                        <td>01612****78</td>
                        <td><span class="mlm-status-badge completed">Completed</span></td>
                        <td>Nov 26, 2024</td>
                        <td><small>Transferred successfully</small></td>
                    </tr>

                    <!-- Row 7 -->
                    <tr>
                        <td><strong>#WD-1052</strong></td>
                        <td>Nov 22, 2024<br><small class="text-muted">01:45 PM</small></td>
                        <td><span class="mlm-amount">৳2,900.00</span></td>
                        <td>Bank Transfer</td>
                        <td>ACC-****3421</td>
                        <td><span class="mlm-status-badge completed">Completed</span></td>
                        <td>Nov 23, 2024</td>
                        <td><small>Transferred successfully</small></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mlm-pagination">
            <div class="mlm-pagination-info">
                Showing 1 to 7 of 24 entries
            </div>
            <div class="mlm-pagination-buttons">
                <button class="mlm-pagination-btn" disabled>
                    <i class="fi-rr-angle-left"></i>
                </button>
                <button class="mlm-pagination-btn active">1</button>
                <button class="mlm-pagination-btn">2</button>
                <button class="mlm-pagination-btn">3</button>
                <button class="mlm-pagination-btn">4</button>
                <button class="mlm-pagination-btn">
                    <i class="fi-rr-angle-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Withdrawal Modal -->
    <div id="withdrawalModal" class="mlm-modal">
        <div class="mlm-modal-content">
            <div class="mlm-modal-header">
                <h3><i class="fi-rr-wallet"></i> New Withdrawal Request</h3>
                <button class="mlm-modal-close" onclick="closeWithdrawalModal()">×</button>
            </div>
            <form action="{{ url('/customer/mlm/submit-withdrawal-request') }}" method="POST">
                @csrf
                <div class="mlm-modal-body">
                    <!-- Balance Info -->
                    <div class="mlm-balance-info">
                        <h4>Available Balance</h4>
                        <p class="amount">৳15,680.00</p>
                    </div>

                    <!-- Amount -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            Withdrawal Amount <span>*</span>
                        </label>
                        <input type="number" name="amount" class="mlm-form-input" placeholder="Enter amount" required
                            min="500" max="15680" step="0.01">
                        <p class="mlm-form-help">Minimum withdrawal: ৳500 | Maximum: ৳15,680</p>
                    </div>

                    <!-- Method -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            Withdrawal Method <span>*</span>
                        </label>
                        <select name="method" class="mlm-form-select" required>
                            <option value="">Select Method</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                            <option value="rocket">Rocket</option>
                        </select>
                    </div>

                    <!-- Account Number -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            Account Number <span>*</span>
                        </label>
                        <input type="text" name="account_number" class="mlm-form-input"
                            placeholder="Enter account number" required>
                        <p class="mlm-form-help">For mobile banking: Enter your mobile number</p>
                    </div>

                    <!-- Account Holder Name -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            Account Holder Name <span>*</span>
                        </label>
                        <input type="text" name="account_holder" class="mlm-form-input"
                            placeholder="Enter account holder name" required>
                    </div>

                    <!-- Notes -->
                    <div class="mlm-form-group">
                        <label class="mlm-form-label">
                            Additional Notes (Optional)
                        </label>
                        <textarea name="notes" class="mlm-form-textarea" placeholder="Add any additional information..."></textarea>
                    </div>
                </div>
                <div class="mlm-modal-footer">
                    <button type="button" class="mlm-btn mlm-btn-outline" onclick="closeWithdrawalModal()">
                        Cancel
                    </button>
                    <button type="submit" class="mlm-btn mlm-btn-success">
                        <i class="fi-rr-check"></i> Submit Request
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

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('dateFrom').addEventListener('change', filterTable);
        document.getElementById('dateTo').addEventListener('change', filterTable);

        function filterTable() {
            // Implement filter logic here
            console.log('Filtering withdrawal requests...');
        }
    </script>
@endsection
