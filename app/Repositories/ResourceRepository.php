<?php

namespace jamx\Repositories;

use jamx\Models\AudioSingle;
use jamx\Models\AudioGroup;
use jamx\Models\TextGroup;
use jamx\Models\TextSingle;
use jamx\Models\Record;
use jamx\Models\Source;
use jamx\Models\Storfile;

class ResourceRepository extends MisRepository
{

     public function __construct(
        AudioSingle $audio_single,AudioGroup $audio_group,TextGroup $text_group,TextSingle $text_single,Record $record,Source $source,Storfile $storfile)
    {
        $this->audio_single = $audio_single;
        $this->audio_group = $audio_group;
        $this->text_group = $text_group;
        $this->text_single = $text_single;
        $this->record = $record;
        $this->source = $source;
        $this->storfile = $storfile;
        
        $this->model = $audio_single;
       
    }

    public function index($req,$extra='')
    {
        $type = $req->type;
        $this->model = $this->$type;
        
        return parent::index($req);
    }
    
    public function format_right_one($model){
    	//缩略图：
    	$cover = $model->download_url;
    	$pos = strrpos($cover,'.');
    	if($pos){
    		$cover = substr($cover, 0,strrpos($cover,'.')).'.jpg';
    		$model->cover = $cover;
    	}
    	
    	return $model;
    }
    
    public function list_render_names($req){
    	return array('type','oid','iid','uid','gid','start','end','time','StartTime','EndTime');
    }
    
    protected function list_search_sk_names($req){
    	return array('vid');
    }
    
    protected function list_where_raw($req){
    	$rtn = array();
    	//
    	$arr_uid = array('oid','iid','uid');
    	foreach($arr_uid as $name){
    		$v = $req->$name;
    		if($v){
    			$rtn[] = $name." in (select user_id from users where nick like '%$v%')";
    			session(['s_'.$name=>$v]);
    		}else{
    			session(['s_'.$name=>'']);
    		}
    	}
    	//
    	$name = 'gid';
    	$v = $req->$name;
    	if($v){
    		$rtn[] = "gid in (select group_id from groups where name like '%$v%')";
    		session(['s_'.$name=>$v]);
    	}else{
    		session(['s_'.$name=>'']);
    	}
    	//
    	$arr_time = array('start','end','time','StartTime','EndTime');
    	foreach($arr_time as $n){
    		$name = $n.'1';
    		$v = $req->$name;
    		if($v){
    			$vv = strtotime($v.' 00:00:00');
    			$rtn[] = $n." > $vv";
    			session(['s_'.$name=>$v]);
    		}else{
    			session(['s_'.$name=>'']);
    		}
    		$name = $n.'2';
    		$v = $req->$name;
    		if($v){
    			$vv = strtotime($v.' 23:59:59');
    			$rtn[] = $n." < $vv";
    			session(['s_'.$name=>$v]);
    		}else{
    			session(['s_'.$name=>'']);
    		}
    	}
    	
    	return $rtn;
    }
    
    //删除文件；
    protected function post_destroy($model){
    	$file = '';
    	if($model->download_url){
    		$file = $model->download_url;
    	}
    	@unlink($file);
    }
    
    //获得类型的名称
    public function typeName($type){
    	$arr['audio_single'] = '语音一对一';
    	$arr['audio_group'] = '语音群组';
    	$arr['text_group'] = '文本群组';
    	$arr['text_single'] = '文本一对一';
    	$arr['record'] = '视频1';
    	$arr['source'] = '图片';
    	$arr['storfile'] = '视频2';
    	
    	return $arr[$type];
    }
    
    public function list_before_pageinate($list){
    	$list = $list->paginate(1000000);
    	//print_r($list);
    	$dowload_url = '';
    	foreach($list as $v){
    		if($v->FilePath){
    			$dowload_url .= '<p>'.$v->FilePath.'</p>';
    		}
    		
    	}
    	session(['download_url'=>$dowload_url]);
    	//print_r($dowload_url);exit;
    	return $list;
    }
    
}
