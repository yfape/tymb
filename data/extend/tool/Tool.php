<?php
namespace tool;

class Tool {

	public function thumbnail($img){
		$img = imgInFormat($img);
		$src = config('admin.file'). '/'. $img;

		$newfile = uniqid(). '.jpg';
		$addr = 'thumbnail/'. date('Ymd');

		$newweb = $addr. '/'. $newfile;
		$newweb = str_replace('\\', '/', $newweb);

		$newaddr = config('admin.file'). '/'. $addr;
		mkdirs($newaddr);

		$newsrc = $newaddr. '/'. $newfile;
		$newsrc = str_replace('/', '\\', $newsrc);

		$imgc = new \tool\ImgCompress($src, 0.4);
		$imgc->compressImg($newsrc);
		
		return $newweb;
	}

}