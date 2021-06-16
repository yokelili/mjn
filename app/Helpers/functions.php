<?php

use GuzzleHttp\Client;
use App\Models\Prize;

/**
 * Created by PhpStorm.
 * User: mogu
 * Date: 2021/04/12
 * Time: 17:17
 */


/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */

function getDraw($store){
    $prize = Prize::where('channel', $store)->select('number', 'name', 'v')->get()->toArray();
    //如果中奖数据是放在数据库里，这里就需要进行判断中奖数量
    //在中1、2、3等奖的，如果达到最大数量的则unset相应的奖项，避免重复中大奖
    //code here eg:unset($prize_arr['0'])
    foreach ($prize as $key => $val) {
        $arr[$val['number']] = $val['v'];
    }

    $rid = get_rand($arr); //根据概率获取奖项id

    $res['yes']['name'] = $prize[$rid-1]['name']; //中奖项
    $res['yes']['number'] = $prize[$rid-1]['number'];
    //将中奖项从数组中剔除，剩下未中奖项，如果是数据库验证，这里可以省掉
    unset($prize[$rid-1]);
    shuffle($prize); //打乱数组顺序
    for($i=0;$i<count($prize);$i++){
        $pr[] = $prize[$i]['name'];
    }
    $res['no'] = $pr;
    return $res['yes'];
}

function get_rand($proArr) {
    $result = '';

    //概率数组的总概率精度
    $proSum = array_sum($proArr);

    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);

    return $result;
}




