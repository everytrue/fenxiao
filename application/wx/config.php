<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 20:37
 */

return [
    'WeChat' => [
        'appid' => '',  // 微信公众号唯一标识
        'secret' => '', // 微信公众号appsecret

        // 获取微信网页授权access_token的链接地址
        // https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        'authorization_url' => 'https://api.weixin.qq.com/sns/oauth2/access_token'
    ]
];