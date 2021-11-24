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

        $flagModels = DB::table('flag_list')->where('status', 1)->get(['id','flag_model']);

        return view('activity-up')->with('flagModels', $flagModels);
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


    public function mgc()
    {
        $ms = app('mgc');
        $content = '轮法功';
        $bad_word = $ms::getBadWord($content);

        if (!empty($bad_word)) {
            return response()->json(['status' => 'fail','code' => 500,'error' => '包含敏感词',]);
        } else {
            return response()->json(['status' => 'success','code' => 200,'message' => '合规']);
        }
    }

    // 保存flag
    public function setFlag(Request $request)
    {

        $customize_flag = $request->input('customize_flag', '');
        $model_ids = $request->input('model_ids', '');

        if (!empty($customize_flag)) {
            DB::table('customize_flag')->insert(['uid'=>1, 'customize_flag'=>$model_ids]);
        }

        if (!empty($model_ids)) {
            $model_ids = rtrim($model_ids,',');
            $id_arr = explode(',', $model_ids);
            foreach ($id_arr as $k => $v) {
                DB::table('user_to_flag')->insert(['uid'=>1, 'flag_id'=>$v]);
            }
        }
        return response()->json(['code' => 200]);

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
