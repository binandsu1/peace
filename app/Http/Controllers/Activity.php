<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AipContentCensor;
use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use App\Models\PrizeNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function makePrizeNum($uid = '0', $gid = '0')
    {
        $uid = 1;
        $gid = 1;
        $is = PrizeNum::whereIn('status', [1,2])->where('u_id',$uid)->first();
        if($is){
            return -1;
        }
        try {
            DB::beginTransaction();
            $is = PrizeNum::where('status', 0)->first();
            $is->u_id = $uid;
            $is->gift_id = $gid;
            $is->status = 1;
            if (!$is->save()) {
                return -1;
            }
            DB::commit();
            return $is->num;
        } catch (\Exception $exception) {
            DB::rollback();
            return 0;
        }
    }


    public function unPrizeNum(Request $request)
    {
        $num = $request->input('num');
        $u_id = $request->input('u_id');
        if($num<0){
            return -1;
        }
        $is = PrizeNum::where('status', 1)->where('num',$num)->where('u_id',$u_id)->first();
        if(!$is){
            return -1;
        }
        $is->status = 2;
        $is->un_at = date('Y-m-d H:i:s');
        $re = $is->save();
        if($re){
            return 1;
        }
        return 0;
    }

}
