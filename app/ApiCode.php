<?php


namespace App;


class ApiCode
{
    //系统错误
    const SYSTEM_ERROR = 500;
    //没有抽奖机会
    const NOT_DRAW_CHANCE = 1000;
    //是否已经扫过码
    const SCAN_EXIST = 1001;
    //防伪码已使用
    const DIGITCODE_EXIST = 1002;
    //CRM系统错误
    const CRM_VERIFI_CODE_ERROR = 1003;
    //防伪码验证失败
    const CRM_VERIFI_FORMAT_ERROR = 1004;
    //会员查询系统错误
    const CRM_QUERT_MEMBER_INFO_ERROR = 1005;
    //产品不存在与活动范围内
    const PRODUCT_INFO_ERROR = 1006;
    //用户没有奖品
    const NOT_PRIZE = 1007;
    //用户已经领取奖品了
    const HAS_RECEIVE = 1008;
    //红包领取失败
    const SEND_HONGBAO_FAIL = 1009;
    //请填写购买门店
    const STORE_NAME_NOT_FOUND = 1010;
    //授权失败
    const Author_Failed = 1011;
}
