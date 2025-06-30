<?php

use App\Models\ParkingSettingModel;

if (!function_exists('get_settings')) {
    function get_settings()
    {
        static $cached;
        if ($cached !== null) {
            return $cached;
        }

        $model = new ParkingSettingModel();
        $cached = $model->first();
        return $cached;
    }
}
