<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\Team as TeamModel;
use app\web\model\Teamhub as TeamhubModel;
use app\web\model\User as UserModel;

class Team {

	protected $user;

	public function __construct(){
		$this->user = Request::middleware('user');
	}

	public function getSelfTeam(){
		$team = [];
		if($this->user->team > 0){
			$team = TeamModel::find($this->user->team)->toArray();
			if($team['creator'] != $this->user->uid){
				unset($team['own']);
				unset($team['code']);
			}
		}
		return suc($team);
	}

	public function getMembers(){
		$page = Request::get('page/d');
		$out = UserModel::with(['wx' => function($query) {
			$query->field('uid,nickname,headimgurl,city');
		}])->where('team',$this->user->team)->field('uid')->where('valid',1)->order('teamtime','asc')->paginate([
			'list_rows' => 10,
        	'page' => $page
        ]);

		$users = $out->items();
		return suc($users);
	}

	public function teams(){
		$page = Request::get('page/d');
		$search = Request::get('search/s');
		$sen = '';
		if(strlen($search)>40){
			return err('搜索内容有误');
		}
		if(!$search){
			$sen = true;
		}else{
			$sen = 'name="'.$search.'"';
		}
		$out = TeamModel::where('valid',1)->where($sen)->field('tid,name,headimg,city,own,sum,create_time')->order(['sum'=>'desc','create_time'=>'desc'])->paginate([
			'list_rows' => 10,
        	'page' => $page
        ]);

        $teams = $out->items();
        return suc($teams);
	}

	public function exitTeam(){
		$team = TeamModel::where('tid',$this->user->team)->find();
		$team->sum = $team->sum-1;
		$team->save();

		$this->user->team = null;
		$this->user->teamtime = null;
		$this->user->save();

		return suc('退出代表团成功');
	}

	public function getCreator(){
		$tid = Request::get('tid/d');
		$team = TeamModel::find($tid);
		if(!$team){
			return err('不存在此代表团');
		}

		$user = UserModel::with(['wx' => function($query) {
			$query->field('uid,nickname,headimgurl,city');
		}])->where('uid',$team->creator)->field('uid')->find();

		return suc($user->wx);
	}

	public function joinTeam(){
		$tid = Request::post('tid/d');

		if($this->user->team > 0){
			return err('您已在代表团中，请退出后再加入');
		}

		if($this->user->creator>0){
			$teamhub = TeamhubModel::find($this->user->creator);
			if($teamhub){
				return err('您创建的"'.$teamhub->name.'"正在审核中，暂时无法加入其他代表团');
			}
		}

		$team = TeamModel::find($tid);
		if(!$team){
			return err('不存在此代表团');
		}
		if($team->valid != 1){
			return err('此代表团已被禁用');
		}
		if($team->own == 1){
			$incode = Request::post('code/s');
			if($incode != $team->code){
				return err('邀请码错误');
			}
		}

		$this->user->team = $tid;
		$this->user->teamtime = time();
		$this->user->save();

		$team->sum = $team->sum + 1;
		$team->save();
		return suc('加入代表团成功');

	}

}