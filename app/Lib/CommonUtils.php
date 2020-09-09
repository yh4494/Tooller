<?php


namespace App\Lib;


class CommonUtils
{
    /**
     * 判断字符串
     *
     * @param $string
     * @return bool
     */
    public static function Judge($string)
    {
        if ($string == 'false' || !$string || $string == '') {
            return false;
        }
        return true;
    }
}
