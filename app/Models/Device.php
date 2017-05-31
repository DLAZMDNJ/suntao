<?php

namespace jamx\Models;

use Eloquent;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class Device extends Mis
{

    protected $table = 'device';
    public $timestamps = false;  //关闭自动更新时间戳
    
    public function types() {
    	return $this->belongsTo('jamx\Models\Dict','type','id');
    }
    
    public function created_gids() {
    	return $this->belongsTo('jamx\Models\Channel','created_gid','channel_id');
    }
    
    public function belong_gids() {
    	return $this->belongsTo('jamx\Models\Channel','belong_gid','channel_id');
    }

}
