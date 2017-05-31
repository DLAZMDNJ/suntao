@extends('admin.back') @section('content-header') @parent
<h1>
	设施管理 <small>设施</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
	<li><a href="{{ route('admin.article.index') }}">设施管理 - 设施</a></li>
	<li class="active"></li>
</ol>
@stop @section('content') @if(Session::has('fail'))
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


@if(isset($data) && $data->id)
<h2 class="page-header">查看设施</h2>
<form method="post"
	action="{{ route('admin.device.update', $data->id) }}"
	accept-charset="utf-8">
	
	<input name="_method" type="hidden" value="put"> 
	@else
	<h2 class="page-header">查看设施</h2>
	<form method="post" name="form" id="form_follow"
		action="{{ route('admin.device.store') }}" accept-charset="utf-8"
		enctype="multipart/form-data">
		@endif <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="nav-tabs-custom">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab"
					aria-expanded="true">主要内容</a></li>
				
				
			</ul>

			<div class="tab-content">
				{{-- 这里需兼顾初次传入，以及提交过未通过的闪存数据 --}}
				<div class="tab-pane active" id="tab_1">
					<div class="form-group">
						<label>设施名称<small class="text-red">*</small></label>{{ isset($data) ? $data->nickname : '' }}
					</div>
					
                     
					<div class="form-group">
						<label>设施建档时间</label> {{  isset($data) ? date('Y-m-d',strtotime($data->ctime)) : '' }}
					</div>
					{!!$html or ''!!}
				</div>	
					

				<!-- /.tab-pane -->
				<div class="tab-pane" id="tab_2">
                      
            	</div>
				<button type="button" onclick="javascript:history.go(-1)" class="btn btn-primary margin-bottom" style="margin: 0 0 5px 20px;">返回</button>

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
	@stop 
	
