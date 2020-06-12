<?php


namespace App\Http\Config;


class HttpRouteConfig
{
    public static $loginAccess = [
        'article',
        'about',
        'process'
    ];

    /**
     * 路由查找
     *
     * @param $route
     * @return bool
     */
    public static function includeRoute($route)
    {
        foreach (self::$loginAccess as $access) {
            $res = strpos($route, $access);
            if ($res !== false) {
                return true;
            }
        }
        return false;
    }
}
