<?php

namespace App\Modules\MLM\Service;

use App\Modules\MLM\Managements\Referral\Models\MlmReferralActivityLog;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Referral Activity Logger Service
 * 
 * Handles creation of MLM referral activity log entries when orders are placed.
 * Traverses the referral chain up to 3 levels and creates commission entries.
 * 
 * Business Rules:
 * - Activity logged only for completed/paid orders
 * - Commission calculated based on mlm_commissions_settings
 * - Initial status = pending
 * - Up to 3 levels of referrals processed
 */
class ReferralActivityLogger
{
    /**
     * Maximum referral levels to process
     */
    const MAX_LEVELS = 3;

    /**
     * Log referral activity for an order.
     * Creates activity log entries for all referrers in the chain (up to 3 levels).
     * 
     * @param Order $order The completed order
     * @return array Array of created activity log IDs
     */
    public static function logOrderActivity(Order $order): array
    {
        try {
            // Get buyer (user who placed the order)
            $buyer = User::find($order->user_id);

            if (!$buyer || !$buyer->referred_by) {
                // No referrer, nothing to log
                return [];
            }

            // Get commission settings
            $settings = self::getCommissionSettings();

            if (!$settings) {
                Log::warning('MLM commission settings not found');
                return [];
            }

            // Traverse referral chain and create activity logs
            $activityIds = self::traverseReferralChain($buyer, $order, $settings);

            return $activityIds;
        } catch (\Exception $e) {
            Log::error('Error logging referral activity: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * Traverse the referral chain up to MAX_LEVELS.
     * Creates one activity log entry per referrer level.
     * 
     * @param User $buyer The buyer user
     * @param Order $order The order
     * @param object $settings Commission settings
     * @return array Activity log IDs created
     */
    protected static function traverseReferralChain(User $buyer, Order $order, $settings): array
    {
        $activityIds = [];
        $currentUser = $buyer;
        $level = 1;

        // Track visited users to prevent infinite loops
        $visitedUsers = [];

        while ($level <= self::MAX_LEVELS && $currentUser->referred_by) {
            // Get referrer
            $referrer = User::find($currentUser->referred_by);

            if (!$referrer) {
                break; // Referrer not found
            }

            // Prevent infinite loop
            if (in_array($referrer->id, $visitedUsers)) {
                Log::warning('Circular referral detected', [
                    'buyer_id' => $buyer->id,
                    'referrer_id' => $referrer->id
                ]);
                break;
            }

            $visitedUsers[] = $referrer->id;

            // Calculate commission for this level
            $commission = self::calculateCommission($order->total, $level, $settings);

            if ($commission > 0) {
                // Create activity log entry
                $activityLog = MlmReferralActivityLog::create([
                    'buyer_id' => $buyer->id,
                    'referrer_id' => $referrer->id,
                    'order_id' => $order->id,
                    'level' => $level,
                    'commission_amount' => $commission,
                    'status' => MlmReferralActivityLog::STATUS_PENDING,
                    'activity_type' => MlmReferralActivityLog::ACTIVITY_COMMISSION_GENERATED,
                    'meta' => [
                        'order_total' => $order->total,
                        'commission_percentage' => self::getCommissionPercentage($level, $settings),
                        'order_date' => $order->created_at->toDateTimeString(),
                    ],
                ]);

                $activityIds[] = $activityLog->id;
            }

            // Move up the chain
            $currentUser = $referrer;
            $level++;
        }

        return $activityIds;
    }

    /**
     * Calculate commission amount for a given level.
     * 
     * @param float $orderTotal Order total amount
     * @param int $level Referral level (1, 2, or 3)
     * @param object $settings Commission settings
     * @return float Commission amount
     */
    protected static function calculateCommission(float $orderTotal, int $level, $settings): float
    {
        $percentage = self::getCommissionPercentage($level, $settings);

        if ($percentage <= 0) {
            return 0;
        }

        return round(($orderTotal * $percentage) / 100, 2);
    }

    /**
     * Get commission percentage for a level from settings.
     * 
     * @param int $level Referral level
     * @param object $settings Commission settings
     * @return float Percentage (e.g., 10.00 for 10%)
     */
    protected static function getCommissionPercentage(int $level, $settings): float
    {
        return match ($level) {
            1 => (float) ($settings->level_1_percentage ?? 0),
            2 => (float) ($settings->level_2_percentage ?? 0),
            3 => (float) ($settings->level_3_percentage ?? 0),
            default => 0,
        };
    }

    /**
     * Get MLM commission settings from database.
     * 
     * @return object|null Settings object or null if not found
     */
    protected static function getCommissionSettings()
    {
        return DB::table('mlm_commissions_settings')
            ->where('status', 1) // Active settings only
            ->first();
    }

    /**
     * Update activity status (e.g., from pending to approved/paid).
     * 
     * @param int $activityId Activity log ID
     * @param string $newStatus New status
     * @param string|null $activityType Optional new activity type
     * @return bool Success
     */
    public static function updateActivityStatus(int $activityId, string $newStatus, ?string $activityType = null): bool
    {
        try {
            $data = ['status' => $newStatus];

            if ($activityType) {
                $data['activity_type'] = $activityType;
            }

            MlmReferralActivityLog::where('id', $activityId)->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Error updating activity status: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Bulk approve activities for an order.
     * Changes status from pending to approved.
     * 
     * @param int $orderId Order ID
     * @return int Number of activities approved
     */
    public static function approveOrderActivities(int $orderId): int
    {
        return MlmReferralActivityLog::where('order_id', $orderId)
            ->where('status', MlmReferralActivityLog::STATUS_PENDING)
            ->update([
                'status' => MlmReferralActivityLog::STATUS_APPROVED,
                'activity_type' => MlmReferralActivityLog::ACTIVITY_COMMISSION_APPROVED,
            ]);
    }

    /**
     * Bulk mark activities as paid.
     * Changes status from approved to paid.
     * 
     * @param int $orderId Order ID
     * @return int Number of activities marked as paid
     */
    public static function markOrderActivitiesAsPaid(int $orderId): int
    {
        return MlmReferralActivityLog::where('order_id', $orderId)
            ->where('status', MlmReferralActivityLog::STATUS_APPROVED)
            ->update([
                'status' => MlmReferralActivityLog::STATUS_PAID,
                'activity_type' => MlmReferralActivityLog::ACTIVITY_COMMISSION_PAID,
            ]);
    }

    /**
     * Cancel all activities for an order.
     * Used when order is cancelled/refunded.
     * 
     * @param int $orderId Order ID
     * @return int Number of activities cancelled
     */
    public static function cancelOrderActivities(int $orderId): int
    {
        return MlmReferralActivityLog::where('order_id', $orderId)
            ->whereIn('status', [
                MlmReferralActivityLog::STATUS_PENDING,
                MlmReferralActivityLog::STATUS_APPROVED
            ])
            ->update([
                'status' => MlmReferralActivityLog::STATUS_CANCELLED,
                'activity_type' => MlmReferralActivityLog::ACTIVITY_COMMISSION_CANCELLED,
            ]);
    }
}
