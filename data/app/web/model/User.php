<?php
namespace app\web\model;

use think\Model;
use app\web\model\UserWx;

class User extends Model{

	protected $table = 'user';
	protected $pk = 'uid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'uid' => 'int',
		'openid' => 'string',
		'nickname' => 'string',
		'idcard' => 'string',
		'phone' => 'string',
		'ismigrant' => 'bit',
		'team' => 'int',
		'teamtime' => 'int',
		'creator' => 'int',
		'valid' => 'bit',
		'create_time' => 'int',
		'update_time' => 'int'
	];

	protected $type = [
		'uid' => 'integer',
		'ismigrant' => 'integer',
		'team' => 'integer',
		'creator' => 'integer',
		'valid' => 'integer',
	];

	public function wx(){
		return $this->hasOne(UserWx::class,'uid');
	}

}