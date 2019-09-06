<?php
/**
 *
 * User: zs
 * Date: 2019/9/4 11:18
 * Email: <1769360227@qq.com>
 */

namespace App\Model\Admin;


use EasySwoole\Spl\SplBean;

class AdminBean extends SplBean
{
    protected $admin_id;
    protected $admin_name;           // 用户名
    protected $admin_account;        // 账号
    protected $admin_password;       // 密码
    protected $admin_session;        // 会话信息
    protected $last_login_ip;         // 最后一次登录ip
    protected $last_login_time;       // 最后一次登录时间
    protected $add_time;             // 添加时间
    protected $is_forbid;

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param mixed $admin_id
     */
    public function setAdminId($admin_id): void
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return mixed
     */
    public function getAdminName()
    {
        return $this->admin_name;
    }

    /**
     * @param mixed $admin_name
     */
    public function setAdminName($admin_name): void
    {
        $this->admin_name = $admin_name;
    }

    /**
     * @return mixed
     */
    public function getAdminAccount()
    {
        return $this->admin_account;
    }

    /**
     * @param mixed $admin_account
     */
    public function setAdminAccount($admin_account): void
    {
        $this->admin_account = $admin_account;
    }

    /**
     * @return mixed
     */
    public function getAdminPassword()
    {
        return $this->admin_password;
    }

    /**
     * @param mixed $admin_password
     */
    public function setAdminPassword($admin_password): void
    {
        $this->admin_password = $admin_password;
    }

    /**
     * @return mixed
     */
    public function getAdminSession()
    {
        return $this->admin_session;
    }

    /**
     * @param mixed $admin_session
     */
    public function setAdminSession($admin_session): void
    {
        $this->admin_session = $admin_session;
    }

    /**
     * @return mixed
     */
    public function getLastLoginIp()
    {
        return $this->last_login_ip;
    }

    /**
     * @param mixed $last_login_ip
     */
    public function setLastLoginIp($last_login_ip): void
    {
        $this->last_login_ip = $last_login_ip;
    }

    /**
     * @return mixed
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time;
    }

    /**
     * @param mixed $last_login_time
     */
    public function setLastLoginTime($last_login_time): void
    {
        $this->last_login_time = $last_login_time;
    }

    /**
     * @return mixed
     */
    public function getAddTime()
    {
        return $this->add_time;
    }

    /**
     * @param mixed $add_time
     */
    public function setAddTime($add_time): void
    {
        $this->add_time = $add_time;
    }

    /**
     * @return mixed
     */
    public function getIsForbid()
    {
        return $this->is_forbid;
    }

    /**
     * @param mixed $is_forbid
     */
    public function setIsForbid($is_forbid): void
    {
        $this->is_forbid = $is_forbid;
    }





}