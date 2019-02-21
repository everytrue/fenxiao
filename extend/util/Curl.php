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
     * @return string
     * @throws Exception
     */
    public function get($url, $params=[])
    {
        $url = $params ? $url . '?' . http_build_query($params): $url;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (curl_exec($curl) === false) {
            throw new Exception('Curl error: ' . curl_error($curl));
        }

        $content = curl_multi_getcontent($curl);

        curl_close($curl);

        return $content;
    }
}