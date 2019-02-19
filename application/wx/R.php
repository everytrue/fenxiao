<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 21:21
 */

namespace app\wx;

class R
{
    private static $code = 0;
    private static $message = "success";
    private static $data = null;

    public static function ok($code=0, $message="", $data=null)
    {
        $code = $code ? $code : R::$code;
        $message = $message ? $message : R::$message;
        $data = $data ? $data : R::$data;
        return json(["code"=>$code, "messages"=>$message, "data"=>$data]);
    }

    public static function err($code=StatusCode::SERVER_ERROR, $message="服务器出现异常")
    {
        $code = $code ? $code : R::$code;
        $message = $message ? $message : R::$message;
        return json(["code"=>$code, "messages"=>$message]);
    }
}