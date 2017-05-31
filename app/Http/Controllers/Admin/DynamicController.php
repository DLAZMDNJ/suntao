<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Controllers\MisController;
use Illuminate\Http\Request;
use jamx\Repositories\DynamicRepository;
use jamx\Repositories\DictRepository;
use jamx\Http\Requests\jamx\CustomerRequest;

/**
 * 控制器
 *
 * @author king <king@jinsec.com>
 */
class DynamicController extends BackController
{
    
    public function __construct(
        DynamicRepository $repo,DictRepository $dict)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->dict = $dict;
    }
    

    
	public function channel(Request $req){
		$type = 'channel';
		
		$model = $this->dict->detail(array('code'=>$type,'pid'=>'0'));
		$where['and'] = array('pid'=>$model->id);
		$list = $this->dict->lists($where);
		$rtn['list'] = $list;
		$rtn['pid'] = $model->pid;
		$rtn['render'] = $this->list_render($list,$req);
		$rtn['mn'] = $this->mn();
		return view($this->mis().'.'.$this->mn().'.'.$type, $rtn); 
	}
	
	public function device(Request $req){
		$type = 'device';
		
		
		$model = $this->dict->detail(array('code'=>$type,'pid'=>'0'));
		$where['and'] = array('pid'=>$model->id);
		$list = $this->dict->lists($where);
		$rtn['list'] = $list;
		$rtn['pid'] = $model->pid;
		$rtn['render'] = $this->list_render($list,$req);
		$rtn['mn'] = $this->mn();
		return view($this->mis().'.'.$this->mn().'.'.$type, $rtn); 
	}
	

	protected function index_data(Request $req)
	{
		return array('pid'=>$req->pid);
	}
	
	protected function common_data($req, $my)
	{
		$types = $this->dict->codeChild('dynamic_type');
		return array('pid'=>$req->pid,'types'=>$types);
	}
	
	
	
	protected function redirect_replace_data($req){
		return array('pid'=>$req->pid);
	}
	//输出 type html
	public function html(Request $req){
		$type_id = $req->type_id;
		$record_id = $req->record_id;
		$html = $this->repo->do_html($type_id,$record_id,true);
		$rtn['html'] = $html;
		echo json_encode($rtn);
	}
	
    
}
