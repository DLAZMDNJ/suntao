<?php

namespace jamx\Repositories;

use jamx\Models\Dynamic;
use Illuminate\Support\Facades\Input;
use DB;

class DynamicRepository extends MisRepository
{


    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Dynamic $model)
    {
        $this->model = $model;
        
    }
    
    protected function list_where($req){
    	return array('pid'=>$req->pid);
    }
    
    public function list_order($req){
    	return array('sort'=>'asc');
    }
    
    public function dynamic_list($type_id){
    	$where['and'] = array('pid'=>$type_id);
    	$list = $this->lists($where);
    	return $list;
    }
    
    //获得 dynamic data
    public function dynamic_data_list($record_id,$type_id){
    	$data = DB::table('admin_dynamic_data')->where(array('record_id'=>$record_id,'type_id'=>$type_id))->get();
    	return $data;
    }

    //下来列表
    public function selectList($order='short_name',$by='asc'){
    	$arr =  $this->model->orderBy($order,$by)->get();
    	foreach($arr as $val){
    		$code = $val['id'];
    		$name = $val['short_name'];
    		$rtn[$code] = $name;
    	}
    	return $rtn;
    }
    
    public function save_dynamic_data($record_id,$type_id,$inputs){
    	//print_r($inputs);exit;
    	//先删除历史记录
    	DB::table('admin_dynamic_data')->where(array('type_id'=>$type_id,'record_id'=>$record_id))->delete();
    	//
    	$list = $this->dynamic_list($type_id);
    	foreach($list as $v){
    		$data = isset($inputs[$v->code])?$inputs[$v->code]:'';
    		if($v->type=='checkbox'){
    			$data = serialize($data);
    		}
    		DB::table('admin_dynamic_data')->insert(array('record_id'=>$record_id,'type_id'=>$type_id,'dynamic_id'=>$v->id,'data'=>$data));
    	}
    }
    
    public function do_html($type_id,$record_id,$is_edit){
    	//echo $type_id;echo 'aaa';echo $record_id;
    	$where['and'] = array('pid'=>$type_id);
    	$list = $this->lists($where,$this->list_order(''));
    	//print_r($list);
    	//
    
    	$dynamic_ids = array();
    	if($record_id){
    		$data = $this->dynamic_data_list($record_id,$type_id);
    		foreach($data as $v){
    			$dynamic_ids[$v->dynamic_id] = $v->data;
    		}
    	}
    	//print_r($list);exit;
    	$html = '';
    	foreach($list as $v){
    		$type = $v->type;
    		$code = $v->code;
    		$name = $v->name;
    		$description = $v->description;
    		$params = $v->param;
    		$val = isset($dynamic_ids[$v->id])?$dynamic_ids[$v->id]:'';
    		switch($type){
    			case 'text':
    				if($is_edit){
    					$html .= '<div clss="form-group dynamic_'.$type.' dynamic_'.$code.'"><label>'.$name.'</label>
							<input type="text" class="form-control" name="'.$code.'" value="'.$val.'" placeholder="'.$description.'">
									</div>';
    				}else{
    					$html .= '<div clss="form-group dynamic_'.$type.' dynamic_'.$code.'"><label> '.$name.'</label>:
							'.$val.'
									</div>';
    				}
    					
    				break;
    			case 'select':
    				$arr_opt = explode(';',$params);
    				$options = '';
    				$sel_name = '';
    				foreach($arr_opt as $opt){
    					$selected = '';
    					$opt_val = explode(':',$opt);
    					if($opt_val[0]==$val){
    						$selected = ' selected ';
    						$sel_name = $opt_val[1];
    					}
    					$options .= '<option value="'.$opt_val[0].'" '.$selected.'>'.$opt_val[1].'</option>';
    
    				}
    				if($is_edit){
    					$html .= '<div class="form-group"><label>'.$name.'</label><br>
							<select class="chosen-select" style="min-width:280px;" name="'.$code.'"  placeholder="'.$description.'">'.$options.'</select>';
    				}else{
    					$html .= '<div class="form-group"><label>'.$name.'</label>: '.$sel_name.'</div>';
    				}
    					
    				break;
    			case 'radio':
    				$arr_opt = explode(';',$params);
    				$options = '';
    				$sel_name = '';
    				foreach($arr_opt as $opt){
    					$selected = '';
    					$opt_val = explode(':',$opt);
    					if($opt_val[0]==$val){
    						$selected = 'checked="checked"';
    						$sel_name = $opt_val[1];
    					}
    					$options .= '<label><input type="radio" name="'.$code.'" id="'.$code.$v->id.'" value="'.$opt_val[0].'" '.$selected.'>'.$opt_val[1].'</label>';
    						
    				}
    				if($is_edit){
    					$html .= '<div class="radio dynamic_'.$type.' dynamic_'.$code.'">'.$name.'<br>  '.$options.'</div>';
    				}else{
    					$html .= '<div class="radio dynamic_'.$type.' dynamic_'.$code.'">'.$name.':  '.$sel_name.'</div>';
    				}
    					
    				break;
    			case 'checkbox':
    				$arr_val = unserialize($val);
    				$arr_opt = explode(';',$params);
    				$options = '';
    				$sel_name = '';
    				foreach($arr_opt as $opt){
    					$selected = '';
    					$opt_val = explode(':',$opt);
    					if(is_array($arr_val) && in_array($opt_val[0],$arr_val)){
    						$selected = 'checked="checked"';
    						$sel_name .= $opt_val[1].'  ';
    					}
    					$options .= '<label><input type="checkbox" name="'.$code.'[]" id="'.$code.$v->id.'" value="'.$opt_val[0].'" '.$selected.'>'.$opt_val[1].'</label>&nbsp;&nbsp;';
    						
    				}
    				if($is_edit){
    					$html .= '<div class="checkbox dynamic_'.$type.' dynamic_'.$code.'">'.$name.'<br>  '.$options.'</div>';
    				}else{
    					$html .= '<div class="checkbox dynamic_'.$type.' dynamic_'.$code.'">'.$name.':  '.$sel_name.'</div>';
    				}
    					
    				break;
    			case 'time':
    				if($is_edit){
    					$html .= '<div class="form-group dynamic_'.$type.' dynamic_'.$code.'"><label>'.$name.'</label>
							<input type="text" class="form-control datepicker" name="'.$code.'" value="'.$val.'" placeholder="'.$description.'">
									</div>';
    				}else{
    					$html .= '<div class="form-group dynamic_'.$type.' dynamic_'.$code.'"><label>'.$name.'</label>: 
							'.$val.'</div>';
    				}
    					
    				break;
    		}
    	}
    	return $html;
    }
   
}
