<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Illuminate\Http\Request;
use App\Http\Requests\StoreValidate;
use App\Models\WxUser;
use App\Models\Prize;
use App\Models\LuckDraw;
use App\Models\LuckReceive;
use App\Http\Requests\UserinfoValidate;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class UserinfoController extends Controller
{
    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 获取用户信息
     * @description 获取用户信息接口
     * @method get
     * @url /userinfo
     * @header token 可选 string 设备token
     * @param null null null null
     * @return {"success":true,"code":0,"locale":"en","message":"OK","data":{"userInfo":{"expiry":0,"isMember":0,"store":null,"receive":[],"hasScan":0,"drawCount":0,"is_luck":0}}}
     * @return_param expiry int 活动是否结束：0否，1是
     * @return_param isMember int 是否是会员：0否，1是
     * @return_param receive json 获得的奖品
     * @return_param receive.prizeid int 奖品ID
     * @return_param receive.prize_name string 奖品名称
     * @return_param receive.is_receive int 是否领取了
     * @return_param hasScan int 是否已经扫码：0否，1是
     * @return_param drawCount int 剩余抽奖次数
     * @remark 这里是备注信息
     * @number 99
     */
    public function userInfo(Request $request)
    {
        $openid = session('wx_userinfo.openid');
        $userinfo = WxUser::where('openid', $openid)->first();
        return ResponseBuilder::success([
            'userInfo' => [
                'expiry' => time() > strtotime('2021-05-08 23:59:59') ? 1 : 0,
                'isMember' => $userinfo['status'] == 104 ? 1 : 0,
                'store' => $userinfo['store'],
                'receive' => $userinfo->getPrize,
                'hasScan' => $userinfo['verify'] ? 1 : 0,
                'drawCount' => $userinfo->getDraw->count(),
                'is_luck' => LuckDraw::query()->where('openid', $openid)->where('is_luck', 1)->exists() ? 1 : 0
            ]
        ]);

    }

    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 填写门店
     * @description 填写门店接口
     * @method get
     * @url /addStore
     * @header token 可选 string 设备token
     * @param store 必选 string 门店名称
     * @return {"success":true,"code":0,"locale":"en","message":"OK","data":null}
     * @return_param 无 无 无
     * @remark 这里是备注信息
     * @number 99
     */
    public function addStores(StoreValidate $request)
    {
        $openid = session('wx_userinfo.openid');
        $store = $request->validated();
        WxUser::where('openid', $openid)->update(['store' => $store['store']]);
        return ResponseBuilder::success();

    }

    /**
     * showdoc
     * @catalog 测试文档/用户相关
     * @title 领奖留资
     * @description 领奖留资接口
     * @method get
     * @url /createUserinfo
     * @header token 可选 string 设备token
     * @param prize_id 必选 integer 奖品id
     * @param name 必选 string 用户姓名
     * @param phone 必选 string 用户手机号
     * @param address 必选 string 用户地址
     * @return {"success":true,"code":0,"locale":"en","message":"OK","data":null}
     * @return_param 无 无 无
     * @remark 这里是备注信息
     * @number 99
     */
    public function createUserinfo(UserinfoValidate $request)
    {
        $addinfo = $request->validated();
        $receive = LuckReceive::where('prizeid', $addinfo['prize_id'])
                              ->where('is_receive', 0)
                              ->first();
        if ($receive) {
            $receive->name = $addinfo['name'];
            $receive->phone = $addinfo['phone'];
            $receive->address = $addinfo['address'];
            $receive->is_receive = 1;
            $receive->save();
            return ResponseBuilder::success();
        }
        return ResponseBuilder::error(ApiCode::HAS_RECEIVE);
    }

    public function createPrize()
    {
        $array = [
            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '沃尔玛'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '沃尔玛'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '沃尔玛'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '沃尔玛'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '沃尔玛'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '沃尔玛'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '孩子王'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '孩子王'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '孩子王'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '孩子王'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '孩子王'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '孩子王'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '大润发'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '大润发'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '大润发'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '大润发'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '大润发'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '大润发'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '爱婴岛'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '爱婴岛'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '爱婴岛'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '爱婴岛'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '爱婴岛'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '爱婴岛'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '华润万家'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '华润万家'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '华润万家'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '华润万家'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '华润万家'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '华润万家'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '爱婴室'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '爱婴室'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '爱婴室'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '爱婴室'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '爱婴室'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '爱婴室'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '永辉'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '永辉'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '永辉'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '永辉'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '永辉'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '永辉'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '贝贝熊'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '贝贝熊'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '贝贝熊'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '贝贝熊'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '贝贝熊'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '贝贝熊'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '山姆'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '山姆'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '山姆'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '山姆'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '山姆'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '山姆'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '小飞象'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '小飞象'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '小飞象'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '小飞象'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '小飞象'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '小飞象'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '心聚心'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '心聚心'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '心聚心'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '心聚心'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '心聚心'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '心聚心'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '厦门启儿'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '厦门启儿'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '厦门启儿'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '厦门启儿'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '厦门启儿'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '厦门启儿'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '爱甜甜'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '爱甜甜'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '爱甜甜'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '爱甜甜'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '爱甜甜'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '爱甜甜'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '爱婴世界'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '爱婴世界'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '爱婴世界'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '爱婴世界'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '爱婴世界'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '爱婴世界'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '华南区天虹商场'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '华南区天虹商场'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '华南区天虹商场'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '华南区天虹商场'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '华南区天虹商场'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '华南区天虹商场'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '华南吉之岛'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '华南吉之岛'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '华南吉之岛'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '华南吉之岛'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '华南吉之岛'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '华南吉之岛'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '嘉荣'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '嘉荣'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '嘉荣'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '嘉荣'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '嘉荣'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '嘉荣'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '婴格'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '婴格'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '婴格'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '婴格'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '婴格'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '婴格'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '武汉可恩宝贝'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '利群'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '利群'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '利群'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '利群'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '利群'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '利群'],

            ['number' => 1, 'name' => '戴森吸尘器', 'v' => 125, 'stock'=> 100, 'channel'=> '其他'],
            ['number' => 2, 'name' => '雅诗兰黛精华露', 'v' => 475, 'stock'=> 100, 'channel'=> '其他'],
            ['number' => 3, 'name' => '香薰', 'v' => 1250, 'stock'=> 100, 'channel'=> '其他'],
            ['number' => 4, 'name' => '美赞臣铂睿A2蛋白系列配方奶粉3段', 'v' => 15000, 'stock'=> 100, 'channel'=> '其他'],
            ['number' => 5, 'name' => '1元现金红包', 'v' => 83150, 'stock'=> 100, 'channel'=> '其他'],
            ['number' => 6, 'name' => '谢谢参与', 'v' => 0, 'stock'=> 100, 'channel'=> '其他'],
        ];



        foreach ($array as $key => $item) {
            $prize = new Prize;
            $prize->number = $item['number'];
            $prize->name = $item['name'];
            $prize->v = $item['v'];
            $prize->stock = $item['stock'];
            $prize->total = 100;
            $prize->channel = $item['channel'];
            $prize->save();
        }
    }
}
