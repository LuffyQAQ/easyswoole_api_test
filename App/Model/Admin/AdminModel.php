<?php
/**
 *
 * User: zs
 * Date: 2019/9/4 11:55
 * Email: <1769360227@qq.com>
 */

namespace App\Model\Admin;


use App\Model\BaseModel;
use EasySwoole\Spl\SplBean;

class AdminModel extends BaseModel
{
    protected $table = 'admin_list';
    protected $pk    = 'admin_id';

    //获取用户列表
    public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10 ): array
    {

        if (!empty($keyword)) {
            $this->getDb()->where('admin_name', '%' . $keyword . '%', 'like');
        }
        $list = $this->getDb()
            ->withTotalCount()
            ->orderBy($this->pk, 'DESC')
            ->get($this->table, [$pageSize * ($page - 1), $pageSize]);
        $total = $this->getDb()->getTotalCount();
        return ['total' => $total, 'list' => $list];
    }
    //根据session获取用户信息
    public function getOneBySession($session): ?AdminBean
    {
        $admin = $this->getDb()
                ->where('admin_session', $session)
                ->getOne($this->table);
        if(empty($admin)){
            return false;
        }

        return new AdminBean($admin);

    }
    //登录
    public function login(AdminBean $adminBean): ?AdminBean
    {
        $admin = $this->getDb()
            ->where('admin_account',$adminBean->getAdminAccount())
            ->where('admin_password',$adminBean->getAdminPassword())
            ->getOne($this->table);
        if(empty($admin))
        {
            return null;
        }

        return new AdminBean($admin);
    }
    //退出
    public function logout(AdminBean $adminBean): bool
    {
        return $this->getDb()->where($this->pk,$adminBean->getAdminId())->update($this->table,['admin_session'=> '']);
    }
    //查询一条数据
    public function find(AdminBean $adminBean) : ?AdminBean
    {
        $admin = $this->getDb()->where($this->pk,$adminBean->getAdminId())->getOne($this->table);
        if(empty($admin)){
            return null;
        }

        return new AdminBean($admin);
    }


    //添加数据
    public function add(AdminBean $adminBean): bool
    {
        return $this->getDb()->insert($this->table,$adminBean->toArray(null,SplBean::FILTER_NOT_NULL));
    }
    //更新数据
    public function update(AdminBean $adminBean,array $data): bool
    {
        if(empty($data)){
            return false;
        }
        return $this->getDb()->where('admin_id',$adminBean->getAdminId())->update($this->table,$data);
    }
    //删除数据
    public function delete(AdminBean $adminBean): bool
    {
        return $this->getDb()->where($this->pk,$adminBean->getAdminId())->delete($this->table);
    }



}