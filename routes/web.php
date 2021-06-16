<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserinfoController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LuckDrawController;
use App\Http\Controllers\ScanCodeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TokenBucketController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['middleware' => ['oauth', 'userinfo']], function () {
    // 授权回调
    Route::get('/', [IndexController::class, 'index'])->name('index');
    // 获取用户信息
    Route::get('/userinfo', [UserinfoController::class, 'userInfo']);
    // 用户答题记录
    Route::post('/answerinfo', [AnswerController::class, 'answerInfo']);
    // 填写门店地址
    Route::post('/addStore', [UserinfoController::class, 'addStores']);
    // 抽奖
    Route::get('/luckDraw', [LuckDrawController::class, 'luckDraw']);
    // 扫码
    Route::post('/scanCode', [ScanCodeController::class, 'scanCode']);
    // 留资
    Route::post('/createUserinfo', [UserinfoController::class, 'createUserinfo']);

});
Route::get('createPrize', [UserinfoController::class, 'createPrize']);
Route::get('callback', [IndexController::class, 'index'])->name('callback');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/socketRequest', [ScanCodeController::class, 'socketRequest']);
Route::get('/test', [TestController::class, 'index']);
Route::get('/put', [TestController::class, 'put']);

//令牌桶
Route::group(['middleware'=> 'tokenBucket'], function () {
    Route::get('/tokenBucket', [TokenBucketController::class, 'index']);
});



