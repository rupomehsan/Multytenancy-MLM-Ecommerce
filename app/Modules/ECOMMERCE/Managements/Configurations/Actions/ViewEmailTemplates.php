<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\EmailService\Database\Models\EmailTemplate;

class ViewEmailTemplates
{
    public static function execute(Request $request): array
    {
        try {
            $orderPlacedTemplates = EmailTemplate::where('type', 'order_placed')
                ->orderBy('serial', 'asc')
                ->get();

            return [
                'status' => 'success',
                'orderPlacedTemplates' => $orderPlacedTemplates,
                'view' => 'email_template'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
