<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests;
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use jamx\Cache\SettingCache as SettingCache;
use jamx\Repositories\LogRepository;

/**
 * 系统日志控制器
 *
 * @author king <king@jinsec.com>
 */
class LogController extends BackController
{

    /**
     * The SettingRepository instance.
     *
     * @var jamx\Repositories\SystemLogRepository
     */
    protected $log;

    public function __construct(
        LogRepository $log)
    {
        parent::__construct();
        $this->repo = $log;
        
        if (! user('object')->can('manage_system')) {
            $this->middleware('deny403');
        }
    }
    


}
