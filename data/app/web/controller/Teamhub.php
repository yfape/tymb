<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\Team as TeamModel;
use app\web\model\Teamhub as TeamhubModel;

class Teamhub {

	protected $user;

	public function __construct(){
		$this->user = Request::middleware('user');
	}

	public function index(){
		$thid = Request::get('thid/d');
		$team = TeamhubModel::find($thid);
		return suc($team);
	}

	public function getCreateTeam(){
		$team = TeamModel::where('tid',$this->user->creator)->find();
		if($team){
			return suc($team);
		}

		$teamhub = TeamhubModel::where('thid',$this->user->creator)->find();
		if($teamhub){
			return suc($teamhub);
		}
		return suc([]);
	}

	public function insert(){

		$team = TeamModel::find('creator',$this->user->uid);
		if($team){
			return err('每个用户只能创建一个代表团');
		}

		$data = Request::only(['name','city','headimg','own','code'],'post');
		$data['creator'] = $this->user->uid;
		try{
			$res = TeamhubModel::create($data);
			$this->user->creator = $res->thid;
			$this->user->save();
			return suc('提交成功');
		}catch(\Exception $e){
			$msg = $this->err_tran_msg($e);
			return err($msg);
		}
	}

	public function delete(){
		$res = TeamhubModel::destroy($this->user->creator);
		if($res){
			$this->user->creator = null;
			$this->user->save();
		}
		return $res ? suc('','取消成功') : err('取消失败');
	}

	protected function err_tran_msg($e){
		$text = $e->getMessage();
		if(strpos($text,'creator') !== false){
			return '每个用户只能创建一个代表团';
		}
		return '保存失败';
	}
}