<?php

namespace jamx\Models;

use Eloquent;

/**
 * 元模型
 *
 * @author king <king@jinsec.com>
 */
class Resume extends Vmis
{
    
    protected $table = 'vmis_resume';
    
    public $timestamps = false;  //关闭自动更新时间戳
    protected $guarded = array('_token');
    
}
