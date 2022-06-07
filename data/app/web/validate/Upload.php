<?php
namespace app\web\validate;

use think\Validate;

class Upload extends Validate
{
    protected $rule =   [
        'fileSize'  => '1024',
        'fileExt'   => 'png,gif',
    ];
    
}