<?php
namespace app\web\model;

use think\Model;
use app\web\model\Team as TeamModel;
use app\web\model\Program as ProModel;

class Join extends Model{

	protected $table = 'join';
	protected $pk = 'jid';
	protected $schema = [
		'jid' => 'int',
		'uid' => 'int',
		'pid' => 'int',
		'tid' => 'int',
		'group' => 'string',
		'video' => 'string',
		'card' => 'string',
		'time' => 'int'
	];

	protected $type = [
		'jid' => 'integer',
		'uid' => 'integer',
		'pid' => 'integer',
		'tid' => 'integer',
		'time' => 'integer'
	];

	public static function onBeforeInsert($obj){
		$obj->time = time();
    	$obj->card = imgInFormat($obj->card);
    	$obj->video = imgInFormat($obj->video);
    }
    public static function onBeforeUpdate($obj){
    	$obj->card = imgInFormat($obj->card);
    	$obj->video = imgInFormat($obj->video);
    }
    public static function onAfterRead($obj){
    	$obj->card = imgOutFormat($obj->card);
    	$obj->video = imgOutFormat($obj->video);
    }

    public function team(){
    	return $this->hasOne(TeamModel::class,'tid','tid');
    }

    public function program(){
    	return $this->hasOne(ProModel::class,'pid','pid');
    }

}