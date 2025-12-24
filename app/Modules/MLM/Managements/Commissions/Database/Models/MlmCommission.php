<?php

namespace App\Modules\MLM\Managements\Commissions\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\MLM\Managements\Wallet\Database\Models\WalletTransaction;

/**
 * MLM Commission Model
 * 
 * Represents individual commission records for each referral level
 * when an order is delivered.
 * 
 * @property int $id
 * @property int $order_id
 * @property int $buyer_id
 * @property int $referrer_id
 * @property int $level
 * @property float $commission_amount
 * @property string $status
 * @property float $percentage_used
 * @property string $notes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class MlmCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mlm_commissions';

    protected $fillable = [
        'order_id',
        'buyer_id',
        'referrer_id',
        'level',
        'commission_amount',
        'status',
        'percentage_used',
        'notes',
    ];

    protected $casts = [
        'commission_amount' => 'decimal:2',
        'percentage_used' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_PAID = 'paid';
    const STATUS_REJECTED = 'rejected';

    /**
     * Get the order associated with this commission
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the buyer (customer who placed the order)
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the referrer (person receiving the commission)
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get wallet transaction associated with this commission
     */
    public function walletTransaction()
    {
        return $this->hasOne(WalletTransaction::class, 'mlm_commission_id');
    }

    /**
     * Scope: Get pending commissions
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: Get approved commissions
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope: Get paid commissions
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    /**
     * Scope: Get rejected commissions
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Scope: Get commissions for a specific referrer
     */
    public function scopeForReferrer($query, $referrerId)
    {
        return $query->where('referrer_id', $referrerId);
    }

    /**
     * Scope: Get commissions for a specific order
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope: Get commissions for a specific level
     */
    public function scopeForLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Check if commission is already paid
     */
    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Check if commission is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Mark commission as approved
     */
    public function markAsApproved()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    /**
     * Mark commission as paid
     */
    public function markAsPaid()
    {
        $this->status = self::STATUS_PAID;
        $this->save();
    }

    /**
     * Mark commission as rejected
     */
    public function markAsRejected($notes = null)
    {
        $this->status = self::STATUS_REJECTED;
        if ($notes) {
            $this->notes = $notes;
        }
        $this->save();
    }

    /**
     * Get formatted commission amount
     */
    public function getFormattedAmountAttribute()
    {
        return '৳' . number_format($this->commission_amount, 2);
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => '<span class="badge badge-warning">Pending</span>',
            self::STATUS_APPROVED => '<span class="badge badge-info">Approved</span>',
            self::STATUS_PAID => '<span class="badge badge-success">Paid</span>',
            self::STATUS_REJECTED => '<span class="badge badge-danger">Rejected</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    /**
     * Get level name
     */
    public function getLevelNameAttribute()
    {
        $levels = [
            1 => 'Level 1 (Direct)',
            2 => 'Level 2',
            3 => 'Level 3',
        ];

        return $levels[$this->level] ?? 'Unknown Level';
    }
}
