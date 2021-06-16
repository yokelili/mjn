<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Illuminate\Http\Request;
use App\Services\OfficiaService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class IndexController extends Controller
{
    /**
     * 用户授权
     * @param Request $request
     */
    public function index(Request $request)
    {
        $params = $request->all();
//        if (count($params)) {
            return ResponseBuilder::success();
//        }
//        return ResponseBuilder::error(ApiCode::Author_Failed);
//        if (count($params)) {
//            return redirect(url('/index.html')."?".http_build_query($params));
//        }
//        return redirect(url('/index.html'));
    }

    /**
     * 回调
     * @param Request $request
     */
    public function callback(Request $request)
    {
        $params = $request->all();
        if (isset($params['openid'])) {
            session([
                'wechat_user' => [
                    'openid' => $params['openid']
                ]
            ]);
            $targetUrl = empty(session('target_url')) ? '/' : session('target_url');
            return redirect()->away($targetUrl);
        }
        return redirect()->route('index');
    }


    //    public function simulationDraw()
//    {
//        $munbers = 1000;
//        $prizeArr = Prize::query()
//            ->where('channel', '其他')
//            ->get()->toArray();
//        for ($i = 0; $i <= $munbers; $i++) {
    /****模拟抽奖并发****/
////            $drawService = new DrawService($prizeArr);
////            $luckPrize = $drawService->getPrize();
////
////            //开启一个事务
////            DB::transaction(function () use ($luckPrize, $i) {  // &$luckDraw
////                //减少库存
////                $prize = Prize::query()
////                    ->where('channel', '其他')
////                    ->where('prize_id', $luckPrize['prize_id'])
////                    ->lockForUpdate()
////                    ->first();
////                if ($prize->decreaseStock(1) > 0) {
////                    //写入领取奖品表
////                    $receviePrize = new Receive;
////                    $receviePrize->userid = $i;
////                    $receviePrize->prizeid = $luckPrize['prize_id'];
////                    $receviePrize->prize_name = $luckPrize['prize_name'];
////                    $receviePrize->save();
////
////                    DB::commit();
////                }
////            });
//
    /****模拟抽红包并发****/
//            $hongbaoPrize = HongBaoPrize::query()
//                ->select('id', 'denomination', 'v')
//                ->get()->toArray();
//            foreach ($hongbaoPrize as &$item) {
//                $item['prize_id'] = $item['id'];
//                $item['prize_name'] = $item['denomination'];
//            }
//            $drawService = new DrawService($hongbaoPrize);
//            $luckPrize = $drawService->getPrize();
//
//            //写入记录
//            DB::transaction(function () use ($luckPrize, $i, &$hongbaoStock) {
//                $hongbaoStock = HongBaoPrize::query()
//                    ->where('denomination', $luckPrize['prize_name'])
//                    ->lockForUpdate()
//                    ->first();
//                //减库存
//                if ($hongbaoStock->decreaseStock(1) > 0) {
//                    //写入领取红包表
//                    $receiveHongbao = new Receive;
//                    $receiveHongbao->userid = $i;
//                    $receiveHongbao->prizeid = $luckPrize['prize_id'];
//                    $receiveHongbao->prize_name = $luckPrize['prize_name'];
//                    $receiveHongbao->save();
//                    DB::commit();
//                }
//            });
//
//            sleep(0.3);
//        }
//    }
}
