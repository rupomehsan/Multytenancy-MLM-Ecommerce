<?php

namespace App\Modules\MLM\Managements\Withdrow\Observers;

use App\Modules\MLM\Managements\Withdrow\Database\Models\WithdrawalRequest;
use App\Modules\MLM\Managements\Withdrow\Services\WithdrawalHistoryService;

/**
 * WithdrawalRequestObserver
 * 
 * Automatically logs history entries when withdrawal requests are created or updated.
 */
class WithdrawalRequestObserver
{
    /**
     * Handle the WithdrawalRequest "created" event.
     *
     * @param WithdrawalRequest $withdrawalRequest
     * @return void
     */
    public function created(WithdrawalRequest $withdrawalRequest)
    {
        // Log the creation of the withdrawal request
        WithdrawalHistoryService::logCreated(
            $withdrawalRequest->id,
            $withdrawalRequest->user_id,
            $withdrawalRequest->amount,
            $withdrawalRequest->payment_method,
            [
                'payment_details' => $withdrawalRequest->payment_details,
                'meta' => $withdrawalRequest->meta,
            ]
        );
    }

    /**
     * Handle the WithdrawalRequest "updated" event.
     *
     * @param WithdrawalRequest $withdrawalRequest
     * @return void
     */
    public function updated(WithdrawalRequest $withdrawalRequest)
    {
        // Only log if status changed
        if ($withdrawalRequest->isDirty('status')) {
            $oldStatus = $withdrawalRequest->getOriginal('status');
            $newStatus = $withdrawalRequest->status;

            // Log based on new status
            match ($newStatus) {
                'approved' => WithdrawalHistoryService::logApproved(
                    $withdrawalRequest->id,
                    $withdrawalRequest->user_id,
                    $withdrawalRequest->amount,
                    $withdrawalRequest->admin_notes
                ),
                'rejected' => WithdrawalHistoryService::logRejected(
                    $withdrawalRequest->id,
                    $withdrawalRequest->user_id,
                    $withdrawalRequest->amount,
                    $withdrawalRequest->admin_notes
                ),
                'processing' => WithdrawalHistoryService::logProcessing(
                    $withdrawalRequest->id,
                    $withdrawalRequest->user_id,
                    $withdrawalRequest->amount,
                    $withdrawalRequest->admin_notes
                ),
                'completed' => WithdrawalHistoryService::logCompleted(
                    $withdrawalRequest->id,
                    $withdrawalRequest->user_id,
                    $withdrawalRequest->amount,
                    $withdrawalRequest->meta['transaction_reference'] ?? null,
                    $withdrawalRequest->admin_notes
                ),
                'cancelled' => WithdrawalHistoryService::logCancelled(
                    $withdrawalRequest->id,
                    $withdrawalRequest->user_id,
                    $withdrawalRequest->amount,
                    $withdrawalRequest->admin_notes
                ),
                default => null,
            };
        }
    }
}
