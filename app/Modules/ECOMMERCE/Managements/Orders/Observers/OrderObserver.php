<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Observers;

use Illuminate\Support\Facades\Log;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderLog;
use App\Modules\MLM\Service\MlmCommissionService;

/**
 * Order Observer
 * 
 * Observes Order model events and triggers MLM commission distribution
 * when order status changes.
 * 
 * Events handled:
 * - updated: Triggered when order is updated (status changes)
 * 
 * Business Logic:
 * - Distribute commissions when order status becomes 'delivered'
 * - Reverse commissions when order status becomes 'cancelled' or 'refunded'
 * 
 * @package App\Modules\ECOMMERCE\Managements\Orders\Observers
 */
class OrderObserver
{
    /**
     * @var MlmCommissionService
     */
    protected $commissionService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commissionService = new MlmCommissionService();
    }

    /**
     * Handle the Order "updated" event.
     * 
     * This is triggered whenever an order is updated.
     * We check if the status changed to 'delivered', 'cancelled', or 'return'.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        // Log that observer was triggered
        Log::info('OrderObserver::updated triggered', [
            'order_id' => $order->id,
            'order_no' => $order->order_no,
        ]);

        // Get the changes that were just saved
        $changes = $order->getChanges();

        // Log changes for debugging
        Log::info('Order changes detected', [
            'order_id' => $order->id,
            'changes' => $changes,
            'all_attributes' => $order->getAttributes(),
        ]);

        // Check if order_status was changed
        if (!isset($changes['order_status'])) {
            Log::info('No order_status change detected, skipping observer logic', [
                'order_id' => $order->id,
            ]);
            return;
        }

        $oldStatus = $order->getOriginal('order_status');
        $newStatus = (int) $order->order_status;

        // Log status change to order_logs
        OrderLog::logStatusChange(
            $order->id,
            $this->getStatusName($oldStatus),
            $this->getStatusName($newStatus),
            auth()->id(),
            'Status updated via observer'
        );

        // Log to Laravel logs
        Log::info('Order status changed', [
            'order_id' => $order->id,
            'order_no' => $order->order_no,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        // Handle commission distribution when order is delivered
        if ($newStatus == Order::STATUS_DELIVERED && $oldStatus != Order::STATUS_DELIVERED) {
            Log::info('Triggering commission distribution', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
            ]);
            $this->handleOrderDelivered($order);
        }

        // Handle commission reversal when order is cancelled or returned
        if (
            in_array($newStatus, [Order::STATUS_CANCELLED, Order::STATUS_RETURN]) &&
            !in_array($oldStatus, [Order::STATUS_CANCELLED, Order::STATUS_RETURN])
        ) {
            $this->handleOrderCancelledOrReturned($order);
        }
    }

    /**
     * Handle order delivered event
     * 
     * @param Order $order
     * @return void
     */
    protected function handleOrderDelivered(Order $order)
    {
        try {
            Log::info('Processing MLM commission distribution', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
            ]);

            $result = $this->commissionService->distributeCommissions($order);

            if ($result['success']) {
                // Log to order logs
                OrderLog::logCommissionDistribution(
                    $order->id,
                    $result['commissions_count'] ?? 0,
                    null,
                    $result['message']
                );

                Log::info('MLM commissions distributed successfully', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'commissions_count' => $result['commissions_count'] ?? 0,
                    'message' => $result['message'],
                ]);
            } else {
                Log::warning('MLM commission distribution skipped or failed', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'message' => $result['message'],
                    'idempotent' => $result['idempotent'] ?? false,
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't throw exception to prevent blocking order update
            Log::error('MLM commission distribution exception', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle order cancelled or returned event
     * 
     * @param Order $order
     * @return void
     */
    protected function handleOrderCancelledOrReturned(Order $order)
    {
        try {

            Log::info('Processing MLM commission reversal', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'status' => $order->order_status,
            ]);

            $result = $this->commissionService->reverseCommissions($order);

            if ($result['success']) {
                // Log to order logs
                OrderLog::logCommissionReversal(
                    $order->id,
                    $result['reversed_count'] ?? 0,
                    null,
                    $result['message']
                );

                Log::info('MLM commissions reversed successfully', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'reversed_count' => $result['reversed_count'] ?? 0,
                    'message' => $result['message'],
                ]);
            } else {
                Log::warning('MLM commission reversal skipped or failed', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'message' => $result['message'],
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't throw exception to prevent blocking order update
            Log::error('MLM commission reversal exception', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle the Order "created" event.
     * 
     * Optional: Can be used for future enhancements.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        // Optional: Add logic if needed when order is created
    }

    /**
     * Handle the Order "deleted" event.
     * 
     * Optional: Can be used for future enhancements.

    /**
     * Get status name from status code
     * 
     * @param int $status
     * @return string
     */
    protected function getStatusName($status)
    {
        $statuses = Order::getOrderStatuses();
        return $statuses[$status] ?? "Status {$status}";
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        // Optional: Add logic if needed when order is deleted
    }
}
