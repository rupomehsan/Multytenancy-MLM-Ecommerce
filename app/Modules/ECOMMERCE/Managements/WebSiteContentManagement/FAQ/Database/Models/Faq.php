<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'answer', 'slug'];
}
