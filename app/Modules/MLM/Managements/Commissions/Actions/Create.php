<?php

namespace App\Modules\MLM\Managements\Commissions\Actions;

use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionSettingsModel;

class Create
{


    public static function execute()
    {
        try {
            // Simple string data
            $data =  CommissionSettingsModel::first();

            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
