<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AipContentCensor;
use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use App\Models\PrizeNum;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class Activity extends Controller
{


    public function activityIndex(Request $request)
    {

        $code = $request->input('code');

        $weiboSer = app('weibo');
        if (empty($code)) {
            return $weiboSer->getCode();
        }
        $tokenArr = $weiboSer->getToken($code);
        $weiboSer->getUserInfo($tokenArr['access_token'], $tokenArr['uid']);

        return view('activity-index');
    }

    public function activityUp()
    {

        return view('activity-up');
    }

    public function activityDown()
    {
        return redirect()->away("https://wisepeople.xbaofun.com/wisepeople/oobe/users/storeList");
        return view('map');
    }

    public function luckyDraw(Request $request)
    {
        $flag = $request->input('flag');

        return view('lucky-draw', compact('flag'));
    }

    public function winPrize(Request $request)
    {
        $data = $request->all();
        return view('win-prize', compact('data'));
    }

    public function poster(Request $request)
    {

        $flag = $request->input('flag', '吃饭了吗');
        $pic_re = Jiayu::orderBy('id', 'DESC')->first();
        $image = new Image();
        $path = $pic_re->path;

        $newimageName = 'new' . time() . rand(10000, 99999) . '.jpg';
        $newpath = 'images/' . date('Ymd') . '/' . $newimageName;

        $face_img = $image::make($path)->resize(530, 800);
        $face_img->text($flag, 370, 41, function ($font) use ($path) {
            $font->file(public_path('vista.ttf'));
            $font->size(18);
            $font->color('#FF0000');
            $font->valign('right');
        });

        $save_path = public_path($newpath);

        $face_img->save($save_path);
        return view('poster', compact('pic_re', 'newimageName'));
    }


    public function map()
    {
        return view('map');
    }

    public function phone(Request $request)
    {

        if ($request->method() == 'POST') {

            $image = $request->file('image');
            $type = $image->extension();
            $imageName = time() . rand(10000, 99999) . '.' . $type;
            $path = 'images/' . date('Ymd');
            $image->move(public_path($path), $imageName);
            $data['pic_name_old'] = $image->getClientOriginalName();
            $data['pic_name'] = $imageName;
            $data['type'] = $type;
            $data['path'] = $path . "/" . $imageName;
            UpPicJob::dispatchNow($data);
        }
        $image = Jiayu::orderBy('id', 'DESC')->first();
        return view('phone', compact('image'));
    }

//我这里就是调用了一个 serveice 你的文件没更新下来

    public function mgc()
    {

        $client = new AipContentCensor('25176769', 'rU4t2Kabjo1w8q8ytUiDwxCb', 'ocUascqCQ4OqdVNDzqlhuhj4F3DL69YU');
        $token = $client->getAccessToken();

        $result = $client->checkFlag("傻逼");
        if (!$result) {
            echo "您立的flag中有违规词汇，请您检查后重新提交哦！";
        } else {
            echo 'good';
        }
    }

    public function view()
    {
        return view('view');
    }

    public function baidu()
    {
        return view('weiyi');
    }

    public function tx()
    {
        return view('tx');
    }

    public function cashPrize()
    {
        return view('cash-prize');
    }

    public function makePrizeNum()
    {
        echo '生成兑奖码';
        for($i=0;$i<10000;$i++){
            $num = rand(10000000,99999999);
            $pm = PrizeNum::class;
            $data['num'] = $num;
            PrizeNum::create($data);
        }

    }

}
