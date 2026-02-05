<?php

namespace App\Modules\CRM\Managements\CustomerSourceType\Database\Models;

use App\Modules\CRM\Managements\Customers\Database\Models\Customer;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSourceType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_src_type_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_source_type_id');
    }
}
