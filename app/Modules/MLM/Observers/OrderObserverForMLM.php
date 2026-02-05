<?php

namespace App\Modules\MLM\Observers;

use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\MLM\Service\ReferralActivityLogger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Order Observer for MLM Activity Logging
 * 
 * Automatically creates referral activity logs when orders are placed/updated.
 * Hooks into Laravel's Eloquent events.
 * 
 * Events:
 * - created: Log commission activity when order is created
 * - updated: Update activity status based on order status changes
 */
class OrderObserverForMLM
{
    /**
     * Handle the Order "created" event.
     * Creates referral activity logs for the order if buyer has referrers.
     * 
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        try {
            // Log activity for all orders initially with pending status
            // Activity will be approved/paid when order is delivered
            $activityIds = ReferralActivityLogger::logOrderActivity($order);

            if (count($activityIds) > 0) {
                Log::info('Referral activities created for order', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'activities_count' => count($activityIds),
                    'activity_ids' => $activityIds
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in OrderObserverForMLM created event', [
                'order_id' => $order->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle the Order "updated" event.
     * Updates activity status based on order status changes.
     * 
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        try {
            // Check if order_status was changed (not 'status')
            $changes = $order->getChanges();

            if (isset($changes['order_status'])) {
                $oldStatus = $order->getOriginal('order_status');
                $newStatus = $order->order_status;

                Log::info('OrderObserverForMLM: Order status changed', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ]);

                $this->handleStatusChange($order, $oldStatus, $newStatus);
            }
        } catch (\Exception $e) {
            Log::error('Error in OrderObserverForMLM updated event', [
                'order_id' => $order->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle order status changes and update activities accordingly.
     * 
     * @param Order $order
     * @param int $oldStatus
     * @param int $newStatus
     * @return void
     */
    protected function handleStatusChange(Order $order, int $oldStatus, int $newStatus)
    {
        // Handle different status transitions using Order constants

        // When order status is delivered, ensure activities exist and approve/mark as paid
        if ($newStatus == Order::STATUS_DELIVERED) {
            // Check if activities already exist for this order
            $existingActivities = DB::table('mlm_referral_activity_logs')
                ->where('order_id', $order->id)
                ->count();

            if ($existingActivities == 0) {
                // Activities don't exist yet (order was created via raw DB insert or never processed)
                // Create them now
                Log::info('Creating referral activities for order being delivered', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ]);

                $activityIds = ReferralActivityLogger::logOrderActivity($order);

                if (count($activityIds) > 0) {
                    Log::info('Referral activities created for order', [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'activities_count' => count($activityIds),
                        'activity_ids' => $activityIds
                    ]);
                }
            }

            // Only approve and mark as paid if we're transitioning TO delivered (not if already delivered)
            if ($oldStatus != Order::STATUS_DELIVERED) {
                // Approve activities
                $count = ReferralActivityLogger::approveOrderActivities($order->id);
                if ($count > 0) {
                    Log::info("Approved {$count} referral activities for delivered order", [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                    ]);
                }

                // Mark activities as paid
                $paidCount = ReferralActivityLogger::markOrderActivitiesAsPaid($order->id);
                if ($paidCount > 0) {
                    Log::info("Marked {$paidCount} referral activities as paid", [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                    ]);
                }
            }
        }

        // When order is cancelled or returned, cancel activities
        if (
            in_array($newStatus, [Order::STATUS_CANCELLED, Order::STATUS_RETURN]) &&
            !in_array($oldStatus, [Order::STATUS_CANCELLED, Order::STATUS_RETURN])
        ) {
            $count = ReferralActivityLogger::cancelOrderActivities($order->id);
            if ($count > 0) {
                Log::info("Cancelled {$count} referral activities for cancelled/returned order", [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                ]);
            }
        }
    }
}
