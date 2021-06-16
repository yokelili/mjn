<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;

class OtherService
{
    /**
     * Notes:[获取当前时间所在的阶段]
     * User: COJOY_10
     * Date: 2020/12/28
     * Time: 17:53
     * @return int
     */
    public static function getStage($openid = null)
    {
        $currentTime = time();
        if ($currentTime >= strtotime('2021-01-08 00:00:00') && $currentTime <= strtotime('2021-01-14 23:59:59')) {
            return 1;
        } else if ($currentTime >= strtotime('2021-01-15 00:00:00') && $currentTime <= strtotime('2021-01-21 23:59:59')) {
            return 2;
        } else if ($currentTime >= strtotime('2021-01-22 00:00:00') && $currentTime <= strtotime('2021-01-28 23:59:59')) {
            return 3;
        } else {
            return 1;
        }
        // if (Cache::has($openid)) {
        //     return Cache::get($openid, 1);
        // } else {
            
        // }
    }
}
