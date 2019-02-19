<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 20:37
 */

namespace app\wx\controller;

use app\wx\R;
use app\wx\StatusCode;
use think\Config;
use think\Controller;
use think\Exception;
use util\Curl;

class User extends Controller
{
    public function login()
    {

    }

    /**
     * @return \think\response\Json
     */
    public function oauth()
    {
        $code = $this->request->get('code');
        if (empty($code)) return R::err(StatusCode::REQUEST_PARAM_LACK, 'code is not null.');

        $appid = Config::get('WeChat.appid');
        $secret = Config::get('WeChat.secret');
        $authorization_url = Config::get('WeChat.authorization_url');
        $url = $authorization_url . "?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";

        try {
            $curl = new Curl();
            $content = json_decode($curl->get($url));
            if (!empty($content['errcode'])) return R::err(StatusCode::WX_OAUTH, $content['errmsg']);


        } catch (Exception $e) {
            return R::err(StatusCode::REQUEST_ERROR, $e);
        }

        return R::ok(null, null, ['url'=>'']);
    }
}