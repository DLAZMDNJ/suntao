<?php

namespace jamx\Repositories;
// require_once 'Ice.php';
// require_once 'Printer.php';
// require_once '/home/jzb/Murmur.php';
use Illuminate\Support\Facades\Input;
use Cache;
use Illuminate\Http\Request;
use DB;
use Log;
use Murmur_ServerPrxHelper;
use Murmur_Server;
use Murmur_MurmurException;

use jamx\Logger\SystemLogger as SysLog;

/**
 * mis repo 基类
 * 
 * ／
 *
 * @author king
 */
class MisRepository extends BaseRepository
{

	protected $model;
	protected $related;//related model
	protected $dict;
	protected $attach;
	protected $server_id = 1;
	
	public function __construct(
			DictRepository $dict,AttachRepository $attach)
	{
		parent::__construct();
		$this->dict = $dict;
		$this->attach = $attach;
	}
	
	public function mn(){
		return $this->model()->mn();
	}
	//获得 model信息
	public function model(){
		$model = $this->model;
		
		return $model;
	}
	
	public function setModel($model){
		$this->model = $model;
	}
	
	public function related(){
		return $this->related;
	}
	
	public function all()
	{
		$list = $this->model()->get();
		return $list;
	}
	
	public function find($id){
		$model = $this->model->find($id);
		if($model){
			$model = $this->format_right_one($model);
		}
		
		
		return $model;
	}
	public function detail($where){
		$model = $this->model;
		foreach($where as $k=>$v){
			$model = $model->where($k,$v);
		}
		return $model->first();
	}
	
	public function index($req,$extra=''){
		$where['and'] = $this->list_where($req);
		$where['like'] = $this->list_where_like($req);
		$where['join'] = array();
		$where['raw'] = $this->list_where_raw($req);
		//list search
		$search = $this->list_search($req);
		//print_r($search);exit;
		if(isset($search['and'])){
			$where['and'] = array_merge($where['and'],$search['and']);
		}
		if(isset($search['like'])){
			$where['like'] = array_merge($where['like'],$search['like']);
		}
		if(isset($search['raw'])){
			$where['raw'] = array_merge($where['raw'],$search['raw']);
		}
		
		$limit = 10;
		if($req->limit){
			$limit = $req->limit;
		}
		//print_r($where);exit;
		$list = $this->lists($where,$this->list_order($req),$limit,$req->is_count);
		
		//print_r($list);exit;
		return $list;
	}
	
	public function lists($where,$order=array(),$limit='10',$count=false){
		$list =  $this->model();
		
		$where_and = array();
		$where_like = array();
		$where_join = array();
		$where_raw = array();
		if(array_key_exists('and',$where)){
			$where_and = $where['and'];
		}
		if(array_key_exists('like',$where)){
			$where_like = $where['like'];
		}
		if(array_key_exists('join',$where)){
			$where_join = $where['join'];
		}
		if(array_key_exists('raw',$where)){
			$where_raw = $where['raw'];
		}
		
		//默认过滤
		
		//print_r($arr_where);
		foreach($where_and as $key=>$val){
			$list = $list->where($key,$val);
		}
		foreach($where_like as $key=>$val){
			$list = $list->where($key,'like',$val);
		}
		foreach($where_join as $key=>$val){
			if($key=='resume_true_name'){
				$list = $list->join('posts',function($join){
					$join->on('users.id','=','posts.user_id')
					->where('posts.id','>',1);
				});
			}
			
		}
		foreach($where_raw as $key=>$val){
			$list = $list->whereRaw($val);
		}
		
		if(empty($order)){
			//$order = $this->list_order();
			$list2 = $list;
		}
		foreach($order as $k=>$v){
			$list2 = $list->orderBy($k,$v);
		}
		//计数接口
		if($count){
			return $list2->count();
		}
		
		//在分页之前，做特殊处理：比如统计资源下载列表
		$this->list_before_pageinate($list2);
		
		if($limit=='111'){
			//$list2 = $list2->setPageName('p'.$this->mn());
			$list2 = $list2->paginate($limit, ['*'], 'p'.$this->mn());
		}else{
			$list2 = $list2->paginate($limit, ['*'], 'p'.$this->mn());
		}
		
		$list2 = $this->format_list($list2,$list);
		//print_r($list);
		
		return $list2;
	}
	
	public function list_before_pageinate($list){
		return $list;
	}
	
	protected function list_where($req){
		return array();
	}
	
	public function list_order($req){
		$rtn = array();
		if($req->orderby){
			$orderbys = explode('__',$req->orderby);
			$rtn[$orderbys[0]] = $orderbys[1];
		}else{
			$rtn = array($this->pk()=>'desc');
		}
		return $rtn;
	}
	
	public function pk(){
		return $this->model()->pk();
	}
	
	protected function list_search($req){
		$where = array();
		$where_raw = array();
		//s_key
		if(isset($req->s_key) && $req->s_key!=''){
			$where_raw[] = $this->list_search_sk($req);
			session(['s_key'=>$req->s_key]);
		}else{
			session(['s_key'=>'']);
		}
		
		$names = $this->list_search_names($req);
		foreach($names as $name){
			$sname = 's_'.$name;
			if(!isset($req->$name) || $req->$name==''){
				session([$sname=>'']);
				continue;
			}
			$where[$name] = $req->$name;
			session([$sname=>$req->$name]);
		}
		//
		$search_like = $this->list_search_like_names($req);
		$where_like = array();
		foreach($search_like as $name=>$like){
			//
			if(is_numeric($name)){
				$name = $like;
				$like = '%$%';
			}
			$s_name = 's_'.$name;
			if(!isset($req->$name) || $req->$name==''){
				session([$s_name=>'']);
				continue;
			}
			$like = str_replace('$', $req->$name, $like);
			$where_like[$name] = $like;
			session([$s_name=>$req->$name]);
		}
		$rtn['and'] = $where;
		$rtn['like'] = $where_like;
		$rtn['raw'] = $where_raw;
		//print_r($rtn);exit;
		return $rtn;
	}
	
	protected  function list_search_like_names($req){
		return array();
	}
	
	protected  function list_search_sk($req){
		$names = $this->list_search_sk_names($req);
		$sk = $req->s_key;
		$sql = '';
		foreach($names as $name){
			$sql .= "$name like '%$sk%' or ";
		}
		$sql = substr($sql,0,-3);
		return $sql;
	}
	
	protected function list_search_sk_names($req){
		return array();
	}
	
	public function list_render_names($req){
		return $this->list_search_names($req);
	}
	
	public function list_search_names($req){
		return array();
	}
	
	protected function list_where_like($req){
		return array();
	}
	protected function list_where_raw($req){
		return array();
	}
	
	public function format_list($list,$model){
		$list = $this->format_dict($list);
		//每个列表必须 format；
		$list = $this->format_right($list);
		
		return $list;
	}
	
	public function format_right($list){
	
		foreach($list as $key=>$row){
			$row = $this->format_right_one($row);
			//生成顺序号:Begin from 1;
			if(is_object($list)){
				$sn = $list->perPage() * ($list->currentPage()-1)+$key+1;
				$row->sn = $sn;
			}
			
			
			$list[$key] = $row;
		}
	
		return $list;
	}
	public function format_right_one($model){
		/*
		if(!$row){
			return;
		}
		$grole_id = session('grole_id');
		$guid = session('guid');
		$record_uid = 0;
		if(is_array($row)){
			$record_uid = $row['uid'];
		}else{
			$record_uid = $row->uid;
		}
		
		$redit = false;
		if($grole_id =='3' || $guid==$record_uid){
			$redit = true;
		}
		
		if(is_array($row)){
			$row['redit']=$redit;
		}else{
			$row->redit = $redit;
		}
		
		*/
		return $model;
	}
	
	public function format_dict($list){
		
			foreach($list as $key=>$row){
				$row = $this->format_dict_one($row);
				$list[$key] = $row;
			}
		
		return $list;
	}
	
	public function format_dict_one($row){
		//print_r($row);
		$arr = $this->format_names();
		foreach($arr as $col=>$code){
				//根据列值取转义后的:可能是数组，也可能是对象
				if(is_array($row)){
					$t = Cache::get('_t_'.$code.'_'.$row[$col]);
					//print_r('_t_'.$code.'_'.$row[$col]);echo ',';print_r($t);echo '|';
					
					$row[$col.'_t'] = $t;
				}else if(isset($row->$col)){
					$t = Cache::get('_t_'.$code.'_'.$row->$col);
					//print_r('_t_'.$code.'_'.$row[$col]);echo ',';print_r($t);echo '|';
					$ncol = $col.'_t';
					$row->$ncol = $t;
				}
				
				
		}
		return $row;
	}
	
	
	//对下拉列表名字进行转义
	public function format_names(){
		return array();
	}
	
	public function edit($id,$extra=''){
		//若 id 为0，则返还一个空的
		if($id=='0'){
			//todo...
			$model = $this->model->find($id);
		}else{
			$model = $this->model->find($id);
		}
		
		$model = $this->format_dict_one($model);
		$model = $this->format_right_one($model);
		
		return $model;
	}
	
	public function store($inputs,$pid)
	{
		//print_r($inputs);
		$model = $this->model();
		$this->fill_data($model,$inputs);
		//添加共同数据
		$this->format_model($model,array());
		$model->save();
		//print_r($model);exit;
		$this->post_store($model,$inputs);
		return $model;
	}
	
	protected function pre_store($data){
		
	}
	
	protected function post_store($model,$inputs){
		$this->post_replace($model,$inputs);
	}
	
	protected function post_replace($model,$inputs){
	
	}
	
	public function update($id, $inputs, $extra=''){
		$model = $this->model->findOrFail($id);
		$arr = $model->get();
		//print_r($inputs);
		$this->fill_data($model,$inputs);
		//print_r($model);
		//common
		//$model->utime = time();
		//print_r($model);
		$this->format_model($model,$arr);
		//print_r($model);exit;
		$model->save();
		$this->post_update($model,$inputs);	
		return $model;
	}
	
	public function fill_data($model,$inputs){
		$model->fill($inputs);
	}
	
	protected function post_update($model,$inputs){
		$this->post_replace($model,$inputs);
	}
	
	public function format_model($model,$old){
		return $model;
	}
	
	
	
	public function destroy($ids,$extra='')
	{
		$arr = explode(",",$ids);
		$rtn = array();
		foreach($arr as $id){
			$model = $this->model->findOrFail($id);
			if($this->pre_destroy($model)){
				$model->delete();
			}
			$this->post_destroy($model);
		}
		return $rtn;
	}
	
	protected function pre_destroy($model){
		return true;
	}
	protected function post_destroy($model){
	
	}
	public function delete($where){
		foreach($where as $k=>$v){
			$model = $this->model()->where($k,$v);
		}
		$model->delete();
	}
	//对文件进行统一处理
	public function format_files($model,$cols){
		foreach($cols as $col){
			$this->format_file($model, $col);
		}
	}
	
	//绑定操作
	public function bind($mn,$type,$id){
		$list = array();
		
		
		$rtn['list'] = $list;
		$rtn['render'] = '';
		return $rtn;
	}
	
	public function bind_user_default_channel($uid,$op,$default){
		//echo $uid.$op.$default;exit;
		if($op=='1' && $default){
			DB::table('users')->where('user_id',$uid)->update(array('default_channel'=>$default));
			//
			if(session('gc_old_version')){
				DB::table('user_info')->where(array('server_id'=>session('gsid'),'user_id'=>$uid,'key'=>'7'))->update(array('value'=>$default));
			}
		}else if($op=='-1'){
			//解除默认，则选择另一个编组为默认；且该编组没有被删除
			$list = DB::table('channel_users')->join('channels',function($join){
					$join->on('channels.channel_id','=','channel_users.cid')
					->where('channels.state','=',0);
				})->where('uid',$uid)->get();
			foreach($list as $v){
				$default = $v->cid;
			}
			//echo $default;exit;
			DB::table('users')->where('user_id',$uid)->update(array('default_channel'=>$default));
			//
			if(session('gc_old_version')){
				DB::table('user_info')->where(array('server_id'=>session('gsid'),'user_id'=>$uid,'key'=>'7'))->update(array('value'=>$default));
			}
		}
	
	
	}
	
	//根据设备 id 拼接设备的相关信息
	public function device_info($did){
		$device_info = DB::table('device')->find($did);
		if(!$device_info){
			return false;
		}
		$dict_info = DB::table('admin_dict')->find($device_info->type);
		$device_info->dict_max = $dict_info->max;
		
		$dynamic = DB::table('admin_dynamic')->where('pid',$device_info->type)->get();
		
		return $device_info;
	}
	
	public function bind_device_user_type($op,$did,$uid){
		$device_info = DB::table('device')->find($did);
		$dict_info = DB::table('admin_dict')->find($device_info->type);
		
		if($dict_info->code=='phone'){
			return $this->bind_device_user_mobile($op, $did, $uid);
		}else if($dict_info->code=='pc'){
			return $this->bind_device_user_pc($op, $did, $uid);
		}
	}
	
	public function bind_device_user_mobile($op,$did,$uid){
		//
		//Log::info($op.';did:'.$did.';uid:'.$uid);
		$device_info = DB::table('device')->find($did);
		$dict_info = DB::table('admin_dict')->find($device_info->type);
		//设备类型不是手机
		if($dict_info->code!='phone'){
			return;
		}
		//若解绑，则初始化
		if($op==-1){
			DB::table('user_info')->where('user_id',$uid)->where('key','8')->update(array('value'=>'-1'));
			return;
		}
	
		$imei = DB::table('admin_dynamic')->where('pid',$device_info->type)->where('code','imei')->first();
		$imei_id = $imei?$imei->id:0;
		$imsi = DB::table('admin_dynamic')->where('pid',$device_info->type)->where('code','imsi')->first();
		$imsi_id = $imsi?$imsi->id:0;
		//取值
		$imei_data = DB::table('admin_dynamic_data')->where(array('record_id'=>$did,'type_id'=>$dict_info->id,'dynamic_id'=>$imei_id))->first();
		$imei_val = $imei_data?$imei_data->data:'';
	
		$imsi_data = DB::table('admin_dynamic_data')->where(array('record_id'=>$did,'type_id'=>$dict_info->id,'dynamic_id'=>$imsi_id))->first();
		$imsi_val = $imsi_data?$imsi_data->data:'';
	
		$val = $imei_val.'_'.$imsi_val.'_';
		DB::table('user_info')->where('user_id',$uid)->where('key','8')->update(array('value'=>$val));
	
	}
	//绑定与解绑pc设备，需进行的特殊操作。
	public function bind_device_user_pc($op,$did,$uid){
		//
		//Log::info($op.';did:'.$did.';uid:'.$uid);
		$device_info = DB::table('device')->find($did);
		$dict_info = DB::table('admin_dict')->find($device_info->type);
		//设备类型不是手机
		if($dict_info->code!='pc'){
			return;
		}
		//若解绑，则初始化
		if($op==-1){
			DB::table('user_info')->where('user_id',$uid)->where('key','13')->update(array('value'=>'-1'));
			return;
		}
	
		$uuid = DB::table('admin_dynamic')->where('pid',$device_info->type)->where('code','uuid')->first();
		$uuid_id = $uuid?$uuid->id:0;
	
		//取值
		$uuid_data = DB::table('admin_dynamic_data')->where(array('record_id'=>$did,'type_id'=>$dict_info->id,'dynamic_id'=>$uuid_id))->first();
		$uuid_val = $uuid_data?$uuid_data->data:'';
	
		DB::table('user_info')->where('user_id',$uid)->where('key','13')->update(array('value'=>$uuid_val));
	
	}
	
	public function sid(){
		return '1';
	}
	

	
	
}
