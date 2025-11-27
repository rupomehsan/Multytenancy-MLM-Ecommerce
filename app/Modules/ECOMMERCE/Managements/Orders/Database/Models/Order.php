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
