<?php

namespace App\Http\Controllers;

use App\Jobs\UpPicJob;
use App\Models\Jiayu;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
class Activity extends Controller
{


    public function activityIndex(){
        return view('activity-index');
    }

    public function activityUp(){
        return view('activity-up');
    }

    public function activityDown(){
        return view('map');
    }

    public function luckyDraw(Request $request){
        $flag = $request->input('flag');

        return view('lucky-draw',compact('flag'));
    }

    public function winPrize(Request $request){
        $data = $request->all();
        return view('win-prize',compact('data'));
    }

    public function poster(Request $request){

        $flag = $request->input('flag','吃饭了吗');
        $pic_re = Jiayu::orderBy('id','DESC')->first();
        $image = new Image();
        $path = $pic_re->path;

        $newimageName = 'new'.time() . rand(10000, 99999) .'.jpg';
        $newpath = 'images/' . date('Ymd').'/'.$newimageName;

        $face_img = $image::make($path)->resize(530,800);
        $face_img->text($flag, 370,41, function ($font) use ($path) {
            $font->file(public_path('vista.ttf'));
            $font->size(18);
            $font->color('#FF0000');
            $font->valign('right');
        });

        $save_path = public_path($newpath);

        $face_img->save($save_path);
        return view('poster',compact('pic_re','newimageName'));
    }


    public function map(){
        return view('map');
    }

    public function phone(Request $request){

        if($request->method() == 'POST'){

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
        $image = Jiayu::orderBy('id','DESC')->first();
        return view('phone',compact('image'));

    }
}
