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
use app\admin\model\system\SystemConfig as ConfigModel;

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

        $weChatConfig = ConfigModel::getMore(['wechat_appid', 'wechat_appsecret']);
        $authorization_url = Config::get('WeChat.authorization_url');
        $url = $authorization_url . "?appid={$weChatConfig['wechat_appid']}&secret={$weChatConfig['wechat_appsecret']}&code={$code}&grant_type=authorization_code";

        try {
            $curl = new Curl();
            $content = json_decode($curl->get($url));
            if (!empty($content['errcode'])) return R::err(StatusCode::WX_OAUTH, $content['errmsg']);

            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$content['access_token']}&openid={$content['openid']}&lang=zh_CN";
            $content = json_decode($curl->get($url));
            if (!empty($content['errcode'])) return R::err(StatusCode::WX_OAUTH, $content['errmsg']);


        } catch (Exception $e) {
            return R::err(StatusCode::REQUEST_ERROR, $e);
        }

        return R::ok(null, null, ['url'=>'']);
    }
}