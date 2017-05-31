@extends('admin.back')

@section('content-header')
@parent
          <h1>
            设施管理 
          </h1>
         
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">设施管理 - 设施</li>
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
                  <h3 class="box-title">设施列表</h3>
                  <div class="box-tools">
                    
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <div class="tablebox-controls" id="ad_search_div" style="display:;">
			<form action="{{ route('admin.device.index') }}" method="get" class="form-inline">
				<div class="form-group pull-right" style="margin-bottom:10px;">
				<div class="form-group">
						<label class="control-label">设施名称：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="nickname"
						value="{{ session('s_nickname') }}" style="width: 100px;"
						placeholder="">
					</div>
					
					<div class="form-group">
						<label class="control-label">设施类型：</label>
						
					</div>
					<div class="form-group">
						<select data-placeholder="选择..." class="form-select" style="min-width:40px;height:40px;" name="type">
                          <option value="">请选择</option>
                          
                          @foreach ($types as $v)
                            <option value="{{ $v->id }}" {{ (session('s_type') == $v->id) ? 'selected':'' }}>{{ $v->name }}</option>
                          @endforeach
                          </select>
						
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
                        <th>选择</th>
                        
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','id')">设施编号{{$orderby_id or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','nickname')">设施名称{{$orderby_nickname or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','type')">设施类型{{$orderby_type or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','belong_gid')">归属部门{{$orderby_belong_gid or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','ctime')">创建时间{{$orderby_ctime or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','is_delete')">已禁用{{$orderby_is_delete or ''}}</a></th>
                        <th>操作</th>
                      </tr>
                      <!--tr-th end-->

                      @foreach ($list as $v)
                      <tr>
                        <td class="table-operation">
                        @if(session('gcid')==$v->created_gid ||session('guid')==0 ||session('guid')==1)
                        <input type="checkbox" value="{{ $v->id }}" name="ids">
                        @endif
                        </td>
                        
                        <td class="text-green">{{$v->id}}</td>
                        <td class="text-green">{{$v->nickname}}</td>
                        <td class="text-red">{{ $v->types?$v->types->name:''}}</td>
                        <td>{{ $v->belong_gids?$v->belong_gids->name:'' }}</td>
                        <td>{{date('Y-m-d',$v->ctime)}}</td>
                        <td>{{ $v->is_delete==1?'是':'否'   }}</td>
                        <td>
						
						<a href="{{ route('admin.device.index') }}/{{ $v->id }}" class=""><i class="fa fa-fw fa-link" title="预览"></i>查看</a>  
						@if($v->is_delete)
                            <a href="javascript:restore('{{$mn}}','{{ $v->id }}')"><i class="fa fa-fw fa-mail-reply" title="恢复"></i>恢复</a>
                        @else
                            @if(in_array('update_user',session('gright')) && (session('gcid')==$v->belong_gid ||session('guid')==0 ||session('guid')==1)) 
                            	<a href="{{ route('admin.device.index') }}/{{ $v->id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i>修改</a>
                            @endif 
                        
	                        @if($v->types && $v->types->type==1)
	                         	@if(session('gr_update_device')) <a href="{{ route('admin.device.user') }}?id={{ $v->id }}&user_id=!0&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>学生绑定</a> @endif
	                         @elseif($v->types && $v->types->type==2)
	                         	@if(session('gr_update_device')) <a href="{{ route('admin.device.channel') }}?id={{ $v->id }}&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>部门绑定</a> @endif
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

@section('extraPlugin')
<!--引入iCheck组件-->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
@stop

