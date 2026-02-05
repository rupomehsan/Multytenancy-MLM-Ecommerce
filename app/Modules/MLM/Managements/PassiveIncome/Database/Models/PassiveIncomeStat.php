<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Database\Models;

use Illuminate\Database\Eloquent\Model;

class PassiveIncomeStat extends Model
{
    protected $table = 'passive_income_stats';

    protected $fillable = [
        'user_id',
        'is_verified_seller',
        'level_1_count',
        'level_2_count',
        'level_3_count',
        'level_4_count',
        'delivered_orders',
        'estimated_daily_commission',
    ];
}
