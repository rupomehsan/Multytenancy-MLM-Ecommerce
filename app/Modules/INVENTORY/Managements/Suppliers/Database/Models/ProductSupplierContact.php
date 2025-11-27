<?php

namespace App\Modules\INVENTORY\Managements\Suppliers\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductSupplierContact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contactsupplier()
    {
        return $this->belongsTo(ProductSupplier::class, 'product_supplier_id');
    }
}
