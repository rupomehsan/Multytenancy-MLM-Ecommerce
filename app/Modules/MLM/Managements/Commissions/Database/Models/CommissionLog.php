<?php

namespace App\Modules\MLM\Managements\Commissions\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

/**
 * Commission Log Model
 * 
 * Tracks all commission-related activities including creation,
 * approval, rejection, and wallet transactions.
 * 
 * @property int $id
 * @property int $commission_id
 * @property int $order_id
 * @property int $referrer_id
 * @property string $activity_type
 * @property string $old_status
 * @property string $new_status
 * @property float $amount
 * @property float $old_wallet_balance
 * @property float $new_wallet_balance
 * @property int $performed_by
 * @property string $action_source
 * @property string $title
 * @property string $description
 * @property array $metadata
 * @property string $ip_address
 * @property string $user_agent
 * @property string $error_message
 * @property string $error_trace
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CommissionLog extends Model
{
    use HasFactory;

    protected $table = 'mlm_commission_logs';

    protected $fillable = [
        'commission_id',
        'order_id',
        'referrer_id',
        'activity_type',
        'old_status',
        'new_status',
        'amount',
        'old_wallet_balance',
        'new_wallet_balance',
        'performed_by',
        'action_source',
        'title',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
        'error_message',
        'error_trace',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'old_wallet_balance' => 'decimal:2',
        'new_wallet_balance' => 'decimal:2',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Activity type constants
    const TYPE_CREATED = 'created';
    const TYPE_CALCULATED = 'calculated';
    const TYPE_APPROVED = 'approved';
    const TYPE_REJECTED = 'rejected';
    const TYPE_PAID = 'paid';
    const TYPE_REVERSED = 'reversed';
    const TYPE_STATUS_CHANGED = 'status_changed';
    const TYPE_WALLET_CREDITED = 'wallet_credited';
    const TYPE_WALLET_DEBITED = 'wallet_debited';
    const TYPE_ERROR = 'error';
    const TYPE_OTHER = 'other';

    // Action source constants
    const SOURCE_ADMIN = 'admin';
    const SOURCE_SYSTEM = 'system';
    const SOURCE_API = 'api';
    const SOURCE_OBSERVER = 'observer';
    const SOURCE_SERVICE = 'service';
    const SOURCE_MANUAL = 'manual';
    const SOURCE_CRON = 'cron';

    /**
     * Get the commission associated with this log
     */
    public function commission()
    {
        return $this->belongsTo(MlmCommission::class, 'commission_id');
    }

    /**
     * Get the order associated with this log
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the referrer (beneficiary)
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who performed the action
     */
    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Scope: Get logs for a specific commission
     */
    public function scopeForCommission($query, $commissionId)
    {
        return $query->where('commission_id', $commissionId);
    }

    /**
     * Scope: Get logs for a specific order
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope: Get logs for a specific referrer
     */
    public function scopeForReferrer($query, $referrerId)
    {
        return $query->where('referrer_id', $referrerId);
    }

    /**
     * Scope: Get logs by activity type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope: Get error logs
     */
    public function scopeErrors($query)
    {
        return $query->where('activity_type', self::TYPE_ERROR);
    }

    /**
     * Scope: Get wallet transaction logs
     */
    public function scopeWalletTransactions($query)
    {
        return $query->whereIn('activity_type', [self::TYPE_WALLET_CREDITED, self::TYPE_WALLET_DEBITED]);
    }

    /**
     * Get formatted activity type
     */
    public function getActivityTypeNameAttribute()
    {
        $types = [
            self::TYPE_CREATED => 'Commission Created',
            self::TYPE_CALCULATED => 'Commission Calculated',
            self::TYPE_APPROVED => 'Commission Approved',
            self::TYPE_REJECTED => 'Commission Rejected',
            self::TYPE_PAID => 'Commission Paid',
            self::TYPE_REVERSED => 'Commission Reversed',
            self::TYPE_STATUS_CHANGED => 'Status Changed',
            self::TYPE_WALLET_CREDITED => 'Wallet Credited',
            self::TYPE_WALLET_DEBITED => 'Wallet Debited',
            self::TYPE_ERROR => 'Error',
            self::TYPE_OTHER => 'Other',
        ];

        return $types[$this->activity_type] ?? 'Unknown';
    }

    /**
     * Static method to create a log entry
     */
    public static function createLog(array $data)
    {
        return static::create(array_merge($data, [
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
        ]));
    }

    /**
     * Log commission creation
     */
    public static function logCreation($commissionId, $orderId, $referrerId, $amount, $level, $percentage, $description = null)
    {
        return static::createLog([
            'commission_id' => $commissionId,
            'order_id' => $orderId,
            'referrer_id' => $referrerId,
            'activity_type' => self::TYPE_CREATED,
            'amount' => $amount,
            'action_source' => self::SOURCE_OBSERVER,
            'title' => "Level {$level} commission created",
            'description' => $description ?? "Commission of ৳{$amount} ({$percentage}%) created for referrer",
            'metadata' => [
                'level' => $level,
                'percentage' => $percentage,
            ],
        ]);
    }

    /**
     * Log commission approval and wallet credit
     */
    public static function logApprovalAndCredit($commissionId, $orderId, $referrerId, $amount, $oldBalance, $newBalance, $performedBy = null)
    {
        return static::createLog([
            'commission_id' => $commissionId,
            'order_id' => $orderId,
            'referrer_id' => $referrerId,
            'activity_type' => self::TYPE_WALLET_CREDITED,
            'old_status' => 'pending',
            'new_status' => 'paid',
            'amount' => $amount,
            'old_wallet_balance' => $oldBalance,
            'new_wallet_balance' => $newBalance,
            'performed_by' => $performedBy,
            'action_source' => $performedBy ? self::SOURCE_ADMIN : self::SOURCE_SERVICE,
            'title' => "Commission approved and wallet credited",
            'description' => "Commission of ৳{$amount} credited to wallet. Balance: ৳{$oldBalance} → ৳{$newBalance}",
        ]);
    }

    /**
     * Log commission reversal
     */
    public static function logReversal($commissionId, $orderId, $referrerId, $amount, $oldBalance = null, $newBalance = null, $reason = null)
    {
        return static::createLog([
            'commission_id' => $commissionId,
            'order_id' => $orderId,
            'referrer_id' => $referrerId,
            'activity_type' => self::TYPE_REVERSED,
            'amount' => -$amount,
            'old_wallet_balance' => $oldBalance,
            'new_wallet_balance' => $newBalance,
            'action_source' => self::SOURCE_OBSERVER,
            'title' => "Commission reversed",
            'description' => $reason ?? "Commission of ৳{$amount} reversed due to order cancellation",
        ]);
    }

    /**
     * Log commission rejection
     */
    public static function logRejection($commissionId, $orderId, $referrerId, $amount, $reason = null, $performedBy = null)
    {
        return static::createLog([
            'commission_id' => $commissionId,
            'order_id' => $orderId,
            'referrer_id' => $referrerId,
            'activity_type' => self::TYPE_REJECTED,
            'old_status' => 'pending',
            'new_status' => 'rejected',
            'amount' => $amount,
            'performed_by' => $performedBy,
            'action_source' => $performedBy ? self::SOURCE_ADMIN : self::SOURCE_OBSERVER,
            'title' => "Commission rejected",
            'description' => $reason ?? "Commission rejected",
        ]);
    }

    /**
     * Log error
     */
    public static function logError($commissionId, $orderId, $referrerId, $errorMessage, $errorTrace = null, $metadata = null)
    {
        return static::createLog([
            'commission_id' => $commissionId,
            'order_id' => $orderId,
            'referrer_id' => $referrerId,
            'activity_type' => self::TYPE_ERROR,
            'action_source' => self::SOURCE_SYSTEM,
            'title' => "Commission processing error",
            'description' => "Error occurred during commission processing",
            'error_message' => $errorMessage,
            'error_trace' => $errorTrace,
            'metadata' => $metadata,
        ]);
    }
}
