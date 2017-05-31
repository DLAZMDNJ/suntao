<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Cache\ConfigCache;
use jamx\Repositories\ConfigRepository;

/**
 * 系统配置控制器
 *
 * @author king <king@jinsec.com>
 */
class ConfigController extends BackController
{

    /**
     * The SettingRepository instance.
     *
     * @var jamx\Repositories\SettingRepository
     */
    protected $option;

    public function __construct(
        ConfigRepository $option)
    {
        parent::__construct();
        $this->option = $option;
        
        if (! user('object')->can('manage_system')) {
            $this->middleware('deny403');
        }
    }

    public function getIndex()
    {
        //
        $system_options = $this->option->index();
        foreach ($system_options as $so) {
            $data[$so['name']] = $so['value'];
        }
        $mn = 'config';

        return view('admin.config.index', compact('data','mn'));
    }


    public function putUpdate(Request $request)
    {
        $data = $request->input('data');
        if ($data && is_array($data)) {
            $this->option->batchUpdate($data);
            //更新系统静态缓存
            ConfigCache::cacheStatic();
            return redirect()->route('admin.config.index')->with('message', '成功更新系统配置！');
        } else {
            return redirect()->back()->with('fail', '提交过来的数据异常！');
        }
    }
}
