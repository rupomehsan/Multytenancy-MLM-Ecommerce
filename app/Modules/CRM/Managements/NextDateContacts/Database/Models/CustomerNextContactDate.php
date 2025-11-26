<?php

namespace App\Modules\CRM\Managements\NextDateContacts\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\CRM\Managements\Customers\Database\Models\Customer;

class CustomerNextContactDate extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
