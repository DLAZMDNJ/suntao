<?php

namespace jamx\Http\Controllers;

use jamx\Http\Requests;
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Cache\DataCache as DataCache;
use jamx\Models\Content as Content;
use jamx\Models\Meta as Meta;
use Cache;
use jamx\Repositories\DictRepository;
use jamx\Repositories\FollowRepository;
use jamx\Repositories\InvestRepository;
use jamx\Repositories\WithdrawRepository;
use jamx\Repositories\AccountRepository;
use jamx\Repositories\Vmis\ArticleRepository;
use jamx\Http\Requests\LoginRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Session;

/**
 * 博客控制器
 * 用于前台博客展示
 *
 * @author king <king@jinsec.com>
 */
class IndexController extends VmisController
{
	private $dict;
	

    public function __construct(DictRepository $dict)
    {
        parent::__construct();
        if (!Cache::has('categories')) {  //如果分类缓存不存在
            DataCache::cacheCategories();
        }
        $categories = Cache::get('categories');

        //使用视图组件，传入头部导航数据
        view()->composer('widgets.bootstrapCategory', function ($view) use ($categories) {
            $view->with('categories', $categories);
        });

        view()->composer('widgets.bootstrapHeader', function ($view) {
            $topPage = Content::page()->take(3)->get();  //最多取得3个单页，以免撑爆导航栏
            $view->with('topPage', $topPage);
        });
        
        $this->dict = $dict;
        
        
    }

    
    public function index(Request $req)
    {
    	return redirect()->route('admin');
    	
    }
    
}
