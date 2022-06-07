<?php
namespace app\web\controller;

use think\facade\Request;
use think\facade\Filesystem;
use think\exception\ValidateException;
use app\web\validate\Upload as UploadValidate;

class Upload {

	public function index(){
		$files = Request::file();
		try {
	        validate(['file' => [
				'fileSize' => 102400,
				'fileExt' => 'jpg,png,gif,jpeg',
				'fileMime' => 'image/jpeg,image/png,image/gif',
			]])->check($files);
			$thisfile = \think\facade\Filesystem::putFile( 'upload/image', $files['file']);
	        $thisfile = str_replace('\\','/',$thisfile);
	        $filename = imgOutFormat($thisfile);
	        return suc($filename,'上传成功');
	    } catch (ValidateException $e) {
	        return err($e->getMessage());
	    }
	}
}