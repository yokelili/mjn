<?php

namespace App\Http\Middleware;

use App\Models\WxUser;
use App\Models\LuckDraw;
use App\Services\Crm\CrmService;
use Closure;
use Illuminate\Http\Request;

class UserInfoMiddleware
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
        $crmUserinfo = new CrmService();

        if (!WxUser::query()->where('openid', $openid)->select('id', 'status')->exists()) {
            $userinfo = $crmUserinfo->selectUserQueryMember($openid);

            $wxUser = new WxUser;
            $wxUser->openid = $openid;
            $wxUser->status = $userinfo['status'];
            $wxUser->save();
        } else {
            $wxUser = WxUser::where('openid', $openid)
                            ->select('status')
                            ->first();
            if ($wxUser['status'] == 100) {
                $userinfo = $crmUserinfo->selectUserQueryMember($openid);

                if ($userinfo['status'] == 104) {
                    if (!LuckDraw::query()->where('openid', $openid)->where('type','sign')->exists()) {
                        $luckDraw = new LuckDraw;
                        $luckDraw->openid = $openid;
                        $luckDraw->type = 'sign';
                        $luckDraw->is_luck = 1;
                        $luckDraw->save();
                    }
                }
                $wxUser->status = $userinfo['status'];
                $wxUser->change_num += 1;
                $wxUser->save();
            }
        }
        return $next($request);
    }
}
