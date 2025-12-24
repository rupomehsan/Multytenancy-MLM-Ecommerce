<?php

namespace App\Modules\MLM\Service;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use Illuminate\Support\Collection;

/**
 * ReferralTreeService
 * 
 * Builds a hierarchical referral tree structure for MLM functionality.
 * Maximum depth is limited to 3 levels to prevent performance issues.
 */
class ReferralTreeService
{
    /**
     * Maximum allowed depth for the referral tree.
     * Level 0 = Root user
     * Levels 1, 2, 3 = Children
     */
    const MAX_DEPTH = 3;

    /**
     * Visited nodes tracker to prevent infinite loops.
     * 
     * @var array
     */
    protected $visited = [];

    /**
     * Build the referral tree starting from a root customer.
     * 
     * @param User $rootCustomer The authenticated customer (root of the tree)
     * @return array Tree structure with nested children
     */
    public function buildTree(User $rootCustomer): array
    {
        // Reset visited tracker
        $this->visited = [];

        // Build the tree starting at level 0 (root)
        return $this->buildNode($rootCustomer, 0);
    }

    /**
     * Recursively build a single node and its children.
     * 
     * @param User $customer Current customer node
     * @param int $currentLevel Current depth level (0-based)
     * @return array Node structure with metadata and children
     */
    protected function buildNode(User $customer, int $currentLevel): array
    {
        // Prevent infinite loops by tracking visited nodes
        if (in_array($customer->id, $this->visited)) {
            return $this->emptyNode($customer, $currentLevel);
        }

        // Mark this node as visited
        $this->visited[] = $customer->id;

        // Build the base node structure
        $node = [
            'id' => $customer->id,
            'name' => $customer->name ?? 'N/A',
            'email' => $customer->email ?? 'N/A',
            'level' => $currentLevel,
            'joined_at' => $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A',
            'direct_count' => 0,
            'total_team_count' => 0,
            'children' => [],
        ];

        // Stop recursion if we've reached max depth
        if ($currentLevel >= self::MAX_DEPTH) {
            // Calculate stats without going deeper
            $node['direct_count'] = $customer->referrals()->count();
            $node['total_team_count'] = $this->calculateTotalTeam($customer->id, 1);
            return $node;
        }

        // Eager load direct referrals to avoid N+1 queries
        $directReferrals = $customer->referrals()
            ->where('user_type', 3) // Only customers
            ->where('status', 1)     // Only active users
            ->orderBy('created_at', 'asc')
            ->get();

        // Set direct count
        $node['direct_count'] = $directReferrals->count();

        // Recursively build children nodes
        foreach ($directReferrals as $referral) {
            $childNode = $this->buildNode($referral, $currentLevel + 1);
            $node['children'][] = $childNode;
        }

        // Calculate total team count (all descendants)
        $node['total_team_count'] = $this->countTotalTeam($node);

        return $node;
    }

    /**
     * Create an empty node structure (used for loop prevention).
     * 
     * @param User $customer
     * @param int $level
     * @return array
     */
    protected function emptyNode(User $customer, int $level): array
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name ?? 'N/A',
            'email' => $customer->email ?? 'N/A',
            'level' => $level,
            'joined_at' => $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A',
            'direct_count' => 0,
            'total_team_count' => 0,
            'children' => [],
        ];
    }

    /**
     * Count total team members recursively from a node structure.
     * 
     * @param array $node Current node
     * @return int Total count of all descendants
     */
    protected function countTotalTeam(array $node): int
    {
        $count = count($node['children']);

        foreach ($node['children'] as $child) {
            $count += $this->countTotalTeam($child);
        }

        return $count;
    }

    /**
     * Calculate total team using direct database query (fallback method).
     * This is used when we hit max depth but still need accurate counts.
     * 
     * @param int $customerId Root customer ID
     * @param int $remainingDepth How many more levels to check
     * @return int Total team count
     */
    protected function calculateTotalTeam(int $customerId, int $remainingDepth = 3): int
    {
        if ($remainingDepth <= 0) {
            return 0;
        }

        // Get direct referrals
        $directReferrals = User::where('referred_by', $customerId)
            ->where('user_type', 3)
            ->where('status', 1)
            ->pluck('id');

        $count = $directReferrals->count();

        // Recursively count children's teams
        foreach ($directReferrals as $referralId) {
            $count += $this->calculateTotalTeam($referralId, $remainingDepth - 1);
        }

        return $count;
    }

    /**
     * Get statistics for a specific customer's referral network.
     * 
     * @param User $customer
     * @return array Statistics array
     */
    public function getNetworkStats(User $customer): array
    {
        return [
            'level_1_count' => $this->getLevelCount($customer, 1),
            'level_2_count' => $this->getLevelCount($customer, 2),
            'level_3_count' => $this->getLevelCount($customer, 3),
            'total_network' => $this->calculateTotalTeam($customer->id, 3),
            'direct_referrals' => $customer->referrals()->where('user_type', 3)->where('status', 1)->count(),
        ];
    }

    /**
     * Get count of referrals at a specific level.
     * 
     * @param User $customer Root customer
     * @param int $targetLevel Level to count (1, 2, or 3)
     * @return int Count of users at that level
     */
    protected function getLevelCount(User $customer, int $targetLevel): int
    {
        if ($targetLevel < 1 || $targetLevel > 3) {
            return 0;
        }

        return $this->countAtLevel($customer->id, 1, $targetLevel);
    }

    /**
     * Recursively count users at a specific level.
     * 
     * @param int $customerId Current customer ID
     * @param int $currentLevel Current level in recursion
     * @param int $targetLevel Target level to count
     * @return int Count at target level
     */
    protected function countAtLevel(int $customerId, int $currentLevel, int $targetLevel): int
    {
        $referrals = User::where('referred_by', $customerId)
            ->where('user_type', 3)
            ->where('status', 1)
            ->pluck('id');

        // If we're at the target level, return the count
        if ($currentLevel === $targetLevel) {
            return $referrals->count();
        }

        // If we've gone too deep, stop
        if ($currentLevel >= $targetLevel) {
            return 0;
        }

        // Recursively count at the next level
        $count = 0;
        foreach ($referrals as $referralId) {
            $count += $this->countAtLevel($referralId, $currentLevel + 1, $targetLevel);
        }

        return $count;
    }

    /**
     * Flatten the tree structure for export or API purposes.
     * 
     * @param array $tree Tree structure
     * @return array Flattened array of all nodes
     */
    public function flattenTree(array $tree): array
    {
        $flattened = [$tree];

        foreach ($tree['children'] as $child) {
            $flattened = array_merge($flattened, $this->flattenTree($child));
        }

        // Remove children key for flat structure
        return array_map(function ($node) {
            unset($node['children']);
            return $node;
        }, $flattened);
    }
}
