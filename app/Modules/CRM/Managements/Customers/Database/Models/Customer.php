<?php

namespace App\Modules\CRM\Managements\Customers\Database\Models;

use App\Modules\CRM\Managements\CustomerSourceType\Database\Models\CustomerSourceType;
use App\Modules\CRM\Managements\CustomerCategory\Database\Models\CustomerCategory;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function customerCategory()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
    }

    public function customerSourceType()
    {
        return $this->belongsTo(CustomerSourceType::class, 'customer_source_type_id');
    }

    public function referenceBy()
    {
        return $this->belongsTo(User::class, 'reference_by');
    }
}
