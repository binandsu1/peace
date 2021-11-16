<?php
namespace App\Http\Controllers;
use AipBase;
use http\Client\Curl;
/**
 * 敏感词过滤
 */

require_once public_path('/lib/AipBase.php');

/**
 * 内容审核
 */
class AipContentCensor extends AipBase {

    //这些要不要改
    const APP_ID = '25176769';
    const API_KEY = 'rU4t2Kabjo1w8q8ytUiDwxCb';
    const SECRET_KEY = 'ocUascqCQ4OqdVNDzqlhuhj4F3DL69YU';

    function aaa($requestUrl = '', $requestData = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $last_error = curl_error($ch);
        curl_close($ch);

        $result = json_decode($result, true);
    }

    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        return $data;
    }

    /**
     * 有效期30天，12月15过期，活动开始前要进行一个更新
     */
    function getAccessToken() {
        //TODO 活动开始前更新
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']       = 'client_credentials';
        $post_data['client_id']      = self::API_KEY;
        $post_data['client_secret'] = self::SECRET_KEY;
        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url, $post_data);
//        $res = $this->aaa($url, $post_data);
        return $res;
    }

    function checkFlag($text) {
        $url = 'https://aip.baidubce.com/rest/2.0/solution/v1/text_censor/v2/user_defined?access_token=24.46c3d0ec4dbacd1e96271f316873d9b5.2592000.1639641137.282335-25176769' ;
        $bodys = array(
            'text' => $text
        );

        $res = $this->request_post($url, $bodys);
        $result = json_decode($res, true);
        if ($result['conclusionType'] == 2 || $result['conclusionType'] == 3) {
            return false;
        }
        return true;
    }
}


