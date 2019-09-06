<?php
/**
 *
 * User: zs
 * Date: 2019/9/4 11:49
 * Email: <1769360227@qq.com>
 */

namespace App\Model;


use EasySwoole\Mysqli\Mysqli;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct(Mysqli $db)
    {
        $this->db = $db;
    }

    public function getDb(): Mysqli
    {
        return  $this->db;
    }
}