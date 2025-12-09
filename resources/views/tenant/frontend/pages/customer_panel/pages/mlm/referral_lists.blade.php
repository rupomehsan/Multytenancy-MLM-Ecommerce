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

        /* Stats Cards */
        .mlm-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .mlm-stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s;
        }

        .mlm-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .mlm-stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
        }

        .mlm-stat-card.primary .mlm-stat-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .mlm-stat-card.success .mlm-stat-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .mlm-stat-card.warning .mlm-stat-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .mlm-stat-card.info .mlm-stat-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .mlm-stat-content h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 4px 0;
        }

        .mlm-stat-content p {
            font-size: 14px;
            color: var(--gray-600);
            margin: 0;
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
            min-width: 200px;
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

        .mlm-search-box {
            position: relative;
            flex: 2;
            min-width: 300px;
        }

        .mlm-search-box input {
            width: 100%;
            padding: 10px 14px 10px 42px;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .mlm-search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .mlm-search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
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

        .mlm-user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mlm-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--gray-200);
        }

        .mlm-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mlm-user-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0 0 2px 0;
        }

        .mlm-user-info p {
            font-size: 12px;
            color: var(--gray-600);
            margin: 0;
        }

        .mlm-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .mlm-badge.active {
            background: #d1fae5;
            color: #065f46;
        }

        .mlm-badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .mlm-badge.level {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .mlm-action-btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .mlm-action-btn:hover {
            background: var(--primary-color);
            color: white;
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
            .mlm-stats-row {
                grid-template-columns: 1fr;
            }

            .mlm-filters {
                flex-direction: column;
            }

            .mlm-filter-group,
            .mlm-search-box {
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
        <h1><i class="fi-rr-users-alt"></i> Referral List</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Referral List</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="mlm-stats-row">
        <div class="mlm-stat-card primary">
            <div class="mlm-stat-icon">
                <i class="fi-rr-users-alt"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>248</h3>
                <p>Total Referrals</p>
            </div>
        </div>
        <div class="mlm-stat-card success">
            <div class="mlm-stat-icon">
                <i class="fi-rr-check-circle"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>186</h3>
                <p>Active Members</p>
            </div>
        </div>
        <div class="mlm-stat-card warning">
            <div class="mlm-stat-icon">
                <i class="fi-rr-user-add"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>24</h3>
                <p>Direct Referrals</p>
            </div>
        </div>
        <div class="mlm-stat-card info">
            <div class="mlm-stat-icon">
                <i class="fi-rr-chart-network"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>224</h3>
                <p>Indirect Referrals</p>
            </div>
        </div>
    </div>

    <!-- Content Card -->
    <div class="mlm-content-card">
        <!-- Card Header -->
        <div class="mlm-card-header">
            <h2 class="mlm-card-title">
                <i class="fi-rr-list"></i>
                All Referrals
            </h2>
            <div style="display: flex; gap: 12px;">
                <button class="mlm-btn mlm-btn-outline" onclick="exportData()">
                    <i class="fi-rr-download"></i> Export
                </button>
                <button class="mlm-btn mlm-btn-primary" onclick="shareReferralLink()">
                    <i class="fi-rr-share"></i> Share Link
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="mlm-filters">
            <div class="mlm-filter-group">
                <label for="levelFilter">Level</label>
                <select id="levelFilter">
                    <option value="">All Levels</option>
                    <option value="1">Level 1</option>
                    <option value="2">Level 2</option>
                    <option value="3">Level 3</option>
                    <option value="4">Level 4</option>
                    <option value="5">Level 5+</option>
                </select>
            </div>
            <div class="mlm-filter-group">
                <label for="statusFilter">Status</label>
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="mlm-filter-group">
                <label for="dateFilter">Join Date</label>
                <input type="date" id="dateFilter">
            </div>
            <div class="mlm-search-box">
                <label for="searchBox">Search</label>
                <i class="fi-rr-search"></i>
                <input type="text" id="searchBox" placeholder="Search by name or email...">
            </div>
        </div>

        <!-- Table -->
        <div class="mlm-table-wrapper">
            <table class="mlm-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Direct Referrals</th>
                        <th>Total Network</th>
                        <th>Join Date</th>
                        <th>Total Sales</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff"
                                        alt="John">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>John Doe</h4>
                                    <p>john.doe@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 1</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>12</strong></td>
                        <td><strong>48</strong></td>
                        <td>Feb 15, 2024</td>
                        <td><strong>৳25,400</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(1)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=10b981&color=fff"
                                        alt="Jane">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Jane Smith</h4>
                                    <p>jane.smith@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 1</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>8</strong></td>
                        <td><strong>32</strong></td>
                        <td>Feb 20, 2024</td>
                        <td><strong>৳18,900</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(2)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=f59e0b&color=fff"
                                        alt="Mike">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Mike Johnson</h4>
                                    <p>mike.johnson@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 2</span></td>
                        <td><span class="mlm-badge inactive">Inactive</span></td>
                        <td><strong>5</strong></td>
                        <td><strong>15</strong></td>
                        <td>Mar 5, 2024</td>
                        <td><strong>৳9,200</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(3)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Williams&background=ef4444&color=fff"
                                        alt="Sarah">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Sarah Williams</h4>
                                    <p>sarah.w@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 2</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>10</strong></td>
                        <td><strong>42</strong></td>
                        <td>Mar 10, 2024</td>
                        <td><strong>৳32,100</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(4)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=David+Brown&background=3b82f6&color=fff"
                                        alt="David">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>David Brown</h4>
                                    <p>david.brown@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 1</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>15</strong></td>
                        <td><strong>68</strong></td>
                        <td>Feb 28, 2024</td>
                        <td><strong>৳45,800</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(5)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 6 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Emily+Davis&background=8b5cf6&color=fff"
                                        alt="Emily">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Emily Davis</h4>
                                    <p>emily.davis@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 3</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>6</strong></td>
                        <td><strong>18</strong></td>
                        <td>Mar 18, 2024</td>
                        <td><strong>৳12,500</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(6)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 7 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Robert+Lee&background=ec4899&color=fff"
                                        alt="Robert">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Robert Lee</h4>
                                    <p>robert.lee@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 1</span></td>
                        <td><span class="mlm-badge active">Active</span></td>
                        <td><strong>9</strong></td>
                        <td><strong>38</strong></td>
                        <td>Mar 1, 2024</td>
                        <td><strong>৳28,700</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(7)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>

                    <!-- Row 8 -->
                    <tr>
                        <td>
                            <div class="mlm-user-cell">
                                <div class="mlm-user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Lisa+Wilson&background=06b6d4&color=fff"
                                        alt="Lisa">
                                </div>
                                <div class="mlm-user-info">
                                    <h4>Lisa Wilson</h4>
                                    <p>lisa.wilson@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="mlm-badge level">Level 2</span></td>
                        <td><span class="mlm-badge inactive">Inactive</span></td>
                        <td><strong>3</strong></td>
                        <td><strong>8</strong></td>
                        <td>Mar 25, 2024</td>
                        <td><strong>৳5,400</strong></td>
                        <td>
                            <button class="mlm-action-btn" onclick="viewDetails(8)">
                                <i class="fi-rr-eye"></i> View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mlm-pagination">
            <div class="mlm-pagination-info">
                Showing 1 to 8 of 248 entries
            </div>
            <div class="mlm-pagination-buttons">
                <button class="mlm-pagination-btn" disabled>
                    <i class="fi-rr-angle-left"></i>
                </button>
                <button class="mlm-pagination-btn active">1</button>
                <button class="mlm-pagination-btn">2</button>
                <button class="mlm-pagination-btn">3</button>
                <button class="mlm-pagination-btn">4</button>
                <button class="mlm-pagination-btn">5</button>
                <button class="mlm-pagination-btn">
                    <i class="fi-rr-angle-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State (Show when no data) -->
    <!-- <div class="mlm-content-card">
        <div class="mlm-empty-state">
            <i class="fi-rr-users-alt"></i>
            <h3>No Referrals Yet</h3>
            <p>Start building your network by sharing your referral link</p>
            <button class="mlm-btn mlm-btn-primary">
                <i class="fi-rr-share"></i> Get Referral Link
            </button>
        </div>
    </div> -->

    <script>
        // Filter functionality
        document.getElementById('levelFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('dateFilter').addEventListener('change', filterTable);
        document.getElementById('searchBox').addEventListener('input', filterTable);

        function filterTable() {
            // Implement filter logic here
            console.log('Filtering table...');
        }

        function viewDetails(id) {
            alert('View details for member ID: ' + id);
            // Implement view details logic
        }

        function exportData() {
            alert('Export data as CSV/Excel');
            // Implement export logic
        }

        function shareReferralLink() {
            const referralLink = window.location.origin + '/register?ref=' +
                '{{ auth('customer')->user()->id ?? 'USER_ID' }}';

            if (navigator.clipboard) {
                navigator.clipboard.writeText(referralLink).then(() => {
                    alert('Referral link copied to clipboard!\n\n' + referralLink);
                });
            } else {
                alert('Your Referral Link:\n\n' + referralLink);
            }
        }
    </script>
@endsection
