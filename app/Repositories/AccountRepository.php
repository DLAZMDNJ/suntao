<?php

namespace jamx\Repositories;

use jamx\Models\Account;
use jamx\Repositories\CustomerRepository;
use jamx\Repositories\SeviceRepository;

class AccountRepository extends SaasRepository
{


    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
       Account $model,CustomerRepository $customer,ServiceRepository $service,UserRepository $user)
    {
        $this->model = $model;
        $this->customer = $customer;
        $this->service = $service;
        $this->user = $user;
    }
    
    //同步到业务系统
    public function syn($account){
    	
    	$sid = $account->customer_id;
    	$username = $account->username;
    	$uinfo = $this->user->detail(array('sid'=>$sid,'username'=>$username));
    	if($uinfo){
    		//update
    		$inputs = array('sid'=>$sid,'username'=>$username,'true_name'=>$account->true_name,'password'=>$account->password,'founder'=>1,'role_id'=>3,'gender'=>$account->gender,'status'=>1);
    		$this->user->update($uinfo->id,$inputs);
    	}else{
    		//insert
    		$inputs = array('sid'=>$sid,'username'=>$username,'true_name'=>$account->true_name,'password'=>$account->password,'founder'=>1,'role_id'=>3,'gender'=>$account->gender,'status'=>1);
    		$this->user->store($inputs);
    	}
    	
    }
    //检查服务
    public function checkServ($serv,$username,$password){
    	$rtn['message'] = '';
    	//查询客户是否存在
    	$customer = $this->customer->detail(array('domain_self'=>$serv));
    	if(!$customer){
    		$customer = $this->customer->detail(array('domain_second'=>$serv));
    	}
    	if(!$customer){
    		$rtn['message'] = '当前域名未开通服务';
    		return $rtn;
    	}
    	//检查服务是否开通
    	$service = $this->service->detail(array('customer_id'=>$customer->id,'service_code'=>'vmis'));
    	if(!$service){
    		$rtn['message'] = '您未开通服务或服务已经过期';
    		return $rtn;
    	}
    	//检查帐号是否存在
    	$rtn['sid'] = $customer->id;
    	$rtn['logo'] = $customer->logo;
    	return $rtn;
    }


}
