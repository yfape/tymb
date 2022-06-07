<?php
namespace tool;

use think\Db;
use think\Exception;

use Redis;

class RedisSet extends Redis
{
    protected $index = 1;  //Hash 默认库
    protected $prefix="";   //HashKey前缀
    protected $host="";
    protected $port="";

    public function __construct($options=[]){
        $sysconfig = config('cache.stores.redis');
        $this->host = $sysconfig['host'];
        $this->port = $sysconfig['port'];

        self::connect( $this->host, $this->port);
        self::select($this->index);
    }
}