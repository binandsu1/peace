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

        $weiboSer = app('weibo');
        if (empty($code)) {
            return $weiboSer->getCode();
        }
        $tokenArr = $weiboSer->getToken($code);
        $api_token = $weiboSer->getUserInfo($tokenArr['access_token'], $tokenArr['uid']);

        return redirect()->route('activity-index-new',['api_token'=>$api_token]);
    }

    public function activityIndexNew(Request $request)
    {

        $user = Auth::guard('api')->user();
        $uid = $user->id;
        Redis::set('page_status_'.$uid,'1');
        return view('activity-index');
    }

    public function activityUp()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        Redis::set('page_status_'.$uid,'11');
        $flagModels = DB::table('flag_list')->where('status', 1)->get(['id','flag_model']);

        return view('activity-up')->with('flagModels', $flagModels);
    }

    public function activityDown()
    {
        return redirect()->away("https://wisepeople.xbaofun.com/wisepeople/oobe/users/storeList");
        return view('map');
    }

    public function luckyDraw()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;
        // TODO::修改uid
        $page_status = Redis::get('page_status_2');

        if ($page_status == 12) {
            // 抽奖方法
            $v = rand(1,100);

            $one = 1; //1%中奖率

            $two_start = 2; // 3%中奖率
            $two_finish = 4;

            $three_start = 5;
            $three_finish = 100;

            switch($v) {
                case $v==$one:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('one_prize',1);
                    $count1 = Redis::get('one_prize');
                    if ($count1 > 1019) {
                        $prize_type = 3;
                    } else {
                        $prize_type = 1;
                    }
                    break;
                case $v>=$two_start && $v<=$two_finish:
                    // TODO::上线前清空Redis计数器
                    Redis::incr('two_prize',1);
                    $count2 = Redis::get('two_prize');
                    if ($count2 > 3000) {
                        $prize_type = 3;
                    } else {
                        $prize_type = 2;
                    }
                    break;
                case $v>=$three_start && $v<=$three_finish:
                    $prize_type = 3;
                    break;
            }

            // TODO::修改uid
            self::makePrizeNum(2,$prize_type);  // 根据中奖类型，取用兑奖码
            // TODO::修改uid
            $uid = 2;
            Redis::set('page_status_'.$uid,'13');
            return view('lucky-draw')->with('prize_type',$prize_type);
        } elseif ($page_status == 13) {
            // TODO::修改uid
//            $prize_type = PrizeNum::where('u_id',2)->get('gift_id'); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
            $prize_type = DB::table('prize_num')->where('u_id', 2)->get(['gift_id']); // 非首次进入抽奖页面，沿用首次进入时的抽奖结果
            foreach($prize_type as $v) {
                $prize_type = $v->gift_id;
            }
            return view('lucky-draw')->with('prize_type',$prize_type);
        }

    }

    // 中奖信息展示页面
    public function winPrize()
    {
        $user = Auth::guard('api')->user();
        $uid = $user->id;

        // TODO::修改uid的值
        $prize_code = DB::table("prize_num")->where('u_id', 2)->get(['gift_id', 'num']);
//        $user_info = DB::table("jiayus")->where('id',29)->get(['id', 'u_name']);
        // TODO::修改uid
        $uid = 2;
        foreach ($prize_code as $v) {
            $num = $v->num;
        }

        // 将兑奖码与uid连接后AES对等加密
        $code = $num.$uid;
        $encode = self::encrypt($code);
        return view('win-prize')->with(['prize_code'=>$prize_code, 'code'=>$encode]);
    }

    public function poster()
    {

//        $flag = $request->input('flag', '吃饭了吗');
        $flag_ids = DB::table('user_to_flag')->where('uid',2)->get(['flag_id']);
//        dd($flag_ids);
        if (!empty($flag_ids)) {
            foreach ($flag_ids as $k=>$v) {
                $flag = self::getFlagModel($v->flag_id);
            }
        }
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


    public function mgc(Request $request)
    {
        $ms = app('mgc');
        $content = $request->input('flag_wb');
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
            // TODO:修改uid
            DB::table('customize_flag')->insert(['uid'=>1, 'customize_flag'=>$customize_flag]);
        }

        if (!empty($model_ids)) {
            $model_ids = rtrim($model_ids,',');
            $id_arr = explode(',', $model_ids);
            foreach ($id_arr as $k => $v) {
                // TODO:修改uid
                DB::table('user_to_flag')->insert(['uid'=>1, 'flag_id'=>$v]);
            }
        }
        // TODO::修改uid
        $uid = 2;
        Redis::set('page_status_'.$uid,'12');
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
//        $uid = 1;
//        $gid = 1;
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

    public function tt(){
        $data["a"] = 1;
        $data["b"] = 1;
        tt::dispatch($data);
    }

    // page_status 对照
    public function page_status_list($page_status) {
        switch ($page_status) {
            case 1:
                // 首页
                break;
            case 11: //10+ 均为线上点亮后的状态,可根据具体开发需要增加状态节点
                // 线上点亮 立flag页面
                break;
            case 12:
                // 首次进入大转盘页面
                break;
            case 13:
                // 多次进入大转盘页面
                break;
            case 14:
                // 奖品展示页面
                break;
            case 15:
                // 点亮个人海报页面
                break;
            case 21: // 20+ 均为线下点亮后的状态,可根据具体开发需要增加状态节点
                //线下点亮立flag
                break;
            case 22:
                // 首次进入大转盘
                break;
            case 23:
                // 多次进入大转盘
                break;
            case 24:
                // 线下门店地图展示
                break;
            default:
                // 无效状态
                break;
        }
    }

    // flag 模板
    public function getFlagModel($id) {
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
    public function shopLogin() {
        return view('shop-login');
    }

    // 线上客服登录验证
    public function checkOnline(Request $request) {
        $name = $request->input("name");
        $pwd = $request->input("pwd");

        if (empty($name) || empty($pwd)) {
            return response()->json(['code' => 500, 'result' => '用户名或密码错误！']);
        }

//        $userInfo = DB::table("kf_user")->where('user=? AND pwd=?',[$name, $pwd])->get('id');
//        dd($userInfo);
    }

    //线上客服兑奖页面
    public function exchangeCode(Request $request) {
        $user_name = $request->input('username');
        $pwd = $request->input('pwd');



    }

}
