<?php
// 应用公共文件

//返回错误信息
function err($txt,$status=999){
	return json(['msg' => $txt], $status);
}

//返回正确信息
function suc($data,$txt=''){
	return json(['data'=>$data,'msg'=>$txt],200);
}

//获取随机数
function getRandomStr($len, $special=true){
	$chars = array(
	    "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R","S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2","3", "4", "5", "6", "7", "8", "9"
	);

	if($special){
	    $chars = array_merge($chars, array(
	        "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
	        "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
	        "}", "<", ">", "~", "+", "=", ",", "."
	    ));
	}

	$charsLen = count($chars) - 1;
	shuffle($chars);                            //打乱数组顺序
	$str = '';
	for($i=0; $i<$len; $i++){
	    $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
	}
	return $str;
}

//判断路径是否存在不存在则创建
function mkdirs($dir, $mode = 0777){
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
}

function imgOutFormat($img){
	if(!$img){
		return;
	}
	if(strstr($img,'http') === false){
		return config('app.domain.file').$img;
	}else{
		return $img;
	}
} 

/**
 * 图片输入格式化
 * @param  [type] $img [description]
 * @return [type]      [description]
 */
function imgInFormat($img){
	if(strstr($img,config('app.domain.file')) === false){
		return $img;
	}
	$arr = explode('/', $img);
	$arr = array_slice($arr,3);
	return implode('/', $arr);
}

function arr_str_to_int($arr){
	if(!is_array($arr)){
		return is_numeric($arr) ? (int)$arr : $arr;
	}
	foreach ($arr as $k => $v) {
		if(is_numeric($v)){
			$arr[$k] = (int)$v;
		}else if(is_object($v)){
			$v = (array)$v;
			$arr[$k] = arr_str_to_int($v);
		}else if(is_array($v)){
			$arr[$k] = arr_str_to_int($v);
		}
	}
	return $arr;	
}

function geturl($url){
    $headerArray =array("Content-type:application/json;","Accept:application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output,true);
    return $output;
}