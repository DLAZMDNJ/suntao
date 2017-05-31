@extends('admin.back')

@section('content-header')
@parent
          <h1>
            数据字典
            <small>修改</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li><a href="{{ route('admin.category.index') }}">数据字典 - 修改</a></li>
            <li class="active">修改分类</li>
          </ol>
@stop

@section('content')

          @if(Session::has('fail'))
            <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4>  <i class="icon icon fa fa-warning"></i> 提示！</h4>
              {{ Session::get('fail') }}
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-ban"></i> 警告！</h4>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
            </div>
          @endif
				@if(isset($data) && $data->id)
              <h2 class="page-header">修改</h2>
              <form method="post" action="{{ route('admin.dict.update', $data->id) }}" accept-charset="utf-8">
              <input name="_method" type="hidden" value="put">
              @else
              <h2 class="page-header">新增</h2>
	<form method="post" name="form" id="form_follow"
		action="{{ route('admin.dict.store') }}" accept-charset="utf-8"
		enctype="multipart/form-data">
			@endif
              
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="pid" value="{{ $pid or '' }}">
              <div class="nav-tabs-custom">
                  
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
                  </ul>

                  <div class="tab-content">
                    
                    <div class="tab-pane active" id="tab_1">
                      <div class="form-group">
                        <label>标识 <small class="text-red">*</small> <span class="text-green small">可以为字母或数字</span></label>
                        <input type="text" class="form-control" name="code" autocomplete="off" value="{{ Input::old('code', isset($data) ? $data->code : null) }}" placeholder="标识" maxlength="100">
                      </div>
                      <div class="form-group">
                        <label>名称 <small class="text-red">*</small> <span class="text-green small">显示的名称</span></label>
                       <input type="text" class="form-control" name="name" autocomplete="off" value="{{ Input::old('name', isset($data) ? $data->name : null) }}" placeholder="名称" maxlength="100">
                      </div>
                      @if(isset($data) && $data->pid=='2')
                      <div class="form-group">
                      <label>类型 <small class="text-red">*</small> <span class="text-green small"></span></label>
						<input type="radio"
						class="form-radio" name="type" @if(isset($data) && $data->type==1) checked @endif
						value="1" style="width: 20px;"
						placeholder=""> 用户
						<input type="radio"
						class="form-radio" name="type" @if(isset($data) && $data->type==2) checked @endif
						value="2" style="width: 20px;"
						placeholder=""> 编组
					</div>
                      <div class="form-group">
                        <label>绑定最大数量 <small class="text-red">*</small> <span class="text-green small"></span></label>
                       <input type="text" class="form-control" name="max" autocomplete="off" value="{{ Input::old('max', isset($data) ? $data->max : null) }}" placeholder="" maxlength="100">
                      </div>
                      @endif
                      <div class="form-group">
                        <label>排序 <small class="text-red">*</small> <span class="text-green small"></span></label>
                       <input type="text" class="form-control" name="sort" autocomplete="off" value="{{ Input::old('sort', isset($data) ? $data->sort : null) }}" placeholder="" maxlength="100">
                      </div>
                      <div class="form-group">
                        <label>描述 <small class="text-red">*</small> <span class="text-green small">可不填</span></label>
                        <textarea class="form-control" name="description" cols="45" rows="2" maxlength="200" placeholder="分类描述">{{ Input::old('description', isset($data) ? $data->description : null) }}</textarea>
                      </div>
                    </div><!-- /.tab-pane -->

                    <button type="submit" class="btn btn-primary">提交</button>

                  </div><!-- /.tab-content -->
                  
              </div>
              </form>
@stop


