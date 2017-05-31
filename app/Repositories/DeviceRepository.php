<?php

namespace jamx\Repositories;

use jamx\Models\Device;
use DB;
use jamx\Repositories\DynamicRepository;



class DeviceRepository extends MisRepository
{

    public function __construct(
        Device $model,DynamicRepository $dynamic)
    {
        $this->model = $model;  
        $this->dynamic = $dynamic;
        
    }
    
    public function format_model($model,$old){
    	if(!$model->id){
    		$model->ctime = time();
    	}
    	
    }
    

    public function fill_data($model,$inputs){
    	$n_inputs = array();
    	$n_inputs['nickname'] = $inputs['nickname'];
    	$n_inputs['type'] = $inputs['type'];
    	$n_inputs['description'] = $inputs['description'];
    	if(!$model->id){
    		$n_inputs['ctime'] = $inputs['ctime'];
    	}
    	
    	$n_inputs['belong_gid'] = $inputs['belong_gid'];
    	$n_inputs['created_gid'] = session('gcid');;
    	//device_id是冗余信息，在新建时记录设备动态信息的第一项;编辑动态信息时候对应修改device_id
    	//print_r($inputs);exit;
    	if($n_inputs['type']){
    		$dynamic = DB::table('admin_dynamic')->where('pid',$n_inputs['type'])->orderBy('sort','asc')->first();
    		if($dynamic){
    			$code = $dynamic->code;
    			//$n_inputs['device_id'] = $inputs[$code];
    			//print_r($n_inputs);exit;
    		}
    	}
    	
    	$model->fill($n_inputs);
    }
    
    protected function post_replace($model,$inputs){
    	$record_id = $model->id;
    	$type_id = $model->type;
    	$this->dynamic->save_dynamic_data($record_id,$type_id,$inputs);
    	
    }
    
    protected function post_update($model,$inputs){
    	parent::post_update($model, $inputs);
    	//2.	如果编辑的设备是手机，那么修改imei和imsi信息
    	$bind_users = DB::table('user_devices')->where('did',$model->id)->get();
    	foreach($bind_users as $v){
    		$this->bind_device_user_mobile('1',$model->id,$v->uid);
    	}
    	
    }
    
    protected function pre_destroy($model){
    	//不真删除，而是改变状态
    	$this->find($model->id)->update(array('is_delete'=>1));
    	//解除和用户、编组的绑定
    	DB::table('user_devices')->where('did',$model->id)->delete();
    	DB::table('channel_devices')->where('did',$model->id)->delete();
    	
    	//根据状态判断是否是真删
    	$force = session($this->mn().'_delete_force');
    	if($force=='1'){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function restore($id){
    	$this->model->find($id)->update(array('is_delete'=>0));
    }
    
    public function list_render_names($req){
    	return array('type','is_delete','description','parent_id','nickname','state','id','is_delete');
    }
    
    public function list_search_names($req){
    	return array('type','is_delete');
    }
    
    public function list_search_like_names($req){
    	return array('nickname','description');
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
    	
    	//管理员可以查看created_gid等于或低于其管理级别的用户
    	$gcid = session('gcid');
    	$gcid_users = session('gcid_user');
    	if(in_array(session('guid'),array(0,1))){
    		//管理员可以看到所有的。
    	}else if($gcid){
    		$gcid_reg = '|'.$gcid.'|';
    		$filter = "belong_gid in(select channel_id from channels where level_path like '%$gcid_reg%' or channel_id='$gcid' )";
    		//echo $filter;
    		$rtn[] = $filter;
    	}elseif($gcid_users){
    		$add = " select channel_id from channels where ";
    		$add2 = '';
    		foreach($gcid_users as $gcid_user){
    			$gcid_reg = '|'.$gcid_user.'|';
    			$add2 = $add2 . " level_path like '%$gcid_reg%' or channel_id='$gcid_user'  or ";
    		}
    		$add .= substr($add2,0,-3);
    		
    		$filter = "belong_gid in($add )";
    		//echo $filter;
    		$rtn[] = $filter;
    	}else{
    		//悬空，看不到任何东西
    		$rtn[] = '1!=1';
    	}
    	
    	//默认情况下，不显示已删除的记录；
    	$is_delete = $req->is_delete;
    	if($is_delete==1){
    		$rtn[] = " is_delete=1";
    	}else{
    		$rtn[] = " is_delete!=1";
    	}
    	
    	//过滤设备类型：编组还是用户 ，device_type
    	if($req->device_type){
    		$rtn[] = " type in (select id from admin_dict where pid = 2 and type='".$req->device_type."')";
    	}
    
    	return $rtn;
    }
  
}
