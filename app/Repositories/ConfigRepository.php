<?php

namespace jamx\Repositories;

use jamx\Models\Config;

/**
 * 系统配置仓库SystemOptionRepository
 *
 * @author raoyc<king@jinsec.com>
 */
class ConfigRepository extends MisRepository
{

    /**
     * The SystemOption instance.
     *
     * @var jamx\Models\SystemOption
     */
    protected $option;

    /**
     * Create a new SystemOptionRepository instance.
     *
     * @param  jamx\Models\SystemOption $option
     * @return void
     */
    public function __construct(
        Config $option)
    {
        $this->model = $option;
    }

    /**
     * 获取所有系统配置数据
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        $options = $this->model->all();
        return $options;
    }

    /**
     * 批量更新系统配置
     *
     * @param  array $data
     * @return void
     */
    public function batchUpdate($data)
    {
        $option = new $this->model;
        foreach ($data as $name=>$value) {
            $map = [
                'name' => $name
            ];
            $option->where($map)->update(['value' => e($value)]);
        }
    }

    /**
     * 系统配置资源列表数据
     * 注：暂使用all()返回所有角色数据，不进行分页与搜索处理
     *
     * @param  array $data
     * @param  array|string $extra
     * @param  string $size 分页大小
     * @return Illuminate\Support\Collection
     */
    public function index($data = [], $extra = '', $size = '10')
    {
        return $this->all();
    }

    //
    public function get($name){
    	$my = $this->model()->where('name',$name)->first();
    	return $my->value;
    }
}
