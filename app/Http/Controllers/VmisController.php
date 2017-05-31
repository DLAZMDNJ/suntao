<?php

namespace jamx\Http\Controllers;
use Illuminate\Http\Request;

class VmisController extends BaseController {

	protected $repo;
	protected $related;
	protected $mn;
	
	
	public function __construct()
	{
		
	}
	
	protected function repo(){
		return $this->repo;
	}
	
	protected function mn(){
		return $this->mn;
	}
	
	public function index(Request $req)
	{
		if(!session('guid')){
			return redirect()->route('vmis.login');
		}
		
		$data = $this->index_data($req);
		$search_data = $this->search_data($req);
		$data = array_merge($data,$search_data);
		
		$list = $this->repo()->index($req);
		$data['list'] = $list;
		//
		$stat_data = $this->stat_data($list,$req);
		$data = array_merge($data,$stat_data);
		
		$data['render'] = $this->list_render($list,$req);
		$data['mn'] = $this->mn();
		$data['guid'] = session('guid');
		//若有 project_id 参数，则放入 url 参数中
		$data['project_id'] = $req->project_id;
		$data['number'] = $req->number;
		$data['guser'] = session('guser');
		//print_r($categories);exit;
		//print_r($data);
		if($req->api=='json'){
			$data['list'] =$list->toArray();
			echo json_encode($data);
		}else{
			return view('vmis.'.$this->mn().'.index', $data);
		}
		
	}
	
	//统计信息
	public function stat_data($list,$req){
		return array();
	}
	
	public function list_render($list,$req){
		$arr = $this->list_render_name($req);
		return $list->appends($arr)->render();
		
	}
	
	public function list_render_name($req){
		$data = array();
		$cols = $this->search_data_names($req);
		foreach($cols as $v){
			$val = $req->$v;
			if($val){
				$data[$v] = $val;
			}
				
		}
		return $data;
	}
	
	protected function index_data($req)
	{
		return array();
	}
	
	
	protected function search_data($req)
	{
		$data = array();
		$cols = $this->search_data_names($req);
		foreach($cols as $v){
			$val = $req->$v;
			//不管有没有都赋值
			$data['s_'.$v] = $val;
			
		}
		return $data;
	}
	
	protected function search_data_names($req)
	{
		return array();
	}
	

	public function create(Request $req)
	{
		//
		if(!session('guid')){
			return redirect()->route('vmis.login');
		}
		
		$edata = $this->create_data($req);
		$edata['mn'] = $this->mn();
		$edata['guser'] = session('guser');
		return view('vmis.'.$this->mn().'.edit',$edata);
	}
	
	protected function create_data($req)
	{
		return array();
	}
	
	public function edit(Request $req,$id)
	{
		//tod do
		if(!session('guid')){
			return redirect()->route('vmis.login');
		}
		
		$req->id = $id;
		
		$edata = $this->edit_data($req);
		$data = $this->repo->edit($id);
		$edata['data'] = $data;
		$edata['mn'] = $this->mn();
		$edata['guser'] = session('guser');
		//print_r($edata);
		return view('vmis.'.$this->mn().'.edit', $edata);
	}
	
	protected function edit_data($req)
	{
		return array();
	}
	
	public function destroy($ids)
	{
		//返还重定向参数
		$data = $this->repo->destroy($ids);
		//echo route('vmis.'.$this->mn().'.index');exit;
		return redirect()->route('vmis.'.$this->mn().'.index',$data)->with('message', '操作成功！');
			
	}
	public function show(Request $req,$id)
	{
		if(!session('guid')){
			return redirect()->route('vmis.login');
		}
		
		$api = $req->api;
		$sdata['data'] = $this->repo->edit($id);
		$sdata['mn'] = $this->mn();
		$sdata['guser'] = session('guser');
		$sdata = array_merge($sdata,$this->show_data($req));
		if($api=='json'){
			echo json_encode($sdata);
		}else{
			return view('vmis.'.$this->mn().'.show', $sdata);
		}
		
	}
	public function show_data($req){
		return array();
	}
}
