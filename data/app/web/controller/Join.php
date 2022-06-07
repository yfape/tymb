<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\Program as ProModel;
use app\web\model\Join as JoinModel;

class Join{

	protected $user;

	public function __construct(){
		$this->user = Request::middleware('user');
	}

	public function joinJudge(){
		$pid = Request::get('pid/d');
		$join = JoinModel::where('uid',$this->user->uid)->where('pid',$pid)->find();
		if($join){
			return suc([
				'jid' => $join->jid,
				'group' => $join->group,
				'card' => $join->card,
				'time' => $join->time
			]);
		}
		return suc(true);
	}

	public function insert(){
		$pid = Request::post('pid/d');
		$pro = ProModel::find($pid);
		if(!$pro){
			return err('不存在此活动');
		}
		if($pro->valid != 1){
			return err('此活动已被禁用');
		}
		if($pro->start > time()){
			return err('此活动尚未开始');
		}
		if($pro->end < time()){
			return err('活动已结束');
		}
		$join = JoinModel::where('pid', $pid)->where('uid', $this->user->uid)->find();
		if($join){
			return err('您已参与本次活动');
		}

		$group = Request::post('group/s');
		if(!in_array($group, $pro->groups)){
			return err('不存在“'.$group.'”组别');
		}

		$card = $this->getCard();
		if(!$card){
			return err('内部错误');
		}

		$video = $this->getVideo();
		if(is_object($video)){
			return err($e->getMessage());
		}

		$data = [
			'uid' => $this->user->uid,
			'pid' => $pid,
			'tid' => $this->user->team,
			'group' => $group,
			'video' => $video,
			'card' => $card
		];

		$res = JoinModel::create($data);
		return $res ? suc(['card' => $card],'参加成功') : err('参与失败');
	}

	public function index(){

	}

	protected function getVideo(){
		$video = Request::file('video');
		try{
			validate(['file' => [
				'fileSize' => 102400,
				'fileExt' => 'mp4,avi,3gp,mpg,wmv,flv,rmvb',
				'fileMime' => 'video/*',
			]])->check([$video]);
			$thisfile = \think\facade\Filesystem::putFile( 'upload/video', $video);
	        $thisfile = str_replace('\\','/',$thisfile);
	        $filename = imgOutFormat($thisfile);
	        return $filename;
	    } catch (ValidateException $e) {
	        return $e;
	    }
	}

	protected function getCard(){
		return 'http://file.ty.com:8001/upload/image/jz.png';
	}

}