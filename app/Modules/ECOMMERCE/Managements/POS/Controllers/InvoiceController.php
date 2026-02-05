<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\POS\Actions\GenerateInvoiceAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetInvoiceDataAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\GetInvoiceListAction;
use App\Modules\ECOMMERCE\Managements\POS\Actions\AutoGenerateInvoiceAction;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/POS');
    }
    /**
     * Generate invoice for a POS order
     */
    public function generateInvoice(GenerateInvoiceAction $action, Request $request, $orderId)
    {
        $request->merge(['order_id' => $orderId]);
        $result = $action->execute($request);

        return response()->json($result);
    }

    /**
     * Display invoice details
     */
    public function showInvoice(GetInvoiceDataAction $action, Request $request, $orderId)
    {
        $request->merge(['order_id' => $orderId]);
        $result = $action->execute($request);

        if (!$result['success']) {
            session()->flash('error', $result['message']);
            return redirect()->back();
        }

        return view('show', [
            'order' => $result['order'],
            'orderDetails' => $result['orderDetails'],
            'customer' => $result['customer'],
            'generalInfo' => $result['generalInfo']
        ]);
    }

    /**
     * Print invoice
     */
    public function printInvoice(GetInvoiceDataAction $action, Request $request, $orderId)
    {
        $request->merge(['order_id' => $orderId]);
        $result = $action->execute($request);

        if (!$result['success']) {
            session()->flash('error', $result['message']);
            return redirect()->back();
        }

        return view('print', [
            'order' => $result['order'],
            'orderDetails' => $result['orderDetails'],
            'customer' => $result['customer'],
            'generalInfo' => $result['generalInfo']
        ]);
    }

    /**
     * Print POS invoice - Thermal printer friendly format
     */
    public function posInvoicePrint(GetInvoiceDataAction $action, Request $request, $orderId)
    {
        $request->merge(['order_id' => $orderId]);
        $result = $action->execute($request);

        if (!$result['success']) {
            // Auto-generate if doesn't exist
            $autoGenerateAction = new AutoGenerateInvoiceAction();
            $generateResult = $autoGenerateAction->execute($orderId);

            // Re-fetch data after auto-generation
            $result = $action->execute($request);
            
            // If still fails, show error
            if (!$result['success']) {
                session()->flash('error', $result['message'] ?? 'Unable to generate invoice');
                return redirect()->route('ViewAllInvoices');
            }
        }

        return view('pos.components.invoice_print', [
            'order' => $result['order'],
            'orderDetails' => $result['orderDetails'],
            'customer' => $result['customer'],
            'generalInfo' => $result['generalInfo']
        ]);
    }

    /**
     * Get printable content for POS invoice (AJAX)
     */
    public function getPrintableContent(GetInvoiceDataAction $action, Request $request, $orderId)
    {
        $request->merge(['order_id' => $orderId]);
        $result = $action->execute($request);

        if (!$result['success']) {
            // Auto-generate if doesn't exist
            $autoGenerateAction = new AutoGenerateInvoiceAction();
            $generateResult = $autoGenerateAction->execute($orderId);

            // Re-fetch data after auto-generation
            $result = $action->execute($request);
            
            // If still fails, return error JSON for AJAX
            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Unable to generate invoice'
                ], 404);
            }
        }

        return view('pos.components.invoice_content_only', [
            'order' => $result['order'],
            'orderDetails' => $result['orderDetails'],
            'customer' => $result['customer'],
            'generalInfo' => $result['generalInfo']
        ]);
    }

    /**
     * List all invoices
     */
    public function index(GetInvoiceListAction $action, Request $request)
    {
        if ($request->ajax()) {
            return $action->execute($request);
        }

        return view('index');
    }

    /**
     * Auto-generate invoice for completed POS order
     */
    public static function autoGenerateInvoice($orderId)
    {
        $action = new AutoGenerateInvoiceAction();
        return $action->execute($orderId);
    }
}
