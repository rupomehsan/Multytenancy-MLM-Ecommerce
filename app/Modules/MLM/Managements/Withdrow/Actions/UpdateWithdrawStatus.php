<?php

namespace App\Modules\MLM\Managements\Withdrow\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * UpdateWithdrawStatus Action
 * 
 * Handles approval, rejection, and completion of withdrawal requests.
 * Updates user wallet balance and tracks status changes.
 * 
 * Supported statuses:
 * - approved: Admin approves the request
 * - rejected: Admin rejects the request (returns amount to wallet)
 * - completed: Payment sent to user
 */
class UpdateWithdrawStatus
{
    /**
     * Execute withdrawal status update.
     * 
     * @param Request $request
     * @return array Result with success/error status
     */
    public static function execute(Request $request): array
    {
        try {
            // Validate input
            $validated = $request->validate([
                'id' => 'required|integer|exists:mlm_withdrawal_requests,id',
                'status' => 'required|in:approved,rejected,completed',
                'admin_notes' => 'nullable|string|max:1000'
            ]);

            DB::beginTransaction();

            // Get withdrawal request with lock
            $withdrawal = DB::table('mlm_withdrawal_requests')
                ->where('id', $validated['id'])
                ->lockForUpdate()
                ->first();

            if (!$withdrawal) {
                return [
                    'success' => false,
                    'message' => 'Withdrawal request not found'
                ];
            }

            // Only pending requests can be approved/rejected
            // Only approved requests can be completed
            if ($validated['status'] === 'completed' && $withdrawal->status !== 'approved') {
                return [
                    'success' => false,
                    'message' => 'Only approved requests can be marked as completed'
                ];
            }

            if (in_array($validated['status'], ['approved', 'rejected']) && $withdrawal->status !== 'pending') {
                return [
                    'success' => false,
                    'message' => 'Only pending requests can be approved or rejected'
                ];
            }

            $userId = $withdrawal->user_id;
            $amount = $withdrawal->amount;
            $newStatus = $validated['status'];
            $adminId = auth()->id();

            // Get user with lock
            $user = DB::table('users')
                ->where('id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$user) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'User not found'
                ];
            }

            // Handle status-specific logic
            $updateData = [
                'status' => $newStatus,
                'processed_by' => $adminId,
                'processed_at' => now(),
                'updated_at' => now()
            ];

            if (!empty($validated['admin_notes'])) {
                $updateData['admin_notes'] = $validated['admin_notes'];
            }

            // Handle wallet balance updates
            $walletUpdate = null;
            $statusMessage = '';

            switch ($newStatus) {
                case 'approved':
                    // When approving, amount is already deducted from wallet
                    // Just update status
                    $statusMessage = 'Withdrawal request approved successfully';
                    Log::info('Withdrawal approved', [
                        'withdrawal_id' => $validated['id'],
                        'user_id' => $userId,
                        'amount' => $amount,
                        'admin_id' => $adminId
                    ]);
                    break;

                case 'rejected':
                    // Return amount to user's wallet
                    $currentBalance = $user->wallet_balance ?? 0;
                    $newBalance = $currentBalance + $amount;

                    DB::table('users')
                        ->where('id', $userId)
                        ->update(['wallet_balance' => $newBalance]);

                    $statusMessage = 'Withdrawal request rejected and amount returned to wallet';

                    Log::info('Withdrawal rejected - amount returned', [
                        'withdrawal_id' => $validated['id'],
                        'user_id' => $userId,
                        'amount' => $amount,
                        'old_balance' => $currentBalance,
                        'new_balance' => $newBalance,
                        'admin_id' => $adminId
                    ]);
                    break;

                case 'completed':
                    // Payment has been sent - just update status
                    $statusMessage = 'Withdrawal marked as completed - payment sent';

                    Log::info('Withdrawal completed', [
                        'withdrawal_id' => $validated['id'],
                        'user_id' => $userId,
                        'amount' => $amount,
                        'admin_id' => $adminId
                    ]);
                    break;
            }

            $oldStatus = $withdrawal->status;

            // Update withdrawal request
            DB::table('mlm_withdrawal_requests')
                ->where('id', $validated['id'])
                ->update($updateData);

            // Prepare history payload
            $paymentMethod = $withdrawal->payment_method ?? null;
            $transactionReference = null;
            // Try to extract transaction reference from payment_details if present
            if (!empty($withdrawal->payment_details)) {
                try {
                    $pd = json_decode($withdrawal->payment_details, true);
                    if (is_array($pd) && isset($pd['transaction_reference'])) {
                        $transactionReference = $pd['transaction_reference'];
                    }
                } catch (Exception $e) {
                    // ignore
                }
            }

            DB::table('mlm_withdrawal_history')->insert([
                'withdrawal_request_id' => $validated['id'],
                'user_id' => $userId,
                'action' => $newStatus,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'performed_by' => $adminId,
                'notes' => $validated['admin_notes'] ?? null,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'transaction_reference' => $transactionReference,
                'meta' => json_encode([
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent')
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => $statusMessage,
                'data' => [
                    'withdrawal_id' => $validated['id'],
                    'new_status' => $newStatus,
                    'amount' => $amount
                ]
            ];
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Withdrawal status update failed', [
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update withdrawal status: ' . $e->getMessage()
            ];
        }
    }
}
