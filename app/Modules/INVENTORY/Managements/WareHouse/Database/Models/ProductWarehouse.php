<?php

namespace App\Modules\INVENTORY\Managements\WareHouse\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\INVENTORY\Managements\WareHouse\Database\Models\ProductWarehouseRoom;
use App\Http\Controllers\Inventory\Models\ProductWarehouseRoomCartoon;

class ProductWarehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productWarehouseRoom()
    {
        return $this->hasMany(ProductWarehouseRoom::class);
    }

    public function productWarehouseRoomCartoon()
    {
        return $this->hasMany(ProductWarehouseRoomCartoon::class);
    }
}
