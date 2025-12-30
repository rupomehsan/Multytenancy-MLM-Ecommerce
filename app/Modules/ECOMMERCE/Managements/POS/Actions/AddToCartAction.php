<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class AddToCartAction
{
    public function execute(Request $request): array
    {
        $cart = session()->get('cart', []);
        $productKey = $this->buildProductKey($request);

        if ($request->color_id > 0 || $request->size_id > 0) {
            $productInfo = $this->getVariantProduct($request);
            $cart = $this->addOrUpdateCart($cart, $productKey, $productInfo, $request, true);
        } else {
            $productInfo = Product::where('id', $request->product_id)->first();
            $cart = $this->addOrUpdateCart($cart, $productKey, $productInfo, $request, false);
        }

        session()->put('cart', $cart);

        return $cart;
    }

    private function buildProductKey(Request $request): string
    {
        return $request->product_id . "_"
            . $request->color_id . "_"
            . $request->size_id . "_"
            . $request->purchase_product_warehouse_id . "_"
            . $request->purchase_product_warehouse_room_id . "_"
            . $request->purchase_product_warehouse_room_cartoon_id;
    }

    private function getVariantProduct(Request $request)
    {
        $query = DB::table('product_variants')
            ->leftJoin('products', 'product_variants.product_id', 'products.id')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select('product_variants.*', 'products.image as product_image', 'products.code as product_code', 'products.name as product_name', 'colors.name as color_name', 'product_sizes.name as size_name');

        if ($request->color_id > 0) {
            $query->where('product_variants.color_id', $request->color_id);
        }

        if ($request->size_id > 0) {
            $query->where('product_variants.size_id', $request->size_id);
        }

        return $query->where('product_variants.product_id', $request->product_id)->first();
    }

    private function addOrUpdateCart(array $cart, string $productKey, $productInfo, Request $request, bool $isVariant): array
    {
        if (isset($cart[$productKey])) {
            $cart[$productKey]['quantity']++;
        } else {
            $cart[$productKey] = $isVariant
                ? $this->buildVariantCartItem($productInfo, $request)
                : $this->buildStandardCartItem($productInfo, $request);
        }

        return $cart;
    }

    private function buildVariantCartItem($productInfo, Request $request): array
    {
        return [
            "product_id" => $productInfo->product_id,
            "code" => $productInfo->product_code,
            "name" => $productInfo->product_name,
            "quantity" => 1,
            'discount_price' => 0,
            "price" => $productInfo->discounted_price > 0 ? $productInfo->discounted_price : $productInfo->price,
            "image" => $productInfo->product_image,
            "color_id" => $request->color_id,
            "color_name" => $productInfo->color_name,
            "size_id" => $request->size_id,
            "size_name" => $productInfo->size_name,
            "purchase_product_warehouse_id" => $request->purchase_product_warehouse_id,
            "purchase_product_warehouse_room_id" => $request->purchase_product_warehouse_room_id,
            "purchase_product_warehouse_room_cartoon_id" => $request->purchase_product_warehouse_room_cartoon_id,
        ];
    }

    private function buildStandardCartItem($productInfo, Request $request): array
    {
        return [
            "product_id" => $productInfo->id,
            "code" => $productInfo->code,
            "name" => $productInfo->name,
            "quantity" => 1,
            'discount_price' => 0,
            "price" => $productInfo->discount_price > 0 ? $productInfo->discount_price : $productInfo->price,
            "image" => $productInfo->image,
            "color_id" => null,
            "color_name" => null,
            "size_id" => null,
            "size_name" => null,
            "purchase_product_warehouse_id" => $request->purchase_product_warehouse_id,
            "purchase_product_warehouse_room_id" => $request->purchase_product_warehouse_room_id,
            "purchase_product_warehouse_room_cartoon_id" => $request->purchase_product_warehouse_room_cartoon_id,
        ];
    }
}
