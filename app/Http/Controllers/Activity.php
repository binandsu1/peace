<?php

namespace App\Http\Controllers;

use App\Console\Commands\Excel\TeacherToUser;
use App\Http\Controllers\AipContentCensor;
use App\Jobs\tt;
use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use App\Models\PrizeNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redis;

class Activity extends Controller
{


    public function activityIndex(Request $request)
    {
        $code = $request->input('code');
        $type = $request->input('type');

        $weiboSer = app('weibo');
        if ($type == 'wx') {
            if (empty($code)) {
                return $weiboSer->getCode('wx');
            }
            $tokenArr = $weiboSer->getToken($code, 'wx');
            $api_token = $weiboSer->getwxUserInfo($tokenArr['access_token'],$tokenArr['openid']);
        }
        if ($type == 'wb') {
            if (empty($code)) {
                return $weiboSer->getCode('wb');
            }
            $tokenArr = $weiboSer->getToken($code,'wb');
            $api_token = $weiboSer->getUserInfo($tokenArr['access_token'], $tokenArr['uid']);
        }

        //todo 测试用，正式环境删除
//        $api_token = "89da839bfa90025570f9a3a23a0d91d8";
        return redirect()->route('activity-index-new', ['api_token' => $api_token]);
    }

    public function activityIndexNew(Request $request)
    {

        $user = Auth::guard('api')->user();
        $api_token = $user->api_token;
        $is_draw = $user->is_draw;
        $way = $user->way;
        $authorization = $user->authorization;
        $type = $user->type;

        if ($authorization == 1) {
            return redirect()->route('authorization', ['api_token' => $api_token]);
        }

        if ($is_draw == 2 && $way == 2) {

            $uid = $user->id;

            $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id', 'num']);

            foreach ($prize_code as $v) {
                $num = $v->num;
            }

            // 将兑奖码与uid连接后AES对等加密
            $code = $num . '+' . $uid;
            $encode = $this->encrypt($code);
//            return view('win-prize3')->with(['prize_code'=>$prize_code, 'code'=>$encode]);

            return redirect()->route('win-prize3', ['api_token' => $api_token])->with(['prize_code' => $prize_code, 'code' => $encode]);
        }

        if ($is_draw == 2 && $way == 1) {
            return redirect()->route('win-prize', ['api_token' => $api_token]);
        }

        return view('activity-index');
    }

    // 授权页面
    public function authorization(Request $request) {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
//        $api_token = $user->api_token;

        $code = $request->input("code");
        if (empty($code)) {
            return view('authorization');
        }

        $result = DB::table('jiayus')->where('id', $uid)->update(['authorization' => 2]);
        if($result) {
            return response()->json(['code' => 200]);
        }

    }

    // 线上立下flag
    public function activityUp()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $way = $user->way;
        $api_token = $user->api_token;
//        $flagModels = DB::table('flag_list')->where('status', 1)->get(['id', 'flag_model']);
        if (empty($way)) {
            DB::table('jiayus')->where('id', $uid)->update(['way' => 1]);
        } else {
            if ($way == 2) {
                // 检测到选择了线下点亮的用户又点击线上点亮后，强制跳转回线下路线
                return redirect()->route('activity-down', ['api_token' => $api_token]);
            }
        }

        return view('activity-up');
    }

    // 线下立下flag
    public function activityDown()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $way = $user->way;
        $api_token = $user->api_token;
        $flagModels = DB::table('flag_list')->where('status', 1)->get(['id', 'flag_model']);
        if (empty($way)) {
            DB::table('jiayus')->where('id', $uid)->update(['way' => 2]);
        } else {
            if ($way == 1) {
                // 检测到选择了线上点亮的用户又点击线下点亮后，强制跳转回线上路线
                return redirect()->route('activity-up', ['api_token' => $api_token])->with('flagModels', $flagModels);
            }
        }

        return view('activity-down')->with('flagModels', $flagModels);
    }

//    public function activityDown()
//    {
//        return redirect()->away("https://wisepeople.xbaofun.com/wisepeople/oobe/users/storeList");
//        return view('map');
//    }

    public function luckyDraw()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $is_draw = $user->is_draw;

        if ($is_draw == 1) {
            // 抽奖方法
            $v = rand(1, 100);

            $one = 1; //1%中奖率

            $two_start = 2; // 3%中奖率
            $two_finish = 4;

            $three_start = 5;
            $three_finish = 100;

            switch ($v) {
                case $v == $one:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('one_online', 1);
                    $count1 = Redis::get('one_online');
                    if ($count1 > 1019) {
                        Redis::incr('three_online', 1);
                        $prize_type = 3;
                    } else {
                        $prize_type = 1;
                    }
                    break;
                case $v >= $two_start && $v <= $two_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('two_online', 1);
                    $count2 = Redis::get('two_online');
                    if ($count2 > 3000) {
                        Redis::incr('three_online', 1);
                        $prize_type = 3;
                    } else {
                        $prize_type = 2;
                    }
                    break;
                case $v >= $three_start && $v <= $three_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('three_online', 1);
                    $prize_type = 3;
                    break;
            }

            self::makePrizeNum($uid, $prize_type);  // 根据中奖类型，取用兑奖码

            DB::table('jiayus')->where('id', $uid)->update(['is_draw' => 2]);
            return view('lucky-draw')->with('prize_type', $prize_type);
        } elseif ($is_draw == 2) {
            $prize_type = DB::table('prize_num')->where('u_id', $uid)->get(['gift_id']); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
            foreach ($prize_type as $v) {
                $prize_type = $v->gift_id;
            }
            return view('lucky-draw')->with('prize_type', $prize_type);
        }

    }


    // 线下大转盘
    public function luckyDraw2()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $is_draw = $user->is_draw;

        if ($is_draw == 1) {
            // 抽奖方法
            $v = rand(1, 100);

            $one_start = 1; //33%中奖率
            $one_finish = 33; //33%中奖率

            $two_start = 34; // 33%中奖率
            $two_finish = 66;

            $three_start = 67;
            $three_finish = 100;

            switch ($v) {
                case $v >= $one_start && $v <= $one_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('one_offline', 1);
                    $count1 = Redis::get('one_offline');
                    if ($count1 > 1019) {
                        Redis::incr('three_offline', 1);
                        $prize_type = 3;
                    } else {
                        $prize_type = 1;
                    }
                    break;
                case $v >= $two_start && $v <= $two_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('two_offline', 1);
                    $count2 = Redis::get('two_offline');
                    if ($count2 > 3000) {
                        Redis::incr('three_offline', 1);
                        $prize_type = 3;
                    } else {
                        $prize_type = 2;
                    }
                    break;
                case $v >= $three_start && $v <= $three_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('three_offline', 1);
                    $prize_type = 3;
                    break;
            }

            self::makePrizeNum($uid, $prize_type);  // 根据中奖类型，取用兑奖码
            // 更新用户是否已抽奖标识
            DB::table('jiayus')->where('id', $uid)->update(['is_draw' => 2]);
            return view('lucky-draw2')->with('prize_type', $prize_type);
        } elseif ($is_draw == 2) {
            $prize_type = DB::table('prize_num')->where('u_id', $uid)->get(['gift_id']); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
            foreach ($prize_type as $v) {
                $prize_type = $v->gift_id;
            }
            return view('lucky-draw2')->with('prize_type', $prize_type);
        }

    }

    // 中奖信息展示页面
    public function winPrize()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id', 'num']);
//        $user_info = DB::table("jiayus")->where('id',29)->get(['id', 'u_name']);

        foreach ($prize_code as $v) {
            $num = $v->num;
        }

        // 将兑奖码与uid连接后AES对等加密
        $code = $num . '+' . $uid;
        $encode = $this->encrypt($code);
        return view('win-prize')->with(['prize_code' => $prize_code, 'code' => $encode]);
    }

    // 线下中奖信息展示页面（到店前）
    public function winPrize2()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id', 'num']);
//        $user_info = DB::table("jiayus")->where('id',29)->get(['id', 'u_name']);

        foreach ($prize_code as $v) {
            $num = $v->num;
        }

        // 将兑奖码与uid连接后AES对等加密
        $code = $num . '+' . $uid;
        $encode = $this->encrypt($code);
        return view('win-prize2')->with(['prize_code' => $prize_code, 'code' => $encode]);
    }

    // 线下中奖信息展示页面（到店后）
    public function winPrize3()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id', 'num']);
//        $user_info = DB::table("jiayus")->where('id',29)->get(['id', 'u_name']);

        foreach ($prize_code as $v) {
            $num = $v->num;
        }

        // 将兑奖码与uid连接后AES对等加密
        $code = $num . '+' . $uid;
        $encode = $this->encrypt($code);
        return view('win-prize3')->with(['prize_code' => $prize_code, 'code' => $encode]);
    }

    public function poster()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $flag_ids = DB::table('user_to_flag')->where('uid', $uid)->get(['flag_id']);
        if (!$flag_ids->isEmpty()) {
            $flag = '';
            foreach ($flag_ids as $k => $v) {
                $flag .= self::getFlagModel($v->flag_id) . PHP_EOL;
            }
        }
        $pic_re = Jiayu::where('id', $uid)->first();
        $image = new Image();
        //原始图路径
        $path = "images/20211125/bg.png";
        $newimageName = 'new' . time() . rand(10000, 99999) . '.jpg';
        $newpath = 'images/' . date('Ymd') . '/' . $newimageName;
        $face_img = $image::make($path)->resize(530, 800);
        $face_img->text($flag, 370, 41, function ($font) use ($path) {
            $font->file(public_path('vista.ttf', 777, true));
            $font->size(12);
            $font->color('#FF0000');
            $font->valign('right');
        });

        $pic_re->path = $newpath;
        $pic_re->save();

        $save_path = public_path($newpath);

        $face_img->save($save_path);
        return view('poster', compact('pic_re'));
    }

    // 线下个人海报
    public function poster2()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $flag_ids = DB::table('user_to_flag')->where('uid', $uid)->get(['flag_id']);
        if (!$flag_ids->isEmpty()) {
            $flag = '';
            foreach ($flag_ids as $k => $v) {
                $flag .= self::getFlagModel($v->flag_id) . PHP_EOL;
            }
        }
        $pic_re = Jiayu::where('id', $uid)->first();
        $image = new Image();
        //原始图路径
        $path = "images/20211125/bg.png";
        $newimageName = 'new' . time() . rand(10000, 99999) . '.jpg';
        $newpath = 'images/' . date('Ymd') . '/' . $newimageName;
        $face_img = $image::make($path)->resize(530, 800);
        $face_img->text($flag, 370, 41, function ($font) use ($path) {
            $font->file(public_path('vista.ttf', 777, true));
            $font->size(12);
            $font->color('#FF0000');
            $font->valign('right');
        });

        $pic_re->path = $newpath;
        $pic_re->save();

        $save_path = public_path($newpath);

        $face_img->save($save_path);
        return view('poster', compact('pic_re'));
    }


    public function map()
    {
        return view('map');
    }

    public function phone(Request $request)
    {

        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $userinfo = Jiayu::find($uid);
        if ($request->method() == 'POST') {
            $image = $request->file('image');
            $type = $image->extension();
            $imageName = time() . rand(10000, 99999) . '.' . $type;
            $path = 'images/' . date('Ymd');
            $image->move(public_path($path), $imageName);
            $userinfo->pic_name_old = $image->getClientOriginalName();
            $userinfo->pic_name = $imageName;
            $userinfo->type = $type;
            $userinfo->path = $path . "/" . $imageName;
            $userinfo->save();
//            UpPicJob::dispatchNow($data);
        }

        return view('phone', compact('userinfo'));
    }


    public function mgc(Request $request)
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $ms = app('mgc');
        $content = $request->input('flag_wb');
        $bad_word = $ms::getBadWord($content);
        if (!empty($bad_word)) {
            return response()->json(['status' => 'fail', 'code' => 500, 'error' => '包含敏感词',]);
        } else {
            $result = DB::table('customize_flag')->where("uid", $uid)->get();
            if ($result->isEmpty()) {
                DB::table('customize_flag')->insert(['uid' => $uid, 'customize_flag' => $content]);
            } else {
                DB::table("customize_flag")->where('uid', $uid)->update(['customize_flag'=>$content]);
            }

            return response()->json(['status' => 'success', 'code' => 200, 'message' => '合规']);
        }

    }

    // 保存flag
    public function setFlag(Request $request)
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $flag_id = $user->flag_id;

        $model_id = $request->input('flag_id');
        if (empty($flag_id)) {
            if (!empty($model_id) && is_numeric($model_id)) {
                DB::table("jiayus")->where('id', $uid)->update(['flag_id'=>$model_id]);
                return response()->json(['code' => 200]);
            } else {
                return response()->json(['code' => 300]); // 参数格式错误
            }
        } else {
            return response()->json(['code' => 500]); // 已经传过一次了，不允许二次上传
        }

    }

    public function view()
    {
        return view('view');
    }

    public function storeMap()
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
        $is = PrizeNum::whereIn('status', [1, 2])->where('u_id', $uid)->first();
        if ($is) {
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
        if ($num < 0) {
            return -1;
        }
        $is = PrizeNum::where('status', 1)->where('num', $num)->where('u_id', $u_id)->first();
        if (!$is) {
            return -1;
        }
        $is->status = 2;
        $is->un_at = date('Y-m-d H:i:s');
        $re = $is->save();
        if ($re) {
            return 1;
        }
        return 0;
    }

    public function tt()
    {
        $data["a"] = 1;
        $data["b"] = 1;
        tt::dispatch($data);
    }


    // todo::修改完poster方法后废弃
    public function getFlagModel($id)
    {
        $flag = "";
        if (!empty($id)) {
            switch ($id) {
                case 1:
                    $flag = "新年365天不加班";
                    break;
                case 2:
                    $flag = "我的工作就是好好生活";
                    break;
                case 3:
                    $flag = "工作创新潮";
                    break;
                case 4:
                    $flag = "生活创新潮";
                    break;
                case 5:
                    $flag = "与我所爱，更近一步";
                    break;
                default:
                    $flag = "";
                    break;
            }
        }
        return $flag;
    }


    public function ss()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        dd($uid);
    }

    // AES对等加密兑奖码
    protected function encrypt($data)
    {
        if (empty($data)) {
            return false;
        }
        return openssl_encrypt($data, 'AES-128-ECB', 'love&&peace', 0, '');
    }

    // AES对等解密兑奖码
    protected function decrypt($data)
    {
        if (empty($data)) {
            return false;
        }
        return openssl_decrypt($data, 'AES-128-ECB', 'love&&peace', 0, '');
    }

    //线上客服登录页面
    public function shopLogin()
    {
//        $a = md5(time());
//        dd($a);
        return view('shop-login');
    }

    // 线上客服登录验证
    public function checkOnline(Request $request)
    { //这里做的登录
        $name = $request->input("name");
        $pwd = $request->input("pwd");

        if (empty($name) || empty($pwd)) {
            return response()->json(['code' => 500, 'result' => '用户名或密码错误！']);
        }

        $userInfo = DB::table("kf_user")->where(['user' => $name, 'pwd' => $pwd])->get();
        if ($userInfo->isEmpty()) {
            return response()->json(['code' => 500, 'result' => '用户名或密码错误！']);
        }

        return response()->json(['code' => 200, 'result' => 'OK', 'token' => $userInfo[0]->api_token]);
//        return redirect()->route('exchange-code',['kf_token'=>$userInfo[0]->kf_token]);

    }

    //线上客服兑奖页面
    public function exchangeCode()
    {

        return view('exchange-code');
    }

    // 兑奖码查询
    public function checkCode(Request $request)
    {

        $user = Auth::guard('kf')->user();
        $kf_id = $user->id;

        $code = $request->input("code");
        if (empty($code)) {
            return response()->json(['code' => 500, 'result' => 'fail1']);
        }
        // 兑奖码解码
        $sum_code = $this->decrypt($code);
        if (!$sum_code) {
            return response()->json(['code' => 500, 'result' => 'fail2']);
        }
        $code_arr = explode('+', $sum_code);
        $num = $code_arr[0];
        $uid = $code_arr[1];

        // 查询兑奖码
        $codeInfo = DB::table("prize_num")->where(['u_id' => $uid, 'num' => $num])->get();
        if ($codeInfo->isEmpty()) {
            return response()->json(['code' => 500, 'result' => 'fail3']);
        }

        if ($codeInfo[0]->gift_id == 1 || $codeInfo[0]->gift_id == 3) {
            $giftInfo = "319 限量多彩 “新”意套装（M365+精巧鼠标）";
        } else if ($codeInfo[0]->gift_id == 2) {
            $giftInfo = "M365个人版+爱奇异季卡";
        } else {
            return response()->json(['code' => 500, 'result' => 'fail4']);
        }

        // 如果兑奖码已经被消费，提示已使用
        if ($codeInfo[0]->status == 2) {
            $kf_name = DB::table('kf_user')->where('id', $codeInfo[0]->kf_id)->get('user');
            return response()->json(['code' => 300, 'result' => $giftInfo . ' 兑奖客服：' . $kf_name[0]->user]);
        }

        // 如果兑奖码存在且未被消费，兑奖吧亲
        if ($codeInfo[0]->status == 1) {

            $result = DB::table('prize_num')->where(['u_id' => $uid, 'num' => $num])->update(['status' => 2, 'kf_id' => $kf_id]);
            if (!$result) {
                return response()->json(['code' => 500, 'result' => 'fail5']);
            }
            return response()->json(['code' => 200, 'result' => $giftInfo]);
        }

    }


    // 中奖统计后台
    public function prizeAdmin()
    {
        $online1 = Redis::get('one_online');
        $online2 = Redis::get('two_online');
        $online3 = Redis::get('three_online');
        $offline1 = Redis::get('one_offline');
        $offline2 = Redis::get('two_offline');
        $offline3 = Redis::get('three_offline');
        return view('prize-admin')->with(['online1' => $online1, 'online2' => $online2, 'online3' => $online3, 'offline1' => $offline1, 'offline2' => $offline2, 'offline3' => $offline3]);
    }

    // 用户协议
    public function agreement()
    {
        return view('agreement');
    }


}
