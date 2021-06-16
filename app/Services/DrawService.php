<?php


namespace App\Services;


use App\ApiCode;
use Illuminate\Support\Facades\Log;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class DrawService
{
    /**
     * @var $prizeArr
     */
    protected $prizeArr;

    /**
     * DrawService constructor.
     * @param $prizeArr
     */
    public function __construct($prizeArr)
    {
        $this->prizeArr = $prizeArr;
    }

    /**
     * Desc : 获取中奖奖品
     * Authority : Administrator
     * FunctionName : getPrize
     * Date : 2020/4/20
     * Time : 13:28
     * @param $prize_arr
     * @throws \Exception
     */
    public function getPrize()
    {

        if (count($this->prizeArr) <= 0) {
            return ResponseBuilder::error(ApiCode::SERVER_ERROR);
        }
        foreach ($this->prizeArr as $key => $val) {
            $arr[$val['prize_on']] = $val['v'];
        }
        $rid = $this->get_rand($arr); //根据概率获取奖项id

        $randId = $rid - 1;
        $res['yes']['prize_id'] = $this->prizeArr[$randId]['prize_id'];
        $res['yes']['prize_on'] = $this->prizeArr[$randId]['prize_on'];
        $res['yes']['prize_name'] = $this->prizeArr[$randId]['prize_name']; //中奖项
        unset($this->prizeArr[$randId]); //将中奖项从数组中剔除，剩下未中奖项

        shuffle($this->prizeArr); //打乱数组顺序
        for ($i = 0, $iMax = count($this->prizeArr); $i < $iMax; $i++) {
            $pr[] = $this->prizeArr[$i]['prize_name'];
        }
        $res['no'] = $pr;
        return $res['yes'];
    }

    /**
     * Desc : 概率算法，
     * Authority : Administrator
     * FunctionName : get_rand
     * Date : 2020/4/20
     * Time : 13:26
     * @param $proArr
     * @return int|string
     */
    protected function get_rand($proArr)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            try {
                $randNum = random_int(1, $proSum);
            } catch (\Exception $e) {
                Log::error('DrawService@get_rand :' . $e->getMessage());
            }
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
}
