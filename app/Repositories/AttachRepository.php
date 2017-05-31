<?php

namespace jamx\Repositories;

use jamx\Models\Attach;
use Symfony\Component\HttpFoundation\Request;
use DB;


class AttachRepository extends VmisRepository
{

    
    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Attach $model)
    {
        $this->model = $model;
        
    }
    //根据 type，record_id 进行过滤
    protected function list_where($req){
    	$type = $req->type;
    	$record_id = $req->record_id;
    	$rtn = array();
    	if($type){
    		$rtn['type']=$type;
    	}
    	if($record_id!=''){
    		$rtn['record_id']=$record_id;
    	}
    	
    	return $rtn;
    }
    
    //保存 attach 记录
    public function save($type,$record_id,$ref_id,$file_path,$file_name,$original_name){
    	$model = $this->model();
    	$model->sid = session("gsid"); 	//saas id
    	$model->uid = session("guid");
    	$model->ctime = time();
    	$model->utime = time();
    	$model->type = $type;
    	$model->record_id = $record_id;
    	$model->ref_id = $ref_id;
    	$model->file_name = $file_name;
    	$model->file_path = $file_path;
    	$model->original_name = $original_name;
    	$model->save();
    	$this->syn_file($type, $record_id);
    }
    //根据 type record_id 生成 file 的查看路径
    public function syn_file($type,$record_id){
    	$where['and'] = array('type'=>$type,'record_id'=>$record_id);
    	$where['like'] = array();
    	$where['join'] = array();
    	$list = $this->lists($where);
    	//print_r($list);exit;
    	$html = '';
    	foreach($list as $v){
    		$html .= '<a href="/'.$v->file_path.'">'.$v->original_name.'</a>&nbsp;';
    	}
    	DB::table('vmis_'.$type)->where('id',$record_id)->update(array('file'=>$html));
    }
    
}
