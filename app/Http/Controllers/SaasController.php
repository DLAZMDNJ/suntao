<?php

namespace jamx\Http\Controllers;
use Illuminate\Http\Request;

class SaasController extends BaseController {
	
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
		$idata = $this->index_data($req);
		$list = $this->repo()->index();
		$idata['list'] = $list;
		return view('saas.'.$this->mn().'.index', $idata);
	}
	
	protected function index_data(Request $req)
	{
		return array();
	}
	
	public function create()
	{
		//
		return view('saas.'.$this->mn().'.edit',$this->create_data());
	}
	
	protected function create_data()
	{
		return array();
	}
	
	public function edit($id)
	{
		//
		$edata = $this->edit_data();
		$data = $this->repo->edit($id);
		$edata['data'] = $data;
		return view('saas.'.$this->mn().'.edit', $edata);
	}
	
	protected function edit_data()
	{
		return array();
	}
	
	public function destroy($id)
	{
		$my = $this->repo->find($id);
		 
		$this->repo->destroy($id);
		return redirect()->route('saas.'.$this->mn().'.index')->with('message', '操作成功！');
		 
	}
	public function show($id)
	{
		$data = $this->repo->edit($id);
		return view('saas.'.$this->mn().'.show', ['data' => $data]);
	}
	
	
}
