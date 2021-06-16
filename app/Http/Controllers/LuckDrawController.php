<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Illuminate\Http\Request;
use App\Models\WxUser;
use App\Models\Prize;
use App\Models\LuckDraw;
use App\Models\LuckReceive;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class LuckDrawController extends Controller
{
    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 抽奖
     * @description 抽奖接口
     * @method get
     * @url /luckDraw
     * @header token 可选 string 设备token
     * @param null null null null
     * @return {"success":true,"code":0,"locale":"en","message":"OK","data":{"name":"1元现金红包","number":5,"user_prize_id":2}}
     * @return_param number int 奖品ID:1：戴森，<br>2：雅诗兰黛，<br>3：香薰，<br>4：美赞臣铂睿A2蛋白系列配房奶粉3段，<br>5：1元现金红包，<br>6：谢谢参与
     * @return_param name string 奖品名称
     * @return_param user_prize_id int 新增的用户奖品表ID
     * @remark 这里是备注信息
     * @number 99
     */
    public function luckDraw()
    {
        $openid = session('wx_userinfo.openid');
        $luckdraw = LuckDraw::where('openid', $openid)
                            ->where('is_luck', 1)
                            ->where('status', 0)
                            ->orderBy('created_at', 'asc')
                            ->select('openid', 'is_luck', 'status', 'id')
                            ->first();
        $userinfo = WxUser::where('openid', $openid)
                    ->select('store')
                    ->first();
        if (!$luckdraw) {
            $data = [
                'number'=> 7,
                'message'=> '没有抽奖机会',
            ];
            return ResponseBuilder::success($data);
        }

        if (!$luckdraw['is_luck'] || !($userinfo['store']??false)) {
            $data = [
                'number'=> 6,
                'name'=> '谢谢参与'
            ];
        } else {
            $data = getDraw($userinfo['store']);
        }
        //判断用户是否已抽到这个奖
        $hanvePrize = LuckReceive::where('openid', $openid)
                                 ->where('prizeid', $data['number'])
                                 ->first();
        if ($hanvePrize) {
            $data = [
                'number'=> 6,
                'name'=> '谢谢参与',
                'user_prize_id'=> 0
            ];
        }

        DB::transaction(function () use($openid, $userinfo, &$data, $luckdraw) {
            if ($data['number'] !== 6) {
                $prize = Prize::where('channel', $userinfo['store'])
                              ->where('number', $data['number'])
                              ->where('stock', '>=', 1)
                              ->first();
                if ($prize) {
                    $prize->stock -= 1;
                    $prize->save();

                    $wxUser = WxUser::where('openid', $openid)->first();
                    $wxUser->change_num -= 1;
                    $wxUser->save();

                    $receive = new LuckReceive;
                    $receive->openid = $openid;
                    $receive->prizeid = $data['number'];
                    $receive->prize_name = $data['name'];
                    $receive->date = date('Y-m-d');
                    $receive->save();

                    $data['user_prize_id'] = $receive->id;
                } else {
                    $data = [
                        'number'=> 6,
                        'name'=> '谢谢参与',
                        'user_prize_id'=> 0
                    ];
                }
                DB::table('luck_draw')->where('id', $luckdraw['id'])->update(['status'=> 1]);
            }
            return $data;
        });
        return ResponseBuilder::success($data);
    }

}
