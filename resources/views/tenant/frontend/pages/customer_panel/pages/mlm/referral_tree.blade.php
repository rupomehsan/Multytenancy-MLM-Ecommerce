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

        .mlm-tree-container {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .mlm-tree-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .mlm-search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .mlm-search-box input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
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
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
        }

        .mlm-tree-actions {
            display: flex;
            gap: 12px;
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
            border: 2px solid var(--gray-200);
            color: var(--gray-600);
        }

        .mlm-btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* MLM Tree Structure */
        .mlm-tree {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
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

        .mlm-node-date {
            font-size: 11px;
            color: var(--gray-600);
            margin-top: 8px;
        }

        /* Tree Children */
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

        .mlm-expand-btn {
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: 3px solid white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s;
            z-index: 10;
        }

        .mlm-expand-btn:hover {
            background: var(--secondary-color);
            transform: translateX(-50%) scale(1.1);
        }

        .mlm-expand-btn.collapsed::before {
            content: '+';
        }

        .mlm-expand-btn.expanded::before {
            content: '−';
        }

        /* Loading Skeleton */
        .mlm-skeleton {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .mlm-skeleton-tree {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 40px;
        }

        .mlm-skeleton-node {
            width: 200px;
            height: 280px;
            background: var(--gray-200);
            border-radius: 16px;
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
            .mlm-tree-children {
                flex-direction: column;
                gap: 60px;
            }

            .mlm-tree-node-content {
                min-width: 180px;
                margin: 0 10px 40px 10px;
            }

            .mlm-tree-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .mlm-search-box {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Page Header -->
    <div class="mlm-page-header">
        <h1><i class="fi-rr-sitemap"></i> Referral Tree</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Referral Tree</span>
        </div>
    </div>

    <!-- Tree Container -->
    <div class="mlm-tree-container">
        <!-- Controls -->
        <div class="mlm-tree-controls">
            <div class="mlm-search-box">
                <i class="fi-rr-search"></i>
                <input type="text" id="treeSearch" placeholder="Search by name or email...">
            </div>
            <div class="mlm-tree-actions">
                <button class="mlm-btn mlm-btn-outline" onclick="expandAll()">
                    <i class="fi-rr-expand"></i> Expand All
                </button>
                <button class="mlm-btn mlm-btn-outline" onclick="collapseAll()">
                    <i class="fi-rr-compress"></i> Collapse All
                </button>
                <button class="mlm-btn mlm-btn-primary" onclick="exportTree()">
                    <i class="fi-rr-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Loading Skeleton -->
        <div id="loadingSkeleton" class="mlm-skeleton-tree" style="display: none;">
            <div class="mlm-skeleton mlm-skeleton-node"></div>
            <div class="mlm-skeleton mlm-skeleton-node"></div>
            <div class="mlm-skeleton mlm-skeleton-node"></div>
        </div>

        <!-- MLM Tree -->
        <div id="mlmTreeView" class="mlm-tree">
            <!-- Root Node (You) -->
            <div class="mlm-tree-node">
                <div class="mlm-tree-node-content root">
                    <div class="mlm-node-avatar">
                        <img src="https://ui-avatars.com/api/?name=You&background=667eea&color=fff" alt="You">
                    </div>
                    <div class="mlm-node-level">You (Root)</div>
                    <div class="mlm-node-name">{{ auth('customer')->user()->name ?? 'Your Name' }}</div>
                    <div class="mlm-node-email">{{ auth('customer')->user()->email ?? 'your@email.com' }}</div>
                    <div class="mlm-node-stats">
                        <div class="mlm-node-stat">
                            <div class="mlm-node-stat-value">24</div>
                            <div class="mlm-node-stat-label">Direct</div>
                        </div>
                        <div class="mlm-node-stat">
                            <div class="mlm-node-stat-value">156</div>
                            <div class="mlm-node-stat-label">Total</div>
                        </div>
                    </div>
                    <div class="mlm-node-date">
                        <i class="fi-rr-calendar"></i> Joined: Jan 15, 2024
                    </div>
                    <div class="mlm-expand-btn expanded" data-node="root"></div>
                </div>

                <!-- Level 1 Children -->
                <div class="mlm-tree-children" id="children-root">
                    <!-- Child 1 -->
                    <div class="mlm-tree-node">
                        <div class="mlm-tree-node-content">
                            <div class="mlm-node-avatar">
                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=10b981&color=fff"
                                    alt="John">
                            </div>
                            <div class="mlm-node-level">Level 1</div>
                            <div class="mlm-node-name">John Doe</div>
                            <div class="mlm-node-email">john@example.com</div>
                            <div class="mlm-node-stats">
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">8</div>
                                    <div class="mlm-node-stat-label">Direct</div>
                                </div>
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">42</div>
                                    <div class="mlm-node-stat-label">Total</div>
                                </div>
                            </div>
                            <div class="mlm-node-date">
                                <i class="fi-rr-calendar"></i> Joined: Feb 20, 2024
                            </div>
                            <div class="mlm-expand-btn collapsed" data-node="node1"></div>
                        </div>

                        <!-- Level 2 Children (Hidden by default) -->
                        <div class="mlm-tree-children" id="children-node1" style="display: none;">
                            <div class="mlm-tree-node">
                                <div class="mlm-tree-node-content">
                                    <div class="mlm-node-avatar">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&background=f59e0b&color=fff"
                                            alt="Sarah">
                                    </div>
                                    <div class="mlm-node-level">Level 2</div>
                                    <div class="mlm-node-name">Sarah Wilson</div>
                                    <div class="mlm-node-email">sarah@example.com</div>
                                    <div class="mlm-node-stats">
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">3</div>
                                            <div class="mlm-node-stat-label">Direct</div>
                                        </div>
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">12</div>
                                            <div class="mlm-node-stat-label">Total</div>
                                        </div>
                                    </div>
                                    <div class="mlm-node-date">
                                        <i class="fi-rr-calendar"></i> Joined: Mar 10, 2024
                                    </div>
                                </div>
                            </div>
                            <div class="mlm-tree-node">
                                <div class="mlm-tree-node-content">
                                    <div class="mlm-node-avatar">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Chen&background=3b82f6&color=fff"
                                            alt="Mike">
                                    </div>
                                    <div class="mlm-node-level">Level 2</div>
                                    <div class="mlm-node-name">Mike Chen</div>
                                    <div class="mlm-node-email">mike@example.com</div>
                                    <div class="mlm-node-stats">
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">5</div>
                                            <div class="mlm-node-stat-label">Direct</div>
                                        </div>
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">18</div>
                                            <div class="mlm-node-stat-label">Total</div>
                                        </div>
                                    </div>
                                    <div class="mlm-node-date">
                                        <i class="fi-rr-calendar"></i> Joined: Mar 15, 2024
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Child 2 -->
                    <div class="mlm-tree-node">
                        <div class="mlm-tree-node-content">
                            <div class="mlm-node-avatar">
                                <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=ef4444&color=fff"
                                    alt="Jane">
                            </div>
                            <div class="mlm-node-level">Level 1</div>
                            <div class="mlm-node-name">Jane Smith</div>
                            <div class="mlm-node-email">jane@example.com</div>
                            <div class="mlm-node-stats">
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">6</div>
                                    <div class="mlm-node-stat-label">Direct</div>
                                </div>
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">38</div>
                                    <div class="mlm-node-stat-label">Total</div>
                                </div>
                            </div>
                            <div class="mlm-node-date">
                                <i class="fi-rr-calendar"></i> Joined: Feb 25, 2024
                            </div>
                            <div class="mlm-expand-btn collapsed" data-node="node2"></div>
                        </div>

                        <!-- Level 2 Children (Hidden) -->
                        <div class="mlm-tree-children" id="children-node2" style="display: none;">
                            <div class="mlm-tree-node">
                                <div class="mlm-tree-node-content">
                                    <div class="mlm-node-avatar">
                                        <img src="https://ui-avatars.com/api/?name=Alex+Brown&background=8b5cf6&color=fff"
                                            alt="Alex">
                                    </div>
                                    <div class="mlm-node-level">Level 2</div>
                                    <div class="mlm-node-name">Alex Brown</div>
                                    <div class="mlm-node-email">alex@example.com</div>
                                    <div class="mlm-node-stats">
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">4</div>
                                            <div class="mlm-node-stat-label">Direct</div>
                                        </div>
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">15</div>
                                            <div class="mlm-node-stat-label">Total</div>
                                        </div>
                                    </div>
                                    <div class="mlm-node-date">
                                        <i class="fi-rr-calendar"></i> Joined: Apr 5, 2024
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Child 3 -->
                    <div class="mlm-tree-node">
                        <div class="mlm-tree-node-content">
                            <div class="mlm-node-avatar">
                                <img src="https://ui-avatars.com/api/?name=Robert+Lee&background=06b6d4&color=fff"
                                    alt="Robert">
                            </div>
                            <div class="mlm-node-level">Level 1</div>
                            <div class="mlm-node-name">Robert Lee</div>
                            <div class="mlm-node-email">robert@example.com</div>
                            <div class="mlm-node-stats">
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">10</div>
                                    <div class="mlm-node-stat-label">Direct</div>
                                </div>
                                <div class="mlm-node-stat">
                                    <div class="mlm-node-stat-value">52</div>
                                    <div class="mlm-node-stat-label">Total</div>
                                </div>
                            </div>
                            <div class="mlm-node-date">
                                <i class="fi-rr-calendar"></i> Joined: Mar 1, 2024
                            </div>
                            <div class="mlm-expand-btn collapsed" data-node="node3"></div>
                        </div>

                        <!-- Level 2 Children (Hidden) -->
                        <div class="mlm-tree-children" id="children-node3" style="display: none;">
                            <div class="mlm-tree-node">
                                <div class="mlm-tree-node-content">
                                    <div class="mlm-node-avatar">
                                        <img src="https://ui-avatars.com/api/?name=Emily+Davis&background=ec4899&color=fff"
                                            alt="Emily">
                                    </div>
                                    <div class="mlm-node-level">Level 2</div>
                                    <div class="mlm-node-name">Emily Davis</div>
                                    <div class="mlm-node-email">emily@example.com</div>
                                    <div class="mlm-node-stats">
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">7</div>
                                            <div class="mlm-node-stat-label">Direct</div>
                                        </div>
                                        <div class="mlm-node-stat">
                                            <div class="mlm-node-stat-value">28</div>
                                            <div class="mlm-node-stat-label">Total</div>
                                        </div>
                                    </div>
                                    <div class="mlm-node-date">
                                        <i class="fi-rr-calendar"></i> Joined: Apr 12, 2024
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (Show when no referrals) -->
        <!-- <div class="mlm-empty-state" style="display: none;">
            <i class="fi-rr-sitemap"></i>
            <h3>No Referrals Yet</h3>
            <p>Start building your network by sharing your referral link</p>
            <button class="mlm-btn mlm-btn-primary">
                <i class="fi-rr-share"></i> Get Referral Link
            </button>
        </div> -->
    </div>

    <script>
        // Tree Expand/Collapse
        document.addEventListener('DOMContentLoaded', function() {
            // Expand/Collapse functionality
            document.querySelectorAll('.mlm-expand-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const nodeId = this.dataset.node;
                    const children = document.getElementById('children-' + nodeId);

                    if (children) {
                        if (children.style.display === 'none' || !children.style.display) {
                            children.style.display = 'flex';
                            this.classList.remove('collapsed');
                            this.classList.add('expanded');
                        } else {
                            children.style.display = 'none';
                            this.classList.remove('expanded');
                            this.classList.add('collapsed');
                        }
                    }
                });
            });

            // Search functionality
            document.getElementById('treeSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.mlm-tree-node-content').forEach(node => {
                    const name = node.querySelector('.mlm-node-name')?.textContent.toLowerCase() ||
                        '';
                    const email = node.querySelector('.mlm-node-email')?.textContent
                    .toLowerCase() || '';

                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        node.parentElement.style.display = 'block';
                        node.style.opacity = '1';
                    } else if (searchTerm) {
                        node.style.opacity = '0.3';
                    } else {
                        node.style.opacity = '1';
                    }
                });
            });
        });

        // Expand All
        function expandAll() {
            document.querySelectorAll('.mlm-tree-children').forEach(children => {
                children.style.display = 'flex';
            });
            document.querySelectorAll('.mlm-expand-btn').forEach(btn => {
                btn.classList.remove('collapsed');
                btn.classList.add('expanded');
            });
        }

        // Collapse All
        function collapseAll() {
            document.querySelectorAll('.mlm-tree-children').forEach((children, index) => {
                if (index > 0) { // Keep root children visible
                    children.style.display = 'none';
                }
            });
            document.querySelectorAll('.mlm-expand-btn').forEach((btn, index) => {
                if (index > 0) { // Keep root expanded
                    btn.classList.remove('expanded');
                    btn.classList.add('collapsed');
                }
            });
        }

        // Export Tree
        function exportTree() {
            alert('Export functionality will download the tree as PDF/Image');
            // Implement export logic here
        }

        // Simulate loading
        window.addEventListener('load', function() {
            // Hide skeleton after load
            document.getElementById('loadingSkeleton').style.display = 'none';
        });
    </script>
@endsection
