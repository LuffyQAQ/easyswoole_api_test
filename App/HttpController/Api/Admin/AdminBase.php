<?php
/**
 *
 * User: zs
 * Date: 2019/9/4 9:28
 * Email: <1769360227@qq.com>
 */

namespace App\HttpController\Api\Admin;


use App\HttpController\Api\ApiBase;
use App\Model\Admin\AdminBean;
use App\Model\Admin\AdminModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Validate\Validate;

class AdminBase extends ApiBase
{
    //登录白名单
    public $whiteList = ['login'];
    /**
     * @var AdminBean
     */
    protected $who;

    protected $sessionKey = 'adminSession';

    public function onRequest(?string $action): ?bool
    {

        if(!parent::onRequest($action)){
            return false;
        }
        //如果不在白名单中并且没有登录
        if(!in_array($action,$this->whiteList) && !$this->who()){
            return false;
        }

        return true;

    }

    protected function who():?AdminBean
    {

        if(!$this->who){
            //执行session检查
            //获取session信息
            $session = $this->request()->getRequestParam($this->sessionKey);

            if(empty($session)){
                $session = $this->request()->getCookieParams($this->sessionKey);
            }
            if(empty($session)){
                $this->writeJson(Status::CODE_UNAUTHORIZED, null, '请先登录');
                return null;
            }

            $db = Mysql::defer('mysql');

            $model = new AdminModel($db);
            $who = $model->getOneBySession($session);


            if(!$who)
            {
                $this->writeJson(Status::CODE_BAD_REQUEST,null,'请先登录');
                return null;
            }
            if($who->getIsForbid() === 1){
                $this->writeJson(Status::CODE_FORBIDDEN,null,'该用户已被禁止登录');
                return null;
            }

            $this->who = $who;
            return $who;
        }
        return $this->who;
    }
}