<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TokenBucketExpir;
use Illuminate\Support\Facades\Log;

class TokenBucketMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('***********************************');
        // 获取路由
        $url = $request->getRequestUri();
        $url = 'bucket:'.substr($url, 0);
        $tokenBucket = new TokenBucketExpir;
        $result = $tokenBucket->grant($url);
        if (! $result) {
            Log::info('请求Discard'.date('s'));
            return response()->json(['status' => false, 'message' => 'network busy, please try again', 'code' => 429, 'data' => []]);
        }
        Log::info('请求成功'.date('s'));
        return $next($request);
    }

}
