<?php

namespace App\Modules\INVENTORY\Managements\Purchase\Quotations\Database\Models;

use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchaseQuotationProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quotation()
    {
        return $this->belongsTo(ProductPurchaseQuotation::class, 'product_purchase_quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
