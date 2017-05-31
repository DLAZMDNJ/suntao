<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests\DictRequest;
use jamx\Http\Controllers\MisController;
use Illuminate\Http\Request;
use jamx\Repositories\DictRepository;

/**
 * 控制器
 *
 * @author king <king@jinsec.com>
 */
class DictController extends BackController
{
    
    /**
     * The MetaRepository instance.
     *
     * @var jamx\Repositories\MetaRepository
     */
    protected $mn = 'dict';
    


    public function __construct(
        DictRepository $meta)
    {
        parent::__construct();
        $this->repo = $meta;
        
    }
    
    protected function index_data(Request $req)
    {
    	return array('pid'=>$req->pid);
    }
    
    protected function common_data($req, $my)
    {
    	return array('pid'=>$req->pid);
    }
    
    protected function redirect_replace_data($req){
    	return array('pid'=>$req->pid);
    }
}
