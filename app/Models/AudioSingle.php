<?php

namespace jamx\Models;

use Eloquent;

/**
 * 
 * 
 *
 * @author king <king@jinsec.com>
 */
class AudioSingle extends Mis
{

    protected $table = 'audio_single';
    public $timestamps = false;  //关闭自动更新时间戳
    protected $primaryKey = 'vid';
    
    public function mn(){
    	return 'resource';
    }
    
    
    
    public function oids() {
    	return $this->belongsTo('jamx\Models\User','oid','user_id');
    }
    public function iids() {
    	return $this->belongsTo('jamx\Models\User','iid','user_id');
    }

}
