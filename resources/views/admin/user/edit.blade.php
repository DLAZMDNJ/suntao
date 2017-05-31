@extends('admin.back')

@section('content-header')
@parent
          <h1>
            学生管理
            <small>学生</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li><a href="{{ route('admin.article.index') }}">学生管理 - 学生</a></li>
            @if(isset($data) && $data->user_id)	
            <li class="active">修改学生</li>
            @else
            <li class="active">新增学生</li>
            @endif
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
          
          
			@if(isset($data) && $data->user_id)	
			<h2 class="page-header">修改学生</h2>
                <form method="post" action="{{ route('admin.user.update', $data->user_id) }}" accept-charset="utf-8" onsubmit="return form_check('{{$mn}}');">
                <input name="_method" type="hidden" value="put">
			@else
              <h2 class="page-header">新增学生</h2>
              <form method="post" action="{{ route('admin.user.store') }}" accept-charset="utf-8" onsubmit="return form_check('{{$mn}}');">
             @endif
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="nav-tabs-custom">
                  
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">填写信息</a></li>
                   
                  </ul>

                  <div class="tab-content">
                    
                    <div class="tab-pane active" id="tab_1">
                      <div class="form-group">
                        <label>登录（学号）名 <small class="text-red">*</small> <span class="text-green small"></span></label>
                        @if(isset($data) && $data->user_id)
                        <br><input type="text" value="{{$data->name or ''}}" disabled >
                        @else
                        <input type="text" style="width:300px;" class="form-control" name="name" id="name" autocomplete="off" value="{{isset($data)?$data->name:''}}" placeholder="登录名（学号）">
                        @endif
                        <input type="hidden" name="check_pass" id="check_pass" value="">
                      </div>
                      
                      <div class="form-group">
                      @if(isset($data) && $data->user_id)
                      <label>登录密码<small class="text-red"> (若不输入则为原始密码,输入则可修改)</small> <span class="text-green small"></span></label>
                      <br></b><input type="password" value="******" name="password" autocomplete="off">                  
                      @else
                     	 <label>登录密码<small class="text-red">*</small> <span class="text-green small"></span></label>
                        <input type="password"  style="width:300px;" class="form-control" name="password" autocomplete="off" value="" placeholder="登录密码">
                      @endif
                      </div>
                      
                      <div class="form-group">
                        <label>姓名<small class="text-red">*</small> <span class="text-green small"></span></label>
                        <input style="width:300px;" type="text" class="form-control" name="nick" autocomplete="off" value="{{isset($data)?$data->nick:''}}" placeholder="姓名">
                      </div>
                      <div class="form-group">
                        <label>手机号码<small class="text-red">*</small> <span class="text-green small"></span></label>
                        <input style="width:300px;" type="text" class="form-control" name="phone" autocomplete="off" value="{{isset($data)?$data->phone:''}}" placeholder="手机号">
                      </div>
                      <div class="form-group">
						<label>所属部门<small class="text-red">*</small></label> 
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
                      
                      <div class="form-group">
                        <label>职位<small class="text-red">*</small></label>
                        <div class="input-group">
                        	@if($multi_role=='1')
                        	@foreach($roles as $per)
                          <input type="checkbox"  name="roles[]" value="{{ $per->id }}" {{ ( check_array(isset($data)?$data->roles:array(),'id', $per->id) === true) ? 'checked' : '' }}>
                          <label class="choice" for="roles[]">{{ $per->display_name }}</label>
                          @endforeach
                        	@else
                          <select data-placeholder="选择职位..." class="chosen-select" style="min-width:380px;" name="role_id">
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ (check_array(isset($data)?$data->roles:array(),'id', $role->id) === true) ? 'selected':'' }}>{{ $role->display_name }}</option>
                          @endforeach
                          </select>
                          @endif
                        </div>
                      </div>
                      
                      
                    </div><!-- /.tab-pane -->
                    <!-- /.tab-pane -->

                    <button type="submit" class="btn btn-primary">提交</button>
                    <button type="submit" class="btn btn-primary">返回</button>

                  </div><!-- /.tab-content -->
                  
              </div>
              </form>
          <div id="layerPreviewPic" class="fn-hide">
            
          </div>

@stop

@section('extraPlugin')

  <!--引入iCheck组件-->
  <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
  <!--引入Chosen组件-->
  @include('scripts.endChosen')

@stop


@section('filledScript')
        <!--启用iCheck响应checkbox与radio表单控件-->
        $('input[type="radio"]').iCheck({
          radioClass: 'iradio_flat-blue',
          increaseArea: '20%' // optional
        });
@stop
