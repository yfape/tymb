<?php
namespace app\web\controller;

use think\facade\Request;
use app\web\model\User as UserModel;
use app\web\model\UserWx;

class User {


	public function index(){
		$openid = Request::header('openid');
		$user = UserModel::where('openid', $openid)->field('uid,nickname,idcard,phone,ismigrant')->find();
		return suc($user);
	}

	/**
	 * 新增或更新用户
	 * @return [type] [description]
	 */
	public function save(){
		$uid = Request::post('uid/d');
		$res = false;
		if(!$uid || $uid < 1){
			$res = $this->insert();
		}else{
			$res = $this->update();
		}

		return ($res == false) ? err('保存失败') : suc($res, '保存成功');
	}

	protected function insert(){
		$data = Request::only(['nickname','idcard','phone','ismigrant'=>0,'valid'=>1,'creator'=>0,'wx'=>[]],'post');
		$data['openid'] = Request::header('openid');
		if(!$this->is_idcard($data['idcard'])){
			return false;
		}
		try {
			$res = UserModel::create($data);
			$data = [
				'uid' => $res->uid,
				'nickname' => $res->nickname,
				'idcard' => $res->idcard,
				'phone' => $res->phone,
				'ismigrant' => $res->ismigrant
			];
			$data['wx']['uid'] = $res->uid;
			$this->saveWx($data['wx']);
			return $data;
		}catch (\Exception $e) {
			return false;
		}
		
	}

	protected function update(){
		$data = Request::only(['nickname','idcard','phone','ismigrant'=>0,'wx'=>[]],'post');
		$data['openid'] = Request::header('openid');
		$data['ismigrant'] = (int)$data['ismigrant'];

		if(!$this->is_idcard($data['idcard'])){
			return false;
		}

		try {
			$user = UserModel::where('openid',$data['openid'])->find();
			$res = $user->save($data);
			$data['wx']['uid'] = $user->uid;
			$this->saveWx($data['wx']);
			return $data;
		}catch (\Exception $e) {
			return false;
		}
	}

	protected function saveWx($data){
		$userwx = new UserWx;
		$userwx->replace()->save($data);
	}

	/**
	* 身份证校验
	*/
	private function is_idcard($id) {
        $id = strtoupper($id);
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if(!preg_match($regx, $id))
        {
            return FALSE;
        }
        if(15==strlen($id)) //检查15位
        {
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";
 
            @preg_match($regx, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth))
            {
                return FALSE;
            } else {
                return TRUE;
            }
        }
        else      //检查18位
        {
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth)) //检查生日日期是否正确
            {
                return FALSE;
            }
            else
            {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ( $i = 0; $i < 17; $i++ )
                {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id,17, 1))
                {
                    return FALSE;
                } //phpfensi.com
                else
                {
                    return TRUE;
                }
            }
        }
 
    }

    public function cards(){
    	$user = Request::middleware('user');
    	if(!$user){
    		return err('请求错误');
    	}

    	$record = app('rhash')->setTable('sync_card')->setKey($user->uid)->get();
    	if($record){
    		return err('您操作太频繁了，请稍后再试');
    	}else{
    		app('rhash')->setTable('sync_card')->setKey($user->uid)->set(['uid'=>$user->uid],'',true)->setExpire(60);
    	}
    	$joins =  \app\web\model\Join::with('program')->where('uid',$user->uid)->order('time','desc')->select();
    	$res = [];
    	foreach ($joins as $key => $value) {
    		array_push($res, [
    			'pid' => $value->pid,
    			'name' => $value->program->name,
    			'card' => $value->card
    		]);
    	}
    	return suc($res,'同步证书成功');
    }

    public function joinRecord(){
        $user = Request::middleware('user');
        if(!$user){
            return err('请求错误');
        }

        $page = Request::get('page/d');

        $joins =  \app\web\model\Join::field('jid,tid,pid,group,card,time')
        ->with([
            'program'=>function($query1){
                $query1->field('pid,name,img');
            },
            'team'=>function($query2){
                $query2->field('tid,name,headimg,city');
            }
        ])
        ->where('uid',$user->uid)->order('time','desc')->paginate([
            'list_rows' => 5,
            'page' => $page
        ]);

        $res = $joins->items();
        return suc($res);
    }
}