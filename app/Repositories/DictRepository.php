<?php

namespace jamx\Repositories;

use jamx\Models\Content;
use jamx\Models\Dict;
use Cache;


class DictRepository extends MisRepository
{


    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Dict $dict,
        Content $content)
    {
        $this->model = $dict;
        $this->content = $content;
    }
    
    protected function list_where($req){
    	$pid = $req->pid;
    	if(!$pid){
    		$pid = 0;
    	}
    	return array('pid'=>$pid);
    }
    

    /**
     * 获取元模型所有类型
     *
     * @return array
     */
    private function getModelTypes()
    {
        return [
            'category', //分类
            'tag', //标签
        ];
    }

    /**
     * 获取所有数据
     *
     * @param  
     * @return Illuminate\Support\Collection
     */
    /*
    public function all()
    {
        $metas = $this->model->get();
        return $metas;
    }*/

    /**
     * 创建或更新
     *
     * @param  jamx\Models\Meta $meta
     * @param  array $inputs
     * @return jamx\Models\Meta
     */
    private function saveDict($meta, $inputs)
    {
        $meta->pid              = e($inputs['pid']);
        $meta->code              = e($inputs['code']);
        $meta->name              = e($inputs['name']);
        $meta->sort              = e($inputs['sort']);
        $meta->description       = e($inputs['description']);
      	
        $meta->save();
        return $meta;
    }

    /**
     * 检查当前子类
     *
     * 
     * @param  int $id
     * @return boolean 如果有，则返回true，否则返回false
     */
    public function hasSubContent($id)
    {
        
            $sub = $this->model->where('pid', '=', $id)->get();
            if ($sub->isEmpty()) {
                return false;
            } else {
                return true;
            }
        
    }

    
    public function find($id){
    	return $this->model->findOrFail($id);
    }
    
    //获得 dict list:所有下拉菜单接口 
    public function codeList($code,$order='sort',$by='desc'){
    	if($code=='role'){
    		return RoleRepository::sselectList();
    	}
    	$my = $this->model->where('code', '=', $code)->first();
    	if(!$my){
    		return array();
    	}
    	//print_r($my);exit;
    	$rtn = array(''=>'请选择');
    	$arr =  $this->model->where('pid', '=', $my->id)->orderBy($order,$by)->get();
    	foreach($arr as $val){
    		$code = $val['code'];
    		$name = $val['name'];
    		$rtn[$code] = $name;
    	}
    	return $rtn;
    }
    public function codeListYear(){
    	$begin = 2000;
    	$end = 2017;
    	$rtn = array(''=>'请选择');
    	for($i=$begin;$i<$end;$i++){
    		$rtn[$i] = $i;
    	}
    	return $rtn;
    }
    public function cache(){
    	$arr = $this->model->orderBy('sort','desc')->get();
    	foreach($arr as $val){
    		$pcode = $val['code'];
    		$child = $this->model->where('pid', '=', $val['id'])->orderBy('sort','desc')->get();
    		foreach($child as $c){
    			$t = '_t_'.$pcode.'_'.$c['code'];
    			//echo $t.','.$c['name'].',';
    			Cache::forever($t, $c['name']);
    		}
    		
    	}
    	$this->cache_industry();
    	$this->cache_terminal();
    }
    
    public function cache_industry(){
    	$my = $this->model->where('code', '=', 'com_industry_main')->first();
    	if(!$my){
    		return array();
    	}
    	$arr = $this->model->where('pid',$my['id'])->get();
    	foreach($arr as $val){
    		$t = '_t_industry_'.$val['code'];
    		$n = $val['name'];
    		//echo $t.','.$n.'|';
    		Cache::forever($t,$n );
    		$child = $this->model->where('pid', '=', $val['id'])->get();
    		foreach($child as $c){
    			$tt = '_t_industry_'.$c['code'];
    			$nn = $c['name'];
    			//echo $tt.','.$nn.',/';
    			Cache::forever($tt, $nn);
    		}
    	
    	}
    }
    //项目终止原因
    public function cache_terminal(){
    	$my = $this->model->where('code', '=', 'inve_mgnt_proj_termi_reason')->first();
    	if(!$my){
    		return array();
    	}
    	$arr = $this->model->where('pid',$my['id'])->get();
    	foreach($arr as $val){
    		$t = '_t_terminal_'.$val['code'];
    		$n = $val['name'];
    		//echo $t.','.$n.'|';
    		Cache::forever($t,$n );
    		$child = $this->model->where('pid', '=', $val['id'])->get();
    		foreach($child as $c){
    			$tt = '_t_terminal_'.$c['code'];
    			$nn = $c['name'];
    			//echo $tt.','.$nn.',/';
    			Cache::forever($tt, $nn);
    		}
    		 
    	}
    }
    
    
    //生成名称的翻译数组
    public function codeName($code,$val){
    	$list = $this->codeList($code);
    	foreach($list as $row){
    		if($row['code']==$val){
    			return $row['name'];
    		}
    	}
    	return '';
    }
    
    //处理行业
    public function cascadeList($code,$second_code){
    	$my = $this->model->where('code', '=', $code)->first();
    	if(!$my){
    		return array();
    	}
    	//print_r($my);
    	$code_id = $my['id'];
    	$son = $this->model->where('pid',$code_id)->where('code',$second_code)->first();
    	//print_r($son['id']);
    	$list = $this->model->where('pid',$son['id'])->get();
    	//print_r($list);
    	return $list;
    	
    }
    
    //根据 code 取得子列表
    public function codeChild($code,$pid=0){
    	$model = $this->detail(array('code'=>$code,'pid'=>$pid));
    	$where['and'] = array('pid'=>$model->id);
    	$list = $this->lists($where);
    	return $list;
    }
    //设备类型
    public function channel_type(){
    	return $this->codeChild('channel');
    }
    
    public function device_type(){
    	return $this->codeChild('device');
    }
    
    
}
