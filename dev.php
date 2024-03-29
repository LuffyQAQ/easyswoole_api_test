<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9502,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,
            'reload_async' => true,
            'max_wait_time'=>3
        ],
        'TASK'=>[
            'workerNum'=>4,
            'maxRunningNum'=>128,
            'timeout'=>15
        ]
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,

    'MYSQL'  => [
        'host'                  => '127.0.0.1',
        'port'                  => 3306,
        'user'                  => 'root',
        'password'              => 'Admin123.',
        'database'              => 'layui_easyswoole',
        'timeout'              => '5',//超时时间
        'connect_timeout'      => '5',//连接超时时间
        'charset'              => 'utf8mb4',
        'max_reconnect_times ' => '3',//最大重连次数
        'POOL_MAX_NUM'         => '20', //连接池最大连接数
        'POOL_TIME_OUT'        => '0.1',
    ]
];
