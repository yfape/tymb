<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Method:*");
header("Access-Control-Allow-Headers:*");
if(strtoupper($_SERVER['REQUEST_METHOD'])== 'OPTIONS'){ 
	return true;exit();
}

date_default_timezone_set("Asia/Shanghai");

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
