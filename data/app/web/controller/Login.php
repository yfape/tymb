<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\Subject as SubModel;

class Login {

	protected $arr1;
	protected $arr2;
	protected $token;

	public function index(){
		if(!$this->getArr1()){
			return err('用户认证失败，请重新登录',998);
		}
		if(!$this->getArr2()){
			return err('用户信息拉取失败，请重新登录',998);
		}
		if(!$this->getToken()){
			return err('用户数据错误，请重新登陆',998);
		}

		$data = $this->getJssdk();

		$res = [
			'user' => $this->arr2,
			'token' => $this->token,
			'jsapi' => $data,
			'subjects' => $this->getSubjects()
		];
		return suc($res);
	}

	/**
	 * 获取用户openid access_token
	 * @return [type] [description]
	 */
	protected function getArr1(){
		$code = Request::post('code');
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.config('app.wx.appid').'&secret='.config('app.wx.appsecret').'&code='.$code.'&grant_type=authorization_code';
		$res = geturl($url);
		if(isset($res['errcode'])){
			return false;
		}
		$this->arr1 = $res;
		return true;
	}

	/**
	 * 拉取微信用户信息
	 * @return [type] [description]
	 */
	protected function getArr2(){
		$userurl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$this->arr1['access_token'].'&openid='.$this->arr1['openid'].'&lang=zh_CN';
		$res = geturl($userurl);
		if(isset($res['errcode'])){
			return false;
		}
		$this->arr2 = $res;
		return true;
	}

	/**
	 * 创建用户token
	 * @return [type] [description]
	 */
	protected function getToken(){
		$data = [
			'openid' => $this->arr2['openid']
		];
		$config = config('app.auth');
		$this->token = app('auth')->getToken($data, $config['expire'], $config['aud'], $config['iss'], $config['salt']);
		return $this->token ? true : false;
	}

	protected function getJssdk(){
		$ticket = $this->getJsapi_ticket();
		if(!$ticket){
			return false;
		}
		$noncestr = uniqid();
		$jsapi_ticket = $ticket;
		$timestamp = time();
		$url = config('app.domain.web');
		$sen = "jsapi_ticket=$jsapi_ticket&noncestr=$noncestr&timestamp=$timestamp&url=$url";
		$signature = sha1($sen);
		$data = [
			'noncestr' => $noncestr,
			'timestamp' => $timestamp,
			'signature' => $signature
		];
		return $data;
	}

	protected function getJsapi_ticket(){
		$jsapi_ticket = app('rhash')->setTable('jsapi_ticket')->setKey(1)->get('jsapi_ticket');
		if($jsapi_ticket){
			return $jsapi_ticket;
		}

		$access_token = $this->getAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
		$res = geturl($url);
		if(isset($res['ticket'])){
			app('rhash')->setTable('jsapi_ticket')->setKey(1)->set(['jsapi_ticket'=>$res['ticket']],'',true)->setExpire(180);
			return $res['ticket'];
		}
		return false;
	}

	protected function getAccessToken(){
		$access_token = app('rhash')->setTable('access_token')->setKey(1)->get('access_token');
		if($access_token){
			return $access_token;
		}
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.config('app.wx.appid').'&secret='.config('app.wx.appsecret');
		$res = geturl($url);
		if(isset($res['access_token'])){
			app('rhash')->setTable('access_token')->setKey(1)->set(['access_token'=>$res['access_token']],'',true)->setExpire(180);
			return $res['access_token'];
		}
		return false;
	}

	protected function getSubjects(){
		$subs = cache('subjects');
		$subs = json_decode($subs);
		if($subs){
			return $subs;
		}
		$subs = SubModel::where('valid',1)->field('sid,name,headimg')->select();
		cache('subjects',json_encode($subs));
		return $subs;
	}
}