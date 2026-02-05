<?php

namespace App\Modules\MLM\Managements\Withdrow\Services;

use App\Modules\MLM\Managements\Withdrow\Database\Models\WithdrawalHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * WithdrawalHistoryService
 * 
 * Handles creation and management of withdrawal history records.
 * Provides centralized logging for all withdrawal-related actions.
 */
class WithdrawalHistoryService
{
    /**
     * Log a withdrawal request creation.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string $paymentMethod
     * @param array $meta Additional metadata
     * @return WithdrawalHistory
     */
    public static function logCreated(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        string $paymentMethod,
        array $meta = []
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_CREATED,
            'old_status' => null,
            'new_status' => WithdrawalHistory::STATUS_PENDING,
            'performed_by' => $userId, // User created their own request
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'notes' => 'Withdrawal request created by user',
            'meta' => array_merge($meta, self::getRequestMeta()),
        ]);
    }

    /**
     * Log a withdrawal request approval.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string|null $adminNotes
     * @return WithdrawalHistory
     */
    public static function logApproved(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        ?string $adminNotes = null
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_APPROVED,
            'old_status' => WithdrawalHistory::STATUS_PENDING,
            'new_status' => WithdrawalHistory::STATUS_APPROVED,
            'performed_by' => Auth::id(),
            'amount' => $amount,
            'notes' => $adminNotes ?? 'Withdrawal request approved',
            'meta' => self::getRequestMeta(),
        ]);
    }

    /**
     * Log a withdrawal request rejection.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string|null $adminNotes
     * @return WithdrawalHistory
     */
    public static function logRejected(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        ?string $adminNotes = null
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_REJECTED,
            'old_status' => WithdrawalHistory::STATUS_PENDING,
            'new_status' => WithdrawalHistory::STATUS_REJECTED,
            'performed_by' => Auth::id(),
            'amount' => $amount,
            'notes' => $adminNotes ?? 'Withdrawal request rejected',
            'meta' => self::getRequestMeta(),
        ]);
    }

    /**
     * Log a withdrawal processing status.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string|null $notes
     * @return WithdrawalHistory
     */
    public static function logProcessing(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        ?string $notes = null
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_PROCESSING,
            'old_status' => WithdrawalHistory::STATUS_APPROVED,
            'new_status' => WithdrawalHistory::STATUS_PROCESSING,
            'performed_by' => Auth::id(),
            'amount' => $amount,
            'notes' => $notes ?? 'Payment processing initiated',
            'meta' => self::getRequestMeta(),
        ]);
    }

    /**
     * Log a withdrawal completion.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string|null $transactionReference
     * @param string|null $notes
     * @return WithdrawalHistory
     */
    public static function logCompleted(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        ?string $transactionReference = null,
        ?string $notes = null
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_COMPLETED,
            'old_status' => WithdrawalHistory::STATUS_PROCESSING,
            'new_status' => WithdrawalHistory::STATUS_COMPLETED,
            'performed_by' => Auth::id(),
            'amount' => $amount,
            'transaction_reference' => $transactionReference,
            'notes' => $notes ?? 'Payment completed successfully',
            'meta' => self::getRequestMeta(),
        ]);
    }

    /**
     * Log a withdrawal cancellation.
     *
     * @param int $withdrawalRequestId
     * @param int $userId
     * @param float $amount
     * @param string|null $notes
     * @return WithdrawalHistory
     */
    public static function logCancelled(
        int $withdrawalRequestId,
        int $userId,
        float $amount,
        ?string $notes = null
    ): WithdrawalHistory {
        return self::createHistoryEntry([
            'withdrawal_request_id' => $withdrawalRequestId,
            'user_id' => $userId,
            'action' => WithdrawalHistory::ACTION_CANCELLED,
            'old_status' => null,
            'new_status' => WithdrawalHistory::STATUS_CANCELLED,
            'performed_by' => Auth::id() ?? $userId,
            'amount' => $amount,
            'notes' => $notes ?? 'Withdrawal request cancelled',
            'meta' => self::getRequestMeta(),
        ]);
    }

    /**
     * Create a history entry with the given data.
     *
     * @param array $data
     * @return WithdrawalHistory
     */
    protected static function createHistoryEntry(array $data): WithdrawalHistory
    {
        return WithdrawalHistory::create($data);
    }

    /**
     * Get request metadata (IP, user agent, etc.).
     *
     * @return array
     */
    protected static function getRequestMeta(): array
    {
        return [
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Get complete history for a withdrawal request.
     *
     * @param int $withdrawalRequestId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRequestHistory(int $withdrawalRequestId)
    {
        return WithdrawalHistory::with(['user', 'performer'])
            ->forRequest($withdrawalRequestId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get user's withdrawal history summary.
     *
     * @param int $userId
     * @return array
     */
    public static function getUserSummary(int $userId): array
    {
        $history = WithdrawalHistory::forUser($userId);

        return [
            'total_requests' => $history->action(WithdrawalHistory::ACTION_CREATED)->count(),
            'approved' => $history->action(WithdrawalHistory::ACTION_APPROVED)->count(),
            'rejected' => $history->action(WithdrawalHistory::ACTION_REJECTED)->count(),
            'completed' => $history->action(WithdrawalHistory::ACTION_COMPLETED)->count(),
            'total_withdrawn' => $history->action(WithdrawalHistory::ACTION_COMPLETED)->sum('amount'),
        ];
    }
}
