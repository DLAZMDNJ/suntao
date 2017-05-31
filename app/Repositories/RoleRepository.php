<?php

namespace jamx\Repositories;

use jamx\Models\Role;
use jamx\Models\Permission;
use Cache;
use DB;

/**
 * 角色（用户组）仓库RoleRepository
 *
 * @author raoyc<king@jinsec.com>
 */
class RoleRepository extends MisRepository
{

    /**
     * The Content instance.
     *
     * @var jamx\Models\Permission
     */
    protected $permission;

    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Role $role
     * @param  jamx\Models\Permission $permission
     * @return void
     */
    public function __construct(
        Role $role,
        Permission $permission)
    {
        $this->model = $role;
        $this->permission = $permission;
    }

    /**
     * 获取所有角色数据
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        $roles = $this->model->all();
        return $roles;
    }

    /**
     * 获取所有权限许可
     *
     * @return Illuminate\Support\Collection
     */
    public function permission()
    {
        $permissions = $this->permission->orderBy('id','asc')->get();
        return $permissions;
    }

    /**
     * 获取当前角色所拥有的权限
     *
     * @param  Illuminate\Support\Collection $role
     * @return array
     */
    public function getRoleCans($role)
    {
        //$perms = $role->perms;  //请参阅Entrust文档：https://github.com/Zizaco/entrust/tree/laravel-5
        $perms = $this->rolePerms($role->id);
        $cans = array();
        foreach ($perms as $p) {
            $cans[] = ['id' => $p->id, 'name' => $p->name];
        }
        return $cans;
    }


    /**
     * 创建或更新Role
     *
     * @param  jamx\Models\Role $role
     * @param  array $inputs
     * @return jamx\Models\Role
     */
    private function saveRole($role, $inputs)
    {
        $role->name = e($inputs['name']);
        $role->display_name = e($inputs['display_name']);
        if (array_key_exists('description', $inputs)) {
            $role->description = e($inputs['description']) ;
        }
        if ($role->save()) {
            if (array_key_exists('permissions', $inputs)) {
                $permissions = $inputs['permissions'];  //这里提交的为数组
                if (is_array($permissions) && $permissions) {
                    //$role->perms()->sync($permissions);  //同步角色权限
                }
            } else {
                //$role->perms()->sync([]);
            }
        }
        $this->cache();
        return $role;
    }


    /**
     * 获取编辑的角色
     *
     * @param  int $id
     * @param  string|array $extra
     * @return Illuminate\Support\Collection
     */
    public function edit($id, $extra = '')
    {
        $role = $this->getById($id);
        return $role;
    }


    /**
     * 删除角色
     *
     * @param  int $id
     * @param  string|array $extra
     * @return void
     */
    public function destroy($id, $extra = '')
    {
        $role = $this->getById($id);
        $role->delete();
    }
    //公司所涉及的角色；
    public function selectList($order='id',$by='asc'){
    	$model = $this->model->where('id','>','2');
    	if($order){
    		$model = $model->orderBy($order,$by);
    	}
    	$arr =  $model->get();
    	$rtn = array(''=>'请选择');
    	foreach($arr as $val){
    		$code = $val['id'];
    		$name = $val['display_name'];
    		$rtn[$code] = $name;
    	}
    	return $rtn;
    }
    //对数据进行缓存；
    public function cache(){
    	$arr = $this->model->get();
    	foreach($arr as $val){
    		$t = '_t_role_'.$val['id'];
    		Cache::forever($t, $val['display_name']);
    
    	}
    }
    //获得当前角色的 perms
    public function rolePerms($role_id){
    	$perms = DB::table('admin_permission_role')->join('admin_permissions',function($join){
    		$join->on('admin_permissions.id','=','admin_permission_role.permission_id');
    	})->where('role_id',$role_id)->get();
    	
    	return $perms;
    }
    
    public function permsIds($role_id){
    	$perms = $this->rolePerms($role_id);
    	$rtn = array();
    	foreach($perms as $v){
    		$rtn[] = $v->id;
    	}
    	return $rtn;
    }
    
    
    
    protected function post_replace($model,$inputs){
    	DB::table('admin_permission_role')->where('role_id',$model->id)->delete();
    	$perms = isset($inputs['permissions'])?$inputs['permissions']:array();
    	foreach($perms as $v){
    		DB::table('admin_permission_role')->insert(array('permission_id'=>$v,'role_id'=>$model->id));
    	}
    }
    
    protected function list_where_raw($req){
    	$rtn = array();
    	$uid = session('guid');
    	if($uid > 0){
    		$rtn[] = "id>2";
    	}
    	return $rtn;
    }
}
