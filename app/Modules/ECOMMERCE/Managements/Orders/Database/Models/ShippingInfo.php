<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;


class ShippingInfo extends Model
{
    use HasFactory;


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
