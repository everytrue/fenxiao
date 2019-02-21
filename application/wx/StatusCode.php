<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 21:25
 */

namespace app\wx;

class StatusCode
{
    const SERVER_ERROR = 50000;    // 服务器异常
    const WX_OAUTH = 51000;     // 微信授权异常
    const AUTHENTICATION_USER = 10001;  // 身份认证失败，用户名不存在
    const AUTHENTICATION_PASSWORD = 10002;  // 身份认证失败，密码错误
    const ACCOUNT_DISABLE = 10010;  // 账户异常，账户被禁用
    const ACCOUNT_LOCK = 10011; // 账户异常，账户被锁定
    const REQUEST_ERROR = 40000;    // 请求错误
    const REQUEST_PARAM_LACK = 40010;   // 请求参数错误，缺少参数
}