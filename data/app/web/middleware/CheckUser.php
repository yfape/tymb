<?php
declare (strict_types = 1);

namespace app\web\middleware;

use app\web\model\User as UserModel;

class CheckUser{

    protected $request;
    protected $token;
    protected $openid;
    protected $openid_in_token;
    protected $user;

    /**
     * 处理请求
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $this->request = $request;
        if(!$this->setInData()){
            return err('非法请求',998);
        }
        if(!$this->verToken()){
            return err('密钥失效',998);
        }
        if(!$this->verOpenid()){
            return err('非法请求', 998);
        }
        if(!$this->getUser()){
            return err('用户未认证',997);
        }
        if(!$this->verUserValid()){
            return err('用户已禁用',998);
        }
        
        $request->user = $this->user;
        return $next($request);
    }

    /**
     * 装载数据openid,token
     */
    protected function setInData(){
        $this->token = $this->request->header('Authorization');
        $this->openid = $this->request->header('openid');
        return ( $this->token && $this->openid ) ? true : false;
    }

    /**
     * 验证token合法性
     * @return [type] [description]
     */
    protected function verToken(){
        $res = app('auth')->verToken($this->token, config('app.auth.salt'), config('app.auth.jsclass'));
        if(!$res){
            return false;
        }
        if(!$res->openid){
            return false;
        }
        $this->openid_in_token = $res->openid;
        return true;
    }

    /**
     * 对比openid是否正确
     * @return [type] [description]
     */
    protected function verOpenid(){

        return $this->openid_in_token == $this->openid;
    }

    /**
     * 获取用户
     * @return [type] [description]
     */
    protected function getUser(){
        $user = UserModel::where('openid',$this->openid)->find();
        if(!$user){
            return false;
        }
        $this->user = $user;
        return true;
    }

    /**
     * 验证用户valid
     * @return [type] [description]
     */
    protected function verUserValid(){

        return $this->user['valid'] ? true : false;
    }

}
