<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderProgress;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class CancelOrder
{
    public static function execute(string $slug)
    {


        $data = Order::where('slug', $slug)->first();
        $data->order_status = Order::STATUS_CANCELLED;
        $data->payment_status = Order::PAYMENT_STATUS_FAILED;
        $data->updated_at = Carbon::now();
        $data->save();

        $order_details = DB::table('order_details')->where('order_id', $data->id)->select('product_id', 'qty')->get();

        foreach ($order_details as $order_detail) {
            $product = Product::find($order_detail->product_id);

            if ($product) {
                if ($product->is_package) {
                    $packageItems = DB::table('package_product_items')
                        ->where('package_product_id', $product->id)
                        ->get();

                    foreach ($packageItems as $item) {
                        $itemProduct = Product::find($item->product_id);
                        if (!$itemProduct) continue;

                        if ($item->color_id || $item->size_id) {
                            $variantQuery = DB::table('product_variants')
                                ->where('product_id', $item->product_id);

                            if ($item->color_id) {
                                $variantQuery->where('color_id', $item->color_id);
                            }
                            if ($item->size_id) {
                                $variantQuery->where('size_id', $item->size_id);
                            }

                            $variantQuery->increment('stock', $order_detail->qty * $item->quantity);
                        } else {
                            $itemProduct->increment('stock', $order_detail->qty * $item->quantity);
                        }
                    }
                } else {
                    $product->increment('stock', $order_detail->qty);
                }
            }
        }


        return response()->json(['success' => 'Order Cancelled successfully.']);
    }
}
