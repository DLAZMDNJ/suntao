<?php

namespace jamx\Repositories;

use jamx\Models\Fund;
use Cache;


class FundRepository extends VmisRepository
{

   
    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Fund $fund)
    {
        $this->model = $fund;
       
    }
    //下来列表
    public function selectList($order='short_name',$by='asc'){
    	$model = $this->model;
    	if($order){
    		$model = $model->orderBy($order,$by);
    	}
    	$arr =  $model->get();
    	$rtn = array(''=>'请选择');
    	foreach($arr as $val){
    		$code = $val['id'];
    		$name = $val['name'];
    		$rtn[$code] = $name;
    	}
    	return $rtn;
    }
    
    public function cache(){
    	$arr = $this->model->get();
    	foreach($arr as $val){
    		$t = '_t_fund_'.$val['id'];
    		//echo $t.','.$val['name'];
    		Cache::forever($t, $val['name']);
    	}
    }
    public function format_names(){
    	return array('status'=>'fund_status');
    }

}
