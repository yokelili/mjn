<?php


namespace App\Services;

use Illuminate\Contracts\Redis\Factory;

class Repository
{
    protected $redis;

    public function __construct(Factory $redis)
    {
        $this->redis = $redis;
    }
}
