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

        /* Stats Grid */
        .mlm-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .mlm-stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .mlm-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .mlm-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .mlm-stat-card.primary::before {
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
        }

        .mlm-stat-card.success::before {
            background: linear-gradient(180deg, #10b981, #059669);
        }

        .mlm-stat-card.warning::before {
            background: linear-gradient(180deg, #f59e0b, #d97706);
        }

        .mlm-stat-card.info::before {
            background: linear-gradient(180deg, #3b82f6, #2563eb);
        }

        .mlm-stat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .mlm-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
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

        .mlm-stat-label {
            font-size: 13px;
            color: var(--gray-600);
            font-weight: 600;
        }

        .mlm-stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .mlm-stat-change {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mlm-stat-change.positive {
            color: var(--success-color);
        }

        .mlm-stat-change.negative {
            color: var(--danger-color);
        }

        /* Chart Cards */
        .mlm-chart-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }

        .mlm-chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .mlm-chart-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .mlm-chart-filters {
            display: flex;
            gap: 8px;
        }

        .mlm-chart-filter-btn {
            padding: 8px 16px;
            border: 2px solid var(--gray-200);
            background: white;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.3s;
        }

        .mlm-chart-filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .mlm-chart-filter-btn.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
        }

        .mlm-chart-wrapper {
            position: relative;
            height: 350px;
        }

        /* Breakdown Cards */
        .mlm-breakdown-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .mlm-breakdown-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .mlm-breakdown-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .mlm-breakdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .mlm-breakdown-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .mlm-breakdown-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .mlm-breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .mlm-breakdown-item:last-child {
            border-bottom: none;
        }

        .mlm-breakdown-label {
            font-size: 14px;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mlm-breakdown-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .mlm-breakdown-percentage {
            font-size: 12px;
            color: var(--gray-600);
            margin-left: 8px;
        }

        .mlm-color-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
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

        /* Responsive */
        @media (max-width: 768px) {

            .mlm-stats-grid,
            .mlm-breakdown-grid {
                grid-template-columns: 1fr;
            }

            .mlm-chart-wrapper {
                height: 300px;
            }

            .mlm-chart-filters {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Page Header -->
    <div class="mlm-page-header">
        <h1><i class="fi-rr-chart-line-up"></i> Earning Reports</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Earning Reports</span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mlm-stats-grid">
        <div class="mlm-stat-card primary">
            <div class="mlm-stat-header">
                <div class="mlm-stat-icon">
                    <i class="fi-rr-calendar"></i>
                </div>
                <div class="mlm-stat-label">This Month</div>
            </div>
            <div class="mlm-stat-value">৳28,450</div>
            <div class="mlm-stat-change positive">
                <i class="fi-rr-arrow-trend-up"></i>
                +24.5% from last month
            </div>
        </div>

        <div class="mlm-stat-card success">
            <div class="mlm-stat-header">
                <div class="mlm-stat-icon">
                    <i class="fi-rr-calendar-lines"></i>
                </div>
                <div class="mlm-stat-label">Last Month</div>
            </div>
            <div class="mlm-stat-value">৳22,860</div>
            <div class="mlm-stat-change positive">
                <i class="fi-rr-arrow-trend-up"></i>
                +12.3% from previous
            </div>
        </div>

        <div class="mlm-stat-card warning">
            <div class="mlm-stat-header">
                <div class="mlm-stat-icon">
                    <i class="fi-rr-chart-histogram"></i>
                </div>
                <div class="mlm-stat-label">Average Monthly</div>
            </div>
            <div class="mlm-stat-value">৳24,680</div>
            <div class="mlm-stat-change">
                Last 6 months
            </div>
        </div>

        <div class="mlm-stat-card info">
            <div class="mlm-stat-header">
                <div class="mlm-stat-icon">
                    <i class="fi-rr-calendar-clock"></i>
                </div>
                <div class="mlm-stat-label">Total Lifetime</div>
            </div>
            <div class="mlm-stat-value">৳124,850</div>
            <div class="mlm-stat-change positive">
                <i class="fi-rr-check-circle"></i>
                Since Jan 2024
            </div>
        </div>
    </div>

    <!-- Monthly Earnings Chart -->
    <div class="mlm-chart-card">
        <div class="mlm-chart-header">
            <h3 class="mlm-chart-title">
                <i class="fi-rr-chart-histogram"></i>
                Monthly Earnings Overview
            </h3>
            <div class="mlm-chart-filters">
                <button class="mlm-chart-filter-btn active" onclick="changeChartPeriod('6m', this)">6 Months</button>
                <button class="mlm-chart-filter-btn" onclick="changeChartPeriod('1y', this)">1 Year</button>
                <button class="mlm-chart-filter-btn" onclick="changeChartPeriod('all', this)">All Time</button>
            </div>
        </div>
        <div class="mlm-chart-wrapper">
            <canvas id="monthlyEarningsChart"></canvas>
        </div>
    </div>

    <!-- Daily Earnings Chart -->
    <div class="mlm-chart-card">
        <div class="mlm-chart-header">
            <h3 class="mlm-chart-title">
                <i class="fi-rr-chart-line-up"></i>
                Daily Earnings (This Month)
            </h3>
            <button class="mlm-btn mlm-btn-primary" onclick="exportReport()">
                <i class="fi-rr-download"></i> Export Report
            </button>
        </div>
        <div class="mlm-chart-wrapper">
            <canvas id="dailyEarningsChart"></canvas>
        </div>
    </div>

    <!-- Earnings Breakdown -->
    <div class="mlm-breakdown-grid">
        <!-- Commission Types Breakdown -->
        <div class="mlm-breakdown-card">
            <div class="mlm-breakdown-header">
                <h4 class="mlm-breakdown-title">Earnings by Type</h4>
                <div class="mlm-breakdown-icon"
                    style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <i class="fi-rr-chart-pie"></i>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span class="mlm-color-dot" style="background: #667eea;"></span>
                    Direct Referral
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳12,450</span>
                    <span class="mlm-breakdown-percentage">(44%)</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span class="mlm-color-dot" style="background: #10b981;"></span>
                    Level Commission
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳8,680</span>
                    <span class="mlm-breakdown-percentage">(30%)</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span class="mlm-color-dot" style="background: #f59e0b;"></span>
                    Team Sales
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳5,320</span>
                    <span class="mlm-breakdown-percentage">(19%)</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span class="mlm-color-dot" style="background: #3b82f6;"></span>
                    Bonuses
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳2,000</span>
                    <span class="mlm-breakdown-percentage">(7%)</span>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="mlm-breakdown-card">
            <div class="mlm-breakdown-header">
                <h4 class="mlm-breakdown-title">Top Contributors</h4>
                <div class="mlm-breakdown-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fi-rr-trophy"></i>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span style="font-weight: 600;">🥇</span>
                    John Doe
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳4,850</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span style="font-weight: 600;">🥈</span>
                    Sarah Wilson
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳3,420</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span style="font-weight: 600;">🥉</span>
                    David Brown
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳2,960</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    <span style="font-weight: 600;">4️⃣</span>
                    Emily Davis
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳2,180</span>
                </div>
            </div>
        </div>

        <!-- Growth Metrics -->
        <div class="mlm-breakdown-card">
            <div class="mlm-breakdown-header">
                <h4 class="mlm-breakdown-title">Growth Metrics</h4>
                <div class="mlm-breakdown-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fi-rr-rocket-launch"></i>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    Month-over-Month
                </div>
                <div>
                    <span class="mlm-breakdown-value" style="color: var(--success-color);">+24.5%</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    Quarter Growth
                </div>
                <div>
                    <span class="mlm-breakdown-value" style="color: var(--success-color);">+68.2%</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    Yearly Growth
                </div>
                <div>
                    <span class="mlm-breakdown-value" style="color: var(--success-color);">+142.8%</span>
                </div>
            </div>
            <div class="mlm-breakdown-item">
                <div class="mlm-breakdown-label">
                    Avg. Daily Earnings
                </div>
                <div>
                    <span class="mlm-breakdown-value">৳948</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart Colors
        const chartColors = {
            primary: '#667eea',
            secondary: '#764ba2',
            success: '#10b981',
            warning: '#f59e0b',
            info: '#3b82f6',
            gray: '#d1d5db'
        };

        // Monthly Earnings Chart
        const monthlyCtx = document.getElementById('monthlyEarningsChart').getContext('2d');
        const monthlyEarningsChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Earnings',
                    data: [18500, 19200, 21800, 20500, 22860, 28450],
                    backgroundColor: createGradient(monthlyCtx),
                    borderColor: chartColors.primary,
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 40
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: chartColors.primary,
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return '৳' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        },
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

        // Daily Earnings Chart
        const dailyCtx = document.getElementById('dailyEarningsChart').getContext('2d');
        const dailyEarningsChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: ['1', '3', '5', '7', '9', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31'],
                datasets: [{
                    label: 'Daily Earnings',
                    data: [850, 920, 780, 1050, 980, 1120, 890, 1240, 1080, 950, 1180, 1020, 860, 1350,
                        1150, 980
                    ],
                    backgroundColor: createGradient(dailyCtx, 0.2),
                    borderColor: chartColors.success,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: chartColors.success,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
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
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: chartColors.success,
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return '৳' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        },
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

        // Helper function to create gradient
        function createGradient(ctx, opacity = 1) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, `rgba(102, 126, 234, ${opacity})`);
            gradient.addColorStop(1, `rgba(118, 75, 162, ${opacity * 0.5})`);
            return gradient;
        }

        // Change chart period
        function changeChartPeriod(period, btn) {
            // Remove active class from all buttons
            document.querySelectorAll('.mlm-chart-filter-btn').forEach(b => {
                b.classList.remove('active');
            });

            // Add active class to clicked button
            btn.classList.add('active');

            // Update chart data based on period
            console.log('Changing period to:', period);
            // Implement data update logic here
        }

        // Export report
        function exportReport() {
            alert('Export earnings report as PDF');
            // Implement export logic
        }
    </script>
@endsection
