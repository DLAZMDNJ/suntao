<?php

namespace jamx\Models;

use Eloquent;

/**
 * 元模型
 *
 * @author king <king@jinsec.com>
 */
class Dict extends Mis
{
    
    protected $table = 'admin_dict';
    
    public $timestamps = false;  //关闭自动更新时间戳

/*
    #********
    #* 此表为复合型的元（Meta）数据表，根据type不同确定不同元模型
    #* type : CATEGORY 分类
    #* type : TAG 标签
    #********
    //限定分类
    public function scopeCategory($query)
    {
        return $query->where('type', '=', 'category');
    }
    //限定标签
    public function scopeTag($query)
    {
        return $query->where('type', '=', 'tag');
    }
*/
    /**
     * 内容
     * 模型对象关系：分类对应的文章内容[一个分类下可以多篇文章]
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo('jamx\Models\Content', 'id', 'category_id');
    }
    
    public function devices() {
    	return $this->belongsTo('jamx\Models\Device','id','type');
    }
    
    public function channels() {
    	return $this->belongsTo('jamx\Models\Channel','channel_id','type');
    }
}
