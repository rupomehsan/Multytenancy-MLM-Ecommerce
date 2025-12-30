<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class POSOrderPlacementTest extends TestCase
{
    /**
     * Test POS order placement with valid data
     *
     * @return void
     */
    public function test_pos_order_can_be_placed_successfully()
    {
        // Setup: Create a mock cart session
        Session::put('cart', [
            'test_1' => [
                'product_id' => 1,
                'name' => 'Test Product',
                'price' => 100,
                'quantity' => 2,
                'color_id' => null,
                'size_id' => null,
                'image' => '/path/to/image.jpg',
                'discount_price' => 0,
                'purchase_product_warehouse_id' => 0,
                'purchase_product_warehouse_room_id' => 0,
                'purchase_product_warehouse_room_cartoon_id' => 0,
            ]
        ]);

        // Prepare request data matching the new structure
        $orderData = [
            'customer_id' => null,
            'products' => [
                [
                    'product_id' => '1',
                    'color_id' => null,
                    'size_id' => null,
                    'purchase_product_warehouse_id' => '0',
                    'purchase_product_warehouse_room_id' => '0',
                    'purchase_product_warehouse_room_cartoon_id' => '0',
                    'price' => '100',
                    'quantity' => '2',
                    'discount_price' => '0',
                ]
            ],
            'subtotal_gross' => '200',
            'item_discount_total' => '0',
            'shipping_charge' => '50',
            'discount' => '0',
            'total' => '250',
            'delivery_method' => Order::DELIVERY_POS_HANDOVER,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '01712345678',
            'shipping_email' => 'test@example.com',
            'shipping_address' => 'Test Address',
            'shipping_district_id' => '1',
            'shipping_thana_id' => '1',
            'shipping_postal_code' => '1234',
            'billing_name' => 'Test Customer',
            'billing_phone' => '01712345678',
        ];

        // Execute: Submit the order
        $response = $this->post(route('PosPlaceOrder'), $orderData);

        // Assert: Check response and database
        $response->assertStatus(302); // Redirect on success

        $this->assertDatabaseHas('orders', [
            'order_from' => Order::ORDER_FROM_POS,
            'order_source' => Order::ORDER_SOURCE_POS,
            'delivery_method' => Order::DELIVERY_POS_HANDOVER,
        ]);

        $this->assertDatabaseHas('order_details', [
            'product_id' => 1,
            'qty' => 2,
            'unit_price' => 100,
        ]);

        $this->assertDatabaseHas('order_payments', [
            'payment_through' => 'POS',
        ]);
    }

    /**
     * Test validation: cart must not be empty
     *
     * @return void
     */
    public function test_pos_order_fails_with_empty_cart()
    {
        Session::forget('cart');

        $orderData = [
            'products' => [],
            'delivery_method' => Order::DELIVERY_POS_HANDOVER,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '01712345678',
        ];

        $response = $this->post(route('PosPlaceOrder'), $orderData);

        // Should fail validation or return error
        $response->assertSessionHasErrors();
    }

    /**
     * Test home delivery requires shipping address
     *
     * @return void
     */
    public function test_home_delivery_requires_full_address()
    {
        Session::put('cart', [
            'test_1' => [
                'product_id' => 1,
                'name' => 'Test Product',
                'price' => 100,
                'quantity' => 1,
                'discount_price' => 0,
            ]
        ]);

        $orderData = [
            'products' => [[
                'product_id' => '1',
                'price' => '100',
                'quantity' => '1',
                'discount_price' => '0',
            ]],
            'delivery_method' => Order::DELIVERY_HOME,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '01712345678',
            // Missing required address fields
        ];

        $response = $this->post(route('PosPlaceOrder'), $orderData);

        $response->assertSessionHasErrors(['shipping_address', 'shipping_district_id', 'shipping_thana_id']);
    }

    /**
     * Test store pickup does not require address
     *
     * @return void
     */
    public function test_store_pickup_does_not_require_address()
    {
        Session::put('cart', [
            'test_1' => [
                'product_id' => 1,
                'price' => 100,
                'quantity' => 1,
                'discount_price' => 0,
            ]
        ]);

        $orderData = [
            'products' => [[
                'product_id' => '1',
                'price' => '100',
                'quantity' => '1',
                'discount_price' => '0',
            ]],
            'subtotal_gross' => '100',
            'item_discount_total' => '0',
            'total' => '100',
            'delivery_method' => Order::DELIVERY_STORE_PICKUP,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '01712345678',
            // No address required for pickup
        ];

        $response = $this->post(route('PosPlaceOrder'), $orderData);

        // Should not have address validation errors
        $response->assertSessionMissingErrors(['shipping_address', 'shipping_district_id']);
    }
}
