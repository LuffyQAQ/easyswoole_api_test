<?php
/**
 *
 * User: zs
 * Date: 2019/9/5 14:52
 * Email: <1769360227@qq.com>
 */

namespace App\HttpController\Api\Admin;


use App\Model\Admin\AdminBean;
use App\Model\Admin\AdminModel;
use App\Service\Common\VerifyCodeService;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Spl\SplBean;

class Login extends AdminBase
{
    /**
     * @Param(name="verifyCodeHash",from={COOKIE},required="")
     * @Param(name="verifyCodeTime",from={COOKIE},required="")
     * @Param(name="account",alias="账号",required="",lengthMax="20")
     * @Param(name="password",alias="密码",required="",lengthMin="6",lengthMax="16")
     * @Param(name="verifyCode",alias="验证码",required="",length="4")
     */
    public function login()
    {
        //获取提交的cookie信息
       $hash = $this->request()->getCookieParams('verifyCodeHash');
       $time = $this->request()->getCookieParams('verifyCodeTime');
       //获取用户提交的数据
       $param = $this->request()->getRequestParam();


       if(VerifyCodeService::checkVerifyCode($param['verifyCode'],$time,$hash))
       {
            $db = Mysql::defer('mysql');
            $adminBean = new AdminBean();
            $adminBean->setAdminAccount($param['account']);
            $adminBean->setAdminPassword(md5($param['password']));


            $model = new AdminModel($db);

            $admin = $model->login($adminBean);


            if($admin)
            {
                if($admin->getIsForbid() === 1)
                {
                    $this->writeJson(Status::CODE_BAD_REQUEST,null,'该账号已被禁止登录');
                }else{
                    //更新用户的数据
                    $time = time();
                    $adminBean->restore(['admin_id' => $admin->getAdminId()]);
                    $sessionHash = md5($time.$admin->getAdminId());

                    $model->update($admin,[
                        'last_login_time' => $time,
                        'last_login_ip'   => $this->clientRealIP(),
                        'admin_session'  => $sessionHash
                    ]);
                    $admin = $admin->toArray(null,SplBean::FILTER_NOT_NULL);
                    unset($admin['admin_password']);
                    $admin['admin_session'] = $sessionHash;

                    var_dump($admin);

                    $this->response()->setCookie($this->sessionKey,$sessionHash,time() + 3600, '/');
                    $this->writeJson(Status::CODE_OK,$admin);
                }

            }else{
                $this->writeJson(Status::CODE_BAD_REQUEST,null,'账号或密码错误');
            }
       }else{
           //调用后过期
           $this->response()->setCookie('verifyCodeHash', null, -1);
           $this->response()->setCookie('verifyCodeTime', null, -1);
           $this->writeJson(Status::CODE_BAD_REQUEST, null, '验证码错误');
       }

    }
    public function logout()
    {
        $db = Mysql::defer('mysql');
        $model = new AdminModel($db);
        $admin = $this->who();
        $suc = $model->logout($admin);
        if($suc){
             $this->writeJson(Status::CODE_OK,null,'退出成功');
        }else{
            $this->writeJson(Status::CODE_BAD_REQUEST,null,'退出失败');
        }
    }
    public function getInfo()
    {
        $this->writeJson(Status::CODE_OK, $this->who(), '用户信息');
    }
}