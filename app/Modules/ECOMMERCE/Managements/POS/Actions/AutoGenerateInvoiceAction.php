<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\POS\Database\Models\Invoice;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class AutoGenerateInvoiceAction
{
    public function execute(int $orderId): array
    {
        try {
            $order = Order::find($orderId);

            if (!$order) {
                return ['success' => false, 'message' => 'Order not found'];
            }

            // Generate invoice for POS orders (regardless of completion status)
            // Home delivery orders need invoices even when pending delivery
            if ($order->order_from == Order::ORDER_FROM_POS) {
                if (!Invoice::hasInvoice($orderId)) {
                    $invoice = new Invoice();
                    $invoice->id = $orderId;
                    $invoice->markAsInvoiced();

                    return [
                        'success' => true,
                        'invoice_no' => $invoice->invoice_no,
                        'message' => 'Invoice generated successfully'
                    ];
                }
                
                return ['success' => false, 'message' => 'Invoice already exists'];
            }

            return ['success' => false, 'message' => 'Not a POS order'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
