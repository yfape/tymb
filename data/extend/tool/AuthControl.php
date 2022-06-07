<?php
namespace tool;

use Firebase\JWT\JWT;
/*
生成及验证token
 */
class AuthControl{

	/**
	 * 创建token
	 * @param  [arr] $data [description]
	 * @param  [int] $exp  [description]
	 * @param  [str] $aud  [description]
	 * @param  [str] $iss  [description]
	 * @param  [str] $key  [description]
	 * @return [str] token [description]
	 */
	public function getToken($data,$exp,$aud,$iss,$key){
		$time = time();
		$token = [
			'iss' => $iss,
			'aud' => $aud,
			'iat' => $time,
			'nbf' => $time,
			'exp' => $time+$exp,
			'data' => $data,
		];
		return JWT::encode($token,$key);
	}
	
	/**
	 * 验证token
	 * @param  [str] $jwt     [description]
	 * @param  [str] $key     [description]
	 * @param  [arr] $jmclass [description]
	 * @return [arr]          [description]
	 */
	public function verToken($jwt,$key,$jmclass)
	{
		try {
	    	JWT::$leeway = 60;//当前时间减去60，把时间留点余地
	       	$decoded = JWT::decode($jwt, $key, $jmclass);//HS256方式，这里要和签发的时候对应
	       	$arr = (array)$decoded;
	       	// $arr = array_merge($arr,array('status'=>'1111'));
	       	return $arr['data'];
	    }catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
	    	// return getOut(1011);
	    }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
	    	// return getOut(1012);
	    }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
	    	// return getOut(1013);
	   	}catch(Exception $e) {  //其他错误
	    	// return getOut(1014);
	    }
	}
	
}