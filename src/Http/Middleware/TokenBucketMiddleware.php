<?php

namespace Blog\TokenBucket\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // 获取路由
        $url = $request->getRequestUri();
        $url = 'bucket:'.substr($url, 0);
        $tokenBucket = new TokenBucket;
        $result = $tokenBucket->grant($url);
        if (! $result) {
            return response()->json(['status' => false, 'message' => 'network busy, please try again', 'code' => 429, 'data' => []]);
        }
        return $next($request);
    }
}
