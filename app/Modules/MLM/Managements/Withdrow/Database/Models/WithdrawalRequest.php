<?php

namespace App\Modules\MLM\Managements\Withdrow\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * WithdrawalRequest Model
 * 
 * Represents a user's withdrawal request from their MLM wallet.
 */
class WithdrawalRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mlm_withdrawal_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
        'processed_by',
        'processed_at',
        'admin_notes',
        'wallet_transaction_id',
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
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the withdrawal request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            'App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User',
            'user_id'
        );
    }

    /**
     * Get the admin who processed the request.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(
            'App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User',
            'processed_by'
        );
    }

    /**
     * Get the history records for this withdrawal request.
     */
    public function history(): HasMany
    {
        return $this->hasMany(WithdrawalHistory::class, 'withdrawal_request_id');
    }
}
