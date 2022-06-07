<?php
declare (strict_types = 1);

namespace app\admin\controller\assist;

use think\facade\Request;
use app\admin\model\IPwhite as IPwhiteModel;

/**
 * Created by sublime.
 * Power By yfso
 * func manage IPwhitelist
 */

class IPwhite{

    /**
     * 判断指定ip是否在白名单内
     * @param  [type]  $ip [description]
     * @return boolean     [description]
     */
    public function isExist($ip){
        $len = app('rset')->scard('IPwhite');
        if($len<=0){
            $this->reRedis();
        }
        return app('rset')->sismember('IPwhite',$ip);
    }

    /**
     * 获取IP白名单全部元素  API
     * @return [type] [description]
     */
    public function all(){
        $ips = app('rset')->sMembers('IPwhite');
        if(!$ips){
            $ips = $this->reRedis();
        }
        return json($ips);
    }

    /**
     * 新增IP
     */
    public function add(){
        $ip = Request::post(['ip/s']);
        $ipm = new IPwhiteModel;
        $ipm->IP = $ip;
        $ipm->replace()->save();
        $this->reRedis();
        return suc($ip, '新增IP成功');
    }

    /**
     * 删除IP
     * @return [type] [description]
     */
    public function delete(){
        $ip = Request::post(['ip/s']);
        IPwhiteModel::destroy($ip);
        $this->reRedis();
        return suc($ip, '删除IP成功');
    }

    /**
     * 刷新IP白名单redis
     * @return [type] [description]
     */
    public function reRedis(){
        $ips = IPwhiteModel::select()->toArray();
        foreach ($ips as $key => $value) {
            app('rset')->sAdd('IPwhite',$value['IP']);
        }
        return array_column($ips, 'IP');
    }
}
