<?php


namespace Blog\TokenBucketExpir;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class TokenBucketExpir
{
    /**
     * Notes:[限流鉴权]
     * Desc:
     * User: winks
     * Date: 2021/6/11
     * Time: 14:27
     * @param $url
     * @param int $num
     * @param int $msec
     * @return bool
     */
    public function grant($url, $num = 2, $msec = 1000)
    {
        try {
            $redis = new Redis();
            //桶内最大令牌数
            $limit = $num;
            //间隔执行时间/ms
            $interval = $msec;
            $timeKey = $url.':time';
            $check = $redis::hLen($timeKey);
            if (!$check) {
                return $this->init($redis, $timeKey, $url, $limit - 1);
            }
            $now = $this->getMicroSecond();
            $timestamp = (int)$redis::hGet($timeKey, 'timestamp');

            if ($now < $timestamp + $interval) {
                // 在时间内
                $res = $this->getToken($redis, $url);
                return $res;
            } else {
                // 不在时间内
                return $this->init($redis, $timeKey, $url, $limit - 1);
            }
        } catch (\Exception $exception) {
            Log::info('TokenBucketMiddleware|'.date('Y-m-d H:i:s', time()).'|grant()方法捕获异常'.'|'.
                $exception->getFile().'|'.$exception->getCode().'|'.$exception->getMessage());
            return false;
        }
    }

    /**
     * 重新计算时间戳 毫秒
     *
     * @return float
     */
    public function getMicroSecond()
    {
        list($microsecond, $second) = explode(' ', microtime(true));
        $microsecond = (float)sprintf('%.0f', (floatval($microsecond) + floatval($second)) * 1000);
        return $microsecond;
    }

    /**
     * 初始化
     *
     * @param $redis
     * @param $timeKey
     * @param $url
     * @param $limit
     * @return bool
     */
    public function init($redis, $timeKey, $url, $limit)
    {
        // 初始化时间
        $this->initGrant($redis, $timeKey);
        // 初始化令牌桶
        $this->initTokenBucket($redis, $url, $limit);
        return true;
    }

    /**
     * 初始化指定路由的限流
     *
     * @param $redis
     * @param $url
     * @return bool
     */
    public function initGrant($redis, $url)
    {
        $redis::hSet($url, 'timestamp', $this->getMicroSecond());
        return true;
    }

    /**
     * 初始化令牌桶 一次性放入足够的令牌
     *
     * @param $redis
     * @param $url
     * @param $limit
     * @return void
     */
    public function initTokenBucket($redis, $url, $limit)
    {
        $this->addToken($redis, $url, $limit);
    }

    /**
     * 添加令牌
     * @param $redis
     * @param $url
     * @param $limit
     * @return boolean
     */
    public function addToken($redis, $url, $limit)
    {
        $size = (int)$redis::lLen($url);
        $fillNum = $limit - $size;
        if ($fillNum > 0) {
            $token = array_fill(0, $fillNum, 1);
            $redis::lpush($url, $token);
        }
        return true;
    }

    /**
     * 获取令牌
     *
     * @param $redis
     * @param $url
     * @return bool
     */
    public function getToken($redis, $url)
    {
        return $redis::rpop($url) ? true : false;
    }
}
