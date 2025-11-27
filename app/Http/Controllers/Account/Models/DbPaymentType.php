<?php

namespace App\Http\Controllers\Account\Models;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbPaymentType extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = "db_paymenttypes";

    public function user()
    {
        return $this->belongsTo(User::class, 'creator');
    }
}
