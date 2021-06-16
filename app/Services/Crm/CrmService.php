<?php


namespace App\Services\Crm;


class CrmService
{
    protected $env;

    public function __construct()
    {
        $this->env = config('app.env');
    }

    /**
     * Notes:[查询用户会员信息]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:17
     * @param $openid
     * @return array|mixed
     */
    public function selectUserQueryMember($openid)
    {
        //获取查询会员信息的配置
        $queryMemberConfig = config("mjn_crm.{$this->env}.query_member");
        //发起请求
        return HttpRequestService::httpCrmPostRequest($queryMemberConfig['route'], ['openid' => $openid], $queryMemberConfig['rsa']['private'], $queryMemberConfig['platformToken']);
    }

    /**
     * Notes:[查询防伪码信息]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:30
     * @param $openid
     * @param $digitcode
     * @return array|mixed
     */
    public function verifyCode($openid, $digitcode)
    {
//        $this->env = 'production';
        $verifyCodeConfig = config("mjn_crm.{$this->env}.verifi_code");
        return HttpRequestService::httpCrmPostRequest($verifyCodeConfig['route'], [
            'openid' => $openid,
            'digitcode' => $digitcode,
            'clientip' => request()->getClientIp(),
            'type' => 'W',
            'hoststatus' => $this->env == 'local' ? 1 : 0,
        ], $verifyCodeConfig['rsa']['private'], $verifyCodeConfig['platformToken']);
    }

    /**
     * Notes:[发送红包]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:44
     * @param $openid
     * @param $phone
     * @param $amount
     * @return \Illuminate\Http\Client\Response
     */
    public function sendHongbao($openid, $amount, $phone = null)
    {
        $sendHongbaoConfig = config("mjn_crm.{$this->env}.sendHongbao");
        $currentDate = date('Y-m-d');
        $postData = [
            'date' => $currentDate,
            'sign' => md5($currentDate . $sendHongbaoConfig['secret']),
            'activityId' => $sendHongbaoConfig['activityId'],
            'departmentId' => $sendHongbaoConfig['departmentId'],
            'channelId' => $sendHongbaoConfig['channelId'],
            'cellphone' => is_null($phone) ? 13700000000 : $phone,
            'openId' => $openid,
            'requestId' => md5(uniqid(md5(microtime(true)))),
            'amount' => $amount
        ];
        return HttpRequestService::httpPostRequest($sendHongbaoConfig['route'], $postData);
    }
}
