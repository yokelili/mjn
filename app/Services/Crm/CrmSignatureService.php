<?php


namespace App\Services\Crm;


class CrmSignatureService
{
    /**
     * Notes:[生成签名]
     * User: COJOY_10
     * Date: 2021/3/1
     * Time: 14:02
     * @param $timestamp
     * @param $privateKey
     * @return string
     */
    public static function generateSign($timestamp, $privateKey)
    {
        $signature = '';
        $privKeyId = openssl_pkey_get_private($privateKey);
        openssl_sign(base64_encode($timestamp), $signature, $privKeyId, OPENSSL_ALGO_MD5);
        openssl_free_key($privKeyId);
        return base64_encode($signature);
    }
}
