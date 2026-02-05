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

        /* Controls responsiveness for tablets and mobile */
        @media (max-width: 992px) {
            .mlm-tree-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .mlm-search-box {
                max-width: 100%;
                width: 100%;
                order: 0;
            }

            .mlm-tree-actions {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .mlm-tree-actions .mlm-btn {
                flex: 1 1 calc(33.333% - 8px);
                min-width: 0;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .mlm-tree-controls {
                gap: 10px;
            }

            .mlm-tree-actions {
                justify-content: stretch;
            }

            .mlm-tree-actions .mlm-btn {
                flex: 1 1 100% !important;
                width: 100% !important;
                display: inline-flex;
                justify-content: center;
            }

            .mlm-tree-actions .mlm-btn + .mlm-btn {
                margin-top: 8px;
            }
        }
    </style>
@endsection

@section('dashboard_content')
    <!-- Page Header -->
    <div class="mlm-page-header">
        <h1><i class="fi-rr-sitemap"></i> {{ __('customer.network_tree') }}</h1>
        <div class="mlm-breadcrumb">
            <a href="{{ url('/') }}">{{ __('customer.home') }}</a>
            <span>/</span>
            <a href="{{ url('/customer/dashboard') }}">{{ __('customer.dashboard') }}</a>
            <span>/</span>
            <span>{{ __('customer.network_tree') }}</span>
        </div>
    </div>

    <!-- Tree Container -->
    <div class="mlm-tree-container">
        <!-- Controls -->
        <div class="mlm-tree-controls d-none">
            <div class="mlm-search-box">
                <i class="fi-rr-search"></i>
                <input type="text" id="treeSearch" placeholder="{{ __('customer.search_by_name_email') }}">
            </div>
            <div class="mlm-tree-actions">
                <button class="mlm-btn mlm-btn-outline" onclick="expandAll()">
                    <i class="fi-rr-expand"></i> {{ __('customer.expand_all') }}
                </button>
                <button class="mlm-btn mlm-btn-outline" onclick="collapseAll()">
                    <i class="fi-rr-compress"></i> {{ __('customer.collapse_all') }}
                </button>
                <button class="mlm-btn mlm-btn-primary" onclick="exportTree()">
                    <i class="fi-rr-download"></i> {{ __('customer.export') }}
                </button>
            </div>
        </div>

        <!-- Loading Skeleton -->
        <div id="loadingSkeleton" class="mlm-skeleton-tree" style="display: none;">
            <div class="mlm-skeleton mlm-skeleton-node"></div>
            <div class="mlm-skeleton mlm-skeleton-node"></div>
            <div class="mlm-skeleton mlm-skeleton-node"></div>
        </div>

        <!-- MLM Tree - Dynamic Data -->
        <div id="mlmTreeView" class="mlm-tree">
            @if (isset($tree) && !empty($tree))
                {{-- Render the tree using recursive partial --}}
                @include('tenant.frontend.pages.customer_panel.pages.mlm.partials._tree_node', [
                    'node' => $tree,
                    'depth' => 0,
                ])
            @else
                {{-- Empty State - Show when no referrals --}}
                <div class="mlm-empty-state">
                    <i class="fi-rr-sitemap"></i>
                    <h3>{{ __('customer.no_referrals') }}</h3>
                    <p>{{ __('customer.start_building_network') }}</p>
                    <button class="mlm-btn mlm-btn-primary"
                        onclick="window.location.href='{{ url('/customer/dashboard') }}'">
                        <i class="fi-rr-share"></i> {{ __('customer.get_referral_link') }}
                    </button>
                </div>
            @endif
        </div>
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

        // Expand All - Explicitly attach to window for onclick handlers
        window.expandAll = function() {
            const children = document.querySelectorAll('.mlm-tree-children');
            const buttons = document.querySelectorAll('.mlm-expand-btn');
            
            if (children.length === 0) {
                console.log('No tree children found to expand');
                return;
            }
            
            children.forEach(child => {
                child.style.display = 'flex';
            });
            
            buttons.forEach(btn => {
                btn.classList.remove('collapsed');
                btn.classList.add('expanded');
            });
            
            console.log(`Expanded ${children.length} tree sections`);
        };

        // Collapse All - Explicitly attach to window for onclick handlers
        window.collapseAll = function() {
            const children = document.querySelectorAll('.mlm-tree-children');
            const buttons = document.querySelectorAll('.mlm-expand-btn');
            
            if (children.length === 0) {
                console.log('No tree children found to collapse');
                return;
            }
            
            children.forEach((child, index) => {
                if (index > 0) { // Keep root children visible
                    child.style.display = 'none';
                }
            });
            
            buttons.forEach((btn, index) => {
                if (index > 0) { // Keep root expanded
                    btn.classList.remove('expanded');
                    btn.classList.add('collapsed');
                }
            });
            
            console.log(`Collapsed ${children.length - 1} tree sections`);
        };

        // Export Tree - Explicitly attach to window for onclick handlers
        window.exportTree = function() {
            console.log('Export tree clicked');
            alert('Export functionality will download the tree as PDF/Image');
            // Implement export logic here
        };

        // Simulate loading
        window.addEventListener('load', function() {
            // Hide skeleton after load
            document.getElementById('loadingSkeleton').style.display = 'none';
        });
    </script>
@endsection
