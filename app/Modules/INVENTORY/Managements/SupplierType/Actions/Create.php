<?php

namespace App\Modules\Managements\MLM\Settings\Actions;

use App\Modules\Managements\MLM\Settings\Models\Model as MLMSettings;

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
