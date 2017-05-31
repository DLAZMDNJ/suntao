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

              <div class="box box-primary">

                <div class="box-header with-border">
                  <h3 class="box-title">查阅系统日志</h3>
                  <p>以下为本条系统日志详情。</p>
                  <div class="basic_info bg-info">
                     <ul>
                        <li>ID：<span class="text-muted">{{ $data->id }}</span></li>
                        <li>操作者昵称：<span class="text-green">{{ isset($data->user)?$data->user->nickname:'' }}</span></li>
                        <li>操作者真实姓名：<span class="text-green">{{ isset($data->user)?$data->user->realname:'' }}</span></li>
                        <li>
                            操作类型：
                            <span class="text-yellow">
                            @if(empty($sys_op))
                            {{ $data->type }}
                            @else
                            {{ $data->type }}
                            @endif
                            </span>
                        </li>
                        <li>操作URL：<b>{{ $data->url }}</b></li>
                        <li>操作内容：<b class="text-red">{{ $data->content }}</b></li>
                        <li>操作时间：<span class="text-info">{{ $data->created_at }}</span></li>
                    </ul>
                  </div>
                </div><!-- /.box-header -->

              </div>

@stop

