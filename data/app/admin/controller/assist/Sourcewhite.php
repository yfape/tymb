<?php
namespace app\admin\controller\assist;

use app\admin\model\Sourcewhite as SourcewhiteModel;

class Sourcewhite {

	public function all($mode='api'){
		$sws = app('rset')->sMembers('sourcewhite');
		if(!$sws){
			$sws = $this->reRedis();
		}
		return ($mode == 'api') ? suc($sws) : $sws;
	}

	/**
	 * 刷新redis
	 * @return [type] [description]
	 */
	public function reRedis(){
		$sws = SourcewhiteModel::select()->toArray();
		$sws = array_column($sws,'sourcewhite');
		foreach ($sws as $key => $value) {
			app('rset')->sAdd('sourcewhite',$value);
		}
		return $sws;
	}

}