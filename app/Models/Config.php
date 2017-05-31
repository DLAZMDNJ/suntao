<?php

namespace jamx\Models;

use Eloquent;

/**
 * 系统配置模型
 *
 * @author king <king@jinsec.com>
 */
class Config extends Eloquent
{
    
    protected $table = 'admin_config';
    
    public $timestamps = false;  //关闭自动更新时间戳
}
