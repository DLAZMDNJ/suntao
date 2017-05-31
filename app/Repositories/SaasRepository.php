<?php

namespace jamx\Repositories;

use Illuminate\Support\Facades\Input;

/**
 * repo 基类
 * 
 * 
 *
 * @author king
 */
class SaasRepository extends BaseRepository
{
	protected $model;
	protected $related;//related model
	
	public function model(){
		return $this->model;
	}
	
	public function related(){
		return $this->related;
	}
	
	public function all()
	{
		$list = $this->model()->get();
		return $list;
	}
	
	
	public function index($data='',$extra=''){
		return $this->model->paginate(10);
	}
	
	public function edit($id,$extra=''){
		$meta = $this->model->findOrFail($id);
		
		return $meta;
	}
	public function update($id, $inputs, $extra=''){
		$model = $this->model->findOrFail($id);
		$model->fill(Input::all());
		$model->save();
			
		return $model;
	}
	
	public function store($inputs,$extra='')
	{
	
		$model = $this->model();
		$model->fill(Input::all());
		$model->save();
		 
		return $model;
	}
	
	public function destroy($id,$extra='')
	{
		$meta = $this->model->findOrFail($id);
		 
		$meta->delete();
	}
	
	public function find($id){
		return $this->model->findOrFail($id);
	}
	
	public function detail($where){
		$model = $this->model;
		foreach($where as $k=>$v){
			$model = $model->where($k,$v);
		}
		return $model->first();
	}
	
}
