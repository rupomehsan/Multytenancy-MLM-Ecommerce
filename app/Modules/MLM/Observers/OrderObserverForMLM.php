<?php

namespace App\Modules\MLM\Observers;

use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\MLM\Service\ReferralActivityLogger;
use Illuminate\Support\Facades\Log;

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
            // Only log activity for paid/completed orders
            // You can adjust this based on your order workflow
            if ($this->shouldLogActivity($order)) {
                $activityIds = ReferralActivityLogger::logOrderActivity($order);

                if (count($activityIds) > 0) {
                    Log::info('Referral activities created for order', [
                        'order_id' => $order->id,
                        'activities_count' => count($activityIds),
                        'activity_ids' => $activityIds
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in OrderObserverForMLM created event: ' . $e->getMessage());
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
            // Check if status was changed
            if ($order->isDirty('status')) {
                $this->handleStatusChange($order);
            }
        } catch (\Exception $e) {
            Log::error('Error in OrderObserverForMLM updated event: ' . $e->getMessage());
        }
    }

    /**
     * Determine if activity should be logged for this order.
     * Override this method to match your business logic.
     * 
     * @param Order $order
     * @return bool
     */
    protected function shouldLogActivity(Order $order): bool
    {
        // Example: Log activity for completed/paid orders
        // Adjust status values based on your Order model
        return in_array($order->status, ['completed', 'paid', 'processing']);
    }

    /**
     * Handle order status changes and update activities accordingly.
     * 
     * @param Order $order
     * @return void
     */
    protected function handleStatusChange(Order $order)
    {
        $newStatus = $order->status;

        // Handle different status transitions
        switch ($newStatus) {
            case 'completed':
            case 'paid':
                // Approve activities
                $count = ReferralActivityLogger::approveOrderActivities($order->id);
                if ($count > 0) {
                    Log::info("Approved {$count} activities for order #{$order->id}");
                }
                break;

            case 'cancelled':
            case 'refunded':
                // Cancel activities
                $count = ReferralActivityLogger::cancelOrderActivities($order->id);
                if ($count > 0) {
                    Log::info("Cancelled {$count} activities for order #{$order->id}");
                }
                break;
        }
    }
}
