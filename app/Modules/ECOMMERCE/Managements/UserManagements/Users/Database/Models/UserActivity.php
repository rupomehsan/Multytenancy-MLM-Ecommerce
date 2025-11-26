<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'last_seen'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
