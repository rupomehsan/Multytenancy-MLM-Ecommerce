<?php

namespace App\Modules\ECOMMERCE\Managements\Reports\Actions;

use Illuminate\Http\Request;
use App\Modules\INVENTORY\Managements\Purchase\PurchaseOrders\Database\Models\ProductPurchaseOrder;

class GenerateProductPurchaseReport
{
    public static function execute(Request $request)
    {
        $startDate = date("Y-m-d", strtotime(str_replace("/", "-", $request->start_date))) . " 00:00:00";
        $endDate = date("Y-m-d", strtotime(str_replace("/", "-", $request->end_date))) . " 23:59:59";

        $query = ProductPurchaseOrder::query();
        $query->whereBetween('date', [$startDate, $endDate])
            ->leftJoin('product_warehouses', 'product_purchase_orders.product_warehouse_id', '=', 'product_warehouses.id')
            ->leftJoin('product_warehouse_rooms', 'product_purchase_orders.product_warehouse_room_id', '=', 'product_warehouse_rooms.id')
            ->leftJoin('product_warehouse_room_cartoons', 'product_purchase_orders.product_warehouse_room_cartoon_id', '=', 'product_warehouse_room_cartoons.id')
            ->leftJoin('product_suppliers', 'product_purchase_orders.product_supplier_id', '=', 'product_suppliers.id')
            ->orderBy('product_purchase_orders.total', 'asc')
            ->select(
                'product_purchase_orders.*',
                'product_warehouses.title as warehouse_name',
                'product_warehouse_rooms.title as room_name',
                'product_warehouse_room_cartoons.title as cartoon_name',
                'product_suppliers.name as supplier_name'
            );

        $data = $query->orderBy('id', 'desc')->get();

        return [
            'status' => 'success',
            'data' => [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'purchases' => $data
            ]
        ];
    }
}
