<?php

namespace jamx\Models;

use Eloquent;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class Attach extends Vmis
{

    protected $table = 'vmis_attach';
    public $timestamps = false;  //关闭自动更新时间戳
    protected $guarded = array('_token');
}
