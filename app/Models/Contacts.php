<?php

namespace jamx\Models;

use Eloquent;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class Contacts extends Vmis
{

    protected $table = 'vmis_resume';
    public $timestamps = false;  //关闭自动更新时间戳

}
