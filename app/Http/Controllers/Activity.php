<?php

namespace App\Http\Controllers;

use App\Console\Commands\Excel\TeacherToUser;
use App\Http\Controllers\AipContentCensor;
use App\Jobs\tt;
use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use App\Models\PrizeNum;
use App\Models\Store;
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
        $storeCode = $request->input('storeCode');
        $state = $request->input('state');
        try {
            $weiboSer = app('weibo');
            if ($type == 'wx') {
                if (empty($code)) {
                    return $weiboSer->getCode('wx',$storeCode);
                }

                $tokenArr = $weiboSer->getToken($code, 'wx');
                $api_token = $weiboSer->getwxUserInfo($tokenArr['access_token'],$tokenArr['openid'],$state);
            }
            if ($type == 'wb') {
                if (empty($code)) {
                    return $weiboSer->getCode('wb');
                }
                $tokenArr = $weiboSer->getToken($code,'wb');
                $api_token = $weiboSer->getUserInfo($tokenArr['access_token'], $tokenArr['uid']);
            }
        } catch (Exception $e) {
//            return  $e->getMessage();
           return false;
        }

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
        $use_code = $user->use_code;
        $uid = $user->uid;

// 原授权逻辑
//        if ($authorization == 1) {
//            return redirect()->route('authorization', ['api_token' => $api_token]);
//        }
        try {
            if ($is_draw == 2 && $way == 2) {

                if ($use_code == 2) {

                    $flag_id = $user->flag_id;
                    $type = $user->type;

                    if($flag_id == 8) {
                        $flag = DB::table('customize_flag')->where('uid', $uid)->get(['customize_flag']);
                        if (!$flag->isEmpty()) {
                            $flag_info = $flag[0]->customize_flag;
                            $pic_re = Jiayu::where('id', $uid)->first();
                            $range = 'new' . date("YmdHis").time() . rand(10000, 99999);
                            if(empty($pic_re->path)){
                                $pic_re->path = $this->flagP($flag_info,$range);
                                $pic_re->path = $this->flagX($flag_info,$range);
                                $this->flagZ($flag_info,$range);
                                $pic_re->save();
                            }

                            return redirect()->route('poster2', ['api_token' => $api_token])->with(['flag_id'=>$flag_id, 'bg' => $pic_re->path, 'type'=>$type]);
                        }
                    } else {

                        switch ($flag_id) {
                            case 1:
                                $bg = "不加班";
                                break;
                            case 2:
                                $bg = "工作生活";
                                break;
                            case 3:
                                $bg = "门店看看";
                                break;
                            case 4:
                                $bg = "锻炼身体";
                                break;
                            case 5:
                                $bg = "找男朋友";
                                break;
                            case 6:
                                $bg = "拒绝熬夜";
                                break;
                            case 7:
                                $bg = "保持创新";
                                break;
                        }

                        return redirect()->route('poster2', ['api_token' => $api_token])->with(['flag_id'=>$flag_id, 'bg' => $bg, 'type'=>$type]);
                    }

                }

                $user = Auth::guard('api')->user();
                $uid = $user->id;
                $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id']);

                $prize_num = $prize_code[0]->gift_id;

                switch ($prize_num) {
                    case 11:
                        $bg = "线下上海报";
                        break;
                    case 12:
                        $bg = "李现海报";
                        break;
                    case 13:
                        $bg = "帽子";
                        break;
                    case 14:
                        $bg = "背包";
                        break;
                    case 15:
                        $bg = "袜子";
                        break;
                    case 16:
                        $bg = "贴纸";
                        break;
                    case 17:
                        $bg = "优惠券";
                        break;
                }

                return redirect()->route('win-prize2', ['api_token' => $api_token])->with(['bg' => $bg, 'prize_num' => $prize_num]);
            }

            if ($is_draw == 2 && $way == 1) {
                return redirect()->route('win-prize', ['api_token' => $api_token]);
            }
        } catch (Exception $e) {
//            return  $e->getMessage();
            return false;
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

    // 授权页面
    public function authorization2(Request $request) {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
//        $api_token = $user->api_token;

        $code = $request->input("code");
        if (empty($code)) {
            return view('authorization2');
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
        $authorization = $user->authorization;
        if ($authorization == 1) {
            return redirect()->route('authorization', ['api_token' => $api_token]);
        }
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
        $authorization = $user->authorization;
        if ($authorization == 1) {
            return redirect()->route('authorization2', ['api_token' => $api_token]);
        }
//        $flagModels = DB::table('flag_list')->where('status', 1)->get(['id', 'flag_model']);
        if (empty($way)) {
            DB::table('jiayus')->where('id', $uid)->update(['way' => 2]);
        } else {
            if ($way == 1) {
                // 检测到选择了线上点亮的用户又点击线下点亮后，强制跳转回线上路线
                return redirect()->route('activity-up', ['api_token' => $api_token]);
            }
        }

        return view('activity-down');
    }


//线上抽奖
    public function luckyDraw()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $is_draw = $user->is_draw;

        if ($is_draw == 1) {
            // 抽奖方法
            $v = rand(1, 100);

            $a_start = 1; //10%中奖率 上海报资格1019名 20% 50%
            $a_end = 50;

            $b_start = 51; // 10%中奖率 天猫A、Microsoft 365 家庭版+腾讯视频季卡促销套餐：20000份； 5%
            $b_end = 55;

            $c_start = 56; // 10%中奖率 天猫B、Microsoft 365 家庭版+ING帆布袋+ING袜子促销套餐：30000份；10% 5%
            $c_end = 60;

            $d_start = 61; // 5%中奖率 天猫C、Surface GO3+闪迪卡128G+ING杯子促销套餐：12000份。5% 10%
            $d_end = 70;

            $e_start = 71; // 25%中奖率 京东：A、Microsoft 365 个人盒装+电影兑换券促销套餐：60000份；25% 20% 10%
            $e_end = 80;

            $f_start = 81; // 25%中奖率 B、Microsoft 365 个人盒装+精巧鼠标+ING 帆布袋促销套餐：60000份；25% 10%
            $f_end = 90;

            $g_start = 91; // C、Surface GO3 + 闪迪卡 128G TF卡+ ING 袜子促销套餐：40000份。15% 10%
            $g_end = 100;


            switch ($v) {
                case $v >= $a_start && $v <= $a_end:
                    Redis::incr('a_online', 1);
                    $count1 = Redis::get('a_online');
                    if ($count1 > 1019) {
                        Redis::incr('f_online', 1);
                        $prize_type = 6;
                    } else {
                        $prize_type = 1;
                    }
                    break;
                case $v >= $b_start && $v <= $b_end:
                    Redis::incr('b_online', 1);
                    $prize_type = 2;
                    break;
                case $v >= $c_start && $v <= $c_end:
                    Redis::incr('c_online', 1);
                    $prize_type = 3;
                    break;
                case $v >= $d_start && $v <= $d_end:
                    Redis::incr('d_online', 1);
                    $prize_type = 4;
                    break;
                case $v >= $e_start && $v <= $e_end:
                    Redis::incr('e_online', 1);
                    $prize_type = 5;
                    break;
                case $v >= $f_start && $v <= $f_end:
                    Redis::incr('f_online', 1);
                    $prize_type = 6;
                    break;
                case $v >= $g_start && $v <= $g_end:
                    Redis::incr('g_online', 1);
                    $prize_type = 7;
                    break;
            }

            self::makePrizeNum($uid, $prize_type);  // 根据中奖类型，取用兑奖码

            DB::table('jiayus')->where('id', $uid)->update(['is_draw' => 2]);
            return view('lucky-draw')->with('prize_type', $prize_type);
        } elseif ($is_draw == 2) {
            $prize_type = DB::table('prize_num')->where('u_id', $uid)->get(['gift_id']); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
//            foreach ($prize_type as $v) {
            $prize_type = $prize_type[0]->gift_id;
//            }
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
//            $v = rand(1, 100);
            $v = rand(1, 50);

            $a_start = 1; //10%中奖率 上海报 520 15% 5% 10% 50%
            $a_end = 50;

            $b_start = 51; // 20% 海报 2500 10% 5%
            $b_end = 55;

            $c_start = 56; // 5% 帽子 400 5% 5%
            $c_end = 60;

            $d_start = 61; // 20% 背包 2000 15% 10% 5%
            $d_end = 65;

            $e_start = 66; // 15%中奖率 袜子 1800 10% 5%
            $e_end = 70;

            $f_start = 71; // 20%中奖率 贴纸 2500 25% 15%
            $f_end = 85;

            $g_start = 86; // 优惠券（10000）。10% 20% 30% 15%
            $g_end = 100;

            switch ($v) {
                case $v >= $a_start && $v <= $a_end:
                    Redis::incr('a_offline', 1);
                    $count1 = Redis::get('a_online');
                    if ($count1 > 1320) {
                        Redis::incr('g_offline', 1);
                        $prize_type = 17;
                        Redis::incr('zh_1',1); // 超卖后转化数量
                    } else {
                        $prize_type = 11;
                    }
                    break;
                case $v >= $b_start && $v <= $b_end:
                    Redis::incr('b_offline', 1);
                    $prize_type = 12;
                    break;
                case $v >= $c_start && $v <= $c_end:
                    Redis::incr('c_offline', 1);
                    $count2 = Redis::get('a_online');
                    if ($count2 > 400) {
                        Redis::incr('g_offline', 1);
                        $prize_type = 17;
                        Redis::incr('zh_2',1); // 超卖后转化数量
                    } else {
                        $prize_type = 13;
                    }
                    break;
                case $v >= $d_start && $v <= $d_end:
                    Redis::incr('d_offline', 1);
                    $prize_type = 14;
                    break;
                case $v >= $e_start && $v <= $e_end:
                    Redis::incr('e_offline', 1);
                    $prize_type = 15;
                    break;
                case $v >= $f_start && $v <= $f_end:
                    Redis::incr('f_offline', 1);
                    $prize_type = 16;
                    break;
                case $v >= $g_start && $v <= $g_end:
                    Redis::incr('g_offline', 1);
                    $prize_type = 17;
                    break;
            }

            self::makePrizeNum($uid, $prize_type);  // 根据中奖类型，取用兑奖码
            // 更新用户是否已抽奖标识
            DB::table('jiayus')->where('id', $uid)->update(['is_draw' => 2]);
            return view('lucky-draw2')->with('prize_type', $prize_type);
        } elseif ($is_draw == 2) {
            $prize_type = DB::table('prize_num')->where('u_id', $uid)->get(['gift_id']); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
            $prize_type = $prize_type[0]->gift_id;
            return view('lucky-draw2')->with('prize_type', $prize_type);
        }

    }

    // 中奖信息展示页面
    public function winPrize()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        try {
            $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id']);

            $prize_num = $prize_code[0]->gift_id;

            switch ($prize_num) {
                case 1:
                    $bg = "线上上海报";
                    $url = "";
                    break;
                case 2:
                    $bg = "TMA";
                    $url = "https://m.tb.cn/h.f6eDzQa";
                    break;
                case 3:
                    $bg = "TMB";
                    $url = "https://m.tb.cn/h.fhnjkXn";
                    break;
                case 4:
                    $bg = "TMC";
                    $url = "https://s.tb.cn/c.0uj2Le";
                    break;
                case 5:
                    $bg = "JDA";
                    $url = "https://item.jd.com/100027348974.html";
                    break;
                case 6:
                    $bg = "JDB";
                    $url = "https://item.jd.com/100028456980.html";
                    break;
                case 7:
                    $bg = "JDC";
                    $url = "https://item.jd.com/100027416804.html";
                    break;
            }
        } catch (Exception $e) {
//            return  $e->getMessage();
            return false;
        }




        return view('win-prize')->with(['url' => $url, 'bg' => $bg, 'prize_num' => $prize_num]);
    }

    // 线下中奖信息展示页面（到店前）
    public function winPrize2()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        try {
            $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id']);

            $prize_num = $prize_code[0]->gift_id;

            switch ($prize_num) {
                case 11:
                    $bg = "线下上海报";
                    break;
                case 12:
                    $bg = "李现海报";
                    break;
                case 13:
                    $bg = "帽子";
                    break;
                case 14:
                    $bg = "背包";
                    break;
                case 15:
                    $bg = "袜子";
                    break;
                case 16:
                    $bg = "贴纸";
                    break;
                case 17:
                    $bg = "优惠券";
                    break;
            }
        } catch (Exception $e) {
//            return  $e->getMessage();
            return false;
        }



        return view('win-prize2')->with(['bg' => $bg, 'prize_num' => $prize_num]);
    }

    // 线下中奖信息展示页面（到店后）
    public function winPrize3()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $prize_code = DB::table("prize_num")->where('u_id', $uid)->get(['gift_id']);

        $prize_num = $prize_code[0]->gift_id;

        switch ($prize_num) {
            case 11:
                $bg = "线下上海报";
                break;
            case 12:
                $bg = "李现海报";
                break;
            case 13:
                $bg = "帽子";
                break;
            case 14:
                $bg = "背包";
                break;
            case 15:
                $bg = "袜子";
                break;
            case 16:
                $bg = "贴纸";
                break;
            case 17:
                $bg = "优惠券";
                break;
        }
        return view('win-prize3')->with(['bg' => $bg, 'prize_num' => $prize_num]);
    }

    public function poster()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $flag_id = $user->flag_id;
        $type = $user->type;
        if($flag_id == 8) {
            $flag = DB::table('customize_flag')->where('uid', $uid)->get(['customize_flag']);
            if (!$flag->isEmpty()) {
                $flag_info = $flag[0]->customize_flag;
                $pic_re = Jiayu::where('id', $uid)->first();
                $range = 'new' . date("YmdHis").time() . rand(10000, 99999);
                if(empty($pic_re->path)){
                    $pic_re->path = $this->flagP($flag_info,$range);
                    $pic_re->path = $this->flagX($flag_info,$range);
                    $this->flagZ($flag_info,$range);
                    $pic_re->save();
                }
                return view('poster', compact('pic_re'))->with(['flag_id'=>$flag_id, 'bg' => $pic_re->path, 'type'=>$type]);
            }
        } else {

            switch ($flag_id) {
                case 1:
                    $bg = "不加班";
                    break;
                case 2:
                    $bg = "工作生活";
                    break;
                case 3:
                    $bg = "门店看看";
                    break;
                case 4:
                    $bg = "锻炼身体";
                    break;
                case 5:
                    $bg = "找男朋友";
                    break;
                case 6:
                    $bg = "拒绝熬夜";
                    break;
                case 7:
                    $bg = "保持创新";
                    break;
            }

            return view('poster')->with(['flag_id'=>$flag_id, 'bg' => $bg, 'type'=>$type]);
        }

    }

    // 线下个人海报 待修改
    public function poster2()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $flag_id = $user->flag_id;
        $type = $user->type;
        if($flag_id == 8) {
            $flag = DB::table('customize_flag')->where('uid', $uid)->get(['customize_flag']);
            if (!$flag->isEmpty()) {
                $flag_info = $flag[0]->customize_flag;
                $pic_re = Jiayu::where('id', $uid)->first();
                $range = 'new' . date("YmdHis").time() . rand(10000, 99999);
                if(empty($pic_re->path)){
                    $pic_re->path = $this->flagP($flag_info,$range);
                    $pic_re->path = $this->flagX($flag_info,$range);
                    $this->flagZ($flag_info,$range);
                    $pic_re->save();
                }

                return view('poster2', compact('pic_re'))->with(['flag_id'=>$flag_id, 'bg' => $pic_re->path, 'type'=>$type]);
            }
        } else {

            switch ($flag_id) {
                case 1:
                    $bg = "不加班";
                    break;
                case 2:
                    $bg = "工作生活";
                    break;
                case 3:
                    $bg = "门店看看";
                    break;
                case 4:
                    $bg = "锻炼身体";
                    break;
                case 5:
                    $bg = "找男朋友";
                    break;
                case 6:
                    $bg = "拒绝熬夜";
                    break;
                case 7:
                    $bg = "保持创新";
                    break;
            }

            return view('poster2')->with(['flag_id'=>$flag_id, 'bg' => $bg, 'type'=>$type]);
        }
    }


    public function map()
    {
        return view('map');
    }

    public function phone(Request $request)
    {

        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $type = $user->type;
        $userinfo = Jiayu::find($uid);

        $result = DB::table("prize_num")->where("u_id", $uid)->get();
        if($result->isEmpty()) {
            return false;
        }
        if ($result[0]->gift_id != 11) {
            return false;
        }

        if ($request->method() == 'POST') {

                $image = $request->file('image');
                if(empty($image)) {
                    return view('phone');
                }
                $imageName = $uid.'.jpg';
                $path = 'offline/';
                $image->move(public_path($path), $imageName);
                $userinfo->pic_name = $imageName;
                $userinfo->save();

            DB::table("jiayus")->where("id", $uid)->update(['use_code'=>2]);
            $flag_id = $user->flag_id;
            if($flag_id == 8) {
                $flag = DB::table('customize_flag')->where('uid', $uid)->get(['customize_flag']);
                if (!$flag->isEmpty()) {
                    $flag_info = $flag[0]->customize_flag;
                    $pic_re = Jiayu::where('id', $uid)->first();
                    $range = 'new' . date("YmdHis").time() . rand(10000, 99999);
                    if(empty($pic_re->path)){
                        $pic_re->path = $this->flagP($flag_info,$range);
                        $pic_re->path = $this->flagX($flag_info,$range);
                        $this->flagZ($flag_info,$range);
                        $pic_re->save();
                    }

                    return view('poster2', compact('pic_re'))->with(['flag_id'=>$flag_id, 'bg' => $pic_re->path, 'type'=>$type]);
                }
            } else {

                switch ($flag_id) {
                    case 1:
                        $bg = "不加班";
                        break;
                    case 2:
                        $bg = "工作生活";
                        break;
                    case 3:
                        $bg = "门店看看";
                        break;
                    case 4:
                        $bg = "锻炼身体";
                        break;
                    case 5:
                        $bg = "找男朋友";
                        break;
                    case 6:
                        $bg = "拒绝熬夜";
                        break;
                    case 7:
                        $bg = "保持创新";
                        break;
                }

                return view('poster2')->with(['flag_id'=>$flag_id, 'bg' => $bg, 'type'=>$type]);
            }
        }

        return view('phone');


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
//        $is = PrizeNum::whereIn('status', [1, 2])->where('u_id', $uid)->first();
//        if ($is) {
//            return -1;
//        }
        try {
            DB::beginTransaction();
            DB::table("prize_num")->insert(['u_id'=>$uid, 'gift_id'=>$gid, 'status'=>1]);
//            $is = PrizeNum::where('status', 0)->first();
//            $is->u_id = $uid;
//            $is->gift_id = $gid;
//            $is->status = 1;
//            if (!$is->save()) {
//                return -1;
//            }
            DB::commit();
//            return $is->num;
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
// 清除Redis
//        $online1 = Redis::set('a_online',0);
//        $online2 = Redis::set('b_online',0);
//        $online3 = Redis::set('c_online',0);
//        $online4 = Redis::set('d_online',0);
//        $online5 = Redis::set('e_online',0);
//        $online6 = Redis::set('f_online',0);
//        $online7 = Redis::set('g_online',0);
//        $offline1 = Redis::set('a_offline',0);
//        $offline2 = Redis::set('b_offline',0);
//        $offline3 = Redis::set('c_offline',0);
//        $offline4 = Redis::set('d_offline',0);
//        $offline5 = Redis::set('e_offline',0);
//        $offline6 = Redis::set('f_offline',0);
//        $offline7 = Redis::set('g_offline',0);

        $online1 = Redis::get('a_online');
        $online2 = Redis::get('b_online');
        $online3 = Redis::get('c_online');
        $online4 = Redis::get('d_online');
        $online5 = Redis::get('e_online');
        $online6 = Redis::get('f_online');
        $online7 = Redis::get('g_online');
        $offline1 = Redis::get('a_offline');
        $offline2 = Redis::get('b_offline');
        $offline3 = Redis::get('c_offline');
        $offline4 = Redis::get('d_offline');
        $offline5 = Redis::get('e_offline');
        $offline6 = Redis::get('f_offline');
        $offline7 = Redis::get('g_offline');
        return view('prize-admin')->with(['online1' => $online1, 'online2' => $online2, 'online3' => $online3,'online4' => $online4,'online5' => $online5,'online6' => $online6,'online7' => $online7, 'offline1' => $offline1, 'offline2' => $offline2, 'offline3' => $offline3, 'offline4' => $offline4, 'offline5' => $offline5, 'offline6' => $offline6, 'offline7' => $offline7]);
    }

    // 用户协议
    public function agreement()
    {
        return view('agreement');
    }



    public function flagP($flag_info='',$range=''){

        $str_len = strlen($flag_info);
        if($str_len > 21 && $str_len < 46){
            $flag_info = $this->str_insert($flag_info,21,"\n");
        }


        $image = new Image();
        //原始图路径
        $path = "hb/no-flagp.jpg";
//        $range = 'new' . time() . rand(10000, 99999);
        $newimageName = $range. 'P.jpg';
        $newpath = 'images/' . $newimageName;
        $face_img = $image::make($path)->resize(1280, 2264);
        $face_img->text($flag_info, 383, 1434, function ($font) use ($path) {
            $font->file(public_path('SIMLI.TTF', 777, true));
            $font->size(69);
            $font->color('#CCCC33');
            $font->valign('right');
        });
        $save_path = public_path($newpath);

        $face_img->save($save_path);

        $timg =  $range;
        return $timg;
    }


    public function flagX($flag_info='',$range=''){

        $str_len = strlen($flag_info);
        if($str_len > 21 && $str_len < 46){
            $flag_info = $this->str_insert($flag_info,21,"\n");
        }


        $image = new Image();
        //原始图路径
        $path = "hb/no-flagx.jpg";
//        $range = 'new' . time() . rand(10000, 99999);
        $newimageName = $range. 'X.jpg';
        $newpath = 'images/' . $newimageName;
        $face_img = $image::make($path)->resize(1125, 2185);
        $face_img->text($flag_info, 315, 1435, function ($font) use ($path) {
            $font->file(public_path('SIMLI.TTF', 777, true));
            $font->size(69);
            $font->color('#CCCC33');
            $font->valign('right');
        });
        $save_path = public_path($newpath);
        $face_img->save($save_path);

        $timg =  $range;
        return $timg;
    }

    public function flagZ($flag_info='',$range=''){

        $str_len = strlen($flag_info);
        if($str_len > 21 && $str_len < 46){
            $flag_info = $this->str_insert($flag_info,21,"\n");
        }


        $image = new Image();
        //原始图路径
        $path = "hb/no-flagz.jpg";
//        $range = 'new' . time() . rand(10000, 99999);
        $newimageName = $range. 'Z.jpg';
        $newpath = 'images/' . $newimageName;
        $face_img = $image::make($path)->resize(2160, 3772);
        $face_img->text($flag_info, 380, 3025, function ($font) use ($path) {
            $font->file(public_path('SIMLI.TTF', 777, true));
            $font->size(189);
            $font->color('#CCCC33');
            $font->valign('right');
        });
        $save_path = public_path($newpath);
        $face_img->save($save_path);

        $timg =  $range;
        return $timg;
    }


    public function str_insert($str, $i, $substr)
    {
        $startstr = '';
        $laststr = '';
        for($j=0; $j<$i; $j++){
            $startstr .= $str[$j];
        }
        for ($j=$i; $j<strlen($str); $j++){
            $laststr .= $str[$j];
        }
        $str = ($startstr . $substr . $laststr);
        return $str;
    }

    public function share(Request $request){

        $ms = "快来参与微软零售全品牌大使李现新年新愿海报点亮活动，你的ID或照片有机会作为特殊海报组成元素，登上海报呦！";

        $weiboSer = app('weibo');

        $user = Auth::guard('api')->user();
        $token = $user->u_token;
        $code = $weiboSer->share($token,$ms);
        return response()->json(['code' => 200]);
    }

    public function tp(){
        return view('tp');
    }


    public function mdCode(Request $request) {

        $user = Auth::guard('api')->user();
        $uid = $user->id;
        $storeCode = $user->storeCode;
        $use_code = $user->use_code;
        if ($use_code == 2) {
            return response()->json(['code' => 300]);
        }

        $md_code = $request->input("md_code");
        $t = $request->input("t");

        if (!empty($md_code)) {
            if (!empty($storeCode)) {
                if ($storeCode == $md_code) {
                    DB::table("prize_num")->where("u_id", $uid)->update(['md_code'=>$md_code]);
                    if ($t != 11) {
                        DB::table("jiayus")->where("id", $uid)->update(['use_code'=>2]);
                    }
                    return response()->json(['code' => 200]);
                } else {
                    return response()->json(['code' => 500]);
                }
            } else {
                $result = DB::table("store")->where("store_id", $md_code)->get();
                if ($result->isEmpty()) {
                    return response()->json(['code' => 500]);
                } else {
                    DB::table("prize_num")->where("u_id", $uid)->update(['md_code'=>$md_code]);
                    if ($t != 11) {
                        DB::table("jiayus")->where("id", $uid)->update(['use_code'=>2]);
                    }
                    return response()->json(['code' => 200]);
                }

            }

        } else {
            return response()->json(['code' => 500]);
        }

    }

    public function storeMap2()
    {
        return view('weiyi2');
    }

    public function storeMapList(Request $request)
    {
        $city = $request->input('city');
        $city = substr($city,0,strlen($city)-1);
        $re = Store::where("city_name",$city)->get();
        if($re){
            return $re;
        }
        return [];
    }

    public function wxs(){
        $flag_info="一二三四五一二三四五一二三四五";
        $str_len = strlen($flag_info);
        echo $str_len;die;
        $this->flagP($flag_info,331);
         $this->flagX($flag_info,331);
        $this->flagZ($flag_info,'sssa');
        die;
        echo 'share';
        return view('wxs');
    }

    public function storeMap3()
    {
        return view('weiyi3');
    }


}
