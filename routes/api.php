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












