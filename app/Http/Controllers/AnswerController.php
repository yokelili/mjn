<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnwserValidate;
//use Illuminate\Http\Request;
use App\Models\Anwser;
use App\Models\WxUser;
use App\Models\LuckDraw;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AnswerController extends Controller
{
    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 答题记录
     * @description 答题记录接口
     * @method get
     * @url /answerInfo
     * @header token 可选 string 设备token
     * @param answerInfo 必选 string 答题信息
     * @return {"success":true,"code":0,"locale":"en","message":"OK","data":null}
     * @return_param 无 无 无
     * @remark 这里是备注信息
     * @number 99
     */
    public function answerInfo(AnwserValidate $request)
    {
        $params = $request->validated();
//        $params = $request->input('answer');
        $openid = session('wx_userinfo.openid');

        $answer = new Anwser;
        $answer->openid = $openid;
        $answer->remarks = $params['answer'];
        $answer->save();

        $luckDraw = new LuckDraw;
        $luckDraw->openid = $openid;
        $luckDraw->type = 'answer';
        $luck = LuckDraw::query()->where('openid', $openid)->where('is_luck', 1)->exists();
        if (!$luck) {
            $luckDraw->is_luck = 1;
            $wxUser = WxUser::where('openid', $openid)->first();
            $wxUser->change_num += 1;
            $wxUser->save();
        } else {
            $luckDraw->is_luck = 0;
        }
        $luckDraw->save();

        return ResponseBuilder::success();
    }
}
