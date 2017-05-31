<?php

namespace jamx\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use jamx\Logger\SystemLogger as SysLog;

class MisController extends BaseController {
	
	protected $repo;
	protected $related;
	protected $mn;
	

	public function __construct()
	{
		
	}
	
	protected function repo(){
		return $this->repo;
	}
	//项目名
	protected function mis(){
		return 'mis';
	}
	
	//模块名
	protected function mn(){
		return $this->repo()->mn();
	}
	
	
	public function index(Request $req)
	{
		$idata = $this->index_data($req);
		$list = $this->repo()->index($req);
		$idata['list'] = $list;
		$idata['mn'] = $this->mn();
		$idata['render'] = $this->list_render($list,$req);
		return view($this->mis().'.'.$this->mn().'.index', $idata);
	}
	
	protected function index_data(Request $req)
	{
		$rtn = array();
		//排序
		if($req->orderby){
			$ords = explode('__',$req->orderby);
			$n = 'orderby_'.$ords[0];
			if($ords[1]=='asc'){
				$v = '&#8593;';
			}else{
				$v = '&#8595;';
			}
			$rtn[$n] = $v;
		}
		return $rtn;
	}
	
	public function create(Request $req)
	{
		//
		$rtn = array();
		$rtn = array_merge($rtn,$this->create_data($req));
		return view($this->mis().'.'.$this->mn().'.edit',$rtn);
	}
	
	protected function create_data($req)
	{
		return $this->common_data($req,'');
	}
	
	public function edit($id,Request $req)
	{
		//
		$data = $this->repo->edit($id);
		$edata = $this->edit_data($req,$data);
		$edata['data'] = $data;
		return view($this->mis().'.'.$this->mn().'.edit', $edata);
	}
	
	protected function edit_data($req,$my)
	{
		return $this->common_data($req,$my);
	}
	
	protected function common_data($req,$my){
		$rtn = array();
		$rtn['mn'] = $this->mn();
		return $rtn;
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		return $this->do_store($request);
	}
	
	protected function do_store(Request $req){

		$data = $req->all();
		$this->pre_store($data);
		$info = $this->repo()->store($data,"");
		$this->post_store($info->id,$info);
		//echo $this->mis().'.'.$this->mn().'.index';exit;
		SysLog::log($this->log_store($req));
		return redirect()->route($this->mis().'.'.$this->mn().'.index',$this->redirect_store_data($req));
	}
	
	public function log_store($req){
		return '';
	}
	
	protected function pre_store($data){
		return true;
	}
	
	protected function post_store($id,$my){
		
	}
	
	protected function redirect_store_data($req){
		return $this->redirect_replace_data($req);
	}
	
	protected function redirect_update_data($req){
		return $this->redirect_replace_data($req);
	}
	
	protected function redirect_replace_data($req){
		return array();
	}
	
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		return $this->do_update($request,$id);
	}
	
	protected function do_update(Request $req, $id){
		$data = $req->all();
		$this->repo()->update($id, $data);
		//log
		SysLog::log($this->log_update($req,$id,$data));
		return $this->update_redirect($req);
	}
	
	public function log_update($req,$id,$data){
		return '';
	}
	
	public function update_redirect(Request $req){
		if($this->common_redirect($req)){
			return $this->common_redirect($req);
		}
		return redirect()->route($this->mis().'.'.$this->mn().'.index',$this->redirect_update_data($req));
	}
	
	public function destroy(Request $req,$ids)
	{
		$arr = explode(",",$ids);
		foreach($arr as $id){
			$my = $this->repo->find($id);
			//记录是否真删的状态，供repo使用
			session([$this->mn().'_delete_force'=>$req->force]);
			if($this->pre_destroy($id,$my)){
				$this->repo->destroy($id);
				//
				SysLog::log($this->log_destroy($req,$id,$my));
			}
		}
		return $this->destroy_redirect($req);
		
	}
	
	public function log_destroy($req,$id,$model){
		return '';
	}
	
	public function destroy_redirect(Request $req){
		if($this->common_redirect($req)){
			return $this->common_redirect($req);
		}
		$msg = session('message');
		if($msg==''){
			$msg = '操作成功！';
		}
		return redirect()->route($this->mis().'.'.$this->mn().'.index')->with('message', $msg);
	}
	
	public function common_redirect(Request $req){
		return '';
	}
	
	protected function pre_destroy($id,$my){
		return true;
	}
	
	protected function post_destroy($id,$my){
		return true;
	}
	
	public function show(Request $req,$id)
	{
		$data = $this->repo->edit($id);
		$rtn = $this->show_data($req,$data);
		$rtn['data'] = $data;
		return view($this->mis().'.'.$this->mn().'.show', $rtn);
	}
	
	protected function show_data($req,$my){
		return $this->common_data($req, $my);
	}
	
	public function list_render($list,$req){
		$arr = $this->list_render_name($req);
		//print_r($list);exit;
		return $list->appends($arr)->render();
	
	}
	
	public function list_render_name($req){
		$data = array();
		$cols = $this->repo->list_render_names($req);
		//print_r($cols);
		foreach($cols as $v){
			$val = $req->$v;
			if($val!=''){
				$data[$v] = $val;
			}
	
		}
		if(isset($req->s_key) && $req->s_key !=''){
			$data['s_key'] = $req->s_key;
		}
		//排序
		if($req->orderby){
			$data['orderby'] = $req->orderby;
			$ords = explode('__',$req->orderby);
			$n = 'orderby_'.$ords[0];
			if($ords[1]=='asc'){
				$v = '&#8593;';
			}else{
				$v = '&#8595;';
			}
			//echo $n;
			session([$n=>$v]);
		}
		return $data;
	}
	
	public function restore(Request $req){
		$json = $this->repo->restore($req->id);
		SysLog::log($this->log_restore($req));
		echo json_encode($json);
	}
	
	public function log_restore($req){
		return '';
	}
	
	public function bind_end($req,$type,$idata,$type_repo){
		$id = $req->id;
		//echo $id;
		$mn = $this->mn();
		$idata['type'] = $type;
		$idata['id'] = $req->id;
		$idata['my'] = $this->repo->find($req->id);
		//查询绑定数据
		
		$bind_data = array();
		if($mn=='user' && $type=='channel'){
			$have_data = DB::table('channel_users')->where('uid',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->cid;
			}
		}else if($mn=='user' && $type=='device'){
			$have_data = DB::table('user_devices')->where('uid',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->did;
			}
		}else if($mn=='channel' && $type=='user'){
			$have_data = DB::table('channel_users')->where('cid',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->uid;
			}
		}else if($mn=='channel' && $type=='admin'){
			$have_data = DB::table('channel_administrators')->where('cid',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->uid;
			}
		}else if($mn=='channel' && $type=='device'){
			$have_data = DB::table('channel_devices')->where('cid',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->did;
			}
		}else if($mn=='device' && $type=='channel'){
			$have_data = DB::table('channel_devices')->where('did',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->cid;
			}
		}else if($mn=='device' && $type=='user'){
			$have_data = DB::table('user_devices')->where('did',$id)->get();
			foreach($have_data as $v ){
				$bind_data[] = $v->uid;
			}
		}
		//print_r($bind_data);
		//echo $mn;
		
		$idata['bind_data'] = $bind_data;
		return $idata;
	}
	//执行 bind 操作
	public function bind(Request $req){
		$mn= $req->mn;
		$type= $req->type;
		$id= $req->id;
		$data= $req->data;
		$op= $req->op;
		$default= $req->default;
		//
		$datas = explode(',',$data);
		$defaults = explode(',',$default);
		foreach($datas as $v){
			if(in_array($v,$defaults)){
				$default = 1;
			}else{
				$default = 0;
			}
// 			echo 'mn:'.$mn.',type:'.$type.',id:'.$id.',v:'.$v.',op:'.$op.',default:'.$default;
			$rtn = $this->bind_one($mn,$type,$id,$v,$op,$default);
		}
		echo $rtn;
	}
	public function bind_one($mn,$type,$id,$data,$op,$default){
		 $rtn = array();
		 $msg_device_user_max = '同类型设备绑定超最大数量';
		 $server_id = 1;
		 $log_content = '';
		 
		 if($mn=='user' && $type=='channel'){
		 	if($op==1){
		 		DB::table('channel_users')->insert(array('server_id'=>$server_id,'uid'=>$id,'cid'=>$data));
		 		DB::table('admin_role_user')->insert(array('user_id'=>$id,'role_id'=>'2'));
		 		$this->bind_user_default_channel($id,$op, $data);
		 		//
		 		$arr['uid'] = $id;
		 		$arr['cid'] = $data;
		 		
		 		//绑定排序
		 		DB::table('channels')->where('channel_id',$data)->update(array('utime'=>time()));
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$id)->first();
		 		$channel_info = DB::table('channels')->where('channel_id',$data)->first();
		 		$log_content = '将ID为'.$id.',昵称为'.$user_info->nick.'的用户绑定到'.$channel_info->name.'分组';
		 	}else{
		 		DB::table('channel_users')->where(array('uid'=>$id,'cid'=>$data))->delete();
		 		DB::table('admin_role_user')->where(array('user_id'=>$id,'role_id'=>'2'))->delete();
		 		$this->bind_user_default_channel($id,$op, $data);
		 		//
		 		$arr['uid'] = $id;
		 		$arr['cid'] = $data;
		 	
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$id)->first();
		 		$channel_info = DB::table('channels')->where('channel_id',$data)->first();
		 		$log_content = '将ID为'.$id.',昵称为'.$user_info->nick.'的用户从分组'.$channel_info->name.'解绑';
		 	}
		 }else if($mn=='user' && $type=='device'){
		 	if($op==1){
		 		//同一个设备只能给1个用户使用:其它自动解绑
		 		$dlist = DB::table('user_devices')->where(array('did'=>$data))->get();
		 		foreach($dlist as $dv){
		 			$d_uid = $dv->uid;
		 			$this->bind_device_user_type(-1, $data, $d_uid);
		 			DB::table('user_devices')->where(array('did'=>$data))->where(array('uid'=>$d_uid))->delete();
		 		}
		 		//绑定用户
		 		DB::table('user_devices')->insert(array('uid'=>$id,'did'=>$data));
		 		//绑定排序
		 		DB::table('device')->where(array('id'=>$data))->update(array('utime'=>time()));
		 		
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$id)->first();
		 		$device_info = DB::table('device')->where('id',$data)->first();
		 		$log_content = '将ID为'.$id.',昵称为'.$user_info->nick.'的用户绑定到'.$device_info->nickname.'设备';
		 		
		 	}else{
		 		DB::table('user_devices')->where(array('uid'=>$id,'did'=>$data))->delete();
		 		
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$id)->first();
		 		$device_info = DB::table('device')->where('id',$data)->first();
		 		$log_content = '将ID为'.$id.',昵称为'.$user_info->nick.'的用户从设备'.$device_info->nickname.'解绑';
		 	}
		 	//用户设备绑定：触发条件
		 	$this->bind_device_user_type($op, $data, $id);	//did uid
		 	
		 }else if($mn=='channel' && $type=='user'){
		 	if($op==1){
		 		DB::table('channel_users')->insert(array('server_id'=>$server_id,'cid'=>$id,'uid'=>$data));
		 		DB::table('admin_role_user')->insert(array('user_id'=>$data,'role_id'=>'2'));
		 		//
		 		$this->bind_user_default_channel($data,$op, $id);
		 		//绑定排序
		 		DB::table('users')->where(array('user_id'=>$data))->update(array('utime'=>time()));
		 		//
		 		$arr['cid'] = $id;
		 		$arr['uid'] = $data;
		 		
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$data)->first();
		 		$channel_info = DB::table('channels')->where('channel_id',$id)->first();
		 		$log_content = '将ID为'.$data.',昵称为'.$user_info->nick.'的用户绑定到'.$channel_info->name.'分组';
		 		
		 	}else{
		 		DB::table('channel_users')->where(array('cid'=>$id,'uid'=>$data))->delete();
		 		DB::table('admin_role_user')->where(array('user_id'=>$data,'role_id'=>'2'))->delete();
		 		$this->bind_user_default_channel($data,$op, $id);
		 		//
		 		$arr['cid'] = $id;
		 		$arr['uid'] = $data;
		 		$this->repo->ice('channel_unbind_user',$arr);
		 		
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$data)->first();
		 		$channel_info = DB::table('channels')->where('channel_id',$id)->first();
		 		$log_content = '将ID为'.$data.',昵称为'.$user_info->nick.'的用户从分组'.$channel_info->name.'解绑';
		 		
		 	}
		 }else if($mn=='channel' && $type=='admin'){
		 	if($op==1){
		 		//一个管理员只能管理一个编组
		 		DB::table('channel_administrators')->where(array('uid'=>$data))->delete();
		 		DB::table('channel_administrators')->insert(array('cid'=>$id,'uid'=>$data));
		 		DB::table('admin_role_user')->insert(array('user_id'=>$data,'role_id'=>'1'));
		 		
		 		//绑定排序
		 		DB::table('users')->where(array('user_id'=>$data))->update(array('utime'=>time()));
		 		
		 		//todo
		 		$log_content = '';
		 		
		 	}else{
		 		DB::table('channel_administrators')->where(array('cid'=>$id,'uid'=>$data))->delete();
		 		DB::table('admin_role_user')->where(array('user_id'=>$data,'role_id'=>'1'))->delete();
		 		
		 		//todo
		 		$log_content = '';
		 		
		 	}
		 }else if($mn=='channel' && $type=='device'){
		 	if($op==1){
		 		DB::table('channel_devices')->insert(array('cid'=>$id,'did'=>$data));
		 		//绑定排序
		 		DB::table('device')->where(array('id'=>$data))->update(array('utime'=>time()));
		 		//todo
		 		$channel_info = DB::table('channels')->where('channel_id',$id)->first();
		 		$device_info = DB::table('device')->where('id',$data)->first();
		 		$log_content = '将ID为'.$data.',名称为'.$channel_info->name.'的分组绑定到'.$device_info->nickname.'设备';
		 	}else{
		 		DB::table('channel_devices')->where(array('cid'=>$id,'did'=>$data))->delete();
		 		//todo
		 		$channel_info = DB::table('channels')->where('channel_id',$id)->first();
		 		$device_info = DB::table('device')->where('id',$data)->first();
		 		$log_content = '将ID为'.$data.',名称为'.$channel_info->name.'的分组从设备'.$device_info->nickname.'解绑';
		 	}
		 }else if($mn=='device' && $type=='channel'){
		 	if($op==1){
		 		DB::table('channel_devices')->insert(array('did'=>$id,'cid'=>$data));
		 		//绑定排序
		 		DB::table('channels')->where('channel_id',$data)->update(array('utime'=>time()));
		 		//todo
		 		$channel_info = DB::table('channels')->where('channel_id',$data)->first();
		 		$device_info = DB::table('device')->where('id',$id)->first();
		 		$log_content = '将ID为'.$id.',名称为'.$channel_info->name.'的分组绑定到'.$device_info->nickname.'设备';
		 	}else{
		 		DB::table('channel_devices')->where(array('did'=>$id,'cid'=>$data))->delete();
		 		//todo
		 		$channel_info = DB::table('channels')->where('channel_id',$data)->first();
		 		$device_info = DB::table('device')->where('id',$id)->first();
		 		$log_content = '将ID为'.$id.',名称为'.$channel_info->name.'的分组从设备'.$device_info->nickname.'解绑';
		 	}
		 }else if($mn=='device' && $type=='user'){
		 	if($op==1){
		 		//同一个设备只能给1个用户使用:其它自动解绑
		 		$dlist = DB::table('user_devices')->where(array('did'=>$id))->get();
		 		foreach($dlist as $dv){
		 			$d_uid = $dv->uid;
		 			$this->bind_device_user_type(-1, $id, $d_uid);
		 			DB::table('user_devices')->where(array('did'=>$id))->where(array('uid'=>$d_uid))->delete();
		 		}
		 		//判断设备持有的最大值
		 		if($this->bind_device_user_max($data,$id)){
		 			$rtn['message'] = $msg_device_user_max;
		 		}
		 		DB::table('user_devices')->insert(array('did'=>$id,'uid'=>$data));
		 		//用户设备绑定--手机
		 		$this->bind_device_user_type($op, $id, $data);
		 		//绑定排序
		 		DB::table('users')->where(array('user_id'=>$data))->update(array('utime'=>time()));
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$data)->first();
		 		$device_info = DB::table('device')->where('id',$id)->first();
		 		$log_content = '将ID为'.$data.',昵称为'.$user_info->nick.'的用户绑定到'.$device_info->nickname.'设备';
		 	}else{
		 		DB::table('user_devices')->where(array('did'=>$id,'uid'=>$data))->delete();
		 		//
		 		$this->bind_device_user_type($op, $id, $data);
		 		//todo
		 		$user_info = DB::table('users')->where('user_id',$data)->first();
		 		$device_info = DB::table('device')->where('id',$id)->first();
		 		$log_content = '将ID为'.$data.',昵称为'.$user_info->nick.'的用户从设备'.$device_info->nickname.'解绑';
		 	}
		 }
		 
		 SysLog::log($log_content);
		 
		 return json_encode($rtn);
	}
	
	protected function bind_user_default_channel($uid,$op,$default){
		return $this->repo()->bind_user_default_channel($uid,$op,$default);
	}
	
	protected function bind_device_user_type($op,$did,$uid){
		//根据类型，对应处理；
		return $this->repo()->bind_device_user_type($op,$did,$uid);
		
	}
	
	//判断该用户同类型设备是否超标:uid 要绑定 did
	public function bind_device_user_max($uid,$did){
		$device_info = $this->repo()->device_info($did);
		$max = $device_info->dict_max;
		$type = $device_info->type;
		
		$had = DB::table('user_devices')->where('uid',$uid)->join('device',function($join){
					$join->on('device.id','=','user_devices.did')
					;
				})->where('device.type','=',$type)->count();
		//echo $had;echo $max;exit;
		if($had >= $max){
			return true;
		}else{
			return false;
		}
	}
}
