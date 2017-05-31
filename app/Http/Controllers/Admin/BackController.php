<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Controllers\MisController;

/**
 * 后台共用控制器
 * BackController
 */
class BackController extends MisController
{
    
    public function __construct()
    {
    }
    
    protected function mis(){
    	return 'admin';
    }
    
    public function ice(){
    	
    }
    
}
