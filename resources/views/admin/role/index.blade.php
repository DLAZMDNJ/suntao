@extends('admin.back')

@section('content-header')
@parent
          <h1>
            用户管理
            <small>角色</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">用户管理 - 角色</li>
          </ol>
@stop

@section('content')
@include('block.list_footer')

              @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
                  {{ Session::get('message') }}
                </div>
              @endif
			 
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">角色列表</h3>
                  <div class="box-tips clearfix">
                    <p class="text-red">
                      请谨慎进行新增修改与删除角色（用户组）操作。
                    </p>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                       <th>选择</th>
                        
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','id')">编号{{$orderby_id or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','name')">角色（用户组）名{{$orderby_name or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','display_name')">角色展示名{{$orderby_display_name or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','created_at')">创建日期{{$orderby_created_at or ''}}</a></th>
                        <th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','updated_at')">更新日期{{$orderby_updated_at or ''}}</a></th>
                        <th>操作</th>
                      </tr>
                      <!--tr-th end-->

                      @foreach ($list as $role)
                      <tr>
                      <td class="table-operation">@if($role->id!='1')<input type="checkbox"
						value="{{ $role->vid }}" name="ids"> @endif</td>
                        
                        <td class="text-muted">{{ $role->id }}</td>
                        <td class="text-green">{{ $role->name }}</td>
                        <td class="text-red">{{ $role->display_name }}</td>
                        <td>{{ $role->created_at }}</td>
                        <td>{{ $role->updated_at }}</td>
                        <td>
                           @if(session('gr_update_role'))
						 <a href="{{ route('admin.role.index') }}/{{ $role->id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i>修改</a>  
						 @endif
                            
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div><!-- /.box-body -->

                

              </div>
@stop


@section('filledScript')
        <!--jQuery 提交表单，实现DELETE删除资源-->
        //jQuery submit form
        $('.delete_item').click(function(){
            var action = '{{ route('admin.role.index') }}';
            var id = $(this).data('id');
            var new_action = action + '/' + id;
            $('#hidden-delete-form').attr('action', new_action);
            $('#hidden-delete-form').submit();
        });
@stop
