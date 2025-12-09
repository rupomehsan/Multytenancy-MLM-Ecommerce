<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Database\Models;

use Illuminate\Database\Eloquent\Model;

class PassiveIncomeContent extends Model
{
    protected $table = 'passive_income_contents';

    protected $fillable = [
        'header_title',
        'header_subtitle',
        'intro_text',
        'what_is_title',
        'what_is_text',
        'how_title',
        'how_text',
        'seller_code_title',
        'seller_code_text',
        'why_title',
        'why_text',
        'commission_title',
        'commission_table_html',
        'conclusion_text',
        'terms_title',
        'terms_html',
    ];
}
