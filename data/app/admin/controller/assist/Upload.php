<?php
namespace app\admin\controller\assist;

use think\facade\Request;
use think\facade\Filesystem;

class Upload {

	public function index(){
		$files = Request::file();
		try {
	        validate(['image'=>'filesize:12|fileExt:jpg,gif,png,jpeg,docx,doc,pdf|image:jpg,png,gif,jpeg'])->check($files);
	        $savename = [];
	        foreach($files as $file) {
	            $thisfile = \think\facade\Filesystem::putFile( 'upload', $file);
	            $thisfile = str_replace('\\','/',$thisfile);
	            $savename[] = imgOutFormat($thisfile);
	        }
	        return suc($savename,'上传成功');
	    } catch (\think\exception\ValidateException $e) {
	        return $e;
	    }
	}

}