<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Repositories\ChannelRepository;  //模型仓库层
use jamx\Repositories\DictRepository;
use jamx\Repositories\DynamicRepository;
use jamx\Repositories\UserRepository;
use Illuminate\Http\Request;
use jamx\Repositories\DeviceRepository;


class ChannelController extends BackController
{

    public function __construct(
        ChannelRepository $repo,DictRepository $dict,DynamicRepository $dynamic,UserRepository $user,DeviceRepository $device)
    {
        parent::__construct(); 
        $this->repo = $repo;
        $this->channel = $repo;
        $this->dict = $dict;
        $this->dynamic = $dynamic;
        $this->user = $user;
        $this->admin = $user;
        $this->device = $device;
       
        if (! user('object')->can('manage_channel')) {
            $this->middleware('deny403');
        }
       
    }
    
    protected function common_data($req,$my){
    	$types = $this->dict->channel_type();
    	$pchannels = $this->repo->parentChannel();
    	$rtn =array('types'=>$types,'parent_channel'=>$pchannels);
    	$rtn = array_merge($rtn,parent::common_data($req, $my));
    	//创建编组
    	$gcid = session('gcid');//当前用户所在编组
    	$created_gid = $this->channel->children($gcid,true);
    	$rtn['created_gid'] = $created_gid;
    	
    	return $rtn;
    }
    
    protected function show_data($req,$my){
    	//return $this->common_data($req, $my);
    	$type_id = $my->type;
    	$record_id = $my->channel_id;
    	$html = $this->dynamic->do_html($type_id,$record_id,false);
    	//print_r($html);
    	$rtn['html'] = $html;
    	return $rtn;
    }
    
    public function user(Request $req){
    	$type = 'user';
    	//可为指定编组添加或删除用户，可以操作的用户为该级别管理员向下所有编组创建的用户: don't handle in control. rep is better!
    	//$req->is_delete = 0;
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.user', $idata);
    }
    
    public function admin(Request $req){
    	$type = 'admin';
    	//$idata = $this->user->index_data($req);
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.user', $idata);
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
    public function log_update($req,$id,$data){
    	$str =  '修改了ID为'.$id.',名称为'.$req['name'].'分组信息';
    	return $str;
    }
    public function log_store($req){
    	$str = '增加了名称为'.$req->name.'分组';
    	return $str;
    }
    public function log_destroy($req,$id,$model){
    	if($req->force == '0')
    	{
    		$str = '禁用了ID为'.$id.',名称为'.$model['name'].'分组';
    		return $str;
    	}
    	if($req->force == '1')
    	{
    		$str = '删除了名称为'.$model['name'].'分组';
    		return $str;
    	}
    }
}
