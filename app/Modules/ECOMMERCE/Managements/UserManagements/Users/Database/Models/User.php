<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * User Type Constants
     */
    const ADMIN = 1;
    const SYSTEM_USER = 2;
    const CUSTOMER = 3;
    const DELIVERY_BOY = 4;

    /**
     * User Types Array
     */
    const USER_TYPES = [
        'ADMIN' => self::ADMIN,
        'SYSTEM_USER' => self::SYSTEM_USER,
        'CUSTOMER' => self::CUSTOMER,
        'DELIVERY_BOY' => self::DELIVERY_BOY,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'phone',
        'address',
        'balance',
        'verification_code',
        'referral_code',
        'referred_by',
        'wallet_balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all customers referred by this user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by', 'id');
    }

    /**
     * Get the parent customer who referred this user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    /**
     * Get count of direct referrals.
     * 
     * @return int
     */
    public function getDirectReferralsCountAttribute()
    {
        return $this->referrals()->count();
    }
}
