<?php
/**
 *
 * User: zs
 * Date: 2019/9/5 14:51
 * Email: <1769360227@qq.com>
 */

namespace App\HttpController\Api\Admin;


class AdminMenu extends AdminBase
{
    public function index()
    {
        $icoList = [
            'home'   => 'layui-icon-home',
            'temp'   => 'layui-icon-template',
            'app'    => 'layui-icon-app',
            'set'    => 'layui-icon-set',
            'anz'    => 'layui-icon-auz',
            'senior' => 'layui-icon-senior',
            'list'   => 'layui-icon-list',

            'chain'   => 'layui-icon-template',
            'shop'   => 'layui-icon-app',
            'staff'   => 'layui-icon-group',
            'maintenanceWorker'   => 'layui-icon-set-fill',
            'drug'   => 'layui-icon-auz',
            'users'   => 'layui-icon-user',
            'repository'   => 'layui-icon-diamond',
            'cabinetType'   => 'layui-icon-template-1',


        ];
        $menuList = [
            [
                'title' => "数据概览",
                "icon"  => $icoList['home'],
                "list"  => [
                    [ "title" => "统计中心", "jump" => "/" ],
                    [ "title" => "demo", "jump" => "/demo/list" ],
                ]
            ],
            [
                'title' => "系统设置",
                "icon"  => $icoList['set'],
                "list"  => [
                    [ "title" => "后台用户", "jump" => "/admin/list" ],
                ]
            ],
        ];
        $this->writeJson(200, $menuList,'请求成功');
    }
}