<?php

namespace App\Modules\MLM\Managements\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

/**
 * MLM Referral Activity Log Model
 * 
 * Tracks all referral-based commission events generated after orders.
 * Each row represents one activity event (commission generation, approval, payment, etc.)
 */
class MlmReferralActivityLog extends Model
{
    protected $table = 'mlm_referral_activity_logs';

    protected $fillable = [
        'buyer_id',
        'referrer_id',
        'order_id',
        'level',
        'commission_amount',
        'status',
        'activity_type',
        'meta',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Activity type constants
     */
    const ACTIVITY_ORDER_PLACED = 'order_placed';
    const ACTIVITY_COMMISSION_GENERATED = 'commission_generated';
    const ACTIVITY_COMMISSION_APPROVED = 'commission_approved';
    const ACTIVITY_COMMISSION_PAID = 'commission_paid';
    const ACTIVITY_COMMISSION_CANCELLED = 'commission_cancelled';

    /**
     * Relationships
     */

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scopes
     */

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByReferrer($query, $referrerId)
    {
        return $query->where('referrer_id', $referrerId);
    }

    /**
     * Helpers
     */

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_APPROVED => 'badge-info',
            self::STATUS_PAID => 'badge-success',
            self::STATUS_CANCELLED => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    public function getLevelBadgeClass()
    {
        return match ($this->level) {
            1 => 'badge-primary',
            2 => 'badge-success',
            3 => 'badge-warning',
            default => 'badge-secondary',
        };
    }
}
