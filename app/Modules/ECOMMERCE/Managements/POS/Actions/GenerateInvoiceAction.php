<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\POS\Database\Models\Invoice;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class GenerateInvoiceAction
{
    public function execute(Request $request): array
    {
        $orderId = $request->order_id ?? $request->route('orderId');

        try {
            $order = Order::findOrFail($orderId);

            if ($order->order_from != 3 || $order->complete_order != 1) {
                return [
                    'success' => false,
                    'message' => 'Only completed POS orders can have invoices generated'
                ];
            }

            if (Invoice::hasInvoice($orderId)) {
                return [
                    'success' => false,
                    'message' => 'Invoice already exists for this order'
                ];
            }

            $invoice = new Invoice();
            $invoice->id = $orderId;
            $invoice->markAsInvoiced();

            return [
                'success' => true,
                'message' => 'Invoice generated successfully',
                'invoice_no' => $invoice->invoice_no
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to generate invoice: ' . $e->getMessage()
            ];
        }
    }
}
