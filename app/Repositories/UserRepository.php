<?php

namespace jamx\Repositories;

use jamx\Models\User;
use jamx\Models\Role;
use DB;
use jamx\Models\Config;
use jamx\Models\Channel;

/**
 * 用户仓库UserRepository
 *
 * @author raoyc<king@jinsec.com>
 */
class UserRepository extends MisRepository
{
     public function __construct(
        User $user,
        Role $role,Config $config,Channel $channel)
    {
        $this->model = $user;
        $this->user = $user;
        $this->role = $role;
        $this->config = $config;
        $this->channel = $channel;
    }

    /**
     * 存储管理型用户
     *
     * @param  jamx\Models\User $manager
     * @param  array $inputs
     * @return jamx\Models\User
     */
    /*
    private function saveManager($manager, $inputs)
    {
        $manager->username = $manager->nickname = e($inputs['username']);
        $manager->password = bcrypt(e($inputs['password']));
        $manager->email = e($inputs['email']);
        $manager->realname = e($inputs['realname']);
        $manager->user_type = 'manager';  //管理型用户
        $manager->confirmation_code = md5(uniqid(mt_rand(), true));
        $manager->confirmed = true;  //确定用户已被验证激活

        if ($manager->save()) {
            $manager->roles()->attach($inputs['role']);  //附加上用户组（角色）
        }

        return $manager;
    }*/


    /**
     * 更新管理型用户
     *
     * @param  jamx\Models\User $manager
     * @param  array $inputs
     * @return void
     */
    /*
    private function updateManager($manager, $inputs)
    {
        $manager->nickname = e($inputs['nickname']);
        $manager->realname = e($inputs['realname']);
        $manager->is_lock = e($inputs['is_lock']);
        if ((!empty($inputs['password'])) && (!empty($inputs['password_confirmation']))) {
            $manager->password = bcrypt(e($inputs['password']));
        }
        if ($manager->save()) {

            //确保一个管理型用户只拥有一个角色
            $roles = $manager->roles;
            if ($roles->isEmpty()) {  //判断角色结果集是否为空
                $manager->roles()->attach($inputs['role']);  //空角色，则直接同步角色
            } else {
                if (is_array($roles)) {
                    //如果为对象数组，则表明该管理用户拥有多个角色
                    //则删除多个角色，再同步新的角色
                    $manager->detachRoles($roles);
                    $manager->roles()->attach($inputs['role']);  //同步角色
                } else {
                    if ($roles->first()->id !== $inputs['role']) {
                        $manager->detachRole($roles->first());
                        $manager->roles()->attach($inputs['role']);  //同步角色
                    }
                }
            }
            //上面这一大段代码就是保证一个管理型用户只拥有一个角色
            //Entrust扩展包自身是支持一个用户拥有多个角色的，但在本内容管理框架系统中，限定一个用户只能拥有一个角色
        }
    }*/

    /**
     * 获取所有角色(用户组)
     *
     * @return Illuminate\Support\Collection
     */
    /*
    public function role()
    {
        return $roles = $this->role->all();
    }*/

    /**
     * 获取用户角色
     *
     * @param  jamx\Models\User
     * @return Illuminate\Support\Collection
     */
    /*
    public function getRole($my)
    {
        return $my->roles->first();
    }*/

    /**
     * 伪造一个id为0的Role对象
     *
     * @return jamx\Models\Role
     */
    /*
    public function fakeRole()
    {
        $role = new $this->role;
        $role->id = 0;  //id置为不存在的0
        return $role;
    }*/

    /**
     * 获取特定id管理员信息
     * 
     * @param  int $id
     * @return jamx\Models\User
     */
    
    public function manager($id)
    {
        return $this->model->manager()->where(array('user_id'=>$id))->first();
    }
    
    //关键词搜索
    protected function list_search_sk_names($req){
    	return array('name','nick');
    }
    
    /*
    protected function list_where_raw($req){
    	$rtn = array();
    	if(isset($req->s_key) && $req->s_key!=''){
    		$sk = $req->s_key;
    		$rtn[] = "name like '%$sk%' or nick like '%$sk%'";
    		session(['s_key'=>$sk]);
    	}else{
    		session(['s_key'=>'']);
    	}
    	
    	return $rtn;
    }*/
    /*
    protected function pre_store($data){
    	$data['created_gid'] = session('gcid');
    	$data['server_id'] = $this->sid();
    	return $data;
    }*/
    
    
    
    public function fill_data($model,$inputs){
    	parent::fill_data($model, $inputs);
    	//密码只有在输入的时候采更新；
    	$password = $inputs['password'];
    	if($password!='******'){
    		$model->pw = sha1($password);
    	}
    	//created_gid为管理员所负责的编组id:		修改为可以选择创建编组
    	$model->created_gid = session('gcid');
    	$model->ctime = time();
    	$model->server_id = $this->server_id;
    }
    
    
    protected function post_store($model,$inputs){
    	//处理角色；
    	if(isset($inputs['roles'])){
    		$roles = $inputs['roles'];
    		foreach($roles as $role_id){
    			DB::table('admin_role_user')->insert(array('user_id'=>$model->user_id,'role_id'=>$role_id));
    		}
    	}else{
    		$role_id = $inputs['role_id'];
    		DB::table('admin_role_user')->insert(array('user_id'=>$model->user_id,'role_id'=>$role_id));
    	}
    	
    	//同步
    	if(session('gc_old_version')){
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'2','value'=>$model->description));
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'7','value'=>'0'));
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'8','value'=>'-1'));
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'9','value'=>'1'));
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'12','value'=>$role_id));
    		DB::table('user_info')->insert(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'13','value'=>'-1'));
    	}
    	

    	
    	
    }
    
	public function update($id, $inputs,$extra=''){
		$model = $this->model->findOrFail($id);
		$old_pw = $model->pw;
		$arr = $model->get();
		$model->fill($inputs);
		$password = $inputs['password'];
		
		if($password != "******"){
			$model->pw = sha1($password);
		}else{
			$model->pw = $old_pw;
		}
		//echo $password.';;';echo $old_pw.';';echo $model->pw;exit;
		$model->save();
		//处理角色；
		DB::table('admin_role_user')->where('user_id',$model->user_id)->delete();
		if(isset($inputs['roles'])){
			$roles = $inputs['roles'];
			foreach($roles as $role_id){
				DB::table('admin_role_user')->insert(array('user_id'=>$model->user_id,'role_id'=>$role_id));
			}
		}else{
			$role_id = $inputs['role_id'];
			DB::table('admin_role_user')->insert(array('user_id'=>$model->user_id,'role_id'=>$role_id));
		}
		
		//
		DB::table('user_info')->where(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'2'))->update(array('value'=>$model->description));
		DB::table('user_info')->where(array('server_id'=>session('gsid'),'user_id'=>$model->user_id,'key'=>'12'))->update(array('value'=>$role_id));
		

		return $model;
	}
	
	protected function pre_destroy($model){
		$model->update(array('state'=>-4,'is_delete'=>1));
	
		
		//根据状态判断是否是真删
    	$force = session($this->mn().'_delete_force');
    	if($force=='1'){
    		return true;
    	}else{
    		return false;
    	}
	}
    
	protected function post_destroy($model){
		//删除对应关系
		$uid = $model->user_id;
		//DB::table('admin_role_user')->where('user_id',$model->user_id)->delete();
		//删除对应关系前，需要先发送解绑消息
		$t_list = DB::table('channel_administrators')->where('uid',$uid)->get();
		foreach ($t_list as $v){
			$cid = $v->cid;
			$arr['cid'] = $cid;
			$arr['uid'] = $uid;
			
			
			DB::table('channel_administrators')->where('uid',$uid)->where('cid',$cid)->delete();
		}
		$t_list = DB::table('channel_users')->where('uid',$uid)->get();
		foreach ($t_list as $v){
			$cid = $v->cid;
			$arr['cid'] = $cid;
			$arr['uid'] = $uid;
		
			DB::table('channel_users')->where('uid',$uid)->where('cid',$cid)->delete();
		}
		//设备暂时不用
		DB::table('user_devices')->where('uid',$uid)->delete();
		
	}
	
	public function perms($user_id){
		//判断当前用户是否是 
		$perms = DB::table('admin_role_user')->join('admin_permission_role',function($join){
			$join->on('admin_role_user.role_id','=','admin_permission_role.role_id');
		})->join('admin_permissions',function($join){
			$join->on('admin_permissions.id','=','admin_permission_role.permission_id');
		});
		if($user_id){
			$perms = $perms->where('user_id',$user_id);
		}
		$perms = $perms->get();
	
		return $perms;
	}
	
	public function permsIds($user_id){
		$perms = $this->perms($user_id);
		$rtn = array();
		foreach($perms as $v){
			$rtn[] = $v->id;
		}
		return $rtn;
	}
	
	public function restore($id){
		$model = $this->model->find($id);
		$model->update(array('state'=>0,'is_delete'=>'0'));
		//恢复删除后，重新发送新增消息；
	
	}
	
	//获得当前用户的 channel id
	public function cid($type){
		$user_id = session('guid');
		if($type=='user'){
			$cid = array();
			$data = DB::table('channel_users')->where('uid',$user_id)->get();
			foreach($data as $v){
				$cid[] = $v->cid;
			}
		}else{
			$cid = 0;
			$data = DB::table('channel_administrators')->where('uid',$user_id)->first();
			if($data){
				$cid = $data->cid;
			}
		}
		
		return $cid;
	}
	
	public function list_render_names($req){
		return array('name','is_delete','description','nick','ctime','role_id','state','id','is_delete');
	}
	
	public function list_search_names($req){
		return array('type','is_delete');
	}
	
	public function list_search_like_names($req){
		return array('name','nick','description');
	}
	
	protected function list_where_raw($req){
		$rtn = array();
		$uid = session('guid');
		$user = session('guser');
		$belong_gid = $user->belong_gid;
		//
		$arr_uid = array();
		foreach($arr_uid as $name){
			$v = $req->$name;
			if($v){
				$rtn[] = $name." in (select user_id from users where nick like '%$v%')";
				session(['s_'.$name=>$v]);
			}else{
				session(['s_'.$name=>'']);
			}
		}
		//
		$name = 'role_id';
		$v = $req->$name;
		if($v){
			$rtn[] = "user_id in (select user_id from admin_role_user where role_id= $v)";
			session(['s_'.$name=>$v]);
		}else{
			session(['s_'.$name=>'']);
		}
		 
		//
		$arr_time = array('ctime');
		foreach($arr_time as $n){
			$name = $n.'1';
			$v = $req->$name;
			if($v){
				$vv = $v.' 00:00:00';
				$rtn[] = $n." > '$vv'";
				session(['s_'.$name=>$v]);
			}else{
				session(['s_'.$name=>'']);
			}
			$name = $n.'2';
			$v = $req->$name;
			if($v){
				$vv = $v.' 23:59:59';
				$rtn[] = $n." < '$vv'";
				session(['s_'.$name=>$v]);
			}else{
				session(['s_'.$name=>'']);
			}
		}
		//管理员可以查看created_gid等于或低于其管理级别的用户: 只限制 uid>1的用户；
		$gcid = session('gcid');
		$gcid_users = session('gcid_user');
		//echo $gcid;echo '|';print_r($gcid_users);exit;
		
// 		echo $gcid;

// 		echo $gcid;

		if(in_array($uid,array(0,1))){
			//
		}else if($gcid){
    		$gcid_reg = '|'.$gcid.'|';
    		$filter = "belong_gid in(select channel_id from channels where level_path like '%$gcid_reg%' or channel_id='$gcid' )";
    		//echo $filter;
    		$rtn[] = $filter;
    		
    	}elseif($gcid_users){
    		$add = "";
    		foreach($gcid_users as $gcid_user){
    			$gcid_reg = '|'.$gcid_user.'|';
    			$add = $add . " level_path like '%$gcid_reg%' or channel_id='$gcid_user'  or";
    		}
    		$add = " select channel_id from channels where ".substr($add,0,-3);
    		
    		$filter = "default_channel in($add )";
    		//echo $filter;
    		$rtn[] = $filter;
    		
 		
    	}else{
    		//悬空，看不到任何东西；2017.2.8，改为只看到自己；根据belong_gid判断，可以看到同组的
    		//$rtn[] = "user_id = $uid";
    		//$gcid_reg = '|'.$belong_gid.'|';
    		$filter = "belong_gid = $belong_gid";
    		//echo $filter;
    		$rtn[] = $filter;
    	}
    	
    	//ID 为0或1的为超级用户，不显示
    	if($uid==0){
    		//$rtn[] = " user_id > 1";
    	}else if($uid==1){
    		$rtn[] = " user_id > 0";
    	}else{
    		$rtn[] = " user_id > 1";
    	}
    	
    	
    	//特殊处理，绑定的时候不显示为0的记录
    	if($req->user_id == "!0"){
    		$rtn[] = 'user_id != 0';
    	}
    	
    	
		//默认情况下，不显示已删除的记录；
		$is_delete = $req->is_delete;
		if($is_delete==1){
			$rtn[] = " is_delete=1";
		}else{
			$rtn[] = " is_delete!=1";
		}
		
    	
		return $rtn;
	}
	
	//
	public function format_right_one($model){
		//计算角色 id
		$uid = $model->user_id;
		$roles = DB::table('admin_role_user')->where('user_id',$uid)->get();
		foreach($roles as $v){
			$ids[] = $v->role_id;
		}
		
		return $model;
	}
	
	//用户，角色切换
	public function switchj($uid='',$role_id='',$req=''){
		
		$user = $this->find($uid);
		if($role_id){
			$user->role_id = $role_id;
		}
		 
		//缓存用户的 权限；
		session(['guid'=>$uid]);
		session(['guser'=>$user]);
		//先初始化
		$perms = $this->perms('');
		foreach($perms as $v){
			$k = 'gr_'.$v->name;
			session([$k=>'0']);
		}
		$perms = $this->perms($uid);
		//print_r($perms);exit;
		$gright = array();
		foreach($perms as $v){
			$k = 'gr_'.$v->name;
			session([$k=>'1']);
			$gright[] = $v->name;
		}
		session(['gright'=>$gright]);
		session(['gsid'=>'1']);
		//缓存配置信息
		$configs = $this->config->all();
		foreach($configs as $v){
			$n = 'gc_'.$v->name;
			session([$n=>$v->value]);
		}
		//缓存用户的 cid
		$gcid = $this->cid('');
		session(['gcid'=>$gcid]);	//当前管理员所管理的编组；
		session(['gcid_user'=>$this->cid('user')]);//当前用户所属的编组；
		//当前用户所在编组
		//echo $gcid;echo $user_id;exit;
		if($gcid){
			$gchannel = $this->find($gcid);
			session(['gchannel'=>$gchannel]);
		}
		
		//保留历史
		$arr = session('switch_uids');
		if(!$arr){
			$arr = array();
		}
		$arr[$user->user_id] = $user->name."(".$user->nick.")";
		
		session(['switch_uids'=>$arr]);
	}
	
	protected function post_replace($model,$inputs){
		echo time();exit;
	}
	
	
	
	
}
