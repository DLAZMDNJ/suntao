<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests\UserRequest;
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Logger\SystemLogger as SystemLogger;
use jamx\Repositories\UserRepository;
use jamx\Repositories\RoleRepository;
use jamx\Repositories\ConfigRepository;
use jamx\Repositories\ChannelRepository;
use jamx\Repositories\DeviceRepository;
use Cache;

/**
 * （管理型）用户资源控制器
 *
 * @author king <king@jinsec.com>
 */
class UserController extends BackController
{


    public function __construct(
        UserRepository $user, RoleRepository $role, ConfigRepository $config,ChannelRepository $channel,DeviceRepository $device)
    {
        parent::__construct();
        $this->repo = $user;
        $this->role = $role;
        $this->config = $config;
        $this->channel = $channel;
        $this->device = $device;

        if (! user('object')->can('manage_user')) {
            $this->middleware('deny403');
        }
    }
    protected function index_data(Request $req)
    {
    	$rtn = parent::index_data($req);
    	$rtn = array_merge($rtn,$this->common_data($req, ''));
    	return $rtn;
    }
    

    protected function common_data($req, $my){
    	$where = array();
    	//id为1，2的是默认角色，不出现在任何界面中。
    	$where['raw'][] = "id>2";
    	
    	$roles = $this->role->lists($where,array(),111);
    	$own_role = '';//$this->repo->getRole($my);
    	//配置信息
    	$multi_role = $this->config->get('multi_role');
    	$rtn = array('roles'=>$roles,'own_role'=>$own_role,'multi_role'=>$multi_role);
    	$rtn = array_merge($rtn,parent::common_data($req, $my));
    	//创建编组
    	$gcid = session('gcid');//当前用户所在编组
    	$created_gid = $this->channel->children($gcid,true);
    	$rtn['belong_gid'] = $created_gid;
    	//print_r($ret);
    	return $rtn;
    }
    protected function redirect_replace_data($req){
    	return array('name','nick','created_gid','role_id','description','ctime1','ctime2','is_delete','orderby');
    }
    public function channel(Request $req){
    	$type = 'channel';
    	//$idata = $this->user->index_data($req);
    	//过滤已删除编组
    	$req->state='0';
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.channel', $idata);
    }
    
    public function device(Request $req){
    	$type = 'device';
    	//$idata = $this->user->index_data($req);
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.device', $idata);
    }
    
    //
    
    public function switchj(Request $req){
    	$uid = $req->uid;
    	$role_id = $req->role_id;
    	$this->repo->switchj($uid,$role_id,$req);
    	
    	return Redirect()->back();
    }
    //唯一 1 ；0为不唯一；
	public function unique(Request $req){
    	$col = $req->col;
    	$val = $req->val;
    	$uid = $req->uid;
    	
    	$data = $this->repo->detail(array($col=>$val));
    	
    	
    	if($val && $data){
    		if(isset($uid) && $data->id==$uid){
    			$rtn = '1';
    		}else{
    			$rtn = '0';//todo...
    		}
    		
    	}else{
    		$rtn = '1';
    	}
    	$data['result'] = $rtn;
    	$data['debug'] = $col.';'.$uid.','.$val.','.$rtn;
    	echo json_encode($data);
    }
    
    public function log_update($req,$id,$data){
     	$str =  '修改了ID为'.$id.',昵称为'.$req['nick'].'的用户信息';
    	return $str;
    }
    public function log_store($req){
    	$str = '增加了昵称为'.$req->nick.'用户';
    	return $str;
    }
    public function log_destroy($req,$id,$model){
    	if($req->force == '0')
    	{
    		$str = '禁用了ID为'.$id.',昵称为'.$model['nick'].'用户';
    		return $str;
    	}
    	if($req->force == '1')
    	{
    		$str = '删除了昵称为'.$model['nick'].'用户';
    		return $str;
    	}
    }
    

}
