<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Repositories\DeviceRepository;  //模型仓库层
use jamx\Repositories\DictRepository;
use jamx\Repositories\DynamicRepository;
use Illuminate\Http\Request;
use jamx\Repositories\UserRepository;
use jamx\Repositories\ChannelRepository;

class DeviceController extends BackController
{

    public function __construct(
        DeviceRepository $repo,DictRepository $dict,DynamicRepository $dynamic,UserRepository $user,ChannelRepository $channel)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->dict = $dict;
        $this->dynamic = $dynamic;
        $this->user = $user;
        $this->channel = $channel;
        
        if (! user('object')->can('manage_device')) {
            $this->middleware('deny403');
        }
       
    }
    
    protected function index_data(Request $req)
    {
    	$rtn = parent::index_data($req);
    	$rtn = array_merge($rtn,$this->common_data($req, ''));
    	return $rtn;
    }
    
    protected function common_data($req,$my){
    	$types = $this->dict->device_type();
    	$rtn = array('types'=>$types);
    	$rtn = array_merge($rtn,parent::common_data($req, $my));
    	//创建编组
    	$gcid = session('gcid');//当前用户所在编组
    	$created_gid = $this->channel->children($gcid,true);
    	$rtn['belong_gid'] = $created_gid;
    	return $rtn;
    }
    
    protected function show_data($req,$my){
    	//return $this->common_data($req, $my);
    	$type_id = $my->type;
    	$record_id = $my->id;
    	$html = $this->dynamic->do_html($type_id,$record_id,false);
    	//print_r($html);
    	$rtn['html'] = $html;
    	return $rtn;
    }
    
    public function user(Request $req){
    	$type = 'user';
    	//$idata = $this->user->index_data($req);
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.user', $idata);
    }
    //绑定；
    public function channel(Request $req){
    	$type = 'channel';
    	//$idata = $this->user->index_data($req);
    	$list = $this->$type->index($req);
    	$idata['list'] = $list;
    	$idata['mn'] = $this->mn();
    	$idata['render'] = $this->list_render($list,$req);
    	$idata = $this->bind_end($req,$type,$idata,$this->$type);
    	return view('admin.bind.channel', $idata);
    }
    public function log_update($req,$id,$data){
    	$str =  '修改了ID为'.$id.',名称为'.$data['nickname'].'的设备信息';
    	return $str;
    }
    public function log_store($req){
    	$str = '增加了名称为'.$req->nickname.'设备';
    	return $str;
    }
    public function log_destroy($req,$id,$model){
    	if($req->force == '0')
    	{
    		$str = '禁用了ID为'.$id.',名称为'.$model['nickname'].'设备';
    		return $str;
    	}
    	if($req->force == '1')
    	{
    		$str = '删除了名称为'.$model['nickname'].'设备';
    		return $str;
    	}
    }
}
