<?php


namespace App\Modules\INVENTORY\Managements\WareHouseRoomCartoon\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\INVENTORY\Managements\WareHouse\Database\Models\ProductWarehouse;
use App\Modules\INVENTORY\Managements\WareHouseRoom\Database\Models\ProductWarehouseRoom;

class ProductWarehouseRoomCartoon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productWarehouse()
    {
        return $this->belongsTo(ProductWarehouse::class, 'product_warehouse_id');
    }

    public function productWarehouseRoom()
    {
        return $this->belongsTo(ProductWarehouseRoom::class, 'product_warehouse_room_id');
    }
}
