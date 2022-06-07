<?php
namespace app\web\controller;

use think\facade\Request;

use app\web\model\Top as TopModel;
use app\web\model\Subject as SubModel;
use app\web\model\Program as ProModel;

class Page{

	public function home(){
		$tops = TopModel::where(true)->order('sort','asc')->select();
		$subs = SubModel::where('valid',1)->field('sid,name,headimg')->select();
		$pros = ProModel::where('valid',1)->where('end','>',time())->field('pid,name,img,sid')->select();
		return suc([
			'tops' => $tops,
			'subjects' => $subs,
			'programs' => $pros
		]);
	}

}