<?php

namespace jamx\Http\Controllers\Admin;

use jamx\Http\Requests\ArticleRequest;  //请求层
use jamx\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jamx\Repositories\ResourceRepository;  //模型仓库层
use jamx\Repositories\ConfigRepository;  //推荐位仓库层
use jamx\Cache\DataCache;
use Cache;

/**
 * 内容文章资源控制器
 *
 * @author king <king@jinsec.com>
 */
class ResourceController extends BackController
{

//     protected $audio_single; 
//     protected $audio_group;
//     protected $text_single;
//     protected $text_group;
//     protected $record;
//     protected $storfile;
//     protected $source;
    
    public function __construct(
        ResourceRepository $content,
        ConfigRepository $config)
    {
        parent::__construct();
        $this->repo = $content;
        $this->config = $config;
        if (! user('object')->can('manage_resource')) {
            $this->middleware('deny403');
        }
        
    }
    
    protected function index_data(Request $req)
    {
    	$type = $req->type;
    	$type_name = $this->repo->typeName($type);
    	session(['resource_type'=>$req->type]);
    	$resource_path = '';//$this->config->get('resource_path');
    	$rtn = array('type'=>$req->type,'type_name'=>$type_name,'res_path'=>$resource_path);
    	$rtn = array_merge($rtn,parent::index_data($req));
    	//判断是否能删除
    	$resource_delete = $this->config->get('resource_delete');
    	$rtn['resource_delete'] = $resource_delete;
    	//生成下载地址链接
    	
    	
    	return $rtn;
    }
    
    public function common_redirect(Request $req){
    	$type = session('resource_type');
    	return redirect()->route($this->mis().'.'.$this->mn().'.type',['type'=>$type])->with('message', '操作成功！');
    }
    
    public function destroy(Request $req,$ids)
    {
    	$type = $req->type;
    	$this->repo->setModel($this->repo->$type);
    	$arr = explode(",",$ids);
    	foreach($arr as $id){
    		$my = $this->repo->find($id);
    		if($this->pre_destroy($id,$my)){
    			$this->repo->destroy($id);
    		}
    	}
    	return $this->destroy_redirect($req);
    
    }
    
    //下载资源
    public function download(Request $req){
    	$url = $req->url;
    	//$my = $this->repo->detail(array('ref_id'=>$ref_id));
    	$original_name = '资源下载';
    	//echo $original_name;
    	ob_start();
    	$path = $this->config->get('resource_path');
    	$filepath = $path.$url;
    	$date=date("Ymd-H:i:m");
    	header( "Content-type:  application/octet-stream ");
    	header( "Accept-Ranges:  bytes ");
    	header( "Content-Disposition:  attachment;  filename= {$original_name}");
    	$size=readfile($filepath);
    	header( "Accept-Length: " .$size);
    }
    
    public function show(Request $req,$id)
    {
    	$type = $req->type;
    	$data = $this->repo->$type->find($id);
    	$rtn = $this->show_data($req,$data);
    	$rtn['data'] = $data; 
    	$rtn['type'] = $type;
    	return view($this->mis().'.'.$this->mn().'.show', $rtn);
    }
    
}
