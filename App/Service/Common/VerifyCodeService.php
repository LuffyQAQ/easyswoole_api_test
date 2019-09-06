<?php
/**
 *
 * User: zs
 * Date: 2019/9/5 15:44
 * Email: <1769360227@qq.com>
 */

namespace App\Service\Common;


class VerifyCodeService extends CommonBaseService
{
    const DURATION = 5 * 60;

    static function checkVerifyCode($code, $time, $hash)
    {
        if ($time + self::DURATION < time()) {
            return false;
        }
        $code = strtolower($code);
        return self::getVerifyCodeHash($code, $time) == $hash;
    }

    static function getVerifyCodeHash($code, $time)
    {
        return md5($code . $time);
    }

}