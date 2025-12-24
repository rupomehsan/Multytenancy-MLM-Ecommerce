<?php

/**
 * MLM Referral Tree Service - Usage Examples
 * 
 * This file demonstrates various use cases for the ReferralTreeService.
 * Copy and adapt these examples to your specific needs.
 */

namespace App\Examples;

use App\Modules\MLM\Service\ReferralTreeService;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReferralTreeExamples
{
    /**
     * Example 1: Basic Tree Generation
     * Usage: Display referral tree in customer dashboard
     */
    public function basicTreeExample()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        // Build the tree (max 3 levels)
        $tree = $treeService->buildTree($customer);

        // Pass to view
        return view('referral_tree', compact('tree'));
    }

    /**
     * Example 2: Get Network Statistics
     * Usage: Display network stats in dashboard cards
     */
    public function networkStatsExample()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        $stats = $treeService->getNetworkStats($customer);

        /*
        Returns:
        [
            'level_1_count' => 10,      // Direct referrals
            'level_2_count' => 45,      // Second generation
            'level_3_count' => 120,     // Third generation
            'total_network' => 175,     // All referrals combined
            'direct_referrals' => 10    // Same as level_1_count
        ]
        */

        return $stats;
    }

    /**
     * Example 3: Export Tree Data (Flatten)
     * Usage: Export to CSV, Excel, PDF
     */
    public function exportTreeExample()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        // Build tree
        $tree = $treeService->buildTree($customer);

        // Flatten for export (removes nested structure)
        $flatData = $treeService->flattenTree($tree);

        /*
        Returns array of nodes:
        [
            ['id' => 1, 'name' => 'You', 'level' => 0, ...],
            ['id' => 2, 'name' => 'John', 'level' => 1, ...],
            ['id' => 3, 'name' => 'Jane', 'level' => 1, ...],
            ...
        ]
        */

        // Example: Export to CSV
        return $this->exportToCsv($flatData);
    }

    /**
     * Example 4: Cached Tree for Performance
     * Usage: Large networks with frequent access
     */
    public function cachedTreeExample()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        // Cache for 1 hour (3600 seconds)
        $tree = Cache::remember(
            "referral_tree_{$customer->id}",
            3600,
            function () use ($customer, $treeService) {
                return $treeService->buildTree($customer);
            }
        );

        return $tree;
    }

    /**
     * Example 5: Clear Cache When New Referral Added
     * Usage: In registration/referral creation logic
     */
    public function clearCacheOnReferralAdded($newReferral)
    {
        // Clear cache for parent
        if ($newReferral->referred_by) {
            Cache::forget("referral_tree_{$newReferral->referred_by}");

            // Also clear cache for grandparent and great-grandparent
            $parent = User::find($newReferral->referred_by);
            if ($parent && $parent->referred_by) {
                Cache::forget("referral_tree_{$parent->referred_by}");

                $grandparent = User::find($parent->referred_by);
                if ($grandparent && $grandparent->referred_by) {
                    Cache::forget("referral_tree_{$grandparent->referred_by}");
                }
            }
        }
    }

    /**
     * Example 6: Get Specific User's Tree (Admin View)
     * Usage: Admin dashboard to view any user's network
     */
    public function adminViewUserTree($userId)
    {
        $customer = User::findOrFail($userId);
        $treeService = new ReferralTreeService();

        $tree = $treeService->buildTree($customer);
        $stats = $treeService->getNetworkStats($customer);

        return view('admin.referral_tree', [
            'tree' => $tree,
            'stats' => $stats,
            'customer' => $customer
        ]);
    }

    /**
     * Example 7: Count Total Network Size
     * Usage: Display total team count in profile
     */
    public function getTotalNetworkSize()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        $tree = $treeService->buildTree($customer);

        // Total network size is in the root node
        $totalTeam = $tree['total_team_count'];

        return $totalTeam;
    }

    /**
     * Example 8: Get All Users at Specific Level
     * Usage: Level-specific commission calculations
     */
    public function getUsersAtLevel($level)
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        $tree = $treeService->buildTree($customer);

        // Extract users at specific level
        $usersAtLevel = $this->extractLevel($tree, $level);

        return $usersAtLevel;
    }

    /**
     * Example 9: API Response Format
     * Usage: RESTful API endpoint
     */
    public function apiTreeResponse()
    {
        $customer = auth('customer')->user();
        $treeService = new ReferralTreeService();

        $tree = $treeService->buildTree($customer);
        $stats = $treeService->getNetworkStats($customer);

        return response()->json([
            'success' => true,
            'data' => [
                'tree' => $tree,
                'statistics' => $stats,
                'meta' => [
                    'max_depth' => ReferralTreeService::MAX_DEPTH,
                    'generated_at' => now()->toIso8601String()
                ]
            ]
        ]);
    }

    /**
     * Example 10: Database Query for Specific Level
     * Usage: Direct database access without building full tree
     */
    public function getDirectReferralsOnly()
    {
        $customer = auth('customer')->user();

        // Get only Level 1 (direct referrals) without service
        $directReferrals = User::where('referred_by', $customer->id)
            ->where('user_type', 3)
            ->where('status', 1)
            ->select('id', 'name', 'email', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return $directReferrals;
    }

    /**
     * Example 11: Leaderboard - Top Referrers
     * Usage: Display users with most referrals
     */
    public function getTopReferrers($limit = 10)
    {
        $topReferrers = User::select('users.*')
            ->selectRaw('COUNT(referrals.id) as referral_count')
            ->leftJoin('users as referrals', 'users.id', '=', 'referrals.referred_by')
            ->where('users.user_type', 3)
            ->where('users.status', 1)
            ->groupBy('users.id')
            ->orderByDesc('referral_count')
            ->limit($limit)
            ->get();

        return $topReferrers;
    }

    /**
     * Example 12: Calculate Commission Based on Tree
     * Usage: MLM commission calculation logic
     */
    public function calculateCommissions($orderId, $orderAmount)
    {
        // Assuming commission rates: L1 = 10%, L2 = 5%, L3 = 2%
        $commissionRates = [
            1 => 0.10, // Level 1: 10%
            2 => 0.05, // Level 2: 5%
            3 => 0.02  // Level 3: 2%
        ];

        $buyer = auth('customer')->user();
        $commissions = [];

        // Traverse upwards through the referral chain
        $currentUser = $buyer->parent;
        $level = 1;

        while ($currentUser && $level <= 3) {
            $commissionAmount = $orderAmount * $commissionRates[$level];

            $commissions[] = [
                'user_id' => $currentUser->id,
                'level' => $level,
                'amount' => $commissionAmount,
                'order_id' => $orderId
            ];

            // Move to next level up
            $currentUser = $currentUser->parent;
            $level++;
        }

        return $commissions;
    }

    /**
     * Helper: Extract users at specific level from tree
     */
    private function extractLevel($node, $targetLevel, $currentLevel = 0)
    {
        $results = [];

        if ($currentLevel === $targetLevel) {
            $results[] = $node;
        }

        if (isset($node['children']) && $currentLevel < $targetLevel) {
            foreach ($node['children'] as $child) {
                $results = array_merge(
                    $results,
                    $this->extractLevel($child, $targetLevel, $currentLevel + 1)
                );
            }
        }

        return $results;
    }

    /**
     * Helper: Export flat data to CSV
     */
    private function exportToCsv($flatData)
    {
        $filename = 'referral_tree_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($flatData) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Level', 'Direct Count', 'Total Team', 'Joined']);

            // CSV Data
            foreach ($flatData as $node) {
                fputcsv($file, [
                    $node['id'],
                    $node['name'],
                    $node['email'],
                    $node['level'],
                    $node['direct_count'],
                    $node['total_team_count'],
                    $node['joined_at']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Example 13: Real-time Network Growth Tracking
     * Usage: Dashboard analytics
     */
    public function getNetworkGrowthStats($customerId, $days = 30)
    {
        $startDate = now()->subDays($days);

        $stats = [
            'total_new_referrals' => 0,
            'level_1_new' => 0,
            'level_2_new' => 0,
            'level_3_new' => 0,
            'daily_growth' => []
        ];

        // Get all referrals in network
        $treeService = new ReferralTreeService();
        $tree = $treeService->buildTree(User::find($customerId));
        $flatTree = $treeService->flattenTree($tree);

        foreach ($flatTree as $node) {
            $user = User::find($node['id']);

            if ($user && $user->created_at >= $startDate) {
                $stats['total_new_referrals']++;

                if ($node['level'] == 1) $stats['level_1_new']++;
                if ($node['level'] == 2) $stats['level_2_new']++;
                if ($node['level'] == 3) $stats['level_3_new']++;

                // Group by date
                $date = $user->created_at->format('Y-m-d');
                $stats['daily_growth'][$date] = ($stats['daily_growth'][$date] ?? 0) + 1;
            }
        }

        return $stats;
    }
}
