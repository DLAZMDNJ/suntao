<?php

namespace jamx\Repositories;

use jamx\Models\Service;
use jamx\Models\Customer;


class ServiceRepository extends SaasRepository
{


    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Service $model,
        Customer $related)
    {
        $this->model = $model;
        $this->related = $related;
    }


    
    //服务下拉框
	public function codeList($order='short_name',$by='asc'){
    	/*
		$arr =  $this->model->orderBy($order,$by)->get();
    	foreach($arr as $val){
    		$code = $val['id'];
    		$name = $val['short_name'];
    		$rtn[$code] = $name;
    	}*/
		$rtn['vmis'] = '投资管理系统';
    	return $rtn;
    }
    
    public function selectList($order='id',$by='asc'){
    	$rtn = array();
    	$arr =  $this->model->orderBy($order,$by)->get();
    	foreach($arr as $val){
    		$code = $val['id'];
    		$name = $val['service_code'];
    		$rtn[$code] = $name;
    	}
    	return $rtn;
    }
}
