<?php

namespace jamx\Repositories;

use jamx\Models\Permission;
use jamx\Models\Role;
use DB;

/**
 * 用户仓库UserRepository
 *
 * @author raoyc<king@jinsec.com>
 */
class PermissionRepository extends MisRepository
{
     public function __construct(
        Permission $user,
        Role $role)
    {
        $this->model = $user;
        $this->role = $role;
    }


}
