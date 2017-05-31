<?php

namespace jamx\Models;

use Eloquent;

/**
 * 系统日志模型
 *
 * @author king <king@jinsec.com>
 */
class Log extends Mis
{

    protected $table = 'admin_log';
    
    protected $fillable = array('user_id', 'type', 'url', 'content', 'operator_ip');

     /**
     * 操作用户
     * 模型对象关系：系统日志对应的操作用户
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('jamx\Models\User', 'user_id', 'user_id');
    }
    
    public function uids()
    {
    	return $this->belongsTo('jamx\Models\User', 'user_id', 'user_id');
    }
}
