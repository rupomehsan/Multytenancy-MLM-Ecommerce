<?php

namespace App\Modules\MLM\Managements\Commissions\Actions;

use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionSettingsModel;

class Update
{



    public static function execute($request)
    {
        try {
            $data = CommissionSettingsModel::first();
            if ($data) {
                $data->update($request->all());
            } else {
                $data = CommissionSettingsModel::create($request->all());
            }
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
