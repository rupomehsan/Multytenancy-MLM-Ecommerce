<?php

namespace App\Modules\Managements\MLM\Settings\Actions;

use App\Modules\Managements\MLM\Settings\Models\Model as MLMSettings;

class Update
{
    


    public static function execute($request)
    {
        try {
            $data = MLMSettings::first();
            if ($data) {
                $data->update($request->all());
            } else {
                $data = MLMSettings::create($request->all());
            }
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
