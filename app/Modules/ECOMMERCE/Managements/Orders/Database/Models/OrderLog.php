<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

/**
 * Order Log Model
 * 
 * Tracks all order-related activities and status changes.
 * 
 * @property int $id
 * @property int $order_id
 * @property string $activity_type
 * @property string $old_status
 * @property string $new_status
 * @property int $performed_by
 * @property string $action_source
 * @property string $title
 * @property string $description
 * @property array $metadata
 * @property string $ip_address
 * @property string $user_agent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class OrderLog extends Model
{
    use HasFactory;

    protected $table = 'order_logs';

    protected $fillable = [
        'order_id',
        'activity_type',
        'old_status',
        'new_status',
        'performed_by',
        'action_source',
        'title',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Activity type constants
    const TYPE_STATUS_CHANGE = 'status_change';
    const TYPE_CREATED = 'created';
    const TYPE_UPDATED = 'updated';
    const TYPE_CANCELLED = 'cancelled';
    const TYPE_DELIVERED = 'delivered';
    const TYPE_PAYMENT_UPDATE = 'payment_update';
    const TYPE_COMMISSION_DISTRIBUTED = 'commission_distributed';
    const TYPE_COMMISSION_REVERSED = 'commission_reversed';
    const TYPE_OTHER = 'other';

    // Action source constants
    const SOURCE_ADMIN = 'admin';
    const SOURCE_CUSTOMER = 'customer';
    const SOURCE_SYSTEM = 'system';
    const SOURCE_API = 'api';
    const SOURCE_OBSERVER = 'observer';
    const SOURCE_MANUAL = 'manual';

    /**
     * Get the order associated with this log
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the user who performed the action
     */
    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Scope: Get logs for a specific order
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope: Get logs by activity type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope: Get logs by action source
     */
    public function scopeBySource($query, $source)
    {
        return $query->where('action_source', $source);
    }

    /**
     * Scope: Get logs performed by a specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('performed_by', $userId);
    }

    /**
     * Scope: Get system-generated logs
     */
    public function scopeSystemGenerated($query)
    {
        return $query->whereIn('action_source', [self::SOURCE_SYSTEM, self::SOURCE_OBSERVER]);
    }

    /**
     * Get formatted activity type
     */
    public function getActivityTypeNameAttribute()
    {
        $types = [
            self::TYPE_STATUS_CHANGE => 'Status Changed',
            self::TYPE_CREATED => 'Order Created',
            self::TYPE_UPDATED => 'Order Updated',
            self::TYPE_CANCELLED => 'Order Cancelled',
            self::TYPE_DELIVERED => 'Order Delivered',
            self::TYPE_PAYMENT_UPDATE => 'Payment Updated',
            self::TYPE_COMMISSION_DISTRIBUTED => 'Commission Distributed',
            self::TYPE_COMMISSION_REVERSED => 'Commission Reversed',
            self::TYPE_OTHER => 'Other',
        ];

        return $types[$this->activity_type] ?? 'Unknown';
    }

    /**
     * Get formatted action source
     */
    public function getActionSourceNameAttribute()
    {
        $sources = [
            self::SOURCE_ADMIN => 'Admin',
            self::SOURCE_CUSTOMER => 'Customer',
            self::SOURCE_SYSTEM => 'System',
            self::SOURCE_API => 'API',
            self::SOURCE_OBSERVER => 'Observer',
            self::SOURCE_MANUAL => 'Manual',
        ];

        return $sources[$this->action_source] ?? 'Unknown';
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
     * Log status change
     */
    public static function logStatusChange($orderId, $oldStatus, $newStatus, $performedBy = null, $source = self::SOURCE_SYSTEM, $description = null)
    {
        return static::createLog([
            'order_id' => $orderId,
            'activity_type' => self::TYPE_STATUS_CHANGE,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'performed_by' => $performedBy,
            'action_source' => $source,
            'title' => "Order status changed from {$oldStatus} to {$newStatus}",
            'description' => $description,
        ]);
    }

    /**
     * Log commission distribution
     */
    public static function logCommissionDistribution($orderId, $commissionCount, $performedBy = null, $description = null)
    {
        return static::createLog([
            'order_id' => $orderId,
            'activity_type' => self::TYPE_COMMISSION_DISTRIBUTED,
            'performed_by' => $performedBy,
            'action_source' => self::SOURCE_OBSERVER,
            'title' => "MLM commissions distributed",
            'description' => $description ?? "Distributed {$commissionCount} commission(s) for this order",
            'metadata' => ['commission_count' => $commissionCount],
        ]);
    }

    /**
     * Log commission reversal
     */
    public static function logCommissionReversal($orderId, $reversedCount, $performedBy = null, $description = null)
    {
        return static::createLog([
            'order_id' => $orderId,
            'activity_type' => self::TYPE_COMMISSION_REVERSED,
            'performed_by' => $performedBy,
            'action_source' => self::SOURCE_OBSERVER,
            'title' => "MLM commissions reversed",
            'description' => $description ?? "Reversed {$reversedCount} commission(s) due to order cancellation",
            'metadata' => ['reversed_count' => $reversedCount],
        ]);
    }
}
