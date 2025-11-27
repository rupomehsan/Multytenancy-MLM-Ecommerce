<?php

namespace App\Modules\MLM\Managements\Settings\Actions;

use App\Modules\MLM\Managements\Settings\Database\Models\Model as MLMSettings;

class Create
{


    public static function execute()
    {
        try {
            // Simple string data
            $data =  MLMSettings::first();
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
