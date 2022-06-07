<?php
namespace app\web\model;

use think\Model;

class TeamHub extends Model{

	protected $table = 'team_hub';
	protected $pk = 'thid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'thid' => 'int',
		'name' => 'string',
		'headimg' => 'string',
		'city' => 'string',
		'own' => 'bit',
		'code' => 'string',
		'creator' => 'int',
		'create_time' => 'int',
	];

	protected $type = [
		'thid' => 'integer',
		'own' => 'integer',
		'creator' => 'integer',
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