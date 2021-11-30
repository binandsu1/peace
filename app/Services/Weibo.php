<?php

namespace App\Services;
use App\Models\Jiayu;

class Weibo
{

    protected static $Appkey;
    protected static $AppSecret;
    protected static $RedirectUrl;
    protected static $client;

    public function __construct()
    {       self::$Appkey = env('WbAppKey','4129299852');
            self::$AppSecret = env('WbAppSecret','124c3fea8840764f4c9a5dc5d1d9efe4');
            self::$RedirectUrl = env('WbRedirectUrl','http://microsoftsocial.una-ad.com/api/activityIndex');
            self::$client = new \GuzzleHttp\Client(['verify' =>false]);
    }
    public function getCode(){
        $url = "https://api.weibo.com/oauth2/authorize?client_id=".self::$Appkey."&response_type=code&redirect_uri=".self::$RedirectUrl;
        return redirect()->away($url);
    }

    public function getToken($code){
        $response =self::$client->request('POST', 'https://api.weibo.com/oauth2/access_token', [
            'form_params' => [
                'client_id' => self::$Appkey,
                'client_secret' => self::$AppSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => self::$RedirectUrl,
                'code' => $code,
            ]
        ]);
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
            $data['u_name'] = $re['name'];
            $data['u_image'] = $re['profile_image_url'];
            $data['api_token'] = md5($re['id']);
            Jiayu::create($data);
            return $data['api_token'];
        }
        return $is->api_token;
    }




}
