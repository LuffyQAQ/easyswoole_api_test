<?php
/**
 *
 * User: zs
 * Date: 2019/9/5 15:29
 * Email: <1769360227@qq.com>
 */

namespace App\HttpController\Api\Common;


use App\Service\Common\VerifyCodeService;
use EasySwoole\Http\Message\Status;
use EasySwoole\Utility\Random;
use EasySwoole\VerifyCode\Conf;

class VerifyCode extends CommonBase
{
    static $VERIFY_CODE_TTL = 120;
    static $VERIFY_CODE_LENGTH = 4;

    public function verifyCode()
    {
        $config = new Conf();
        $code = new \EasySwoole\VerifyCode\VerifyCode($config);
        //获取随机数
        $random = Random::character(self::$VERIFY_CODE_LENGTH,'1234567890abcdefghijklmnopqrstuvwxyz');
        $code = $code->DrawCode($random);
        $time = time();
        $result = [
            'verifyCode' => $code->getImageBase64(),
            'verifyCodeTime' => $time,
        ];

        $this->response()->setCookie("verifyCodeHash", VerifyCodeService::getVerifyCodeHash($random, $time), $time + self::$VERIFY_CODE_TTL, '/');
        $this->response()->setCookie('verifyCodeTime', $time, $time + self::$VERIFY_CODE_TTL, '/');
        $this->writeJson(Status::CODE_OK, $result, 'success');

    }
}