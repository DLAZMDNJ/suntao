@extends('admin.back') 

@section('content-header') 

@parent
<h1>
	部门管理 
	
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
	<li class="active">部门管理 - 部门</li>
</ol>
@stop 

@section('content') 

@if(Session::has('error11'))
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon fa fa-focus"></i> 错误！
	</h4>
	{{ Session::get('error') }}
	
</div>
@elseif(Session::has('message'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon fa fa-check"></i> 提示！
	</h4>
	{{ Session::get('message') }}
	
</div>
@endif

@include('block.list_footer')

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">部门列表</h3>
		<div class="box-tools">
			 
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<div class="tablebox-controls" id="ad_search_div" style="display:;">
			<form action="{{ route('admin.channel.index') }}" method="get" class="form-inline">
				<div class="form-group pull-right" style="margin-bottom:10px;">
				<div class="form-group">
						<label class="control-label">部门名称：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="name"
						value="{{ session('s_name') }}" style="width: 100px;"
						placeholder="">
					</div>
					
					<div class="form-group">
						<label class="control-label">上级部门：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="parent_id"
						value="{{ session('s_parent_id') }}" style="width: 100px;"
						placeholder="">
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
						<label class="control-label">部门级别：</label>
						
					</div>
					<div class="form-group">
						<select data-placeholder="选择..." class="form-select" style="min-width:40px;height:40px;" name="level">
                          <option value="">请选择</option>
                          <?php $arr=array(1,2,3,4,5,6,7,8,9,10);?>
                          @foreach ($arr as $v)
                            <option value="{{ $v }}" {{ (session('s_level') == $v) ? 'selected':'' }}>{{ $v }}</option>
                          @endforeach
                          </select>
						
					</div>
					
					<div class="form-group">
						<label class="control-label">已禁用：</label>
						
					</div>
					<div class="form-group">
						<input type="radio"
						class="form-radio" name="state" @if(session('s_state')==-1) checked @endif
						value="-1" style="width: 20px;"
						placeholder=""> 是
						<input type="radio"
						class="form-radio" name="state" @if(session('s_state')==0) checked @endif
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
					<th>选择</th>		
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','channel_id')">部门编号{{$orderby_channel_id or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','name')">部门名称{{$orderby_name or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','parent_id')">上级部门{{$orderby_parent_id or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','level')">部门层次{{$orderby_level or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','type')">部门类型{{$orderby_type or ''}}</a></th>			
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','created_uid')">创建者{{$orderby_created_uid or ''}}</a></th>			
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','ctime')">创建时间{{$orderby_ctime or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','state')">禁用{{$orderby_state or ''}}</a></th>
					<th>操作</th>
				</tr>
				<!--tr-th end-->

				@foreach ($list as $v)
				<tr>
					<td class="table-operation">
						@if($v->channel_id)
						<input type="checkbox" value="{{ $v->channel_id }}" name="ids">
						@endif
					</td>
					
					<td class="text-green">{{$v->channel_id}}</td>
					<td class="text-green">{{ $v->name}}</td>
					<td class="text-muted">{{$v->parent_ids?$v->parent_ids->name:''}}</td>
					<td>{{ $v->level }}</td>
					<td>{{ $v->types?$v->types->name:'' }}</td>
					
					<td>{{ $v->created_uids?$v->created_uids->nick:'' }}</td>
					
					<td>{{ date('Y-m-d',$v->ctime) }}</td>
					<td class="text-yellow">
                          @if($v->state==-1)
                          是
                          @else
                          否
                          @endif
                        </td>
					<td>
						
						<a href="{{ route('admin.channel.index') }}/{{ $v->channel_id }}" class=""><i class="fa fa-fw fa-link" title="预览"></i>查看</a>
						@if($v->state==-1)
                            <a href="javascript:restore('{{$mn}}','{{ $v->channel_id }}')"><i class="fa fa-fw fa-mail-reply" title="恢复"></i>恢复</a>
                        @else
                            @if(in_array('update_channel',session('gright'))) <a href="{{ route('admin.channel.index') }}/{{ $v->channel_id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i>修改</a> @endif
                            
                            @if(session('gr_update_channel'))
                            <a href="{{ route('admin.channel.admin') }}?id={{ $v->channel_id }}&is_delete=0&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>管理员绑定</a> 
                            <a href="{{ route('admin.channel.user') }}?id={{ $v->channel_id }}&is_delete=0&user_id=!0&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>用户绑定</a> 
                            <a href="{{ route('admin.channel.device') }}?id={{ $v->channel_id }}&is_delete=0&device_type=2&orderby=utime__desc"><i class="fa fa-fw fa-crosshairs" title=""></i>设备绑定</a> 
                            @endif                 
                        @endif         
					</td>
				</tr>
				@endforeach

			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	
	@include('block.delete')
	@include('block.forbid')
	<!--隐藏型删除表单-->

	<form method="post" action="{{ route('admin.channel.index') }}"
		accept-charset="utf-8" id="hidden-delete-form">
		<input name="_method" type="hidden" value="delete"> <input
			type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>

</div>
@stop 

@section('extraPlugin')
<!--引入iCheck组件-->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
@stop 

