<?php
/**
 * Desc: 第三方 API 接口配置
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/4/20
 * Time: 22:37
 */
return [
    //开发环境
    'local' => [
        //微信授权地址测试环境
        'oauth' => [
            'route' => env('LOCAL_OAUTH_URL',
                'https://wpqa.novaetech.cn/wx/oauth2/authorize?brandId=PAuKa9J4AQ1MbJg4pT&access_token=false&scope=snsapi_base&url=')
        ],
        //加 88 积分接口
        'integral' => [
            'appid' => env('LOCAL_INTEGRAL_APPID', 'OTYPE@SIT'),
            'appSecret' => env('LOCAL_INTEGRAL_APPSECRET', '727149A90475E78E0F18374581E74D24'),
            'domain' => env('LOCAL_INTEGRAL_DOMAIN', 'http://test-loyalty-core.mjnqy.com'),
            'route' => env('LOCAL_INTEGRAL_ROUTE', '/coreapi/ext/otype/addpoint')
        ],

        //发送红包
        'sendHongbao' => [
            'route' => env('LOCAL_SENDHONGBAO_ROUTE', 'http://193.112.1.71:8090/api/v1/send'),
            'secret' => env('LOCAL_SENDHONGBAO_SECRET', '232323'),
            'activityId' => env('LOCAL_SENDHONGBAO_ACTIVITYID', 'test123'),
            'departmentId' => env('LOCAL_SENDHONGBAO_DEPARTMENTID', 68),
            'channelId' => env('LOCAL_SENDHONGBAO_CHANNELID', 8),
        ],

        //验证防伪码
        'verifi_code' => [
            'route' => env('LOCAL_VERIFI_CODE_ROUTE', 'https://svr.mjnqy.com/DigitCodeHandle/GetProductInfoByDigitCode'),
            'platformToken' => env('LOCAL_PLATFORMTOKEN_VERIFI_CODE', 'MediaClick'),
            'rsa' => [
                'private' => '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDLUXFfPGjolZHxO0fc+e26S0Aq9OyI6jvSFjngLXb4V2dfb1Dh
CXB4y0wWheCvU4jd9b6lklF2kw9d5sPHDMCqssZPKnfcoGPNzGTtzVFjMJXYHHW7
bHvwOhBzO33fGVYlKl2MK+NHyFzByovtQhcCWlTM5SEFBqB96eccg8bfUwIDAQAB
AoGBAIPhahaKSspC6o19FFojy64BTbgPcrZEqVTWkef11au0lhrzS5UM2GWiCNK7
OEjBeI/w7R7cz/aH4XnZS7h7bySgvu/ByPzfxVq8cSFZLx5pXapy0FdI2AWCinKt
5Um9pokD0Fqa0iR+iZS7UGxp0xobEpiohV1dfzqkvm1qYZyhAkEA+27UOco2FgoR
BOoKLtMnVqYF9DQxjTY5g9KH3Mdc9iHEId8fxIo6K8Q4F7kTnACJh3uT5R+o+jbn
176AkPugOQJBAM8C4OoMrO5stDqiu5H22/CzLetX9t2BiQZWEqHPvkGy7HeRyb1H
ZoSgnKaXf3XLGYEsIwAjPZuHx73Ril77I+sCQQD5S8Y5FnnSGGEPkk5OZyZWD39P
xoBrFxyny5LSIQnXMVuaifShlrxesMs9GlCLGS1DnA/j2iRdExuFGmm3VwZhAkEA
ubJGWg3WzuYaYoL6KXy9XVUOOxAkdh0t8s4hVp/JdpvvPW88/hrfnteIznQWNW9k
SJh0KTpzmGIbzm36Zyt30wJAAPjOml0arnWGxzbvhVZp8+GJ9A94ZFMTXnO0V58n
HP2quqKCkp8LWKsWbtAF60sy6fJXrgVMuFXjFSEvwfnuOQ==
-----END RSA PRIVATE KEY-----'
            ],
        ],

        //查询会员信息接口
        'query_member' => [
            'route' => env('LOCAL_QUERYMEMBER_ROUTE', 'https://svr.mjnqy.com/MemberHandle/QueryMember'),
            'platformToken' => env('LOCAL_PLATFORMTOKEN_QUERY_MEMBER', 'MediaClick'),
            'rsa' => [
                'private' => '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDLUXFfPGjolZHxO0fc+e26S0Aq9OyI6jvSFjngLXb4V2dfb1Dh
CXB4y0wWheCvU4jd9b6lklF2kw9d5sPHDMCqssZPKnfcoGPNzGTtzVFjMJXYHHW7
bHvwOhBzO33fGVYlKl2MK+NHyFzByovtQhcCWlTM5SEFBqB96eccg8bfUwIDAQAB
AoGBAIPhahaKSspC6o19FFojy64BTbgPcrZEqVTWkef11au0lhrzS5UM2GWiCNK7
OEjBeI/w7R7cz/aH4XnZS7h7bySgvu/ByPzfxVq8cSFZLx5pXapy0FdI2AWCinKt
5Um9pokD0Fqa0iR+iZS7UGxp0xobEpiohV1dfzqkvm1qYZyhAkEA+27UOco2FgoR
BOoKLtMnVqYF9DQxjTY5g9KH3Mdc9iHEId8fxIo6K8Q4F7kTnACJh3uT5R+o+jbn
176AkPugOQJBAM8C4OoMrO5stDqiu5H22/CzLetX9t2BiQZWEqHPvkGy7HeRyb1H
ZoSgnKaXf3XLGYEsIwAjPZuHx73Ril77I+sCQQD5S8Y5FnnSGGEPkk5OZyZWD39P
xoBrFxyny5LSIQnXMVuaifShlrxesMs9GlCLGS1DnA/j2iRdExuFGmm3VwZhAkEA
ubJGWg3WzuYaYoL6KXy9XVUOOxAkdh0t8s4hVp/JdpvvPW88/hrfnteIznQWNW9k
SJh0KTpzmGIbzm36Zyt30wJAAPjOml0arnWGxzbvhVZp8+GJ9A94ZFMTXnO0V58n
HP2quqKCkp8LWKsWbtAF60sy6fJXrgVMuFXjFSEvwfnuOQ==
-----END RSA PRIVATE KEY-----'
            ]
        ]
    ],


    //生产环境
    'production' => [

        //微信授权地址测试环境
        'oauth' => [
            'route' => env('PRODUCTION_OAUTH_URL', '')
        ],

        //加 88 积分接口
        'integral' => [
            'appid' => env('PRODUCTION_INTEGRAL_APPID', ''),
            'appSecret' => env('PRODUCTION_INTEGRAL_APPSECRET', ''),
            'domain' => env('PRODUCTION_INTEGRAL_DOMAIN', ''),
            'route' => env('PRODUCTION_INTEGRAL_ROUTE', '')
        ],

        //发送红包
        'sendHongbao' => [
            'route' => env('PRODUCTION_SENDHONGBAO_ROUTE', ''),
            'secret' => env('PRODUCTION_SENDHONGBAO_SECRET', ''),
            'activityId' => env('PRODUCTION_SENDHONGBAO_ACTIVITYID', ''),
            'departmentId' => env('PRODUCTION_SENDHONGBAO_DEPARTMENTID', ''),
            'channelId' => env('PRODUCTION_SENDHONGBAO_CHANNELID', ''),
        ],

        //验证防伪码
        'verifi_code' => [
            'route' => env('PRODUCTION_VERIFI_CODE_ROUTE', ''),
            'platformToken' => env('PRODUCTION_VERIFI_CODE_PLATFORMTOKEN', ''),
            'rsa' => [
                'private' => '-----BEGIN RSA PRIVATE KEY-----
MIICXwIBAAKBgQC62o0YYpijdh/pIFoFzRcK7ppV8aoKonrlWwsfiJonmqhkBTbT
JpLPMg1M0PE9Xsh97DneVOOepE6rvymvb/i5I/3KiMlwsO4cMPmg7W+wBgw5XAOu
ELB3imeP9QPgean/TY3E0/wgighZda0ErGciPKbIUUXZkj9zq6j85OdylQIDAQAB
AoGBAJhHOKng4IiG4ia5qOQFanwMTFcyZePY2tNESWJfj1IrZoRtA2s9inO1VMV/
mrrrHfYRqG+bOw201jB90FkbpdTFx3+5fHFL85A6cbuEv8XCFCox6BLhVxstS2s1
uSPwkRfgQ+un9NLDTFE8uy59fnDEwZ1HTLnMxU0kN0jiyRiZAkEA9QlsVUvvDqNk
7tNprJWpMPID6xbGoKLlQX/Dhy26LXFrLdpO9S9RAVwHn7jwvzK50lUD57U8wfwH
h7crAAI4IwJBAMM2t3GxxrrC6DItx4/dXDopIhiFHq+XLduNdxZIrYNFDFQZq0kK
tJiUwRG4tFu6uBmNvQu3PWAjPe10WaTtOecCQQCJv7Rg9wD6r6wL/llHphKo60R8
oh8jKq/KdHKMyY4CAeKIslL0zpaxNvUqOyNLuM5xiU1asq3nNzFcgAHyTU0VAkEA
ux+nBof3zCxq8Taq1b/F2UZ2lXR9bqmG3q8jGSw/jtZQNAmLA/AMHzpwO7GGyWsZ
b/1K2oEihxYhFY3zJEH1vwJBAKC0ZcFh7tXrNu831XJmZ9+oxIdt0Ee/CQWWn4A1
1cQ29WPj7/UFByX06XFURGMjvqCYEP/o/zmC/lNUcAo2A1Y=
-----END RSA PRIVATE KEY-----
'
            ],
        ],

        //查询会员信息接口
        'query_member' => [
            'route' => env('PRODUCTION_QUERYMEMBER_ROUTE', ''),
            'platformToken' => env('PRODUCTION_QUERY_MEMBER_PLATFORMTOKEN', ''),
            'rsa' => [
                'private' => '-----BEGIN RSA PRIVATE KEY-----
MIICXwIBAAKBgQC62o0YYpijdh/pIFoFzRcK7ppV8aoKonrlWwsfiJonmqhkBTbT
JpLPMg1M0PE9Xsh97DneVOOepE6rvymvb/i5I/3KiMlwsO4cMPmg7W+wBgw5XAOu
ELB3imeP9QPgean/TY3E0/wgighZda0ErGciPKbIUUXZkj9zq6j85OdylQIDAQAB
AoGBAJhHOKng4IiG4ia5qOQFanwMTFcyZePY2tNESWJfj1IrZoRtA2s9inO1VMV/
mrrrHfYRqG+bOw201jB90FkbpdTFx3+5fHFL85A6cbuEv8XCFCox6BLhVxstS2s1
uSPwkRfgQ+un9NLDTFE8uy59fnDEwZ1HTLnMxU0kN0jiyRiZAkEA9QlsVUvvDqNk
7tNprJWpMPID6xbGoKLlQX/Dhy26LXFrLdpO9S9RAVwHn7jwvzK50lUD57U8wfwH
h7crAAI4IwJBAMM2t3GxxrrC6DItx4/dXDopIhiFHq+XLduNdxZIrYNFDFQZq0kK
tJiUwRG4tFu6uBmNvQu3PWAjPe10WaTtOecCQQCJv7Rg9wD6r6wL/llHphKo60R8
oh8jKq/KdHKMyY4CAeKIslL0zpaxNvUqOyNLuM5xiU1asq3nNzFcgAHyTU0VAkEA
ux+nBof3zCxq8Taq1b/F2UZ2lXR9bqmG3q8jGSw/jtZQNAmLA/AMHzpwO7GGyWsZ
b/1K2oEihxYhFY3zJEH1vwJBAKC0ZcFh7tXrNu831XJmZ9+oxIdt0Ee/CQWWn4A1
1cQ29WPj7/UFByX06XFURGMjvqCYEP/o/zmC/lNUcAo2A1Y=
-----END RSA PRIVATE KEY-----
'
            ]
        ]
    ]
];
