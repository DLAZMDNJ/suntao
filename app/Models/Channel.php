<?php

namespace jamx\Models;

use Eloquent;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class Channel extends Mis
{

    protected $table = 'channels';
    protected $primaryKey = 'channel_id';
    public $timestamps = false;  //关闭自动更新时间戳

    
    public function mn(){
    	$table = $this->table;
    	$mn = substr($table,0,7);
    	return $mn;
    }
    
    public function parent_ids() {
    	return $this->belongsTo('jamx\Models\Channel','parent_id','channel_id');
    }
    
    public function types() {
    	return $this->belongsTo('jamx\Models\Dict','type','id');
    }
    
    public function created_uids() {
    	return $this->belongsTo('jamx\Models\User','created_uid','user_id');
    }
    
    public function created_gids() {
    	return $this->belongsTo('jamx\Models\Channel','created_gid','channel_id');
    }
    
}
