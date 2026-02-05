<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\PackageProducts\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class PackageProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_product_id',
        'product_id',
        'color_id',
        'size_id',
        'quantity'
    ];

    /**
     * Get the package product that owns this item
     */
    public function packageProduct()
    {
        return $this->belongsTo(Product::class, 'package_product_id');
    }

    /**
     * Get the product included in this package
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color of the product
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the size of the product
     */
    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'size_id');
    }
}
