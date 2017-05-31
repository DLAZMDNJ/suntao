<?php

namespace jamx\Http\Controllers;

use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use jamx\Events\UserLogin;
use jamx\Events\UserLogout;
use jamx\Repositories\UserRepository;
use jamx\Repositories\ConfigRepository;
use jamx\Repositories\ChannelRepository;

/**
 * 用户登录统一认证
 *
 * @author king <king@jinsec.com>
 */
class AuthorityController extends MisController
{

    /**
     * 添加路由过滤中间件
     */
    public function __construct(UserRepository $user,ConfigRepository $config,ChannelRepository $channel)
    {
        $this->middleware('visitor', ['except' => 'getLogout']);
        $this->user = $user;
        $this->config = $config;
        $this->channel = $channel;
    }

    public function getLogin()
    {
        return view('authority.login');
    }

    public function postLogin(Request $request)
    {

        //认证凭证
        $credentials = [
            'name' => $request->input('username'),
            'pw' => $request->input('password'),
            //'user_type' => 'Manager',
            //'state'=> 0,
        ];
        //
        if (Auth::attempt($credentials, $request->has('remember'))) {
        	
            event(new UserLogin(user('object')));  //触发登录事件
            session(['switch_uids'=>array()]);	//初始化；
            $this->user->switchj(user('object')->user_id);
            
            return redirect()->intended(route('admin'));
        } else {
            // 登录失败，跳回
            return redirect()->back()
                             ->withInput()
                             ->withErrors(array('attempt' => '“用户名”或“密码”错误，请重新登录！'));  //回传错误信息
        }
    }

    public function getLogout()
    {
        
        $user_id = user('object')->user_id;
        $perms = $this->user->perms($user_id);
        //print_r($perms);exit;
        foreach($perms as $v){
        	$k = 'gr_'.$v->name;
        	//echo $k;
        	session([$k=>'0']);
        }
        event(new UserLogout(user('object')));  //触发登出事件
        Auth::logout();
        return redirect()->to('/');
    }
}
