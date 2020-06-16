<?php
/**
 * Created by PhpStorm.
 * User: yueyu
 * Date: 2019/2/14
 * Time: 7:00 PM
 */

namespace App\Lib;


class JsonTooller
{
    /**
     * 参数错误
     *
     * @return false|string
     */
    public static function paramsFail()
    {
        return static::data(-6, '参数错误', []);
    }

    /**
     * 未登录
     *
     * @return false|string
     */
    public static function unLogin()
    {
        return static::data(-101, '未登录，请登录后再操作', []);

    }

    /**
     * 成功
     *
     * @return false|string
     */
    public static function success()
    {
        return static::data(0, '成功', []);
    }

    /**
     * 普通错误（请求错误）
     *
     * @return false|string
     */
    public static function commonError()
    {
        return static::data(-7, '请求错误', []);
    }

    /**
     * 系统错误
     *
     * @return false|string
     */
    public static function systemError()
    {
        return static::data(-1, '系统错误', []);
    }

    public static function data($code = -1, $msg = null, $data)
    {
        return json_encode([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ]);
    }
}
