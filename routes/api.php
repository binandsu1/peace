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


Route::any('/activityIndex', [\App\Http\Controllers\Activity::class,'activityIndex'])->name('activity-index');
Route::any('/activityUp', [\App\Http\Controllers\Activity::class,'activityUp'])->name('activity-up');
Route::any('/activityDown', [\App\Http\Controllers\Activity::class,'activityDown'])->name('activity-down');
Route::any('/luckyDraw', [\App\Http\Controllers\Activity::class,'luckyDraw'])->name('lucky-draw');
Route::any('/winPrize', [\App\Http\Controllers\Activity::class,'winPrize'])->name('win-prize');
Route::any('/poster', [\App\Http\Controllers\Activity::class,'poster'])->name('poster');

Route::any('/map', [\App\Http\Controllers\Activity::class,'map'])->name('map');
Route::any('/phone', [\App\Http\Controllers\Activity::class,'phone'])->name('phone');
Route::any('/mgc', [\App\Http\Controllers\Activity::class,'mgc'])->name('mgc');
Route::any('/view', [\App\Http\Controllers\Activity::class,'view'])->name('view');
Route::any('/baidu', [\App\Http\Controllers\Activity::class,'baidu'])->name('baidu');
Route::any('/tx', [\App\Http\Controllers\Activity::class,'tx'])->name('tx');
Route::any('/cash-prize', [\App\Http\Controllers\Activity::class,'cashPrize'])->name('cash-prize');
Route::any('/make-prize-num', [\App\Http\Controllers\Activity::class,'makePrizeNum'])->name('make-prize-num');







