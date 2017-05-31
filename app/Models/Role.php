<?php

namespace jamx\Models;

use Zizaco\Entrust\EntrustRole;

/**
 * 用户组（角色）模型
 *
 * @author king <king@jinsec.com>
 */
class Role extends Mis
{
	protected $table = 'admin_roles';
	protected $guarded = array('_token','mn','permissions','from_perm');
	public function mn(){
		return 'role';
	}
	
}
