<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::post('login', 'login/index');

//home
Route::get('home','Page/home')->middleware(\app\web\middleware\CheckCommon::class); //cache(3600)

//user
Route::get('user','User/index')->middleware(\app\web\middleware\CheckCommon::class);
Route::get('cards','User/cards')->middleware(\app\web\middleware\CheckUser::class);
Route::get('records','User/joinRecord')->middleware(\app\web\middleware\CheckUser::class);
Route::post('saveUser','User/save')->middleware(\app\web\middleware\CheckCommon::class);

//team
Route::get('getCreator','Team/getCreator')->middleware(\app\web\middleware\CheckUser::class);
Route::get('createTeam','Teamhub/getCreateTeam')->middleware(\app\web\middleware\CheckUser::class);
Route::get('selfteam','Team/getSelfTeam')->middleware(\app\web\middleware\CheckUser::class);
Route::get('members','Team/getMembers')->middleware(\app\web\middleware\CheckUser::class);
Route::get('teams','Team/teams')->middleware(\app\web\middleware\CheckUser::class);
Route::post('joinTeam','Team/joinTeam')->middleware(\app\web\middleware\CheckUser::class);
Route::post('exitteam','Team/exitTeam')->middleware(\app\web\middleware\CheckUser::class);
Route::post('addTeam','Teamhub/insert')->middleware(\app\web\middleware\CheckUser::class);
Route::post('deleteTeam','Teamhub/delete')->middleware(\app\web\middleware\CheckUser::class);

//join
Route::get('joinJudge','Join/joinJudge')->middleware(\app\web\middleware\CheckUser::class);
Route::post('joinProgram','Join/insert')->middleware(\app\web\middleware\CheckUser::class);

//program
Route::get('program','Program/index')->middleware(\app\web\middleware\CheckCommon::class); //cache(60)
Route::get('programs','Program/programs')->middleware(\app\web\middleware\CheckCommon::class); //cache(3600)

//service
Route::post('upload','Upload/index')->middleware(\app\web\middleware\CheckUser::class);