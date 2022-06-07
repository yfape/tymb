<?php
declare (strict_types = 1);

namespace app\web\middleware;

class CheckCommon{

    protected $request;
    protected $token;
    protected $openid;
    protected $openid_in_token;

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


}
