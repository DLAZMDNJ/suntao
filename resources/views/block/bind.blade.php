@extends('admin.back')

@section('content-header')
@parent
          <h1>
            绑定与解绑
            <small>列表</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">绑定与解绑 - 列表</li>
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
                  <h3 class="box-title">列表</h3>
                  <div class="box-tools">
                    <form action="{{ route('admin.'.$mn.'.'.$type) }}?id={{$id}}" method="get" class="form-inline">
                    <input type="hidden" name="id" value="{{$id}}">
				<div class="form-group pull-right" style="margin-bottom:10px;">
					
					
					<div class="form-group">
						<label class="control-label">搜索名称：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="name"
						value="{{ session('s_name') }}" style="width: 100px;"
						placeholder="">
					</div>
					
					
					<div class="input-group-btn pull-right" style="padding-right:40px;">
						<button class="btn btn-sm btn-default">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</form>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                	<div class="tablebox-controls" id="ad_search_div" style="display:;">
					当前编号：{{$my->id}}{{$my->channel_id}}{{$my->user_id}}&nbsp;&nbsp;&nbsp;&nbsp;当前名称：{{$my->name}}{{$my->nickname}}
					</div>
		
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                        <th>选择</th>
                        <th>序号</th>
                        <th>名称</th>
                        @if($mn=='channel' && $type=='user')
                        <th>设置</th>
                        @endif
                        
                        @if($mn=='user' && $type=='channel')
                        <th>编组级别</th>
                        @endif
                        
                        <th>操作</th>
                      </tr>
                      <!--tr-th end-->
                      @foreach ($list as $v)
                      <tr>
                        <td class="table-operation"><input type="checkbox" value="{{ $v->user_id }}{{ $v->channel_id }}{{ $v->id }}" name="ids"></td>
                        <td>{{ $v->user_id }}{{ $v->channel_id }}{{ $v->id }}</td>
                        <td class="text-muted">@if($v->nick) {{ $v->nick }} @else  {{ $v->name }} {{ $v->nickname }}  @endif
                        @if(session('gc_area_show'))
                        	{{$v->created_gids?'('.$v->created_gids->name.')':''}}
                        @endif
                        </td>
                        @if($mn=='channel' && $type=='user')
                        <td><input type="checkbox" name="default_channel" id="default_channel{{$v->user_id}}" value="{{$v->user_id}}">&nbsp;&nbsp;&nbsp;&nbsp;默认编组</td>
                        @endif
                        
                        @if($mn=='user' && $type=='channel')
                        <td>{{$v->level}}</td>
                        @endif
                        <td>
                        	
                        	@if(in_array($v->id,$bind_data) or in_array($v->channel_id,$bind_data) or in_array($v->user_id,$bind_data))
                            <a style="color:red;" href="javascript:bind('{{$mn}}','{{$type}}','{{$id}}','{{ $v->id }}{{ $v->channel_id }}{{ $v->user_id }}','-1')"><i class="fa fa-fw fa-minus-square" title=""></i>解绑</a>
                            @else
                            	<a style="color:green;" href="javascript:bind('{{$mn}}','{{$type}}','{{$id}}','{{ $v->id }}{{ $v->channel_id }}{{ $v->user_id }}','1')"><i class="fa fa-fw fa-plus-square" title=""></i>绑定</a>
                            @endif
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix text-right">
                  {!! $render !!}
                  <a href="javascript:history.go(-1)" class="btn btn-primary margin-bottom btn-bottom">返回</a>
                </div>


              </div>
              @include('block.delete')
@stop

