<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Events\PushMsgEvent;
use App\Services\Factory;
use App\Services\Register;
use App\Services\Databases\Mysql;

class TestController extends Controller
{
    public function index()
    {
        //工厂模式
//        $redis = Factory::connectCache();

        //注册树
//        $redis = Register::get('redis');

        //适配模式
//        $db = new Mysql;
//        $db->connect('127.0.0.1', 'root', 'root', 'test');
//        $db->query('show databases');
//        $db->close();


        return view("test");
    }

    /**
     * 接受前端弹幕请求，并触发广播事件
     */
    public function put( Request $request )
    {
        broadcast(new PushMsgEvent($request->msg));
    }
}
