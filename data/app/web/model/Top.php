<?php
namespace app\web\model;

use think\Model;

class Top extends Model{

	protected $table = 'top';
	protected $pk = 'tid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'tid' => 'int',
		'img' => 'string',
		'url' => 'string',
		'sort' => 'int',
		'create_time' => 'int',
		'update_time' => 'int',
	];

	protected $type = [
		'tid' => 'int',
		'sort' => 'int',
	];

	public static function onBeforeInsert($obj){
    	$obj->img = imgInFormat($obj->img);
    }
    public static function onBeforeUpdate($obj){
    	$obj->img = imgInFormat($obj->img);
    }
    public static function onAfterRead($obj){
    	$obj->img = imgOutFormat($obj->img);
    }

}