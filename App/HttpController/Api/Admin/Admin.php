<?php
/**
 *
 * User: zs
 * Date: 2019/9/4 9:22
 * Email: <1769360227@qq.com>
 */

namespace App\HttpController\Api\Admin;


use App\Model\Admin\AdminBean;
use App\Model\Admin\AdminModel;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Spl\SplBean;

class Admin extends AdminBase
{
    /**
     * 获取用户数据列表
     * @Param(name="page", alias="页数", optional="", integer="")
     * @Param(name="limit", alias="每页数量", optional="", lengthMax="3", integer="")
     * @Param(name="keyword", alias="关键字", optional="", lengthMax="64")
     */
    public function index()
    {


        $db = Mysql::defer('mysql');
        $page = (int)$this->input('page', 1);
        $limit = (int)$this->input('limit', 20);
        $keyword = $this->input('keyword');
        $model = new AdminModel($db);
        $data = $model->getAll($page, $keyword, $limit);
        $this->writeJson(Status::CODE_OK, $data, '查询成功');
    }

    /**
     * 添加数据
     * @Param(name="admin_account",alias="管理员账号",required="")
     * @Param(name="admin_password",alias="管理员密码",required="",lengthMin="6",lengthMax="16")
     * @Param(name="admin_name",alias="管理员名称",required="")
     * @Param(name="is_forbid",alias="状态",optional="",inArray="{0,1}")
     * @return bool
     */
    public function add()
    {

        $param = $this->request()->getRequestParam();

        $adminBean = new AdminBean($param);

        $adminBean->setAdminPassword(md5($param['admin_password']));
        $adminBean->setAddTime(time());
        $adminBean->setLastLoginIp($this->clientRealIP());
        $db = Mysql::defer('mysql');
        $adminModel = new AdminModel($db);
        $suc = $adminModel->add($adminBean);
        if($suc){
            return $this->writeJson(Status::CODE_OK,$suc,'插入数据成功');
        }
        return $this->writeJson(Status::CODE_BAD_REQUEST,'','插入数据失败');

    }

    /**
     * 更新数据
     * @Param(name="admin_name",alias="名称",required="")
     * @Param(name="admin_password",alias="密码",optional="",lengthMin="6",lengthMax="16")
     * @Param(name="is_forbid",alias="状态",optional="",inArray="{0,1}")
     * @return bool
     */
    public function update()
    {
        $db = Mysql::defer('mysql');
        $model = new AdminModel($db);
        $param = $this->request()->getRequestParam();
        $admin = $model->find(new AdminBean(['admin_id' => $param['admin_id']]));
        if(empty($admin)){
            $this->writeJson(Status::CODE_BAD_REQUEST,null,'数据不存在');
            return false;
        }

        $adminBean = new AdminBean();
        $adminBean->setAdminName($param['admin_name'] ?? $admin->getAdminName());
        $adminBean->setAdminPassword(isset($param['admin_password']) ? md5($param['admin_password']) : $admin->getAdminPassword());
        $adminBean->setIsForbid($param['is_forbid'] ?? $admin->getIsForbid());

        $data = $adminBean->toArray(null,SplBean::FILTER_NOT_NULL);

        $suc = $model->update($admin,$data);
        if($suc){
            $this->writeJson(Status::CODE_OK, null, "更新成功");
        }else{
            $this->writeJson(Status::CODE_BAD_REQUEST,null,$db->getLastError());
        }


    }

    /**
     * 删除数据
     * @Param(name="admin_id",alias="用户Id",required="")
     */
    public function delete()
    {
        $param = $this->request()->getRequestParam();
        $db = Mysql::defer('mysql');
        $model = new AdminModel($db);
        $adminBean = new AdminBean(['admin_id' =>$param['admin_id'] ]);
        $suc = $model->delete($adminBean);
        if($suc){
            $this->writeJson(Status::CODE_OK,null,'删除成功');
        }else{
            $this->writeJson(Status::CODE_BAD_REQUEST,null,$db->getLastError());
        }
    }
}