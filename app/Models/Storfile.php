<?php

namespace jamx\Models;

use Eloquent;

/**
 * 动态设置模型
 *
 * @author king <king@jinsec.com>
 */
class Storfile extends Mis
{
    
    protected $table = 'storfile';
    
    public $timestamps = false;  //关闭自动更新时间戳
    
    public function mn(){
    	return 'resource';
    }
    
    public function uids() {
    	return $this->belongsTo('jamx\Models\User','CamID','user_id');
    }
    
    public function gids() {
    	return $this->belongsTo('jamx\Models\Group','ChanID','group_id');
    }
    
}