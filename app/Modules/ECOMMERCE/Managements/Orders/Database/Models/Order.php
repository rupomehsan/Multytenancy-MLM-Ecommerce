<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\ShippingInfo;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\BillingAddress;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderDetails;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderDeliveyMan;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Database\Models\Outlet;
use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;
use App\Modules\INVENTORY\Managements\WareHouse\Database\Models\ProductWarehouse;
use App\Modules\INVENTORY\Managements\WareHouseRoom\Database\Models\ProductWarehouseRoom;
use App\Modules\INVENTORY\Managements\WareHouseRoomCartoon\Database\Models\ProductWarehouseRoomCartoon;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Order Status Constants
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DISPATCH = 2;
    const STATUS_INTRANSIT = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_DELIVERED = 5;
    const STATUS_RETURN = 6;

    // Payment Method Constants
    const PAYMENT_COD = 1;
    const PAYMENT_BKASH = 2;
    const PAYMENT_NAGAD = 3;
    const PAYMENT_CARD = 4;
    const PAYMENT_BANK_TRANSFER = 5;
    const PAYMENT_SSL_COMMERZ = 6;
    const PAYMENT_PAYPAL = 7;
    const PAYMENT_STRIPE = 8;

    // Payment Status Constants
    const PAYMENT_STATUS_UNPAID = 0;
    const PAYMENT_STATUS_PAID = 1;
    const PAYMENT_STATUS_FAILED = 2;

    // Delivery Method Constants
    const DELIVERY_HOME = 1; // HOME_DELIVERY
    const DELIVERY_STORE_PICKUP = 2; // STORE_PICKUP
    const DELIVERY_POS_HANDOVER = 3; // POS_HANDOVER

    // Order From Constants
    const ORDER_FROM_WEB = 1;
    const ORDER_FROM_APP = 2;
    const ORDER_FROM_POS = 3;
    const ORDER_FROM_SOCIAL = 4;

    // Order Source Constants
    const ORDER_SOURCE_ECOMMERCE = 1;
    const ORDER_SOURCE_POS = 2;

    // Complete Order Constants
    const COMPLETE_ORDER_INCOMPLETE = 0; // Address missing
    const COMPLETE_ORDER_COMPLETE = 1; // Address given

    /**
     * Get all order statuses
     */
    public static function getOrderStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_DISPATCH => 'Dispatch',
            self::STATUS_INTRANSIT => 'Intransit',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_RETURN => 'Return',
        ];
    }

    /**
     * Get order status name
     */
    public function getOrderStatusNameAttribute()
    {
        $statuses = self::getOrderStatuses();
        return $statuses[$this->order_status] ?? 'Unknown';
    }

    /**
     * Get order status badge HTML
     */
    public function getOrderStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => '<span class="badge badge-soft-warning" style="padding: 2px 10px !important;">Pending</span>',
            self::STATUS_APPROVED => '<span class="badge badge-soft-info" style="padding: 2px 10px !important;">Approved</span>',
            self::STATUS_DISPATCH => '<span class="badge badge-soft-primary" style="padding: 2px 10px !important;">Dispatch</span>',
            self::STATUS_INTRANSIT => '<span class="badge badge-soft-info" style="padding: 2px 10px !important;">Intransit</span>',
            self::STATUS_DELIVERED => '<span class="badge badge-soft-success" style="padding: 2px 10px !important;">Delivered</span>',
            self::STATUS_RETURN => '<span class="badge badge-soft-dark" style="padding: 2px 10px !important;">Return</span>',
            self::STATUS_CANCELLED => '<span class="badge badge-soft-danger" style="padding: 2px 10px !important;">Cancelled</span>',
        ];
        return $badges[$this->order_status] ?? '<span class="badge badge-soft-secondary">Unknown</span>';
    }

    /**
     * Get payment method name
     */
    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            self::PAYMENT_COD => 'Cash on Delivery',
            self::PAYMENT_BKASH => 'bKash',
            self::PAYMENT_NAGAD => 'Nagad',
            self::PAYMENT_CARD => 'Card',
            self::PAYMENT_BANK_TRANSFER => 'Bank Transfer',
            self::PAYMENT_SSL_COMMERZ => 'SSLCommerz',
            self::PAYMENT_PAYPAL => 'PayPal',
            self::PAYMENT_STRIPE => 'Stripe',
        ];
        return $methods[$this->payment_method] ?? 'N/A';
    }

    /**
     * Get delivery method name
     */
    public function getDeliveryMethodNameAttribute()
    {
        $methods = [
            self::DELIVERY_HOME => 'Home Delivery',
            self::DELIVERY_STORE_PICKUP => 'Store Pickup',
            self::DELIVERY_POS_HANDOVER => 'POS Handover',
        ];
        return $methods[$this->delivery_method] ?? 'N/A';
    }

    /**
     * Get payment status name
     */
    public function getPaymentStatusNameAttribute()
    {
        $statuses = [
            self::PAYMENT_STATUS_UNPAID => 'Unpaid',
            self::PAYMENT_STATUS_PAID => 'Paid',
            self::PAYMENT_STATUS_FAILED => 'Failed',
        ];
        return $statuses[$this->payment_status] ?? 'Unknown';
    }

    /**
     * Define allowed status transitions based on current status
     * Returns array of status values that can be transitioned to
     */
    public static function getAllowedStatusTransitions($currentStatus)
    {
        $transitions = [
            self::STATUS_PENDING => [
                self::STATUS_PENDING,
                self::STATUS_APPROVED,
                self::STATUS_CANCELLED,
            ],
            self::STATUS_APPROVED => [
                self::STATUS_APPROVED,
                self::STATUS_DISPATCH,
                self::STATUS_CANCELLED,
            ],
            self::STATUS_DISPATCH => [
                self::STATUS_DISPATCH,
                self::STATUS_INTRANSIT,
                self::STATUS_CANCELLED,
            ],
            self::STATUS_INTRANSIT => [
                self::STATUS_INTRANSIT,
                self::STATUS_DELIVERED,
                self::STATUS_RETURN,
            ],
            self::STATUS_DELIVERED => [
                self::STATUS_DELIVERED,
                self::STATUS_RETURN,
            ],
            self::STATUS_RETURN => [
                self::STATUS_RETURN,
            ],
            self::STATUS_CANCELLED => [
                self::STATUS_CANCELLED,
            ],
        ];

        return $transitions[$currentStatus] ?? [];
    }

    /**
     * Check if status transition is allowed
     */
    public function canTransitionTo($newStatus)
    {
        $allowedStatuses = self::getAllowedStatusTransitions($this->order_status);
        return in_array($newStatus, $allowedStatuses);
    }

    /**
     * Get available statuses for current order
     */
    public function getAvailableStatusesAttribute()
    {
        $allowedStatusValues = self::getAllowedStatusTransitions($this->order_status);
        $allStatuses = self::getOrderStatuses();

        return array_filter($allStatuses, function ($key) use ($allowedStatusValues) {
            return in_array($key, $allowedStatusValues);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function warehouse()
    {
        return $this->belongsTo(ProductWarehouse::class, 'warehouse_id');
    }

    public function room()
    {
        return $this->belongsTo(ProductWarehouseRoom::class, 'room_id');
    }

    public function cartoon()
    {
        return $this->belongsTo(ProductWarehouseRoomCartoon::class, 'cartoon_id');
    }

    public function customerSourceType()
    {
        return $this->belongsTo(CustomerSourceType::class, 'customer_src_type_id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }


    public function shippingInfo()
    {
        return $this->hasOne(ShippingInfo::class, 'order_id');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'order_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function customerSourceType() {
    //     return $this->belongsTo(CustomerSourceType::class, 'customer_src_type_id');
    // }

    public function orderDeliveryMen()
    {
        return $this->hasOne(OrderDeliveyMan::class, 'order_id');
    }
}
