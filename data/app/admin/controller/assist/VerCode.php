<?php
namespace app\admin\controller\assist;

use think\facade\Request;
use app\admin\controller\User;
use app\admin\model\User as UserModel;

use tool\QQMailer;

class Vercode{

	public function send(){
		$username = Request::post('user');
		if(!$username){
			return err('请输入用户名');
		}
		$userc = new User;
		$user = $userc->getUser('user', $username, false);
		if(!$user){
			return err('用户不存在');
		}
		$vercode = getRandomStr(6,false);
		$title = '验证码';
		$content = "<p>您的验证码码为:<span style='font-size:20px;font-weight:bold;color:red'> $vercode </span></p><p>请勿将此码透露给他人,此码将在两分钟内作废。</p>";
		if($this->setVercodeRedis($user['uid'], $vercode)){
			$mailer = new QQMailer(true);
			return $mailer->send($user['email'], $title, $content) ? ['code'=>200,'msg'=>'发送成功'] : err('验证码发送失败');
		}else{
			return err('验证码生成失败');
		}

	}

	/**
	 * 设置vercode至redis
	 */
	protected function setVercodeRedis($uid,$vercode){
		$res = app('rhash')->setTable('u_vercode')->setKey($uid)->set(['vercode'=>$vercode],'',true)->setExpire(180);
		return $res;
	}
}