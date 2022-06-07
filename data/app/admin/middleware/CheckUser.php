<?php
declare (strict_types = 1);

namespace app\admin\middleware;

class CheckUser{

    protected $request;
    protected $token;
    protected $tokendata;
    protected $user;

    /**
     * 处理请求
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if($request->baseUrl() == '/login' || $request->baseUrl() == '/vercode'){
            return $next($request);
        }
        $this->request = $request;
        if(!$this->setToken()){
            return err('非法请求',998);
        }
        if(!$this->verToken()){
            return err('密钥失效',998);
        }
        if(!$this->verIP()){
            return err('非法请求2',998);
        }
        if(!$this->getUser()){
            return err('不存在用户',998);
        }
        if(!$this->verUserValid()){
            return err('用户已禁用',998);
        }
        if(!$this->verUserForbid()){
            return err('用户已阻断',998);
        }
        if(!$this->verTokenRedis()){
            return err('密钥过期',998);
        }
        if(!$this->verIdentity()){
            return err('无权限');
        }
        
        $request->user = $this->user;
        return $next($request);
    }

    /**
     * 装载token
     */
    protected function setToken(){
        $this->token = $this->request->header('Authorization');
        return $this->token ? true : false;
    }

    /**
     * 验证token合法性
     * @return [type] [description]
     */
    protected function verToken(){
        $res = app('auth')->verToken($this->token, config('admin.auth.salt'), config('admin.auth.jsclass'));
        if(!$res){
            return false;
        }
        if(!($res->uid&&$res->ip&&$res->user)){
            return false;
        }
        $this->tokendata = $res;
        return true;
    }

    /**
     * 验证ip一致性
     * @return [type] [description]
     */
    protected function verIP(){

        return $this->tokendata->ip === $this->request->ip();
    }

    /**
     * 获取用户
     * @return [type] [description]
     */
    protected function getUser(){
        $userc = new \app\admin\controller\User;
        $res = $userc->getUser('uid', $this->tokendata->uid, false);
        if(!$res){
            return false;
        }
        $this->user = $res;
        return true;
    }

    /**
     * 验证用户valid
     * @return [type] [description]
     */
    protected function verUserValid(){

        return $this->user['valid'] ? true : false;
    }

    /**
     * 验证用户阻断
     * @return [type] [description]
     */
    protected function verUserForbid(){
        $res = app('rhash')->setTable('u_forbid')->setKey($this->user['uid'])->get();
        return $res ? false : true;
    }

    /**
     * 验证token一致性
     * @return [type] [description]
     */
    protected function verTokenRedis(){
        $token = app('rhash')->setTable('u_token')->setKey($this->user['uid'])->get('token');
        return $this->token === $token;
    }

    /**
     * 验证用户权限
     * @return [type] [description]
     */
    protected function verIdentity(){
        $sysidentity = $this->request->identity ? $this->request->identity : 99;
        return $this->user['identity'] <= $sysidentity;
    }

}
