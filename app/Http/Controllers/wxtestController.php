<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
class wxtestController extends Controller
{

    function index(){
        $options = [
            'app_id'    => 'wx1647b3429377748f',
            'secret'    => '7c837f2ff2887845c13558742232a43d',
            'token'     => 'pasdpasdasd22',
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];

        $app = Factory::officialAccount($options);
        $server = $app->server;
        $user = $app->user;
        $server->push(function($message) use ($user) {
            $fromUser = $user->get($message['FromUserName']);
            return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
        });

        $server->serve()->send();
    }




//
}
