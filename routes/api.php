<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/addApiToken', [\App\Http\Controllers\Yuser::class,'addApiToken']);
//加中间件
//Route::middleware('auth:sanctum')->get('/info', [\App\Http\Controllers\Yuser::class,'info']);

Route::get('/login', [\App\Http\Controllers\Yuser::class,'login']);
Route::get('/info', [\App\Http\Controllers\Yuser::class,'info']);
Route::get('/upView', [\App\Http\Controllers\Yuser::class,'upView']);
Route::any('/upViewSub', [\App\Http\Controllers\Yuser::class,'upViewSub'])->name('up-view-sub');


Route::any('/activityIndexNew', [\App\Http\Controllers\Activity::class,'activityIndexNew'])->name('activity-index-new');
Route::any('/activityIndex', [\App\Http\Controllers\Activity::class,'activityIndex'])->name('activity-index');
Route::any('/activityUp', [\App\Http\Controllers\Activity::class,'activityUp'])->name('activity-up');
Route::any('/activityDown', [\App\Http\Controllers\Activity::class,'activityDown'])->name('activity-down');
Route::any('/luckyDraw', [\App\Http\Controllers\Activity::class,'luckyDraw'])->name('lucky-draw');
Route::any('/luckyDraw2', [\App\Http\Controllers\Activity::class,'luckyDraw2'])->name('lucky-draw2');
Route::any('/winPrize', [\App\Http\Controllers\Activity::class,'winPrize'])->name('win-prize');
Route::any('/winPrize2', [\App\Http\Controllers\Activity::class,'winPrize2'])->name('win-prize2');
Route::any('/winPrize3', [\App\Http\Controllers\Activity::class,'winPrize3'])->name('win-prize3');
Route::any('/poster', [\App\Http\Controllers\Activity::class,'poster'])->name('poster');
Route::any('/poster2', [\App\Http\Controllers\Activity::class,'poster2'])->name('poster2');

Route::any('/map', [\App\Http\Controllers\Activity::class,'map'])->name('map');
Route::any('/phone', [\App\Http\Controllers\Activity::class,'phone'])->name('phone');
Route::any('/mgc', [\App\Http\Controllers\Activity::class,'mgc'])->name('mgc');
Route::any('/view', [\App\Http\Controllers\Activity::class,'view'])->name('view');
Route::any('/store-map', [\App\Http\Controllers\Activity::class,'storeMap'])->name('store-map');
Route::any('/tx', [\App\Http\Controllers\Activity::class,'tx'])->name('tx');
Route::any('/cash-prize', [\App\Http\Controllers\Activity::class,'cashPrize'])->name('cash-prize');
Route::any('/make-prize-num', [\App\Http\Controllers\Activity::class,'makePrizeNum'])->name('make-prize-num');
Route::any('/un-prize-num', [\App\Http\Controllers\Activity::class,'unPrizeNum'])->name('un-prize-num');
Route::any('/set-flag', [\App\Http\Controllers\Activity::class,'setFlag'])->name('set-flag');
Route::any('/tt', [\App\Http\Controllers\Activity::class,'tt'])->name('tt');
Route::any('/ss', [\App\Http\Controllers\Activity::class,'ss'])->name('ss');
Route::any('/shop-login', [\App\Http\Controllers\Activity::class,'shopLogin'])->name('shop-login');
Route::any('/exchange-code', [\App\Http\Controllers\Activity::class,'exchangeCode'])->name('exchange-code');
Route::any('/check-online', [\App\Http\Controllers\Activity::class,'checkOnline'])->name('check-online');
Route::any('/check-code', [\App\Http\Controllers\Activity::class,'checkCode'])->name('check-code');
Route::any('/prize-admin', [\App\Http\Controllers\Activity::class,'prizeAdmin'])->name('prize-admin');
Route::any('/authorization', [\App\Http\Controllers\Activity::class,'authorization'])->name('authorization');
Route::any('/agreement', [\App\Http\Controllers\Activity::class,'agreement'])->name('agreement');
Route::any('/poserdemo', [\App\Http\Controllers\Activity::class,'poserdemo'])->name('poserdemo');








