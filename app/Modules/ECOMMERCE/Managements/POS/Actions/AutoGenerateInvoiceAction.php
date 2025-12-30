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

            if ($order && $order->order_from == 3 && $order->complete_order == 1) {
                if (!Invoice::hasInvoice($orderId)) {
                    $invoice = new Invoice();
                    $invoice->id = $orderId;
                    $invoice->markAsInvoiced();

                    return [
                        'success' => true,
                        'invoice_no' => $invoice->invoice_no
                    ];
                }
            }

            return ['success' => false, 'message' => 'Conditions not met for invoice generation'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
