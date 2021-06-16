<?php
/**
 * Created by PhpStorm.
 * User: COJOY_10
 * Date: 2019/10/12
 * Time: 12:14
 */

namespace App\Services;

use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

class GenerationAuthorization
{
    private $openPlatform;

    /**
     * GenerationAuthorization constructor.初始化代授权服务端
     */
    public function __construct()
    {
        $this->openPlatform = Factory::openPlatform(config('wechat.open_platform.default'));
    }

    /**
     * Notes:[公众号服务]
     * User: COJOY_10
     * Date: 2020/12/29
     * Time: 17:53
     */
    public function officiaService()
    {
        return $this->openPlatform->officialAccount(config('wechat.open_platform.officialAccount.app_id'), config('wechat.open_platform.officialAccount.refresh_token'));
    }

    /**
     * @Desc : 获取用户授权页 URL
     * @Authority : COJOY_10
     * @FunctionName : WeChatAuth
     * @Date : 2019/10/12
     * @Time : 12:43
     * @param string $callback 回调地址
     * @return string
     */
    public function WeChatAuth($callback = '')
    {
        return $this->openPlatform->getPreAuthorizationUrl($callback);

    }

    /**
     * @Desc : 使用授权码换取接口调用凭据和授权信息
     * @Authority : COJOY_10
     * @FunctionName : AuthCallback
     * @Date : 2019/10/12
     * @Time : 12:44
     * @return string
     */
    public function AuthCallback($authorizationCode)
    {

        try {
            $res = $this->openPlatform->handleAuthorize($authorizationCode);

            Log::info(json_encode($res));
//            $authorizer_appid = $res['authorization_info']['authorizer_appid'];
//            $authorizer_refresh_token = $res['authorization_info']['authorizer_refresh_token'];
//            Log::info($authorizer_appid, $authorizer_refresh_token);
            return 'SUCCESS';
        } catch (\Exception $ex) {
            abort(404, $ex->getMessage());
            return 'Fail';
        }

    }

    /**
     * @Desc : 获取授权方信息
     * @Authority : COJOY_10
     * @FunctionName : getAuthorizer
     * @Date : 2019/10/12
     * @Time : 12:51
     * @param $appid
     * @return mixed
     */
    public function getAuthorizer($appid)
    {
        return $this->openPlatform->getAuthorizer($appid);
    }

    /**
     * @Desc : 网页授权回调
     * @Authority : COJOY_10
     * @FunctionName : WebAuthCallBack
     * @Date : 2019/9/9
     * @Time : 18:12
     * @return \Illuminate\Http\RedirectResponse
     */
    public function WebAuthCallBack()
    {
        $officialAccount = $this->openPlatform->officialAccount(config('wechat.open_platform.officialAccount.app_id'), config('wechat.open_platform.officialAccount.refresh_token'));
        $userinfo = $officialAccount->oauth->user();
        session(['wechat.oauth_user.default' => $userinfo->toArray()]);

    }

    /**
     * @Desc : 授权事件接听
     * @Authority : COJOY_10
     * @FunctionName : notify
     * @Date : 2019/9/9
     * @Time : 13:39
     */
    public function notify()
    {
        $server = $this->openPlatform->server;
        return $server->serve();
    }
}
