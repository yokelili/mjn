<?php

namespace App\Services;

use EasyWeChat\Factory;

class OfficiaService
{
    /**
     * Desc : 授权公众号
     * Authority : Administrator
     * FunctionName : officia
     * Date : 2020/3/26
     * Time : 16:53
     * @return \EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application
     */
    public static function officia()
    {
        $config = config('wechat.official_account.default');
        return Factory::officialAccount($config);
    }

    /**
     * Desc : 授权回调
     * Authority : Administrator
     * FunctionName : webAuthCallBack
     * Date : 2020/3/26
     * Time : 17:01
     */
    public function webAuthCallBack($code)
    {
        $officialAccount = $this->officia()->oauth->userFromCode($code);
        session(['wechat.oauth_user.default' => $officialAccount]);
    }


}
