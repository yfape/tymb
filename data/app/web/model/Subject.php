<?php
namespace app\web\model;

use think\Model;

class Subject extends Model{

	protected $table = 'subject';
	protected $pk = 'sid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'sid' => 'int',
		'name' => 'string',
		'headimg' => 'string',
		'valid' => 'bit',
		'create_time' => 'int',
		'update_time' => 'int',
	];

	protected $type = [
		'sid' => 'integer',
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