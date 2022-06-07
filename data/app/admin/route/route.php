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


//登陆
Route::post('login', 'Login/index');
Route::post('vercode', 'assist.Vercode/send');
//系统
Route::post('system', 'System/getSystem');
Route::post('getDataCenter', 'System/getDataCenter');

//用户
Route::post('getSelf', 'User/getSelf');
Route::post('revisePass', 'User/revisePass');
Route::post('reviseSelf', 'User/reviseSelf');

Route::post('getUsers', 'User/getUsers')->append(['identity'=>1]);
Route::post('reviseUser', 'User/reviseUser')->append(['identity'=>1]);
Route::post('addUser', 'User/addUser')->append(['identity'=>1]);
Route::post('deleteUser','User/deleteUser')->append(['identity'=>1]);
Route::post('resetPass', 'User/resetPass')->append(['identity'=>1]);

//栏目
Route::post('changeColSort', 'Col/changeColSort')->append(['identity'=>3]);
Route::post('changeColAllSort', 'Col/changeColAllSort')->append(['identity'=>3]);
Route::post('changeValid', 'Col/changeValid')->append(['identity'=>3]);
Route::post('addCol', 'Col/addCol')->append(['identity'=>3]);

//服务
Route::post('upload','assist.Upload/index');
Route::post('textCensor','assist.Intelligent/textCensor');
Route::post('textToAudio','assist.Intelligent/textToAudio');

//文章
Route::post('saveArticle', 'Article/saveArticle');
Route::post('articles','Article/articles');
Route::post('article', 'Article/article');
Route::post('deleteArticle', 'Article/deleteArticle');
Route::post('changeStatus', 'Article/changeStatus');

//导航
Route::post('nav', 'Nav/nav');
Route::post('saveNav', 'Nav/saveNav')->append(['identity'=>3]);

//页面
Route::post('page', 'Page/page');
Route::post('pages', 'Page/pages');
Route::post('savePage','Page/save')->append(['identity'=>3]);
Route::post('addPage', 'Page/add')->append(['identity'=>3]);
Route::post('deletePage', 'Page/delete')->append(['identity'=>3]);
Route::post('pageValid', 'Page/pageValid')->append(['identity'=>3]);

//模块
Route::post('mod', 'Mod/mod');
Route::post('mods','Mod/mods');
Route::post('saveMod','Mod/save')->append(['identity'=>3]);

//杂志
Route::post('magazine', 'Magazine/magazine');
Route::post('magazines', 'Magazine/magazines');
Route::post('saveMagazine', 'Magazine/save')->append(['identity'=>3]);
Route::post('addMagazine', 'Magazine/add')->append(['identity'=>3]);
Route::post('changeMagazineValid', 'Magazine/valid')->append(['identity'=>3]);
Route::post('deleteMagazine', 'Magazine/delete')->append(['identity'=>3]);

//旧
Route::post('getTopics', 'Page/pages')->append(['identity'=>3]);
Route::post('importArticle','assist.Assist/importArticle');