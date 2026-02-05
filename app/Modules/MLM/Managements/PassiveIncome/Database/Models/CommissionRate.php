<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Database\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionRate extends Model
{
    protected $table = 'commission_rates';

    protected $fillable = [
        'min_price',
        'max_price',
        'level_1_commission',
        'level_2_commission',
        'level_3_commission',
        'level_4_commission',
        'sort_order',
    ];

    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'level_1_commission' => 'decimal:2',
        'level_2_commission' => 'decimal:2',
        'level_3_commission' => 'decimal:2',
        'level_4_commission' => 'decimal:2',
        'sort_order' => 'integer',
    ];
}
