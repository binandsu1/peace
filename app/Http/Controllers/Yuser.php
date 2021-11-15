<?php

namespace App\Http\Controllers;

use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class Yuser extends Controller
{
//    public function addApiToken(Request $request)
//    {
//        echo 'start';
//        $this->middleware('auth:sanctum');
//        $user = User::find(3);
//        //add
//        $token = $user->createToken('token-name');
//        //给权限
//        $user->createToken('token-name', ['sss'])->plainTextToken;
//        //撤销所有令牌
//        $user->tokens()->delete();
//        return $token->plainTextToken;
//    }
//
//    public function login()
//    {
//        echo '请登录';
//    }
//
//
//    public function info(Request $request)
//    {
//        for ($i = 0; $i < 10; $i++) {
//            $data['name'] = rand(10000, 99999);
//            $data['pic'] = rand(10000, 99999);
//            UpPicJob::dispatch($data);
//        }
//        echo 'info';
//    }

    public function upView()
    {
        $model = Jiayu::get();
        return view('user-info');
    }

    public function upViewSub(Request $request)
    {
        $image = $request->file('image');
        $type = $image->extension();
        $imageName = time() . rand(10000, 99999) .'.'. $type;
        $path = 'images/' . date('Ymd');
        $image->move(public_path($path), $imageName);
        $data['pic_name_old'] = $image->getClientOriginalName();
        $data['pic_name'] = $imageName;
        $data['type'] = $type;
        $data['path'] = $path . "/" . $imageName;
        UpPicJob::dispatchNow($data);

    }


}
