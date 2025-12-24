<?php

namespace App\Modules\MLM\Managements\Withdrow\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * WithdrawalHistory Model
 * 
 * Tracks all actions and status changes for withdrawal requests.
 * Provides complete audit trail for compliance and monitoring.
 */
class WithdrawalHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mlm_withdrawal_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'withdrawal_request_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'performed_by',
        'notes',
        'amount',
        'payment_method',
        'transaction_reference',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Action constants
     */
    const ACTION_CREATED = 'created';
    const ACTION_APPROVED = 'approved';
    const ACTION_REJECTED = 'rejected';
    const ACTION_PROCESSING = 'processing';
    const ACTION_COMPLETED = 'completed';
    const ACTION_CANCELLED = 'cancelled';

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the withdrawal request that owns the history entry.
     */
    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(
            'App\Modules\MLM\Managements\Withdrow\Database\Models\WithdrawalRequest',
            'withdrawal_request_id'
        );
    }

    /**
     * Get the user who requested the withdrawal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            'App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User',
            'user_id'
        );
    }

    /**
     * Get the user who performed the action.
     */
    public function performer(): BelongsTo
    {
        return $this->belongsTo(
            'App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User',
            'performed_by'
        );
    }

    /**
     * Scope to filter by action type.
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by withdrawal request.
     */
    public function scopeForRequest($query, int $withdrawalRequestId)
    {
        return $query->where('withdrawal_request_id', $withdrawalRequestId);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the badge class for the action.
     */
    public function getActionBadgeClass(): string
    {
        return match ($this->action) {
            self::ACTION_CREATED => 'badge-secondary',
            self::ACTION_APPROVED => 'badge-primary',
            self::ACTION_PROCESSING => 'badge-info',
            self::ACTION_COMPLETED => 'badge-success',
            self::ACTION_REJECTED, self::ACTION_CANCELLED => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    /**
     * Get formatted action label.
     */
    public function getActionLabel(): string
    {
        return match ($this->action) {
            self::ACTION_CREATED => 'Request Created',
            self::ACTION_APPROVED => 'Request Approved',
            self::ACTION_REJECTED => 'Request Rejected',
            self::ACTION_PROCESSING => 'Payment Processing',
            self::ACTION_COMPLETED => 'Payment Completed',
            self::ACTION_CANCELLED => 'Request Cancelled',
            default => ucfirst($this->action),
        };
    }
}
