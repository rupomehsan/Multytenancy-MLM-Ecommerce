<?php

namespace App\Modules\CRM\Managements\ContactHistory\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\CRM\Managements\Customers\Database\Models\Customer;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

class CustomerContactHistory extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
