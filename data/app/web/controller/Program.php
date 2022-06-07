<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\Program as ProModel;
use app\web\model\Join as JoinModel;

class Program{

	protected $user;

	public function __construct(){
		$this->user = Request::middleware('user');
	}

	public function index(){
		$pid = Request::get('pid/d');
		$pro = ProModel::where('valid',1)->find($pid);
		
		$teams = JoinModel::field('tid,count(jid) as sum')
		->with(['team' => function($query){
			$query->field('tid,name,headimg,city');
		}])
		->where('pid',$pid)
		->group('tid')
		->order('sum','desc')
		->limit(5)
		->select();

		return suc([
			'program' => $pro,
			'teams' => $teams,
		]);
	}

	public function programs(){
		$sid = Request::get('sid/d');
		$programs = '';
		if($sid === 0){
			$programs = ProModel::where('valid',1)->field('pid,name,img,sid')->select();	
		}else{
			$programs = ProModel::where('valid',1)->where('sid',$sid)->field('pid,name,img,sid')->select();	
		}
		return suc($programs);
	}

}