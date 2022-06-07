<?php
namespace app\web\model;

use think\Model;

class UserWx extends Model{

	protected $table = 'user_wx';
	protected $pk = 'uid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'uid' => 'int',
		'nickname' => 'string',
		'sex' => 'int',
		'headimgurl' => 'string',
		'city' => 'string',
		'create_time' => 'int',
	];

	protected $type = [
		'uid' => 'integer',
		'sex' => 'integer',
	];


}