<?php

namespace jamx\Models;

use Eloquent;

/**
 * 动态设置模型
 *
 * @author king <king@jinsec.com>
 */
class TextSingle extends Mis
{
    
    protected $table = 'text_single';
    protected $primaryKey = 'tid';
    public $timestamps = false;  //关闭自动更新时间戳
    
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