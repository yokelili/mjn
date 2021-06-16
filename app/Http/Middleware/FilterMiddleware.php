<?php

namespace App\Http\Middleware;

use App\ApiCode;
use Closure;
use App\Models\WxUser;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class FilterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $openid = session('wx_userinfo.openid');
        $store = WxUser::query()->where('openid', $openid)->first()->exists();
        if (!$store) {
            return ResponseBuilder::error(ApiCode::STORE_NAME_NOT_FOUND);
        }
        return $next($request);
    }
}
