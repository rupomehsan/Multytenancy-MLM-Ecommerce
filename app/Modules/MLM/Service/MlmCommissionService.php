<?php

namespace App\Modules\MLM\Service;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\MLM\Managements\Commissions\Database\Models\MlmCommission;
use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionLog;
use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionSettingsModel;
use App\Modules\MLM\Managements\Wallet\Database\Models\WalletTransaction;

/**
 * MLM Commission Service
 * 
 * Handles commission calculation and distribution for multi-level marketing
 * based on configurable percentages stored in the database.
 * 
 * Business Rules:
 * - Commission distributed ONLY after order status = 'delivered'
 * - Maximum 3 levels of commission
 * - Percentages fetched dynamically from mlm_commissions_settings
 * - Commissions created with 'pending' status
 * - Wallet transactions created only when commission is 'approved' or 'paid'
 * - All operations wrapped in database transactions for integrity
 * - Idempotent: Prevents duplicate commission creation
 * 
 * @package App\Modules\MLM\Service
 */
class MlmCommissionService
{
    /**
     * Maximum referral levels for commission distribution
     */
    const MAX_LEVELS = 3;

    /**
     * Calculate and distribute MLM commissions when order is delivered
     * 
     * @param Order $order The delivered order
     * @return array Result with success status and message
     */
    public function distributeCommissions(Order $order)
    {
        try {
            // Refresh order to get latest data from database
            $order->refresh();

            // Log order status for debugging
            Log::info('MlmCommissionService: Distributing commissions', [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'STATUS_DELIVERED_const' => Order::STATUS_DELIVERED,
                'status_match' => ($order->order_status == Order::STATUS_DELIVERED),
            ]);

            // Validate order status
            if ($order->order_status != Order::STATUS_DELIVERED) {
                return [
                    'success' => false,
                    'message' => 'Commissions can only be distributed for delivered orders. Current status: ' . $order->order_status
                ];
            }

            // Check if buyer exists
            $buyer = User::find($order->user_id);
            if (!$buyer) {
                return [
                    'success' => false,
                    'message' => 'Buyer not found for this order.'
                ];
            }

            // Check if commissions already exist for this order
            if (MlmCommission::forOrder($order->id)->exists()) {
                return [
                    'success' => false,
                    'message' => 'Commissions already distributed for this order.',
                    'idempotent' => true
                ];
            }

            // Get commission settings
            $settings = $this->getCommissionSettings();
            if (!$settings) {
                return [
                    'success' => false,
                    'message' => 'Commission settings not found. Please configure commission percentages.'
                ];
            }

            // Calculate order net amount
            // Use sub_total or total from orders table
            $orderNetAmount = $order->sub_total ?? $order->total ?? 0;

            if ($orderNetAmount <= 0) {
                return [
                    'success' => false,
                    'message' => 'Order amount is invalid or zero.'
                ];
            }

            // Start database transaction
            DB::beginTransaction();

            try {
                $commissionsCreated = $this->processCommissionChain($buyer, $order, $orderNetAmount, $settings);

                // Auto-approve and credit commissions for delivered orders
                if ($commissionsCreated > 0) {
                    $pendingCommissions = MlmCommission::forOrder($order->id)
                        ->where('status', MlmCommission::STATUS_PENDING)
                        ->get();

                    foreach ($pendingCommissions as $commission) {
                        $this->approveAndCreditCommission($commission);
                    }
                }

                DB::commit();

                return [
                    'success' => true,
                    'message' => "Successfully created and credited {$commissionsCreated} commission record(s).",
                    'commissions_count' => $commissionsCreated
                ];
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            Log::error('MLM Commission Distribution Error', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to distribute commissions: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process commission chain up to MAX_LEVELS
     * 
     * @param User $buyer The buyer
     * @param Order $order The order
     * @param float $orderNetAmount The net order amount
     * @param CommissionSettingsModel $settings Commission settings
     * @return int Number of commissions created
     */
    protected function processCommissionChain(User $buyer, Order $order, $orderNetAmount, $settings)
    {
        $commissionsCreated = 0;
        $currentUser = $buyer;

        // Traverse up to MAX_LEVELS
        for ($level = 1; $level <= self::MAX_LEVELS; $level++) {
            // Get referrer at this level
            $referrer = $this->getReferrer($currentUser);

            if (!$referrer) {
                // No more referrers, stop the chain
                break;
            }

            // Get percentage for this level
            $percentage = $this->getPercentageForLevel($level, $settings);

            if ($percentage <= 0) {
                // No commission for this level, but continue to next level
                $currentUser = $referrer;
                continue;
            }

            // Calculate commission amount
            $commissionAmount = $this->calculateCommissionAmount($orderNetAmount, $percentage);

            if ($commissionAmount <= 0) {
                // Commission amount is zero or negative, skip but continue
                $currentUser = $referrer;
                continue;
            }

            // Create commission record
            $commission = $this->createCommissionRecord([
                'order_id' => $order->id,
                'buyer_id' => $buyer->id,
                'referrer_id' => $referrer->id,
                'level' => $level,
                'commission_amount' => $commissionAmount,
                'percentage_used' => $percentage,
                'status' => MlmCommission::STATUS_PENDING,
            ]);

            if ($commission) {
                // Log commission creation
                CommissionLog::logCreation(
                    $commission->id,
                    $order->id,
                    $referrer->id,
                    $commissionAmount,
                    $level,
                    $percentage,
                    "Level {$level} commission created for order #{$order->order_no}"
                );

                $commissionsCreated++;
            }

            // Move to next level
            $currentUser = $referrer;
        }

        return $commissionsCreated;
    }

    /**
     * Get referrer for a user
     * 
     * @param User $user
     * @return User|null
     */
    protected function getReferrer(User $user)
    {
        if (!$user->referred_by) {
            return null;
        }

        // Get the referrer and ensure they are active customers
        return User::where('id', $user->referred_by)
            ->where('user_type', 3) // Customer
            ->where('status', 1) // Active
            ->first();
    }

    /**
     * Get percentage for a specific level from settings
     * 
     * @param int $level
     * @param CommissionSettingsModel $settings
     * @return float
     */
    protected function getPercentageForLevel($level, $settings)
    {
        switch ($level) {
            case 1:
                return (float) $settings->level_1_percentage ?? 0;
            case 2:
                return (float) $settings->level_2_percentage ?? 0;
            case 3:
                return (float) $settings->level_3_percentage ?? 0;
            default:
                return 0;
        }
    }

    /**
     * Calculate commission amount
     * 
     * Formula: (orderNetAmount × percentage) / 100
     * 
     * @param float $orderNetAmount
     * @param float $percentage
     * @return float
     */
    protected function calculateCommissionAmount($orderNetAmount, $percentage)
    {
        return round(($orderNetAmount * $percentage) / 100, 2);
    }

    /**
     * Create commission record in database
     * 
     * @param array $data
     * @return MlmCommission|null
     */
    protected function createCommissionRecord(array $data)
    {
        try {
            // Check for existing commission (safety check)
            $existing = MlmCommission::where('order_id', $data['order_id'])
                ->where('referrer_id', $data['referrer_id'])
                ->where('level', $data['level'])
                ->first();

            if ($existing) {
                Log::warning('Duplicate commission creation attempt prevented', $data);
                return null;
            }

            return MlmCommission::create($data);
        } catch (Exception $e) {
            Log::error('Failed to create commission record', [
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get commission settings from database
     * 
     * @return CommissionSettingsModel|null
     */
    protected function getCommissionSettings()
    {
        return CommissionSettingsModel::first();
    }

    /**
     * Approve commission and credit to wallet
     * 
     * This should be called when admin approves a commission
     * or automatically based on business logic.
     * 
     * @param MlmCommission $commission
     * @return array
     */
    public function approveAndCreditCommission(MlmCommission $commission)
    {
        try {
            // Check if already paid
            if ($commission->isPaid()) {
                return [
                    'success' => false,
                    'message' => 'Commission already paid.'
                ];
            }

            // Check if rejected
            if ($commission->isRejected()) {
                return [
                    'success' => false,
                    'message' => 'Cannot approve rejected commission.'
                ];
            }

            DB::beginTransaction();

            try {
                // Get referrer
                $referrer = User::find($commission->referrer_id);
                if (!$referrer) {
                    throw new Exception('Referrer not found.');
                }

                // Calculate new balance
                $oldBalance = $referrer->wallet_balance ?? 0;
                $newBalance = $oldBalance + $commission->commission_amount;

                // Update user wallet balance
                $referrer->wallet_balance = $newBalance;
                $referrer->save();

                // Create wallet transaction
                WalletTransaction::create([
                    'user_id' => $referrer->id,
                    'transaction_type' => WalletTransaction::TYPE_COMMISSION_CREDIT,
                    'amount' => $commission->commission_amount,
                    'balance_after' => $newBalance,
                    'mlm_commission_id' => $commission->id,
                    'order_id' => $commission->order_id,
                    'description' => "Level {$commission->level} commission for Order #{$commission->order->order_no}",
                ]);

                // Log approval and credit
                CommissionLog::logApprovalAndCredit(
                    $commission->id,
                    $commission->order_id,
                    $referrer->id,
                    $commission->commission_amount,
                    $oldBalance,
                    $newBalance,
                    auth()->id()
                );

                // Mark commission as paid
                $commission->markAsPaid();

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Commission approved and credited to wallet successfully.',
                    'amount' => $commission->commission_amount,
                    'new_balance' => $newBalance
                ];
            } catch (Exception $e) {
                DB::rollBack();

                // Log error to commission logs
                try {
                    CommissionLog::logError(
                        $commission->id,
                        $commission->order_id,
                        $commission->referrer_id,
                        $e->getMessage(),
                        $e->getTraceAsString()
                    );
                } catch (\Exception $logError) {
                    // Silently fail if logging fails
                }

                throw $e;
            }
        } catch (Exception $e) {
            Log::error('Commission approval error', [
                'commission_id' => $commission->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to approve commission: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Reverse commissions when order is cancelled or refunded
     * 
     * @param Order $order
     * @return array
     */
    public function reverseCommissions(Order $order)
    {
        try {
            // Check if order is cancelled or refunded
            if (!in_array($order->order_status, [Order::STATUS_CANCELLED, Order::STATUS_RETURN])) {
                return [
                    'success' => false,
                    'message' => 'Commissions can only be reversed for cancelled or returned orders.'
                ];
            }

            // Get all commissions for this order
            $commissions = MlmCommission::forOrder($order->id)
                ->whereIn('status', [MlmCommission::STATUS_PENDING, MlmCommission::STATUS_PAID])
                ->get();

            if ($commissions->isEmpty()) {
                return [
                    'success' => true,
                    'message' => 'No commissions to reverse.',
                    'reversed_count' => 0
                ];
            }

            DB::beginTransaction();

            try {
                $reversedCount = 0;

                foreach ($commissions as $commission) {
                    // If commission was already paid, reverse the wallet balance
                    if ($commission->isPaid()) {
                        $oldBalance = $commission->referrer->wallet_balance ?? 0;
                        $this->reverseWalletTransaction($commission);
                        $newBalance = $commission->referrer->wallet_balance ?? 0;

                        // Log reversal with wallet changes
                        CommissionLog::logReversal(
                            $commission->id,
                            $order->id,
                            $commission->referrer_id,
                            $commission->commission_amount,
                            $oldBalance,
                            $newBalance,
                            "Order #{$order->order_no} was cancelled/refunded"
                        );
                    } else {
                        // Log rejection without wallet changes
                        CommissionLog::logRejection(
                            $commission->id,
                            $order->id,
                            $commission->referrer_id,
                            $commission->commission_amount,
                            "Order #{$order->order_no} was cancelled before commission was paid"
                        );
                    }

                    // Mark commission as rejected
                    $commission->markAsRejected("Order #{$order->order_no} was cancelled/refunded");
                    $reversedCount++;
                }

                DB::commit();

                return [
                    'success' => true,
                    'message' => "Successfully reversed {$reversedCount} commission(s).",
                    'reversed_count' => $reversedCount
                ];
            } catch (Exception $e) {
                DB::rollBack();

                // Log error to commission logs
                try {
                    CommissionLog::createLog([
                        'commission_id' => null,
                        'order_id' => $order->id,
                        'referrer_id' => null,
                        'activity_type' => CommissionLog::TYPE_ERROR,
                        'action_source' => CommissionLog::SOURCE_SYSTEM,
                        'title' => 'Commission reversal error',
                        'description' => 'Error occurred during commission reversal',
                        'error_message' => $e->getMessage(),
                        'error_trace' => $e->getTraceAsString(),
                    ]);
                } catch (\Exception $logError) {
                    // Silently fail if logging fails
                }

                throw $e;
            }
        } catch (Exception $e) {
            Log::error('Commission reversal error', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to reverse commissions: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Reverse wallet transaction for a paid commission
     * 
     * @param MlmCommission $commission
     * @return void
     */
    protected function reverseWalletTransaction(MlmCommission $commission)
    {
        // Get referrer
        $referrer = User::find($commission->referrer_id);
        if (!$referrer) {
            Log::warning('Referrer not found during reversal', ['commission_id' => $commission->id]);
            return;
        }

        // Calculate new balance (deduct the commission)
        $oldBalance = $referrer->wallet_balance ?? 0;
        $newBalance = max(0, $oldBalance - $commission->commission_amount);

        // Update user wallet balance
        $referrer->wallet_balance = $newBalance;
        $referrer->save();

        // Create reversal transaction
        WalletTransaction::create([
            'user_id' => $referrer->id,
            'transaction_type' => WalletTransaction::TYPE_COMMISSION_REVERSAL,
            'amount' => -$commission->commission_amount, // Negative amount for debit
            'balance_after' => $newBalance,
            'mlm_commission_id' => $commission->id,
            'order_id' => $commission->order_id,
            'description' => "Reversal: Order #{$commission->order->order_no} cancelled/refunded",
        ]);
    }

    /**
     * Get commission summary for a user
     * 
     * @param int $userId
     * @return array
     */
    public function getCommissionSummary($userId)
    {
        return [
            'total_earned' => MlmCommission::forReferrer($userId)->paid()->sum('commission_amount'),
            'pending' => MlmCommission::forReferrer($userId)->pending()->sum('commission_amount'),
            'approved' => MlmCommission::forReferrer($userId)->approved()->sum('commission_amount'),
            'rejected' => MlmCommission::forReferrer($userId)->rejected()->sum('commission_amount'),
            'total_commissions' => MlmCommission::forReferrer($userId)->count(),
        ];
    }
}
