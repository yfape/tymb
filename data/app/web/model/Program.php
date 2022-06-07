<?php
namespace app\web\model;

use think\Model;
use app\web\model\Subject as subModel;

class Program extends Model{

	protected $table = 'program';
	protected $pk = 'pid';
	protected $autoWriteTimestamp = 'int';
	protected $schema = [
		'pid' => 'int',
		'name' => 'string',
		'img' => 'string',
		'sid' => 'int',
		'video' => 'string',
		'start' => 'int',
		'end' => 'int',
		'content' => 'string',
		'groups' => 'string',
		'valid' => 'bit',
		'create_time' => 'int',
		'update_time' => 'int',
	];

	protected $type = [
		'pid' => 'integer',
		'start' => 'integer',
		'end' => 'integer',
		'groups' => 'array',
		'valid' => 'integer',
	];

	public static function onBeforeInsert($obj){
    	$obj->img = imgInFormat($obj->img);
    	$obj->video = imgInFormat($obj->video);
    }
    public static function onBeforeUpdate($obj){
    	$obj->img = imgInFormat($obj->img);
    	$obj->video = imgInFormat($obj->video);
    }
    public static function onAfterRead($obj){
    	$obj->img = imgOutFormat($obj->img);
    	$obj->video = imgOutFormat($obj->video);
    }

    public function subject(){
    	return $this->hasOne(subModel::class,'sid','sid');
    }

}