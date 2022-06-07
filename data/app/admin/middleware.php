<?php
// 全局中间件定义文件
return [
    //检查请求域名
    app\admin\middleware\CheckIP::class,
    app\admin\middleware\CheckUser::class,
];
