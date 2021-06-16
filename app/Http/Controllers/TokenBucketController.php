<?php

namespace App\Http\Controllers;

use App\Services\TokenBucketExpir;
use Illuminate\Http\Request;
use App\Services\TokenBucket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class TokenBucketController extends Controller
{
    public function index(Request $request)
    {
        Log::info('***********************************');
        for ($i = 0; $i < 100; $i++) {
            // 获取路由
            $url = $request->getRequestUri();
            $url = 'bucket:'.substr($url, 0);
            $tokenBucket = new TokenBucketExpir;
            $result = $tokenBucket->grant($url);
            if ($result) {
                Log::info('请求成功'.date('s'));
            } else {
                Log::info('请求Discard'.date('s'));
            }
        }


//        //令牌桶容器
//        $queue = 'traffic';
//        //最大令牌数
//        $max = 5;
//        //创建TrafficShaper对象
//        $tokenBucket = new TokenBucket($queue,$max);
//        //重设令牌桶，填满令牌
//        $tokenBucket->add($max);
//
//        //循环获取令牌，令牌桶内只有5个令牌，因为最后3次获取失败
//        Log::info('***********************************');
//        for($i=0;$i<8;$i++){
//            if($tokenBucket->get()){
//                Log::info('请求成功');
//            }else{
//                Log::info('请求Discard');
//            }
//        }
    }
}
