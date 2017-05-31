<?php

namespace jamx\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * 权限许可模型
 *
 * @author king <king@jinsec.com>
 */
class Permission  extends Mis
{
	protected $table = 'admin_permissions';
	public function mn(){
		return 'permission';
	}
}
