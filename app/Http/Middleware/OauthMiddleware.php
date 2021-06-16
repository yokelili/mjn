<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OauthMiddleware
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
        $oauthUrl = config('mjn_crm.'.config('app.env').'.oauth.route');
         session([
             'wx_userinfo' => [
                 'openid' => 'oarjM0gPOguM7qRvD2MsQ2RO8ycQ'
             ]
         ]);
        if (empty(session('wx_userinfo'))) {
            $url = $oauthUrl.urlencode(route('callback'));
            dd($url);
            session(['target_url' => $request->fullUrl()]);
            return redirect()->away($url);
        }
        return $next($request);
    }
}
