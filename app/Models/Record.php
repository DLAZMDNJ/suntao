<?php

namespace jamx\Models;

use Eloquent;

/**
 * 动态设置模型
 *
 * @author king <king@jinsec.com>
 */
class Record extends Mis
{
    
    protected $table = 'record';
    
    public $timestamps = false;  //关闭自动更新时间戳
    protected $primaryKey = 'vid';
    
    public function mn(){
    	return 'resource';
    }
    
    public function uids() {
    	return $this->belongsTo('jamx\Models\User','usrid','user_id');
    }
    
    public function gids() {
    	return $this->belongsTo('jamx\Models\Group','groupid','group_id');
    }
    
}