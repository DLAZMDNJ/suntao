@extends('admin.back') @section('content-header') @parent
<h1>
	资源管理 <small>{{$type_name or ''}}</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
	<li class="active">资源管理 - {{$type_name or ''}}</li>
</ol>
@stop @section('content') @if(Session::has('message'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">×</button>
	<h4>
		<i class="icon fa fa-check"></i> 提示！
	</h4>
	{{ Session::get('message') }}
</div>
@endif

@include('block.list_footer')
		@include('block.delete')
		@include('block.download')

<div class="box box-primary">
	<div class="box-header with-border">
		
		<div class="box-tools">
			<form action="{{ route('admin.resource.index') }}" method="get">
			<input type="hidden" name ="type" value="{{$type}}">
                      <div class="input-group">
                       
                      </div>
                    </form>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<div class="tablebox-controls" id="ad_search_div" style="display:;">
			<form action="{{ route('admin.resource.index') }}" method="get" class="form-inline">
				<div class="form-group pull-right" style="margin-bottom:10px;">
					<input type="hidden" name="type" value="{{$type}}"></input>
				@if($type=='audio_single') 
					<div class="form-group">
						<label class="control-label">主叫：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="oid"
						value="{{ session('s_oid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">被叫：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="iid"
						value="{{ session('s_iid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">创建时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start1"
						value="{{ session('s_start1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start2"
						value="{{ session('s_start2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					
					<div class="form-group">
						<label class="control-label">结束时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end1"
						value="{{ session('s_end1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end2"
						value="{{ session('s_end2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
									
				@elseif($type=='audio_group') 
					<div class="form-group">
						<label class="control-label">发言方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="uid"
						value="{{ session('s_uid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">群聊组：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="gid"
						value="{{ session('s_gid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">创建时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start1"
						value="{{ session('s_start1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start2"
						value="{{ session('s_start2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					
					<div class="form-group">
						<label class="control-label">结束时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end1"
						value="{{ session('s_end1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end2"
						value="{{ session('s_end2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					@elseif($type=='text_single')
					<div class="form-group">
						<label class="control-label">发言方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="oid"
						value="{{ session('s_oid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">收看方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="iid"
						value="{{ session('s_iid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">发送时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time1"
						value="{{ session('s_time1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time2"
						value="{{ session('s_time2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>	
					@elseif($type=='text_group')
					<div class="form-group">
						<label class="control-label">发言方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="uid"
						value="{{ session('s_uid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">群聊组：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="gid"
						value="{{ session('s_gid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					<div class="form-group">
						<label class="control-label">发送时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time1"
						value="{{ session('s_time1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time2"
						value="{{ session('s_time2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>	
					@elseif($type=="record")
					<div class="form-group">
						<label class="control-label">上传方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="usrid "
						value="{{ session('s_usrid ') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">上传组：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="groupid"
						value="{{ session('s_groupid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">创建时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start1"
						value="{{ session('s_start1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="start2"
						value="{{ session('s_start2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					
					<div class="form-group">
						<label class="control-label">结束时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end1"
						value="{{ session('s_end1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="end2"
						value="{{ session('s_end2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					@elseif($type=='storfile')
					<div class="form-group">
						<label class="control-label">设备：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="CamID"
						value="{{ session('s_CamID') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">通道：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="ChanID "
						value="{{ session('s_ChanID') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">创建时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="StartTime1"
						value="{{ session('s_StartTime1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="StartTime2"
						value="{{ session('s_StartTime2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					
					<div class="form-group">
						<label class="control-label">结束时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="EndTime1"
						value="{{ session('s_EndTime1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="EndTime2"
						value="{{ session('s_EndTime2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>
					@elseif($type=='source')
					<div class="form-group">
						<label class="control-label">上传方：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm" name="uid"
						value="{{ session('s_uid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">上传组：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right" name="gid"
						value="{{ session('s_gid') }}" style="width: 100px;"
						placeholder="搜索昵称">
					</div>
					
					<div class="form-group">
						<label class="control-label">发送时间：</label>
						
					</div>
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time1"
						value="{{ session('s_time1') }}" style="width: 100px;"
						placeholder="搜索时间起">
					</div>
					-
					<div class="form-group">
						<input type="text"
						class="form-control input-sm pull-right datepicker" name="time2"
						value="{{ session('s_time2') }}" style="width: 100px;"
						placeholder="搜索时间止">
					</div>	
				    @else
				    	
				    @endif
					<div class="input-group-btn pull-right" style="padding-right:40px;">
						<button class="btn btn-sm btn-default">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<table class="table table-hover table-bordered">
			<tbody>
				<!--tr-th start-->
				<tr>
					@if($type=='audio_single')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','oid')">主叫方{{$orderby_oid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','iid')">被叫方{{$orderby_iid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','start')">语音创建时间{{$orderby_start or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','end')">结束时间{{$orderby_end or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','duration')">语音时长{{$orderby_duration or ''}}</a></th>
					<th>操作</th>
					@elseif($type=='audio_group')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','uid')">初始发言方{{$orderby_uid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','gid')">群聊的组{{$orderby_gid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','start')">语音创建时间{{$orderby_start or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','end')">结束时间{{$orderby_end or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','duration')">语音时长{{$orderby_duration or ''}}</a></th>
					<th>操作</th>
					@elseif($type=='text_single')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','oid')">发言方{{$orderby_oid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','iid')">收看方{{$orderby_iid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','time')">文本发送时间{{$orderby_time or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','text')">文本内容{{$orderby_text or ''}}</a></th> 
					@elseif($type=='text_group')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','uid')">发言方{{$orderby_uid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','gid')">发言方所在组{{$orderby_gid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','time')">文本发送时间{{$orderby_time or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','text')">文本内容{{$orderby_text or ''}}</a></th> 
					@elseif($type=='record')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','uid')">缩略图</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','uid')">上传方{{$orderby_uid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','gid')">指定上传组{{$orderby_gid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','start')">视频创建时间{{$orderby_start or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','end')">视频结束时间{{$orderby_end or ''}}</a></th>
					<th>视频时长</th>
					<th>操作</th>
					@elseif($type=='storfile')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','CamID')">设备ID{{$orderby_CamID or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','ChanID')">通道ID{{$orderby_ChanID or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','FileName')">文件名称{{$orderby_FileName or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','FilePath')">所在文件夹{{$orderby_FilePath or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','FileSize')">文件大小{{$orderby_FileSize or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','FileType')">文件类型{{$orderby_FileType or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','StartTime')">开始时间{{$orderby_StartTime or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','EndTime')">结束时间{{$orderby_EndTime or ''}}</a></th>
					<th>操作</th> 
					@elseif($type=='source')
					<th>选择</th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','download_url')">缩略图{{$orderby_download_url or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','uid')">上传方{{$orderby_uid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','gid')">指定上传组{{$orderby_gid or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','time')">发送时间{{$orderby_time or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','title')">发送标题{{$orderby_title or ''}}</a></th>
					<th><a href="javascript:void(0);" onclick="list_sort('{{$mn}}','description')">描述信息{{$orderby_description or ''}}</a></th>
					
					<th>操作</th> 
					@else
					@endif
					
				</tr>
				<!--tr-th end-->
				@foreach ($list as $v)
				<tr>
					@if($type=='audio_single')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->vid }}" name="ids"></td>
					
					<td>{{$v->oids?$v->oids->nick:'' }}</td>
					<td>{{$v->iids?$v->iids->nick:''}}</td>
					<td>{{date("Y-m-d H:i:s",intval($v->start))}}</td>
					<td>{{date("Y-m-d H:i:s",intval($v->end))}}</td>
					<td>{{$v->duration or ''}}</td>
					<td><a href="{{route('admin.resource.download')}}?url={{$v->download_url or ''}}"><i class="fa fa-fw fa-download" title=""></i>下载</a>
					<a href="{{$res_path or ''}}{{$v->mp3_url or ''}}"><i class="fa fa-fw fa-file-video-o" title=""></i>播放</a>
						</td>
					@elseif($type=='audio_group')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->vid }}" name="ids"></td>
					<td>{{$v->uids?$v->uids->nick:''}}</td>
					<td>{{$v->gids?$v->gids->name:''}}</td>
					<td>{{date("Y-m-d H:i:s",$v->start)}}</td>
					<td>{{date("Y-m-d H:i:s",$v->end)}}</td>
					<td>{{$v->duration or ''}}</td>
					<td><a href="{{route('admin.resource.download')}}?url={{$v->download_url or ''}}"><i class="fa fa-fw fa-download" title=""></i>下载</a>
					<a href="{{$res_path or ''}}{{$v->mp3_url or ''}}"><i class="fa fa-fw fa-file-video-o" title=""></i>播放</a>
						</td>
					@elseif($type=='text_single')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->tid }}" name="ids"></td>
					<td>{{$v->oids?$v->oids->nick:'' }}</td>
					<td>{{$v->iids?$v->iids->nick:''}}</td>
					<td>{{date("Y-m-d H:i:s",$v->time)}}</td>
					<td>
					<?php 	
						if(strlen($v->text) < 100 )
						{
					?>
						{{$v->text}}
					<?php 
						}				
						else{
							$str = mb_substr($v->text,0,100);
							echo 
							"<div id = 'dit$v->tid' style='display:block;'>".$str."</div>";
					?>
						<button id="did{{$v->tid}}" onclick="ddd({{$v->tid}})">加载更多</button>
						<div id="div{{$v->tid}}" style="display:none ;">{{$v->text}}</div>
					<?php 	
						}
					?>						
					</td>
					
					@elseif($type=='text_group')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->tid }}" name="ids"></td>
					
					<td>{{$v->uids?$v->uids->nick:''}}</td>
					<td>{{$v->gids?$v->gids->name:''}}</td>
					<td>{{date("Y-m-d H:i:s",$v->time)}}</td>
					<td>
					<?php 	
						if(strlen($v->text) < 100 )
						{
					?>
						{{$v->text}}
					<?php 
						}				
						else{
							$str = mb_substr($v->text,0,100);
							echo 
							"<div id = 'dit$v->tid' style='display:block;'>".$str."</div>";
					?>
						<button id="did{{$v->tid}}" onclick="ddd({{$v->tid}})">加载更多</button>
						<div id="div{{$v->tid}}" style="display:none ;">{{$v->text}}</div>
					<?php 	
						}
					?>						
					</td>
					@elseif($type=='record')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->vid }}" name="ids">
						<input type="hidden" value="{{ $v->play_url }}" id="download_{{$v->vid}}">
						</td>		
			
					<td>
					<a href="{{route('admin.resource.index') }}/{{$v->vid}}?type={{$type}}"><img src="http://114.255.88.230<?php
					if($v->play_url)
					{
						$url =  $v->play_url;
						$arr = explode('.flv',$url);
						$url = $arr[0];
						$a = '.jpg';
						$url = $url.$a;
						echo $url;
						
					}	
					?>" id="play_img" width="100px;"></a>
					</td>
<!-- 					<a href="http://114.255.88.230{{$v->play_url or ''}}"> -->				
					
					<td>{{$v->uids?$v->uids->nick:''}}</td>
					<td>{{$v->gids?$v->gids->name:''}}</td>
					<td>{{date("Y-m-d H:i:s",$v->start)}}</td>
					<td>{{date("Y-m-d H:i:s",$v->end)}}</td>
					<td>{{king_time($v->end - $v->start)}}</td>
					<td><a href="http://114.255.88.230{{$v->play_url or ''}}"><i class="fa fa-fw fa-download" title=""></i>下载</a>
					<a href="{{$res_path or ''}}{{$v->play_url or ''}}" class="hide"><i class="fa fa-fw fa-file-video-o" title=""></i>播放</a>
						</td>
					@elseif($type=='storfile')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->ID }}" name="ids">
						<input type="hidden" value="{{ $v->FilePath }}" id="download_{{$v->ID}}">
						</td>
					
					
					<td>{{$v->CamID or ''}}</td>
					<td>{{$v->ChanID  or ''}}</td>
					<td>{{$v->FileName  or ''}}</td>
					<td>{{$v->FilePath  or ''}}</td>
					<td>{{$v->FileSize  or ''}}</td>
					<td>@if($v->FileType=='1')自动@elseif($v->FileType=='2')侦测@elseif($v->FileType=='3')告警@elseif($v->FileType=='4')手动@endif</td>
					<!-- filelist -->
					<td>{{$v->StartTime }}</td>
					<td>{{$v->EndTime }}</td>
					<td><a href="{{route('admin.resource.download')}}?url={{$v->download_url or ''}}"><i class="fa fa-fw fa-download" title=""></i>下载</a>
					<a href="{{$res_path or ''}}{{$v->FileUrl or ''}}" class="hide"><i class="fa fa-fw fa-file-video-o" title=""></i>播放</a>
						</td>
						
					@elseif($type=='source')
					<td class="table-operation"><input type="checkbox"
						value="{{ $v->mid }}" name="ids"></td>
					<td> <a href="{{route('admin.resource.index') }}/{{$v->mid}}?type={{$type}}"> <img src="http://114.255.88.230{{$v->download_url}}" style="width:100px;height:100px;">  </a></td>
					<td>{{$v->uids?$v->uids->nick:''}}</td>
					<td>{{$v->gids?$v->gids->name:''}}</td>
					<td>{{date("Y-m-d H:i:s",$v->time)}}</td>
					<td>{{$v->title or ''}}</td>
					<td>{{$v->description or ''}}</td>
					
					<td><a href="{{route('admin.resource.download')}}?url={{$v->download_url or ''}}" class="hide"><i class="fa fa-fw fa-download" title=""></i>下载</a>
					<a href="http://114.255.88.230{{$v->download_url or ''}}"><i class="fa fa-fw fa-file-video-o" title=""></i>下载</a>
						</td>
					@endif
					
				</tr>
				@endforeach

			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	
	
</div>
@stop 
@section('extraPlugin')
<!--引入iCheck组件-->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<script>		
						
						function ddd(id)
						{
							var did = $("#did" + id);
							var tid = $("#div" + id);
							var dit = $("#dit" + id);						
							var text = did.html();
							if(text == '加载更多')
							{
								did.html('收起');
								dit.css('display','none');
								tid.css('display','block');
							}else
							{
								did.html('加载更多');
								dit.css('display','block');
								tid.css('display','none');
							}
						}


					</script>
@stop 

