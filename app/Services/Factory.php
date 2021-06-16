<?php


namespace App\Services;
use Illuminate\Support\Facades\Redis;
use App\Services\Register;


class Factory
{
    static function connectCache()
    {
        $redis = new Redis;
        Register::set('redis', $redis);
        return $redis;
    }

}
