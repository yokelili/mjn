<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    use HasFactory;

        public $table='wx_user';

    /**
     * 领奖记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getPrize()
    {
        return $this->hasMany(LuckReceive::class, 'openid', 'openid')->select('id', 'prizeid', 'prize_name', 'is_receive');
    }

    public function getDraw()
    {
        return $this->hasMany(LuckDraw::class, 'openid', 'openid')->where('is_luck', 1);
    }
}
