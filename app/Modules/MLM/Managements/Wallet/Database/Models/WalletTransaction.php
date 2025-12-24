<?php

namespace App\Modules\MLM\Managements\Wallet\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\MLM\Managements\Commissions\Database\Models\MlmCommission;

/**
 * Wallet Transaction Model
 * 
 * Records all wallet balance changes including commission credits,
 * withdrawals, and reversals.
 * 
 * @property int $id
 * @property int $user_id
 * @property string $transaction_type
 * @property float $amount
 * @property float $balance_after
 * @property int $mlm_commission_id
 * @property int $order_id
 * @property string $description
 * @property string $notes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class WalletTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'balance_after',
        'mlm_commission_id',
        'order_id',
        'description',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Transaction type constants
    const TYPE_COMMISSION_CREDIT = 'commission_credit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_COMMISSION_REVERSAL = 'commission_reversal';
    const TYPE_ADMIN_ADJUSTMENT = 'admin_adjustment';
    const TYPE_OTHER = 'other';

    /**
     * Get the user associated with this transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the commission associated with this transaction
     */
    public function mlmCommission()
    {
        return $this->belongsTo(MlmCommission::class, 'mlm_commission_id');
    }

    /**
     * Get the order associated with this transaction
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope: Get transactions for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get credit transactions
     */
    public function scopeCredits($query)
    {
        return $query->where('amount', '>', 0);
    }

    /**
     * Scope: Get debit transactions
     */
    public function scopeDebits($query)
    {
        return $query->where('amount', '<', 0);
    }

    /**
     * Scope: Get commission transactions
     */
    public function scopeCommissions($query)
    {
        return $query->where('transaction_type', self::TYPE_COMMISSION_CREDIT);
    }

    /**
     * Scope: Get withdrawal transactions
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('transaction_type', self::TYPE_WITHDRAWAL);
    }

    /**
     * Scope: Get reversal transactions
     */
    public function scopeReversals($query)
    {
        return $query->where('transaction_type', self::TYPE_COMMISSION_REVERSAL);
    }

    /**
     * Check if transaction is a credit
     */
    public function isCredit()
    {
        return $this->amount > 0;
    }

    /**
     * Check if transaction is a debit
     */
    public function isDebit()
    {
        return $this->amount < 0;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        $prefix = $this->amount >= 0 ? '+' : '';
        return $prefix . '৳' . number_format(abs($this->amount), 2);
    }

    /**
     * Get formatted balance
     */
    public function getFormattedBalanceAttribute()
    {
        return '৳' . number_format($this->balance_after, 2);
    }

    /**
     * Get transaction type label
     */
    public function getTransactionTypeLabelAttribute()
    {
        $labels = [
            self::TYPE_COMMISSION_CREDIT => 'Commission Credit',
            self::TYPE_WITHDRAWAL => 'Withdrawal',
            self::TYPE_COMMISSION_REVERSAL => 'Commission Reversal',
            self::TYPE_ADMIN_ADJUSTMENT => 'Admin Adjustment',
            self::TYPE_OTHER => 'Other',
        ];

        return $labels[$this->transaction_type] ?? 'Unknown';
    }

    /**
     * Get transaction type badge
     */
    public function getTransactionTypeBadgeAttribute()
    {
        $badges = [
            self::TYPE_COMMISSION_CREDIT => '<span class="badge badge-success">Commission Credit</span>',
            self::TYPE_WITHDRAWAL => '<span class="badge badge-warning">Withdrawal</span>',
            self::TYPE_COMMISSION_REVERSAL => '<span class="badge badge-danger">Reversal</span>',
            self::TYPE_ADMIN_ADJUSTMENT => '<span class="badge badge-info">Admin Adjustment</span>',
            self::TYPE_OTHER => '<span class="badge badge-secondary">Other</span>',
        ];

        return $badges[$this->transaction_type] ?? '<span class="badge badge-secondary">Unknown</span>';
    }
}
