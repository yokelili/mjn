<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Models\WxUser;
use App\Models\LuckDraw;
use Illuminate\Http\Request;
use App\Http\Requests\CodeValidate;
use App\Services\Crm\CrmService;
use App\Services\SocketService;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ScanCodeController extends Controller
{
    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 扫码获得抽奖机会
     * @description 扫码获得抽奖机会接口
     * @method get
     * @url /scanCode
     * @header token 可选 string 设备token
     * @param digitcode 必选 string 防伪码
     * @return {"success":false,"code":1001,"locale":"en","message":"Error #1001","data":null,"debug":[]}
     * @return_param 无 无 无
     * @remark 这里是备注信息
     * @number 99
     */
    public function scanCode(CodeValidate $request)
    {
        $openid = session('wx_userinfo.openid');
        $code = $request->validated();
        //判断用户是否扫过码
        $userinfo = WxUser::where('openid', $openid)->first();
        if ($userinfo['verify']) {
            return ResponseBuilder::error(ApiCode::SCAN_EXIST);
        }

        //判断码是否被扫
        $haveCode = WxUser::where('verify', $code['digitcode'])->first();
        if ($haveCode) {
            return ResponseBuilder::error(ApiCode::DIGITCODE_EXIST);
        }

        //请求crm
        $crmUserinfo = new CrmService;
        $responseData = $crmUserinfo->verifyCode($openid, $code['digitcode']);
        //防伪码验证失败
        if (!($responseData??false)) {
            return ResponseBuilder::error(ApiCode::CRM_VERIFI_CODE_ERROR);
        }

        //是否符合邀请 114 126 1 防伪码为真
        if (in_array($responseData['status'], [114, 126, 1])) {
            return ResponseBuilder::error(ApiCode::CRM_VERIFI_FORMAT_ERROR);
        }

        //查询当前奶粉信息是否存在于所处活动内
        if (in_array($responseData['productbrand'], ['AMN', 'A2'])) {
            return ResponseBuilder::error(ApiCode::PRODUCT_INFO_ERROR);
        }

        //查询当前防伪码段数是否是1,2,3,4段
        if (in_array($responseData['productstage'], [1, 2, 3, 4])) {
            return ResponseBuilder::error(ApiCode::PRODUCT_INFO_ERROR);
        }

        DB::transaction(function () use($openid, &$userinfo, $code) {
            $luckDraw = new LuckDraw;
            $luckDraw->openid = $openid;
            $luckDraw->type = 'scanCode';
            $luckDraw->is_luck = 1;
            $luckDraw->save();

            $userinfo->verify = $code['digitcode'];
            $userinfo->change_num += 1;
            $userinfo->save();
        });

        return ResponseBuilder::success();
    }

    public function socketRequest()
    {
        $sock = new SocketService('mjc.test','8010');
        $sock->run();
    }
}
