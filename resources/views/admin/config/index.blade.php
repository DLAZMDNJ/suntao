@extends('admin.back')

@section('content-header')
@parent
          <h1>
            系统管理
            <small>系统配置</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">系统管理 - 系统配置</li>
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

          @if(Session::has('message'))
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
              {{ Session::get('message') }}
            </div>
          @endif

              <h2 class="page-header">系统配置</h2>
              <form method="post" action="{{ route('admin.config.index') }}" accept-charset="utf-8">
              <input name="_method" type="hidden" value="put">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="nav-tabs-custom">
                  
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">业务参数</a></li>
                    
                  </ul>

                  <div class="tab-content">
                    <p class="text-red">请谨慎修改系统配置选项，错误或不合理的修改可能会造成系统运行错误。</p>
                    <div class="tab-pane active" id="tab_1">
                      <div class="form-group">
                        <label>用户多角色支持 <small class="text-green">[multi_role] 1为多角色；0为单角色</small></label>
                        <input type="text" class="form-control" name="data[multi_role]" autocomplete="off" value="{{ $data['multi_role'] }}" placeholder="1为支持多角色，0为每个用户只能单个角色">
                      </div>
                      <div class="form-group">
                        <label>老版本支持 <small class="text-green">[old_version]</small></label>
                        <input type="text" class="form-control" name="data[old_version]" autocomplete="off" value="{{ $data['old_version'] }}" placeholder="1为支持老版本的冗余信息，需要同步操作user_info冗余表，0为不支持">
                      </div>
                      
                      <div class="form-group">
                        <label>显示编组名称 <small class="text-green">[area_show] 1为显示；0为不显示</small></label>
                        <input type="text" class="form-control" name="data[area_show]" autocomplete="off" value="{{ $data['area_show'] }}" placeholder="1为显示，0为不显示">
                      </div>
                      
                      <div class="form-group">
                        <label>资源路径 <small class="text-green">[resource_path]</small></label>
                        <input type="text" class="form-control" name="data[resource_path]" autocomplete="off" value="{{ $data['resource_path'] }}" placeholder="非必须">
                      </div>
                      
                      <div class="form-group">
                        <label>资源是否能删除 <small class="text-green">[resource_delete] 1为能删除；0为不能删除</small></label>
                        <input type="text" class="form-control" name="data[resource_delete]" autocomplete="off" value="{{ $data['resource_delete'] }}" placeholder="1可选显示删除按钮；0绝不显示删除按钮">
                      </div>
                      
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                      
                    </div><!-- /.tab-pane -->

                    <button type="submit" class="btn btn-primary">更新系统配置</button>

                  </div><!-- /.tab-content -->
                  
              </div>
              </form>
          <div id="layerPreviewPic" class="fn-hide">
            
          </div>

@stop

@section('extraPlugin')

  <!--引入Layer组件-->
  <script src="{{ asset('plugins/layer/layer.min.js') }}"></script>
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

        @include('scripts.endSinglePic') {{-- 引入单个图片上传与预览JS，依赖于Layer --}}
@stop
