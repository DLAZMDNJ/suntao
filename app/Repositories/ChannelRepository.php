<?php

namespace jamx\Repositories;

use jamx\Models\Channel;
use DB;
use jamx\Repositories\DynamicRepository;


class ChannelRepository extends MisRepository
{

    public function __construct(
        Channel $model,DynamicRepository $dynamic)
    {
        $this->model = $model;  
        $this->dynamic = $dynamic;
        
    }
    
    public function fill_data($model,$inputs){
    	$n_inputs = array();
    	$n_inputs['name'] = $inputs['name'];
    	$n_inputs['type'] = $inputs['type'];
    	$n_inputs['description'] = $inputs['description'];
    	$n_inputs['parent_id'] = $inputs['parent_id'];
    	if(!$model->id){
    		$n_inputs['ctime'] = time();
    	}
    	//计算 level path
    	$pmodel = $this->find($inputs['parent_id']);
    	if(!$pmodel){
    		$level_path = '';
    	}else{
    		$plevel_path = $pmodel->level_path;
    		if(!$plevel_path){
    			$level_path = '|'.$pmodel->channel_id.'|';
    		}else{
    			$level_path = $pmodel->level_path.$pmodel->channel_id.'|';
    		}
    	}
    	$n_inputs['level_path'] = $level_path;
    	$n_inputs['created_uid'] = session('guid');
    	//2016.10.18 改为下拉选择；
    	//$n_inputs['created_gid'] = session('gcid');
    	
    	$model->fill($n_inputs);
    }
    
    protected function list_where($req){
    	return array();//array('state'=>0);
    }
    
    public function format_model($model,$old){
    	//新增时，计算 channel 的 level
    	if(!$model->channel_id){
    		if($model->parent_id==0){
    			$level = 1;
    		}else{
    			$pmodel = $this->find($model->parent_id);
    			$level = $pmodel->level +1;
    		}
    		$model->level = $level;
    	}
    	//创建编组不应为空，它是指创建这个编组的管理员所负责的那个编组: 改为下拉选择
    	//$model->created_gid = session('gcid');
    	$model->server_id = session('gsid');
    }
    
    protected function post_replace($model,$inputs){
    	//print_r($inputs);exit;
    	$record_id = $model->channel_id;
    	$type_id = $model->type;
    	$this->dynamic->save_dynamic_data($record_id,$type_id,$inputs);
    	//
    	if($record_id){
    		DB::table('channel_info')->where(array('server_id'=>$model->server_id,'channel_id'=>$model->channel_id,'key'=>'0'))->update(array('value'=>$model->description));
    	}else{
    		DB::table('channel_info')->insert(array('server_id'=>$model->server_id,'channel_id'=>$model->channel_id,'key'=>'0','value'=>$model->description));
    		DB::table('channel_info')->insert(array('server_id'=>$model->server_id,'channel_id'=>$model->channel_id,'key'=>'1','value'=>'0'));
    	}
    }
    
    protected function pre_destroy($model){
    	//判断是不是叶子节点。若不是，则不允许删除
    	$w['and'] = array('parent_id'=>$model->channel_id);
    	$list = $this->lists($w);
    	if(count($list)>0){
    		$n = '';
    		foreach($list as $v){
    			$n .= $v->name.' ';
    		}
    		$n .= '等子节点存在，不能删除该节点';
    		session(['message'=>$n]);
    		return false;
    	}
    	
    	//不真删除，而是改变状态
    	$this->find($model->channel_id)->update(array('state'=>-1));
    	//检查默认编组是否存在，若存在则解除绑定；
    	$users = DB::table('users')->where('default_channel',$model->channel_id)->get();
    	foreach($users as $v){
    		$this->bind_user_default_channel($v->user_id,'-1',0);
    	}
    	
    	//ice

    	
    	//根据状态判断是否是真删
    	$force = session($this->mn().'_delete_force');
    	if($force=='1'){
    		return true;
    	}else{
    		return false;
    	}
    	
    }
    
    public function restore($id){
    	$model = $this->model->find($id);
    	$model->update(array('state'=>0));
    	//
    
    }
    
    //上级编组列表
    public function parentChannel(){
    	$gcid = session('gcid');
    	return $this->children($gcid,true);
    }
    //获得所有子channel
    public function children($gcid,$if_include_me){
    	$model = $this->model;
    	if($gcid){
    		$filter = '|'.$gcid.'|';
    		$model = $model->whereRaw("(level_path like '%$filter%' or channel_id=$gcid)");// or channel_id=0
    	}
    	//不包含已删除的
    	$model = $model->where('state','0')->orderby('parent_id','asc');
    	//echo $filter;exit;
    	return $model->get();
    }
    //'id'为了绑定时能够 render 关联 id；
    public function list_render_names($req){
    	return array('level','name','description','parent_id','state','id','is_delete','channel_id');
    }
    
    public function list_search_names($req){
    	return array('level','state');
    }
    
    public function list_search_like_names($req){
    	return array('name','description');
    }
    
    protected function list_where_raw($req){
    	$rtn = array();
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
    	$name = 'parent_id';
    	$v = $req->$name;
    	if($v){
    		$rtn[] = "parent_id in (select channel_id from channels where name like '%$v%')";
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
    			$vv = strtotime($v.' 00:00:00');
    			$rtn[] = $n." > $vv";
    			session(['s_'.$name=>$v]);
    		}else{
    			session(['s_'.$name=>'']);
    		}
    		$name = $n.'2';
    		$v = $req->$name;
    		if($v){
    			$vv = strtotime($v.' 23:59:59');
    			$rtn[] = $n." < $vv";
    			session(['s_'.$name=>$v]);
    		}else{
    			session(['s_'.$name=>'']);
    		}
    	}
    	//只能管理下级编组；
    	//print_r(session('gcid'));print_r(session('gcid_user'));
    	if(in_array(session('guid'),array(0,1))){
    		//管理员可以看到所有的。
    	}else if(session('gcid')){
    		$filter = '|'.session('gcid').'|';
    		$rtn[] = "level_path like '%$filter%'";
    	}elseif(session('gcid_user')){
    		$gu = session('gcid_user');
    		$filter = '';
    		foreach($gu as $v){
    			$f = '|'.$v.'|';
    			$filter .= "level_path like '%$f%' or channel_id=$v or ";
    		}
    		if($filter){
    			$filter = '('.substr($filter,0, -3).')';
    		}
    		//echo $filter;
    		$rtn[] = $filter;
    	}else{
    		//悬空，看不到任何东西
    		$rtn[] = '1!=1';
    	}
    	
    	//特殊处理，绑定的时候不显示为0的记录
    	if($req->channel_id == "!0"){
    		$rtn[] = 'channel_id != 0';
    	}
    	
    	
    	//默认情况下，不显示已删除的记录；
    	$is_delete = $req->state;
    	if($is_delete==-1){
    		$rtn[] = " state=-1";
    	}else{
    		$rtn[] = " state!=-1";
    	}
    	 
    	return $rtn;
    }
    
    protected function post_store($model,$inputs){
    	$this->post_replace($model,$inputs);
    	//ice
    
    }
    
    protected function post_update($model,$inputs){
    	$this->post_replace($model,$inputs);
    
    }
    
    protected function post_destroy($model){
    	//删除关联关系
    	$cid = $model->channel_id;
    	$t_list = DB::table('channel_administrators')->where('cid',$cid)->get();
    	foreach ($t_list as $v){
    		$uid = $v->uid;
    		$arr['cid'] = $cid;
    		$arr['uid'] = $uid;
    		
    		DB::table('channel_administrators')->where('uid',$uid)->where('cid',$cid)->delete();
    	}
    	$t_list = DB::table('channel_users')->where('cid',$cid)->get();
    	foreach ($t_list as $v){
    		$uid = $v->uid;
    		$arr['cid'] = $cid;
    		$arr['uid'] = $uid;
    		
    		DB::table('channel_users')->where('uid',$uid)->where('cid',$cid)->delete();
    	}
    	
    }
  
}
