<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Repositories\PermissionRepository;

/**
 * 权限控制器
 *
 * @author king <king@jinsec.com>
 */
class PermissionController extends BackController
{

    /**
     * The RoleRepository instance.
     *
     * @var jamx\Repositories\RoleRepository
     */
    protected $role;


    public function __construct(
        PermissionRepository $role)
    {
        parent::__construct();
        $this->repo = $role;
        if (! user('object')->can('manage_role')) {
            $this->middleware('deny403');
        }
    }
    
}
