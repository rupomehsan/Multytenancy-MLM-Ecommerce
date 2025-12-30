<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\EmailService\Database\Models\EmailTemplate;

class ChangeMailTemplateStatus
{
    public static function execute(Request $request, $templateId): array
    {
        try {
            $template = EmailTemplate::where('id', $templateId)->first();

            if (!$template) {
                return [
                    'status' => 'error',
                    'message' => 'Template not found.'
                ];
            }

            if ($template->status == 1) {
                $template->status = 0;
                $template->save();
                EmailTemplate::where('type', $template->type)
                    ->where('id', '!=', $template->id)
                    ->update(['status' => 1]);
            } else {
                $template->status = 1;
                $template->save();
                EmailTemplate::where('type', $template->type)
                    ->where('id', '!=', $template->id)
                    ->update(['status' => 0]);
            }

            return [
                'status' => 'success',
                'message' => 'Saved successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
