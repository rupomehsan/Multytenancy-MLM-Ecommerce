<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderLog;

class ViewOrderLogDetails
{
    public static function execute($id)
    {
        $log = OrderLog::with(['order', 'performedBy'])->findOrFail($id);

        $html = '<div class="log-details">';

        // Order Information
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-shopping-cart me-2"></i> Order:</span>';
        $html .= '<span class="info-value">';
        if ($log->order) {
            $html .= '<a href="' . url('admin/order/details/' . $log->order->id) . '" target="_blank" class="text-primary">';
            $html .= $log->order->order_no . ' (Order #' . $log->order->id . ')';
            $html .= '</a>';
        } else {
            $html .= 'N/A';
        }
        $html .= '</span>';
        $html .= '</div>';

        // Activity Type
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-tag me-2"></i> Activity Type:</span>';
        $html .= '<span class="info-value">' . self::formatActivityType($log->activity_type) . '</span>';
        $html .= '</div>';

        // Status Change
        if ($log->old_status || $log->new_status) {
            $html .= '<div class="info-item">';
            $html .= '<span class="info-label"><i class="fas fa-exchange-alt me-2"></i> Status Change:</span>';
            $html .= '<span class="info-value">';
            $html .= '<strong>' . ucfirst($log->old_status) . '</strong> → <strong>' . ucfirst($log->new_status) . '</strong>';
            $html .= '</span>';
            $html .= '</div>';
        }

        // Performed By
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-user me-2"></i> Performed By:</span>';
        $html .= '<span class="info-value">';
        if ($log->performedBy) {
            $html .= $log->performedBy->name . ' (' . $log->performedBy->email . ')';
        } else {
            $html .= 'System';
        }
        $html .= '</span>';
        $html .= '</div>';

        // Action Source
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-source me-2"></i> Action Source:</span>';
        $html .= '<span class="info-value">' . self::formatActionSource($log->action_source) . '</span>';
        $html .= '</div>';

        // Title
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-heading me-2"></i> Title:</span>';
        $html .= '<span class="info-value"><strong>' . $log->title . '</strong></span>';
        $html .= '</div>';

        // Description
        if ($log->description) {
            $html .= '<div class="info-item">';
            $html .= '<span class="info-label"><i class="fas fa-align-left me-2"></i> Description:</span>';
            $html .= '<span class="info-value">' . nl2br(htmlspecialchars($log->description)) . '</span>';
            $html .= '</div>';
        }

        // IP Address
        if ($log->ip_address) {
            $html .= '<div class="info-item">';
            $html .= '<span class="info-label"><i class="fas fa-network-wired me-2"></i> IP Address:</span>';
            $html .= '<span class="info-value">' . $log->ip_address . '</span>';
            $html .= '</div>';
        }

        // User Agent
        if ($log->user_agent) {
            $html .= '<div class="info-item">';
            $html .= '<span class="info-label"><i class="fas fa-desktop me-2"></i> User Agent:</span>';
            $html .= '<span class="info-value"><small>' . htmlspecialchars($log->user_agent) . '</small></span>';
            $html .= '</div>';
        }

        // Timestamp
        $html .= '<div class="info-item">';
        $html .= '<span class="info-label"><i class="fas fa-clock me-2"></i> Timestamp:</span>';
        $html .= '<span class="info-value">' . $log->created_at->format('F d, Y h:i:s A') . '</span>';
        $html .= '</div>';

        // Metadata
        if ($log->metadata && is_array($log->metadata) && count($log->metadata) > 0) {
            $html .= '<div class="info-item">';
            $html .= '<span class="info-label"><i class="fas fa-database me-2"></i> Additional Data:</span>';
            $html .= '<div class="metadata-block">';
            $html .= '<pre style="margin: 0; white-space: pre-wrap;">' . json_encode($log->metadata, JSON_PRETTY_PRINT) . '</pre>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    private static function formatActivityType($type)
    {
        $badges = [
            OrderLog::TYPE_STATUS_CHANGE => '<span class="badge bg-info">Status Change</span>',
            OrderLog::TYPE_CREATED => '<span class="badge bg-success">Created</span>',
            OrderLog::TYPE_UPDATED => '<span class="badge bg-primary">Updated</span>',
            OrderLog::TYPE_CANCELLED => '<span class="badge bg-danger">Cancelled</span>',
            OrderLog::TYPE_DELIVERED => '<span class="badge bg-success">Delivered</span>',
            OrderLog::TYPE_PAYMENT_UPDATE => '<span class="badge bg-warning">Payment Update</span>',
            OrderLog::TYPE_COMMISSION_DISTRIBUTED => '<span class="badge bg-success">Commission Distributed</span>',
            OrderLog::TYPE_COMMISSION_REVERSED => '<span class="badge bg-danger">Commission Reversed</span>',
            OrderLog::TYPE_OTHER => '<span class="badge bg-secondary">Other</span>',
        ];

        return $badges[$type] ?? '<span class="badge bg-secondary">' . ucfirst($type) . '</span>';
    }

    private static function formatActionSource($source)
    {
        $badges = [
            OrderLog::SOURCE_ADMIN => '<span class="badge bg-primary">Admin Panel</span>',
            OrderLog::SOURCE_CUSTOMER => '<span class="badge bg-info">Customer</span>',
            OrderLog::SOURCE_SYSTEM => '<span class="badge bg-warning">System Automated</span>',
            OrderLog::SOURCE_API => '<span class="badge bg-secondary">API</span>',
            OrderLog::SOURCE_OBSERVER => '<span class="badge bg-dark">Observer</span>',
            OrderLog::SOURCE_MANUAL => '<span class="badge bg-success">Manual</span>',
        ];

        return $badges[$source] ?? '<span class="badge bg-secondary">' . ucfirst($source) . '</span>';
    }
}
