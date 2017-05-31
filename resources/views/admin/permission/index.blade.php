@extends('admin.back')

@section('content-header')
@parent
          <h1>
            用户管理
            <small>权限</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">用户管理 - 权限</li>
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

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">权限列表</h3>
                  <div class="box-tips clearfix">
                    <p>权限属于系统内置模块，只提供查看功能。</p>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                        <th>操作</th>
                        <th>编号</th>
                        <th>权限标识串</th>
                        <th>权限展示名</th>
                        <th>创建日期</th>
                        <th>更新日期</th>
                      </tr>
                      <!--tr-th end-->

                      @foreach ($list as $per)
                      <tr>
                        <td> - </td>
                        <td>{{ $per->id }}</td>
                        <td class="text-green">{{ $per->name }}</td>
                        <td class="text-red">{{ $per->display_name }}</td>
                        <td>{{ $per->created_at }}</td>
                        <td>{{ $per->updated_at }}</td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix text-right">
                  {!! $render !!}
                </div>
              </div>
@stop

