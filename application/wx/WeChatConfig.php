<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 22:07
 */

namespace app\wx;


class WeChatConfig
{
    const APPID = '';
    const secret = '';

    // 获取微信网页授权access_token的链接地址
    const AUTHORIZATION_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';
}