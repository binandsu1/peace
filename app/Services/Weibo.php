<?php

namespace App\Services;
use App\Models\Jiayu;

class Weibo
{

    protected static $Appkey;
    protected static $WxAppkey;
    protected static $WxComponentAppkey;
    protected static $AppSecret;
    protected static $RedirectUrl;
    protected static $wbRedirectUrl;
    protected static $wbsRedirectUrl;
    protected static $Skey;
    protected static $client;

    public function __construct()
    {
            self::$Appkey = env('WbAppKey','4129299852');
            self::$AppSecret = env('WbAppSecret','c6a0258700216016d286dd1e24933bf7');
            self::$RedirectUrl = env('WbRedirectUrl','https://mssocial.una-ad.com/api/activityIndex');
            self::$wbRedirectUrl = urlencode(env('WbRedirectUrl','https://mssocial.una-ad.com/api/activityIndex?type=wb'));
            self::$wbsRedirectUrl = env('WbRedirectUrl','https://mssocial.una-ad.com/api/activityIndex?type=wb');

            self::$WxAppkey = env('WxAppkey','wx2055b6314cd25ac1');
            self::$WxComponentAppkey = env('WxComponentAppkey','wx062a1b8f9e01e151');
            self::$Skey = env('Skey','gb6hs2up');

            self::$client = new \GuzzleHttp\Client([
                'verify' =>false,
                'headers'  => ['content-type' => 'application/x-www-form-urlencoded'],

            ]);
    }
    public function getCode($type,$getCode='State'){
        if($type=='wx'){
            if(empty($getCode)){
                $getCode = 'State';
            }
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::$WxAppkey."&redirect_uri=".self::$RedirectUrl."?type=wx&response_type=code&scope=snsapi_userinfo&state=".$getCode."&component_appid=".self::$WxComponentAppkey."&storeCode=111#wechat_redirect";
        }
        if($type=='wb'){
            $url = "https://api.weibo.com/oauth2/authorize?client_id=".self::$Appkey."&response_type=code&redirect_uri=".self::$wbRedirectUrl;
        }

        return redirect()->away($url);
    }
    public function getComponentAccessToken(){
        $url = "http://wechatmessage.una-ad.com/wxapi/get_component_token?appid=".self::$WxAppkey."&skey=".self::$Skey;
        $response = self::$client->request('GET', $url);
        $body = $response->getBody()->getContents();
        $result = json_decode($body, TRUE);
        return $result['data']['access_token'];
    }

    public function getToken($code,$type){

        if($type == 'wx'){
            $skey = $this->getComponentAccessToken();
            $url = "https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=".self::$WxAppkey."&code=".$code."&grant_type=authorization_code&component_appid=".self::$WxComponentAppkey."&component_access_token=".$skey;
            $response = self::$client->request('GET', $url);
            $body = $response->getBody()->getContents();
            $result = json_decode($body, TRUE);
            return $result;
        }
        if($type == 'wb'){
            $response =self::$client->request('POST', 'https://api.weibo.com/oauth2/access_token', [
                'form_params' => [
                    'client_id' => self::$Appkey,
                    'client_secret' => self::$AppSecret,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => self::$wbsRedirectUrl,
                    'code' => $code,
                ]
            ]);
        }

        $body = $response->getBody()->getContents();
        $result = json_decode($body, TRUE);
        return $result;
    }

    public function getUserInfo($token,$uid){

        $url = "https://api.weibo.com/2/users/show.json?access_token=".$token."&uid=".$uid;
        $response = self::$client->request('get',$url);
        $body = $response->getBody()->getContents();
        $re = json_decode($body, TRUE);
        $is = Jiayu::where('u_id',$re['id'])->first();
        if(!$is){
            $data['u_id'] = $re['id'];
            $data['u_token'] = $token;
            $data['type'] = 'wb';
            $data['u_name'] = $re['name'];
            $data['u_image'] = $re['profile_image_url'];
            $data['api_token'] = md5($re['id']);
            Jiayu::create($data);
            return $data['api_token'];
        }
        return $is->api_token;
    }


    public function getwxUserInfo($token='',$openid='',$storeCode=''){



        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
        $response = self::$client->request('get',$url);
        $body = $response->getBody()->getContents();
        $re = json_decode($body, TRUE);
        $is = Jiayu::where('u_id',$re['unionid'])->first();

        if(!$is){
            if(!empty($storeCode)){
                $data['store_code'] = $storeCode;
            }
            $data['u_id'] = $re['unionid'];
            $data['u_token'] = $openid;
            $data['type'] = 'wx';
            $data['u_name'] = $re['nickname'];
            $data['u_image'] = $re['headimgurl'];
            $data['api_token'] = md5($re['unionid']);
            Jiayu::create($data);
            return $data['api_token'];
        }
        return $is->api_token;
    }

    public function share($token='',$con=''){

        $response =self::$client->request('POST', 'https://api.weibo.com/2/statuses/share.json', [
            'form_params' => [
                'access_token' => $token,
                'status' => $con."https://mssocial.una-ad.com/api/activityIndex?type=wb",
                'pic' => "https://mssocial.una-ad.com/images/hb/no-flagp.png",
            ]
        ]);
        $body = $response->getBody()->getContents();
        $result = json_decode($body, TRUE);
        return $result;


    }

}
