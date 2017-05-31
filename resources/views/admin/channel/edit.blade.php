@extends('admin.back') @section('content-header') @parent
<h1>
	部门管理 <small>部门</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
	<li><a href="{{ route('admin.article.index') }}">部门管理 - 部门</a></li>
	<li class="active">部门管理</li>
</ol>
@stop @section('content') 
@if(Session::has('fail'))
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon icon fa fa-warning"></i> 提示！
	</h4>
	{{ Session::get('fail') }}
</div>
@endif @if($errors->any())
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


@if(isset($data) && $data->channel_id)
<h2 class="page-header">修改部门</h2>
<form method="post"
	action="{{ route('admin.channel.update', $data->channel_id) }}"
	accept-charset="utf-8" onsubmit="return form_check('{{$mn}}');">
	<input name="_method" type="hidden" value="put"> 
@else
<h2 class="page-header">新增部门</h2>
	<form method="post" name="form" id="form_follow"
		action="{{ route('admin.channel.store') }}" accept-charset="utf-8"
		enctype="multipart/form-data" onsubmit="return form_check('{{$mn}}');">
		@endif 
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="nav-tabs-custom">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab"
					aria-expanded="true">主要内容</a></li>
<!-- 				<li class=""><a href="#tab_2" data-toggle="tab" -->
<!-- 					aria-expanded="false">附加内容</a></li> -->
			</ul>

			<div class="tab-content">
				{{-- 这里需兼顾初次传入，以及提交过未通过的闪存数据 --}}
				<div class="tab-pane active" id="tab_1">
					<div class="form-group">
						<label>部门名称<small class="text-red">*</small></label> <input style="width:300px;"
							type="text" class="form-control" name="name" autocomplete="off"
							value="{{ Input::old('name', isset($data) ? $data->name : null) }}"
							placeholder="部门名称">
					</div>
					
					
					<div class="form-group">
						<label>上级部门<small class="text-red">*</small></label> 
						<div class="input-group">
							@if(isset($data) && $data->channel_id)
							<select  style="min-width:380px;display:none" name="parent_id">
							<option type="text" value ="{{$data->parent_ids}}" ></option>
							</select>
							{{$data->parent_ids->name}}
							@else
							<select data-placeholder="选择..." class="chosen-select" style="min-width:380px;" name="parent_id">
                          
                          @foreach ($parent_channel as $v)
                            <option value="{{ $v->channel_id }}" {{ (isset($data) && $data->parent_id == $v->channel_id) ? 'selected':'' }}>
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
					
					<div class="form-group">
                        <label>部门类型<small class="text-red">*</small></label>
                        <div class="input-group">
                        @if(isset($data) && $data->type)	
                        	@foreach ($types as $v)
                      
                        		@if ($data->type == $v->id) 
                      			 <select style="min-width:280px;display:none" name="type" >
                      			<option  value="{{$v->id}}" name="type"></option>
                      			</select> 
                      			{{$v->name}}
                        		@endif
                        	
                          	@endforeach
                        
                        @else	
                          <select data-placeholder="选择..." class="chosen-select channel_type" style="min-width:280px;" name="type">
                         	
                          @foreach ($types as $v)
                            <option value="{{ $v->id }}" {{ (isset($data) && $data->type == $v->id) ? 'selected':'' }}>{{ $v->name }}</option>
                          @endforeach
                          </select>
                        @endif 
                        </div>
                      </div>
                      
					
					
					<div id="tab_2" class="tab-pane">
            
				
					</div>
					
				</div>
		
<!--                      
      ###################################
      #									#
	  #								    #
	  #   			 扩展                # 
	  #									#
	  #									#
	  ###################################

-->
								
		
			
			<!-- /.tab-pane -->
			<div style="margin: 0 0 20px 20px;padding:0 0 20px 0;">
			<button type="submit" class="btn btn-primary">提交</button>
			<button type="submit" class="btn btn-primary">返回</button>
			</div>
		</div>
		<!-- /.tab-content -->

		</div>
	</form>
	<div id="layerPreviewPic" class="fn-hide"></div>

	@stop @section('extraPlugin')

	<!--引入Layer组件-->
	<script src="{{ asset('plugins/layer/layer.min.js') }}"></script>
	<!--引入iCheck组件-->
	<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"
		type="text/javascript"></script>
	<!--引入Chosen组件-->
	@include('scripts.endChosen') 
	
	<script type="text/javascript">
	$(document).ready(function () {
		dynamic_type({{isset($types) ? $types[0]['id'] : 0}},{{isset($data) ? $data->channel_id : 0}});
	});
	</script>
	@stop 
	
