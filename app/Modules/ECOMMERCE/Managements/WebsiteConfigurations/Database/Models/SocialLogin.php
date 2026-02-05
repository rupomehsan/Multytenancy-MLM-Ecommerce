<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fb_login_status',
        'fb_app_id',
        'fb_app_secret',
        'fb_redirect_url',
        'gmail_login_status',
        'gmail_client_id',
        'gmail_secret_id',
        'gmail_redirect_url',
        'updated_at'
    ];
}
