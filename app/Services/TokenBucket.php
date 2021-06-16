<?php


namespace App\Services;
use Illuminate\Support\Facades\Redis;

class TokenBucket
{
    private $_redis; 	//redis对象
    private $_queue;   //令牌桶
    private $_max;		//最大令牌数

    public function __construct($queue,$max){
        $this->_queue = $queue;
        $this->_max = $max;
        $this->_redis = new Redis;
    }

    /*
	* 加入令牌
	* @param Int $num 加入的令牌数量
	* @return Int 加入的数量
	*/
    public function add($num=0){
        //当前剩余令牌数
        $curnum = intval($this->_redis::lLen($this->_queue));
        //最大令牌数
        $maxnum = intval($this->_max);
        //计算最大可加入的令牌数量，不能超过最大令牌数
        $num = $maxnum >= ($curnum+$num) ? $num : ($maxnum - $curnum);
        //加入令牌
        if($num > 0){
            $token = array_fill(0,$num,1);
            $this->_redis::lPush($this->_queue, ...$token);
            return $num;
        }
        return 0;
    }

    //获取令牌
    public function get(){
        return $this->_redis::rPop($this->_queue) ? true : false;
    }

    //重设令牌桶，填满令牌
    public function reset(){
        $this->_redis::delete($this->_queue);
        $this->add($this->_max);
    }
}
