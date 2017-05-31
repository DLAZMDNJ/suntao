<?php

namespace jamx\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

/**
 * 用户模型
 *
 * @author king <king@jinsec.com>
 */
class User extends Mis implements AuthenticatableContract, CanResetPasswordContract
{
    
    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;
    
    protected $table = 'users';
    //protected $fillable = ['server_id', 'name', 'last_channel', 'textture', 'last_active', 'nick', 'state', '3346_id', 'created_gid', 'ctime', 'description','is_delete','default_channel'];
    protected $hidden = ['pw'];
    protected $guarded = ['password','role_id','check_pass'];
    protected $primaryKey = 'user_id';
    const UPDATED_AT = 'last_active';
    const CREATED_AT = 'ctime';

    #********
    #* 此表为复合型的用户数据表，根据type不同确定不同用户
    #* type : Manager 管理型用户
    #* type : Customer 投资型客户
    #********
    //限定管理型用户
    public function scopeManager($query)
    {
        return $query->where('user_type', '=', 'manager');
    }

    //限定投资型客户
    public function scopeCustomer($query)
    {
        return $query->where('user_type', '=', 'customer');
    }
    
    public function mn(){
    	return 'user';
    }
    /*
    public function roles() {
    	return $this->belongsTo('jamx\Models\Role','role_id88','id');
    }*/
    
    public function created_gids() {
    	return $this->belongsTo('jamx\Models\Channel','created_gid','channel_id');
    }
    
    public function belong_gids() {
    	return $this->belongsTo('jamx\Models\Channel','belong_gid','channel_id');
    }
    
    public function can($perm){
    	$user_id = user('object')->user_id;
    	$perms = DB::table('admin_role_user')->join('admin_permission_role',function($join){
					$join->on('admin_role_user.role_id','=','admin_permission_role.role_id');
				})->join('admin_permissions',function($join){
					$join->on('admin_permissions.id','=','admin_permission_role.permission_id');
				})->where('user_id',$user_id)->get();
    	foreach($perms as $v){
    		if($perm==$v->name){
    			return true;
    		}
    	}
		return false;
    }
}
