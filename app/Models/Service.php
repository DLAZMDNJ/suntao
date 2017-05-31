<?php

namespace jamx\Models;

use Eloquent;

/**
 * 元模型
 *
 * @author king <king@jinsec.com>
 */
class Service extends Eloquent
{
    
    protected $table = 'saas_service';
    
    public $timestamps = false;  //关闭自动更新时间戳
    protected $guarded = array('_token');
    //protected $fillable = array('full_name');
    //protected $hidden = array('_token');
    
    public function customer() {
    	return $this->hasOne('jamx\Models\Customer', 'id', 'customer_id');
    }
}
