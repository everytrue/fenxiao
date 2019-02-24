<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/19
 * Time: 22:32
 */

namespace util;

use think\Exception;

class Curl
{
    /**
     * @param $url
     * @param array $params
     * @param string $cookie
     * @param array $header
     * @return string
     * @throws Exception
     */
    public function get($url, $params=[], $cookie='', $header=[])
    {
        $uri = parse_url($url);
        parse_str($uri['query'], $query);
        $params = array_merge($query, $params);

        $url = $uri['scheme'] . $uri['host'] . $uri['path'] . http_build_query($params);

        $option =  [CURLOPT_HEADER => 0, CURLOPT_RETURNTRANSFER => true];
        $cookie ? $option[CURLOPT_COOKIE]=$cookie : null;
        $header ? $option[CURLOPT_HTTPHEADER]=$header : null;

        return $this->exec($url, $option);
    }

    /**
     * @param $url
     * @param array $params
     * @param string $cookie
     * @param array $header
     * @return bool|string
     * @throws Exception
     */
    public function post($url, $params=[], $cookie='', $header=[])
    {
        $option =  [CURLOPT_POST=>true, CURLOPT_POSTFIELDS=>http_build_query($params)];
        $cookie ? $option[CURLOPT_COOKIE]=$cookie : null;
        $header ? $option[CURLOPT_HTTPHEADER]=$header : null;

        return $this->exec($url, $option);
    }

    /**
     * @param $url
     * @param $option
     * @return bool|string
     * @throws Exception
     */
    public function exec($url, $option)
    {
        if (!is_array($option)) throw new Exception('param $option is not array.');
        isset($option[CURLOPT_HEADER]) ? : $option[CURLOPT_HEADER] = 0;
        isset($option[CURLOPT_RETURNTRANSFER]) ? : $option[CURLOPT_RETURNTRANSFER] = true;

        $curl = curl_init($url);
        curl_setopt_array($curl, $option);

        $res = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) throw new Exception('Curl error: ' . $error);

        return $res;
    }
}