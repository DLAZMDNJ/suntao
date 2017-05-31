<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests\RoleRequest;
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Repositories\RoleRepository;
use jamx\Repositories\PermissionRepository;
use jamx\Repositories\UserRepository;

/**
 * 角色资源控制器
 *
 * @author king <king@jinsec.com>
 */
class RoleController extends BackController
{

    /**
     * The RoleRepository instance.
     *
     * @var jamx\Repositories\RoleRepository
     */
    protected $role;


    public function __construct(
        RoleRepository $role,PermissionRepository $perms,UserRepository $user)
    {
        parent::__construct();
        $this->role = $role;
        $this->repo = $role;
        $this->perms = $perms;
        $this->user = $user;
        //id 1为超级管理员
        if (user('object')->user_id!=1 && ! user('object')->can('manage_role')) {
            $this->middleware('deny403');
        }
    }
    
    protected function common_data($req,$my){
    	$perms = $this->perms->all();
    	if($my){
    		$cans = $this->role->permsIds($my->id);
    	}else{
    		$cans = array();
    	}
    	$rtn = array('permissions'=>$perms,'cans'=>$cans);
    	$rtn = array_merge($rtn,parent::common_data($req, $my));
    	return $rtn;
    }


    
}
