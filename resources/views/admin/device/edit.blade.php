@extends('admin.back') 
@section('content-header') 
@parent
<h1>
	设施管理 <small>设施</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
	<li><a href="{{ route('admin.article.index') }}">设施管理 - 设施</a></li>
	<li class="active"></li>
</ol>
@stop 
@section('content') 
@if(Session::has('fail'))
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon icon fa fa-warning"></i> 提示！
	</h4>
	{{ Session::get('fail') }}
</div>
@endif 
@if($errors->any())
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon fa fa-ban"></i> 警告！
	</h4>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li> @endforeach
	</ul>
</div>
@endif


@if(isset($data) && $data->id)
<h2 class="page-header">修改设施</h2>
<form method="post"
	action="{{ route('admin.device.update', $data->id) }}"
	accept-charset="utf-8" onsubmit="return form_check('{{$mn}}');">
	 
	<input name="_method" type="hidden" value="put"> 
	@else
	<h2 class="page-header">新增设施</h2>
	<form method="post" name="form" id="form_follow"
		action="{{ route('admin.device.store') }}" accept-charset="utf-8"
		enctype="multipart/form-data" onsubmit="return form_check('{{$mn}}');">
		@endif 
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input name="id" id="id" type="hidden" value="{{$data->id or ''}}">
		<div class="nav-tabs-custom">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab"
					aria-expanded="true">主要内容</a></li>
				
			</ul>

			<div class="tab-content">
				{{-- 这里需兼顾初次传入，以及提交过未通过的闪存数据 --}}
				<div class="tab-pane active" id="tab_1">
					<div class="form-group">
						<label>设施名称<small class="text-red">*</small></label> <input style="width:300px;"
							type="text" class="form-control" name="nickname"
							autocomplete="off"
							value="{{ Input::old('nickname', isset($data) ? $data->nickname : null) }}"
							placeholder="设施名称">
					</div>
					@if(count($types)>1)
					<div class="form-group">
                        <label>设施类型<small class="text-red">*</small></label>
                        <div class="input-group">
                        	@if(isset($data) && $data->type)
                        		
                        		@foreach ($types as $v)
                        			@if ($data->type == $v->id) 
                        			<select style="min-width:280px;display:none" name="type" id="channel_type">
                        			<option type="text" value="{{ $v->id }}" ></option>
                        			</select>
                        			{{ $v->name }}
                        			@endif
                          		@endforeach
                        	@else
                        		<select data-placeholder="选择..." class="chosen-select channel_type" style="min-width:280px;" name="type" id="channel_type">
	                       @foreach ($types as $v)
     	                      <option value="{{ $v->id }}" {{ (isset($data) && $data->type == $v->id) ? 'selected':'' }}>{{ $v->name }}</option>
                           @endforeach
         	                   </select>
                         @endif
                        </div>
                      </div>
                      @endif
                      <div class="form-group">
						<label>归属部门<small class="text-red">*</small></label> 
						<div class="input-group">
							@if(false && isset($data) && $data->belong_gid)
							{{$data->belong_gids?$data->belong_gids->name:''}}
							<input type="hidden" name="belong_gid" value="{{$data->belong_gid}}">
							@else
							<select data-placeholder="选择..." class="chosen-select" style="min-width:380px;" name="belong_gid">
                          
                          @foreach ($belong_gid as $v)
                            <option value="{{ $v->channel_id }}" {{ (isset($data) && $data->belong_gid == $v->channel_id) ? 'selected':'' }}>
                            	@for($i=0;$i<$v->level;$i++)
                            	&nbsp;&nbsp;&nbsp;&nbsp;
                            	@endfor
                            	{{ $v->name }}
                            </option>
                          @endforeach
                          </select>
                          @endif
                          </div>
					</div>
                     
					<div class="form-group hide">
						<label>设施建档时间</label> <input type="text" class="form-control datepicker"
							name="ctime" autocomplete="off"
							value="{{ Input::old('ctime', isset($data) ? date('Y-m-d',strtotime($data->ctime)) : null) }}"
							placeholder="设施标识码">
					</div>
					<div class="tab-pane" id="tab_2">
                      
            	</div>
					

				</div>
				<!-- /.tab-pane -->
				

				<button type="submit" class="btn btn-primary">提交</button>
				<button type="submit" class="btn btn-primary">返回</button>

			</div>
			<!-- /.tab-content -->

		</div>
	</form>
	<div id="layerPreviewPic" class="fn-hide"></div>

	@stop 
	@section('extraPlugin')

	<!--引入Layer组件-->
	<script src="{{ asset('plugins/layer/layer.min.js') }}"></script>
	<!--引入iCheck组件-->
	<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"
		type="text/javascript"></script>
	<!--引入Chosen组件-->
	@include('scripts.endChosen') 
	
	
	<script type="text/javascript">
	$(document).ready(function () {
		dynamic_type({{isset($types) ? $types[0]['id'] : 0}},{{isset($data) ? $data->id : 0}});
	});
	</script>
	@stop 

	