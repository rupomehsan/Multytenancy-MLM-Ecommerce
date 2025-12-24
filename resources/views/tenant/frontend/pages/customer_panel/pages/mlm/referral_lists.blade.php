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
                <h3>{{ $totalReferrals ?? 0 }}</h3>
                <p>Total Referrals</p>
            </div>
        </div>
        <div class="mlm-stat-card success">
            <div class="mlm-stat-icon">
                <i class="fi-rr-check-circle"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>{{ $stats['total_network'] ?? 0 }}</h3>
                <p>Total Network</p>
            </div>
        </div>
        <div class="mlm-stat-card warning">
            <div class="mlm-stat-icon">
                <i class="fi-rr-user-add"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>{{ $stats['direct_referrals'] ?? 0 }}</h3>
                <p>Direct Referrals</p>
            </div>
        </div>
        <div class="mlm-stat-card info">
            <div class="mlm-stat-icon">
                <i class="fi-rr-chart-network"></i>
            </div>
            <div class="mlm-stat-content">
                <h3>{{ ($stats['level_2_count'] ?? 0) + ($stats['level_3_count'] ?? 0) }}</h3>
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
                </select>
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
                        <th>Direct Referrals</th>
                        <th>Total Network</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrals as $referral)
                        <tr>
                            <td>
                                <div class="mlm-user-cell">
                                    <div class="mlm-user-avatar">
                                        @if (isset($referral['image']) && $referral['image'])
                                            <img src="{{ asset($referral['image']) }}" alt="{{ $referral['name'] }}">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($referral['name']) }}&background=667eea&color=fff"
                                                alt="{{ $referral['name'] }}">
                                        @endif
                                    </div>
                                    <div class="mlm-user-info">
                                        <h4>{{ $referral['name'] }}</h4>
                                        <p>{{ $referral['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="mlm-badge level">Level {{ $referral['level'] }}</span></td>
                            <td><strong>{{ $referral['direct_count'] }}</strong></td>
                            <td><strong>{{ $referral['total_team_count'] }}</strong></td>
                            <td>{{ $referral['joined_at'] }}</td>
                            <td>
                                <button class="mlm-action-btn" onclick="viewDetails({{ $referral['id'] }})">
                                    <i class="fi-rr-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <div style="color: var(--gray-600);">
                                    <i class="fi-rr-users-alt" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p style="margin-top: 16px;">No referrals found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mlm-pagination">
            <div class="mlm-pagination-info">
                Showing {{ count($referrals) }} of {{ $totalReferrals }} entries
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
        document.getElementById('searchBox').addEventListener('input', filterTable);

        function filterTable() {
            const levelFilter = document.getElementById('levelFilter').value;
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();
            const rows = document.querySelectorAll('.mlm-table tbody tr');

            rows.forEach(row => {
                // Skip empty state row
                if (row.querySelector('td[colspan]')) return;

                const levelBadge = row.querySelector('.mlm-badge.level');
                const userName = row.querySelector('.mlm-user-info h4')?.textContent.toLowerCase() || '';
                const userEmail = row.querySelector('.mlm-user-info p')?.textContent.toLowerCase() || '';

                const level = levelBadge ? levelBadge.textContent.replace('Level ', '') : '';

                // Check level filter
                const levelMatch = !levelFilter || level === levelFilter;

                // Check search filter
                const searchMatch = !searchTerm || userName.includes(searchTerm) || userEmail.includes(searchTerm);

                // Show/hide row
                if (levelMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update showing count
            updateShowingCount();
        }

        function updateShowingCount() {
            const visibleRows = document.querySelectorAll('.mlm-table tbody tr:not([style*="display: none"])').length;
            const totalRows = {{ $totalReferrals ?? 0 }};
            document.querySelector('.mlm-pagination-info').textContent =
                `Showing ${visibleRows} of ${totalRows} entries`;
        }

        function viewDetails(id) {
            // Redirect to user details or open modal
            window.location.href = `/customer/mlm/referral/details/${id}`;
        }

        function exportData() {
            // Export visible rows to CSV
            const rows = document.querySelectorAll('.mlm-table tbody tr:not([style*="display: none"])');
            let csvContent = "Member,Email,Level,Direct Referrals,Total Network,Join Date\n";

            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) return; // Skip empty state

                const cells = row.querySelectorAll('td');
                const name = row.querySelector('.mlm-user-info h4')?.textContent || '';
                const email = row.querySelector('.mlm-user-info p')?.textContent || '';
                const level = row.querySelector('.mlm-badge.level')?.textContent || '';
                const direct = cells[2]?.textContent.trim() || '0';
                const total = cells[3]?.textContent.trim() || '0';
                const joinDate = cells[4]?.textContent.trim() || '';

                csvContent += `"${name}","${email}","${level}","${direct}","${total}","${joinDate}"\n`;
            });

            // Create download
            const blob = new Blob([csvContent], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'referrals_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
        }

        function shareReferralLink() {
            @if (auth('customer')->check() && auth('customer')->user()->referral_code)
                const referralLink = '{{ url('/register?ref=' . auth('customer')->user()->referral_code) }}';
            @else
                const referralLink = '{{ url('/register') }}';
            @endif

            if (navigator.clipboard) {
                navigator.clipboard.writeText(referralLink).then(() => {
                    alert('Referral link copied to clipboard!\n\n' + referralLink);
                }).catch(() => {
                    prompt('Copy this referral link:', referralLink);
                });
            } else {
                prompt('Copy this referral link:', referralLink);
            }
        }
    </script>
@endsection
