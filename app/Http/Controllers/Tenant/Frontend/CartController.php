<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Frontend\CheckoutController;

class CartController extends Controller
{

    public function addToCart($id)
    {

        $product = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id') // joining for data layer info
            ->leftJoin('brands', 'products.brand_id', 'brands.id') // joining for data layer info
            ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name')
            ->where('products.id', $id)
            ->first();

        $minVariant = DB::table('product_variants')->where('stock', '>', 0)->where('product_id', $id)->orderBy('price', 'asc')->first();
        $cart = session()->get('cart', []);

        // Get variant image if min variant has color_id
        $imageToUse = $product->image; // Default to main product image
        if ($minVariant && $minVariant->color_id) {
            $variantImage = DB::table('product_variants')
                ->where('product_id', $id)
                ->where('color_id', $minVariant->color_id)
                ->when($minVariant->size_id, function ($query) use ($minVariant) {
                    return $query->where('size_id', $minVariant->size_id);
                })
                ->value('image');

            // Use variant image if available
            if ($variantImage) {
                $imageToUse = $variantImage;
            }
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => 1,
                "price" => $minVariant ? ($minVariant->price > 0 ? $minVariant->price : 0) : ($product->price > 0 ? $product->price : 0),
                "discount_price" => $minVariant ? ($minVariant->discounted_price > 0 ? $minVariant->discounted_price : 0) : ($product->discount_price > 0 ? $product->discount_price : 0),
                "image" => $imageToUse, // Use variant image if available, otherwise main product image
                // variant
                "color_id" => $minVariant ? $minVariant->color_id : null,
                "size_id" => $minVariant ? $minVariant->size_id : null,
                "region_id" => $minVariant ? $minVariant->region_id : null,
                "sim_id" => $minVariant ? $minVariant->sim_id : null,
                "storage_id" => $minVariant ? $minVariant->storage_type_id : null,
                "warrenty_id" => $minVariant ? $minVariant->warrenty_id : null,
                "condition_id" => $minVariant ? $minVariant->device_condition_id : null,
                // package identification
                "is_package" => $product->is_package ? true : false,
                "is_product_qty_multiply" => $product->is_product_qty_multiply ? true : false,
                'has_variant' => $product->has_variant ? true : false,
                "product_id" => $id, // Store original product ID for package stock checking
                // for data layer
                "brand_name" => $product->brand_name,
                "category_name" => $product->category_name,
            ];
        }

        session()->put('cart', $cart);

        // Recalculate delivery cost when item is added
        $checkoutController = new CheckoutController();
        $checkoutController->recalculateDeliveryCost();

        $returnHTML = view('tenant.frontend.layouts.partials.sidebar_cart')->render();
        return response()->json([
            'rendered_cart' => $returnHTML,
            'cartTotalQty' => count(session('cart')),

            // for data layer
            'p_name_data_layer' => $product->name,
            'p_price_data_layer' => $minVariant ? ($minVariant->discounted_price > 0 ? $minVariant->discounted_price : $minVariant->price) : ($product->discount_price > 0 ? $product->discount_price : $product->price),
            'p_brand_name' => $product->brand_name,
            'p_category_name' => $product->category_name,
            'p_qauntity' => 1,
        ]);
    }

    public function removeCartTtem($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Recalculate delivery cost when item is removed
            $checkoutController = new CheckoutController();
            $checkoutController->recalculateDeliveryCost();
        }

        $returnHTML = view('tenant.frontend.layouts.partials.sidebar_cart')->render();
        $checkoutCartItems = view('tenant.frontend.pages.checkout.cart_items')->render();
        $checkoutTotalAmount = view('tenant.frontend.pages.checkout.order_total')->render();
        $checkoutCoupon = view('tenant.frontend.pages.checkout.coupon')->render();
        return response()->json(['rendered_cart' => $returnHTML, 'checkoutCartItems' => $checkoutCartItems, 'checkoutTotalAmount' => $checkoutTotalAmount, 'checkoutCoupon' => $checkoutCoupon, 'cartTotalQty' => count(session('cart'))]);
    }

    public function removeCartItemByKey($cartKey)
    {
        $cart = session()->get('cart');
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);

            // Recalculate delivery cost when item is removed
            $checkoutController = new CheckoutController();
            $checkoutController->recalculateDeliveryCost();
        }

        $returnHTML = view('tenant.frontend.layouts.partials.sidebar_cart')->render();
        $checkoutCartItems = view('tenant.frontend.pages.checkout.cart_items')->render();
        $checkoutTotalAmount = view('tenant.frontend.pages.checkout.order_total')->render();
        $checkoutCoupon = view('tenant.frontend.pages.checkout.coupon')->render();
        return response()->json(['rendered_cart' => $returnHTML, 'checkoutCartItems' => $checkoutCartItems, 'checkoutTotalAmount' => $checkoutTotalAmount, 'checkoutCoupon' => $checkoutCoupon, 'cartTotalQty' => count(session('cart'))]);
    }

    public function updateCartQty(Request $request)
    {
        $cart = session()->get('cart');
        if (isset($cart[$request->cart_id])) {
            $cart[$request->cart_id]['quantity'] = $request->cart_qty;
            session()->put('cart', $cart);

            // Recalculate delivery cost when quantity changes
            $checkoutController = new CheckoutController();
            $checkoutController->recalculateDeliveryCost();
        }

        $returnHTML = view('tenant.frontend.layouts.partials.sidebar_cart')->render();
        $checkoutCartItems = view('tenant.frontend.pages.checkout.cart_items')->render();
        $checkoutTotalAmount = view('tenant.frontend.pages.checkout.order_total')->render();
        $checkoutCoupon = view('tenant.frontend.pages.checkout.coupon')->render();
        return response()->json([
            'rendered_cart' => $returnHTML,
            'checkoutCartItems' => $checkoutCartItems,
            'checkoutTotalAmount' => $checkoutTotalAmount,
            'checkoutCoupon' => $checkoutCoupon,
            'success' => 'Cart Qty Updated'
        ]);
    }


    public function addToCartWithQty(Request $request)
    {

        $product = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id') // joining for data layer info
            ->leftJoin('brands', 'products.brand_id', 'brands.id') // joining for data layer info
            ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name')
            ->where('products.id', $request->product_id)
            ->first();

        $cart = session()->get('cart', []);

        // Create unique cart key for variant combinations
        $colorId = $request->color_id != 'null' ? $request->color_id : null;
        $sizeId = $request->size_id != 'null' ? $request->size_id : null;

        // Generate unique key: product_id + color_id + size_id
        $cartKey = $request->product_id;
        if ($colorId) {
            $cartKey .= '_c' . $colorId;
        }
        if ($sizeId) {
            $cartKey .= '_s' . $sizeId;
        }

        // Get variant image if this is a variant product
        $imageToUse = $product->image; // Default to main product image
        if ($colorId) {
            $variantImage = DB::table('product_variants')
                ->where('product_id', $request->product_id)
                ->where('color_id', $colorId)
                ->when($sizeId, function ($query) use ($sizeId) {
                    return $query->where('size_id', $sizeId);
                })
                ->value('image');

            // Use variant image if available
            if ($variantImage) {
                $imageToUse = $variantImage;
            }
        }

        if (isset($cart[$cartKey])) {
            // Update existing variant in cart
            $cart[$cartKey]['quantity'] = (int) $request->qty;
            $cart[$cartKey]['price'] = $request->price;
            $cart[$cartKey]['discount_price'] = $request->discount_price;
        } else {
            // Add new variant to cart
            $cart[$cartKey] = [
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => (int) $request->qty,
                "price" => $request->price,
                "discount_price" => $request->discount_price,
                "image" => $imageToUse, // Use variant image if available, otherwise main product image
                // variant
                "color_id" => $colorId,
                "size_id" => $sizeId,
                // package identification
                "is_package" => $product->is_package ? true : false,
                "is_product_qty_multiply" => $product->is_product_qty_multiply ? true : false,
                'has_variant' => $product->has_variant ? true : false,
                "product_id" => $request->product_id, // Store original product ID for package stock checking
                // for data layer
                "brand_name" => $product->brand_name,
                "category_name" => $product->category_name,
            ];
        }

        session()->put('cart', $cart);

        // Recalculate delivery cost when item is added with quantity
        $checkoutController = new CheckoutController();
        $checkoutController->recalculateDeliveryCost();

        $returnHTML = view('tenant.frontend.layouts.partials.sidebar_cart')->render();
        return response()->json([
            'rendered_cart' => $returnHTML,
            'cartTotalQty' => count(session('cart')),

            // for data layer
            'p_name_data_layer' => $product->name,
            'p_price_data_layer' => $request->discount_price > 0 ? $request->discount_price : $request->price,
            'p_brand_name' => $product->brand_name,
            'p_category_name' => $product->category_name,
            'p_qauntity' => (int) $request->qty,
        ]);
    }
}
