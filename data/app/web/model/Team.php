<?php
namespace app\web\model;

use think\Model;

class Team extends Model{

	protected $table = 'team';
	protected $pk = 'tid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'tid' => 'int',
		'name' => 'string',
		'headimg' => 'string',
		'city' => 'string',
		'own' => 'bit',
		'code' => 'string',
		'sum' => 'int',
		'valid' => 'bit',
		'creator' => 'int',
		'create_time' => 'int',
	];

	protected $type = [
		'tid' => 'integer',
		'own' => 'integer',
		'sum' => 'integer',
		'creator' => 'integer',
		'valid' => 'integer',
	];

	public static function onBeforeInsert($obj){
    	$obj->headimg = imgInFormat($obj->headimg);
    }
    public static function onBeforeUpdate($obj){
    	$obj->headimg = imgInFormat($obj->headimg);
    }
    public static function onAfterRead($obj){
    	$obj->headimg = imgOutFormat($obj->headimg);
    }

}