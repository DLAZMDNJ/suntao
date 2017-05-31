@extends('admin.back')

@section('content-header')
@parent
          <h1>
            学生管理 
     
          
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">学生管理 - 学生列表      
            </li>
             
          </ol>
@stop

@section('content')

              @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
                  {{ Session::get('message') }}
                </div>
              @endif
     
				
 	 @include('block.list_footer')
 

	
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">学生列表</h3>
                  <div class="box-tools">
                    
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                	<div class="tablebox-controls" id="ad_search_div" style="display:;">
			<form action="{{ route('admin.user.index') }}" method="get" class="form-inline">
				<div class="form-group pull-right" style="margin-bottom:10px;">
					
					
					<div class="form-group">
						<label class="control-label">登录名：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="name"
						value="{{ session('s_name') }}" style="width: 100px;"
						placeholder="">
					</div>
					
					<div class="form-group">
						<label class="control-label">姓名：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="nick"
						value="{{ session('s_nick') }}" style="width: 100px;"
						placeholder="">
					</div>
				<!--   	<div class="form-group">
						<label class="control-label">编组名称：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="created_gid"
						value="{{ session('s_created_gid') }}" style="width: 100px;"
						placeholder="">
					</div>
					-->
					<div class="form-group">
						<label class="control-label">职位：</label>
						
					</div>
					<div class="form-group">
						<select data-placeholder="选择..." class="form-select" style="min-width:30px;height:30px;" name="role_id">
                          <option value="">请选择</option>
                          
                          @foreach ($roles as $v)
                            <option value="{{ $v->id }}" {{ (session('s_role_id') == $v->id) ? 'selected':'' }}>{{ $v->display_name }}</option>
                          @endforeach
                          </select>
						
					</div>
					
					
					<div class="form-group">
						<label class="control-label">创建时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="ctime1"
						value="{{ session('s_ctime1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="ctime2"
						value="{{ session('s_ctime2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					
					<div class="form-group">
						<label class="control-label">已禁用：</label>
						
					</div>
					<div class="form-group">
						<input type="radio"
						class="form-radio" name="is_delete" @if(session('s_is_delete')==1) checked @endif
						value="1" style="width: 20px;"
						placeholder=""> 是
						<input type="radio"
						class="form-radio" name="is_delete" @if(session('s_is_delete')==0) checked @endif
						value="0" style="width: 20px;"
						placeholder=""> 否
					</div>
					
					<div class="input-group-btn pull-right" style="padding-right:40px;">
						<button class="btn btn-sm btn-default">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                        <th width="4%">选择</th>
                        <th width="4%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','user_id')">序号{{$orderby_user_id or ''}}</a></th>
                        <th width="4%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','name')">学号{{$orderby_name or ''}}</a></th>
                        <th width="8%"> <a href="javascript:void(0);" onclick="list_sort('{{$mn}}','nick')">姓名{{$orderby_nick or ''}}</a></th>
                        <th width="10%">职位</th>
                        <th width="5%">手机号</th>
                        <th width="6%">创建者</th>
                        <th width="10%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','belong_gid')">所属部门{{$orderby_belong_gid or ''}}</a></th>
                        <th width="13%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','ctime')">创建时间{{$orderby_ctime or ''}}</a></th>
                        <th width="13%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','last_active')">最后登录时间{{$orderby_last_active or ''}}</a></th>
                        <th width="4%"><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','is_delete')">禁用{{$orderby_is_delete or ''}}</a></th>
                        <th width="20%">操作</th>
                      </tr>
                      <!--tr-th end-->
                      
                      @foreach ($list as $v)
                      <tr>
                        <td class="table-operation">
                        @if($v->user_id!='1')
                        <input type="checkbox" value="{{ $v->user_id }}" name="ids">
                        @endif
                        </td>
                        <td>{{ $v->user_id }}</td>
                        <td class="text-muted">{{ $v->name }}</td>
                        <td class="text-green">
                          {{ $v->nick }}
                        </td>
                        
                        <td class="text-red">
                        <?php foreach($v->roles as $role){
                        	if(in_array(session('guid'),array(0,1)) || $role->id>1){
                        		echo $role->display_name.'&nbsp;&nbsp;';
                        	}
                        
                        	
                        	
                        }?>
                          
                        </td>
             			<td>{{$v->phone}}</td>
                        
                        <td>@if($v->created_gids && $v->created_gids->created_uids){{ $v->created_gids->created_uids->nick }}@endif</td>
                        <td>{{ $v->belong_gids?$v->belong_gids->name:'' }}</td>
                        <td>{{ $v->ctime }}</td>
                        <td>{{ $v->last_active }}</td>
                        <td class="text-yellow">
                          @if($v->is_delete)
                          是
                          @else
                          否
                          @endif
                        </td>
                        <td>
                        	@if($v->is_delete)
                            <a href="javascript:restore('{{$mn}}','{{ $v->user_id }}')"><i class="fa fa-fw fa-mail-reply" title="恢复"></i>恢复</a>
                            @else
                            	@if($v->user_id!='1')
	                          		@if(session('gr_update_user')) <a href="{{ route('admin.user.index') }}/{{ $v->user_id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i>修改</a> @endif 
	                            @endif 
	                            @if(in_array('update_user',session('gright')) && $v->is_delete!=1 or session('guid')==0)
	                            <a href="{{ route('admin.user.channel') }}?id={{ $v->user_id }}&state=0&channel_id=!0&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>部门绑定</a> 
	                            <a href="{{ route('admin.user.device') }}?id={{ $v->user_id }}&is_delete=0&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>设施绑定</a> 
	                            @endif
                            
                            @endif
                            
                           
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->


              </div>
              @include('block.delete')
              @include('block.forbid')
@stop

