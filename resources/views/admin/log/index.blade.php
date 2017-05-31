@extends('admin.back')

@section('content-header')
@parent
          <h1>
            系统管理
            <small>系统日志</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">系统管理 - 系统日志</li>
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
                  <h3 class="box-title">日志列表</h3>
                  <div class="box-tools">
                    <form action="{{ route('admin.log.index') }}" method="get">
                      <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="s_operator_realname" value="{{ Input::get('s_operator_realname') }}" style="width: 150px;" placeholder="搜索操作者">
                        <input type="text" class="form-control input-sm pull-right" name="s_operator_ip" value="{{ Input::get('s_operator_ip') }}" style="width: 150px;" placeholder="搜索操作者IP">
                        <div class="input-group-btn">
                          <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                        <th>操作者</th>
                        <th>操作者ID</th>
                        <th>操作者IP</th>                      
                        <th>操作内容</th>
                      </tr>
                      <!--tr-th end-->

                      @foreach ($list as $v)
                      <tr>
                        <td class="text-green">{{ $v->uids?$v->uids->nick:'' }}</td>
                        <td class="text-red">{{$v->uids?$v->uids->user_id:'' }}</td>
                        <td class="text-yellow">{{ $v->operator_ip }}</td>
                         <td class="overflow-hidden" title="{{ $v->content }}">{{ str_limit($v->content, 70, '...') }}</td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  {!! $render !!}
                </div>

              </div>
@stop

