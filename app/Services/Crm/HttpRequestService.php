<?php


namespace App\Services\Crm;

use App\Models\CrmRequestLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HttpRequestService
{
    /**
     * Notes:[CRM HTTP Post Request]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:45
     * @param $request_api
     * @param $params
     * @param $privateKey
     * @param $platformToken
     * @return array|mixed
     */
    public static function httpCrmPostRequest($request_api, $params, $privateKey, $platformToken)
    {
        try {
            //请求开始时间
            $requestStartTime = microtime(true);

            //获取当前时间戳
            $timestamp = sprintf("%s", time());
            //公共参数合并
            $params = array_merge([
                'timestamp' => $timestamp,
                'signature' => CrmSignatureService::generateSign($timestamp, $privateKey)
            ], $params);

            //发起请求
            $response = Http::withHeaders([
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'UTF8',
                'Platform-Token' => $platformToken
            ])->post($request_api, $params)->json();

            //响应结束时间
            $responseEndTime = microtime(true);
            //请求接口花费的时间
            $spent_time = floor(($responseEndTime - $requestStartTime) * 1000);

            //记录接口日志
//            self::crmRequestLog($request_api, $params, $response, $spent_time);
            //返回数据
            return $response;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            Log::error(__CLASS__.__FUNCTION__.' error：'.$exception->getMessage());
            abort(500);
        }
    }

    /**
     * Notes:[Ordinary Http Request]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:40
     * @param $request_api
     * @param $params
     * @param  array  $withHeaders
     * @return \Illuminate\Http\Client\Response
     */
    public static function httpPostRequest($request_api, $params, $withHeaders = [])
    {
        //请求开始时间
        $requestStartTime = microtime(true);
        $response = Http::withHeaders($withHeaders)->post($request_api, $params);
        //响应结束时间
        $responseEndTime = microtime(true);
        //请求接口花费的时间
        $spent_time = floor(($responseEndTime - $requestStartTime) * 1000);
        //记录接口日志
        self::crmRequestLog($request_api, $params, $response, $spent_time);
        return $response;
    }

    /**
     * Notes:[请求日志记录]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:38
     * @param $request_api
     * @param $params
     * @param $response
     * @param $spent_time
     */
    public static function crmRequestLog($request_api, $params, $response, $spent_time)
    {
        $crmRequestLog = new CrmRequestLog();
        $crmRequestLog->request_api = $request_api;
        $crmRequestLog->request_data = json_encode($params);
        $crmRequestLog->response_data = is_array($response) ? json_encode($response) : $response;
        $crmRequestLog->spent_time = $spent_time;
        $crmRequestLog->save();
    }
}
