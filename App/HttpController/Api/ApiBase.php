<?php


namespace App\HttpController\Api;


use App\Service\ServiceException;
use EasySwoole\EasySwoole\Core;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Trigger;
use EasySwoole\Http\AbstractInterface\AnnotationController;
use EasySwoole\Http\Exception\ParamAnnotationValidateError;
use EasySwoole\Http\Message\Status;

abstract class ApiBase extends AnnotationController
{
    public function index()
    {
        // TODO: Implement index() method.
        $this->actionNotFound('index');
    }

    protected function actionNotFound(?string $action): void
    {
        $this->writeJson(Status::CODE_NOT_FOUND);
    }

    protected function onException(\Throwable $throwable): void
    {
        if ($throwable instanceof ParamAnnotationValidateError){
            $msg = $throwable->getValidate()->getError()->getErrorRuleMsg();
            $this->writeJson(Status::CODE_BAD_REQUEST,null,$msg);
        }elseif ($throwable instanceof ServiceException){
            $this->writeJson(Status::CODE_BAD_REQUEST, null,$throwable->getMessage());
        }else{
            if(Core::getInstance()->isDev()){
                $this->writeJson(Status::CODE_INTERNAL_SERVER_ERROR,null,$throwable->getMessage() . " at file {$throwable->getFile()} line {$throwable->getLine()}");
            }else{
                Trigger::getInstance()->throwable($throwable);
                $this->writeJson(Status::CODE_INTERNAL_SERVER_ERROR,null,'内部服务器错误');
            }
        }


    }
    /**
     * 获取用户的get/post的一个值,可设定默认值
     * input
     * @param      $key
     * @param null $default
     * @return array|mixed|null
     * @author Tioncico
     * Time: 17:27
     */
    protected function input($key, $default = null)
    {
        $value = $this->request()->getRequestParam($key);
        return $value ?? $default;
    }

    /**
     * 获取用户的真实IP
     * @param string $headerName 代理服务器传递的标头名称
     * @return string
     */
    protected  function clientRealIP($headerName = 'x-real-ip')
    {
        $serv = ServerManager::getInstance()->getSwooleServer();
        $client = $serv->getClientInfo($this->request()->getSwooleRequest()->fd);
        $clientAddress = $client['remote_ip'];
        $xri = $this->request()->getHeader($headerName);
        $xff = $this->request()->getHeader('x-forwarded-for');
        if ($clientAddress === '127.0.0.1'){
            if (!empty($xri)) {  // 如果有xri 则判定为前端有NGINX等代理
                $clientAddress = $xri[0];
            } elseif (!empty($xff)) {  // 如果不存在xri 则继续判断xff
                $list = explode(',', $xff[0]);
                if (isset($list[0])) $clientAddress = $list[0];
            }
        }
        return  $clientAddress;
    }
}