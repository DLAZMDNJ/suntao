<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
#Laravel 5.1 默认路由
Route::get('/', function () {
    return view('welcome');
});
*/

//added some test routes


#对后台开启csrf过滤
Route::when('admin/*', 'csrf', ['post','delete','put']);

/*
|--------------------------------------------------------------------------
| 基础权限 登录注册找回密码等操作
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
	$Authority = 'AuthorityController@';
	# 退出
	Route::get('logout', ['as' => 'logout', 'uses' => $Authority.'getLogout']);
	# 登录
	Route::get('login', ['as' => 'login', 'uses' => $Authority.'getLogin']);
	Route::post('login', $Authority.'postLogin');
});

/*
Route::group(['prefix' => 'saas', 'middleware' => 'admin'], function () {
	
	Route::resource('customer','jamx\CustomerController');
	Route::resource('account','jamx\AccountController');
	Route::resource('service','jamx\ServiceController');
	Route::resource('dict','jamx\DictController');
	
});*/
/*
|--------------------------------------------------------------------------
| 管理员后台 实现文章和用户等管理操作
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

# 后台首页
	$Admin = 'AdminController@';
	# 访问后台首页 会 重定向至 后台控制台概要页面 （在控制器方法getIndex中处理）
	Route::get('/', ['as' => 'admin', 'uses' => $Admin.'getIndex']);
	
	Route::get('/ice/printer', ['as' => 'admin.ice.printer', 'uses' => 'Admin\IceController@printer']);
	Route::get('/ice/test', ['as' => 'admin.ice.printer', 'uses' => 'Admin\IceController@test']);


# 后台上传图片文件layer
	Route::get('/upload', ['as' => 'admin.upload', 'uses' => $Admin.'getUpload']);
	Route::post('/upload', ['as' => 'admin.upload.store', 'uses' => $Admin.'postUpload']);

#重建缓存（更新内容或者刚安装完本CMS之后，如果数据显示异常，请点击后台导航中“重建缓存”链接）
	Route::get('/cache', ['as' => 'admin.cache', 'uses' => $Admin.'getRebuildCache']);

#--------------------
# 控制台 START
#--------------------

	Route::group(['prefix' => 'console'], function (){
		$resource = 'admin.console';
		$controller = 'Admin\AdminConsoleController@';
		Route::get( '/', ['as' => $resource.'.index', 'uses' => $controller.'getIndex']);
		
	});

#--------------------
# 控制台 END
#--------------------


#--------------------
# 内容管理 START
#--------------------

	# 文章
	Route::resource('article', 'Admin\AdminArticleController');
	
	# 单页
	Route::resource('page', 'Admin\AdminPageController');
	
	#碎片
	Route::resource('fragment', 'Admin\AdminFragmentController');
	
	# 分类
	Route::resource('category','Admin\AdminCategoryController');

	# 标签
	Route::resource ('tag','Admin\AdminTagController');
	
	

#--------------------
# 内容管理 END
#--------------------

#--------------------
# 用户管理 START
#--------------------
	#我的账户
	Route::get('/profile', ['as'=>'admin.profile.index', 'uses'=>'Admin\AdminMeController@getIndex']);
	Route::put('/profile', ['as'=>'admin.profile.update', 'uses'=>'Admin\AdminMeController@putUpdate']);
/*
	#管理型用户
	Route::group( ['prefix' => 'user'], function () {
		$resource = 'admin.user';
		$controller = 'Admin\UserController@';
		Route::get( '/', ['as' => $resource.'.index', 'uses' => $controller.'index'] );  //管理型用户列表
		Route::get( 'create', ['as' => $resource.'.create', 'uses' => $controller.'create'] );  //新增管理型用户
		Route::post( '/', ['as' => $resource.'.store', 'uses' => $controller.'store'] );  //post处理提交数据
		Route::get( '{id}', ['as' => $resource.'.show', 'uses' => $controller.'show'] );  //展示管理型用户个人基础信息
		Route::get('{id}/edit', ['as' => $resource.'.edit', 'uses' => $controller.'edit'] );  //修改管理型用户信息
		Route::put( '{id}', ['as' => $resource.'.update', 'uses' => $controller.'update'] );  //put更新管理型用户信息
	});
*/
	Route::get('/user/restore', ['as'=>'admin.user.restore', 'uses'=>'Admin\UserController@restore']);
	Route::get('/user/channel', ['as'=>'admin.user.channel', 'uses'=>'Admin\UserController@channel']);
	Route::get('/user/device', ['as'=>'admin.user.device', 'uses'=>'Admin\UserController@device']);
	Route::get('/user/bind', ['as'=>'admin.user.bind', 'uses'=>'Admin\UserController@bind']);
	Route::get('/user/switch', ['as'=>'admin.user.switch', 'uses'=>'Admin\UserController@switchj']);
	Route::get('/user/unique', ['as'=>'admin.user.unique', 'uses'=>'Admin\UserController@unique']);
	Route::resource('user', 'Admin\UserController');
	#角色
	Route::resource('role', 'Admin\RoleController');

	#权限
	Route::get('/permission', ['as' => 'admin.permission.index', 'uses' => 'Admin\PermissionController@index']);
#--------------------
# 用户管理 END
#--------------------

#--------------------
# 业务管理 START
#--------------------

	#首页
	//Route::get('/business', ['as' => 'admin.business.index', 'uses' => 'Admin\AdminBusinessController@getIndex']);
	
	#流程
	//Route::get('/flow', ['as' => 'admin.flow','uses' => 'Admin\AdminBusinessController@getFlow']);
	Route::get('/channel/restore', ['as'=>'admin.channel.restore', 'uses'=>'Admin\ChannelController@restore']);
	Route::get('/channel/user', ['as'=>'admin.channel.user', 'uses'=>'Admin\ChannelController@user']);	//绑定用户
	Route::get('/channel/admin', ['as'=>'admin.channel.admin', 'uses'=>'Admin\ChannelController@admin']);	//绑定管理员
	Route::get('/channel/device', ['as'=>'admin.channel.device', 'uses'=>'Admin\ChannelController@device']);
	Route::get('/channel/bind', ['as'=>'admin.channel.bind', 'uses'=>'Admin\ChannelController@bind']);
	Route::resource('channel', 'Admin\ChannelController');
	
	Route::get('/device/restore', ['as'=>'admin.device.restore', 'uses'=>'Admin\DeviceController@restore']);
	Route::get('/device/user', ['as'=>'admin.device.user', 'uses'=>'Admin\DeviceController@user']);	//绑定用户
	Route::get('/device/channel', ['as'=>'admin.device.channel', 'uses'=>'Admin\DeviceController@channel']);//绑定编组
	Route::get('/device/bind', ['as'=>'admin.device.bind', 'uses'=>'Admin\DeviceController@bind']);
	Route::resource('device', 'Admin\DeviceController');

	Route::get('/resource/index/{type}', ['as'=>'admin.resource.type', 'uses'=>'Admin\ResourceController@index']);
	Route::get('/resource/download', ['as'=>'admin.resource.download', 'uses'=>'Admin\ResourceController@download']);
	Route::resource('resource', 'Admin\ResourceController');
	
	Route::resource('dict','Admin\DictController');
	Route::get('/dynamic/channel', ['as'=>'admin.dynamic.channel', 'uses'=>'Admin\DynamicController@channel']);
	Route::get('/dynamic/device', ['as'=>'admin.dynamic.device', 'uses'=>'Admin\DynamicController@device']);
	Route::get('/dynamic/html', ['as'=>'admin.dynamic.html', 'uses'=>'Admin\DynamicController@html']);
	Route::resource('dynamic','Admin\DynamicController');

	Route::resource('setting', 'Admin\SettingController');  //动态设置
	Route::resource('setting_type','Admin\SettingTypeController');  //动态设置分组

	#静态系统配置
	Route::get('/config', ['as'=>'admin.config.index', 'uses'=>'Admin\ConfigController@getIndex']);
	Route::put('/config', ['as'=>'admin.config.update', 'uses'=>'Admin\ConfigController@putUpdate']);

	#系统日志
	Route::resource('log', 'Admin\LogController');  //系统日志
});



/*
|--------------------------------------------------------------------------
| 前台
|--------------------------------------------------------------------------
*/

Route::group(array(), function () {
	$index = 'IndexController@';

	# 前台首页
	Route::get('/', ['as' => 'index', 'uses' => $index.'index']);
	
});

