<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\POS\Database\Models\Invoice;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class GetInvoiceDataAction
{
    public function execute(Request $request): array
    {
        $orderId = $request->order_id ?? $request->route('orderId');

        $order = Order::with(['shippingInfo', 'billingAddress'])->findOrFail($orderId);

        if (!Invoice::hasInvoice($orderId)) {
            return [
                'success' => false,
                'message' => 'Invoice not found for this order'
            ];
        }

        $orderDetails = DB::table('order_details')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('units', 'order_details.unit_id', '=', 'units.id')
            ->leftJoin('colors', 'order_details.color_id', '=', 'colors.id')
            ->leftJoin('product_sizes', 'order_details.size_id', '=', 'product_sizes.id')
            ->select(
                'order_details.*',
                'products.name as product_name',
                'products.code as product_code',
                'units.name as unit_name',
                'colors.name as color_name',
                'product_sizes.name as size_name'
            )
            ->where('order_details.order_id', $orderId)
            ->get();

        $customer = null;
        if ($order->user_id) {
            $customer = User::find($order->user_id);
        }

        $generalInfo = DB::table('general_infos')
            ->select('logo', 'logo_dark', 'company_name', 'address', 'email', 'contact')
            ->first();

        return [
            'success' => true,
            'order' => $order,
            'orderDetails' => $orderDetails,
            'customer' => $customer,
            'generalInfo' => $generalInfo
        ];
    }
}
