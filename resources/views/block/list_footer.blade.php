<div class="box-footer clearfix text-right">
                  {!! $render !!}
                  
    @if(isset($mn) && $mn == 'user')              
	    @if(in_array('create_user',session('gright')))
	            <a href="{{ route('admin.user.create') }}" class="btn btn-primary margin-bottom btn-bottom">新增学生</a>
	    @endif
    @endif
    @if(isset($mn) && $mn == 'channel')              
	    @if(in_array('create_channel',session('gright')))
	            <a href="{{ route('admin.channel.create') }}" class="btn btn-primary margin-bottom btn-bottom">新增部门</a>
	    @endif
    @endif
    @if(isset($mn) && $mn == 'device')              
	    @if(in_array('create_device',session('gright')))
	            <a href="{{ route('admin.device.create') }}" class="btn btn-primary margin-bottom btn-bottom">新增设施</a>
	    @endif
    @endif
   	@if(isset($mn) && $mn == 'role')              
	    @if(in_array('create_role',session('gright')))
	            <a href="{{ route('admin.role.create') }}" class="btn btn-primary margin-bottom btn-bottom">新增职位</a>
	    @endif
    @endif 
    <a href="javascript:list_choose('{{$mn}}')" class="btn btn-primary margin-bottom btn-bottom">全选</a>
    @if(isset($mn) && $mn=='resource' && in_array($type,array('record','storfile')))
	<a href="javascript:list_download('{{$type or ''}}')" " class="btn btn-primary margin-bottom btn-bottom hide">下载</a>
	@endif
	@if(isset($resource_delete) && $resource_delete==0)
	@else
	
	
	@if(isset($mn) && in_array($mn,array('user','channel','device')))
	@if(isset($mn) && $mn=='resource' && session('gc_resource_delete')==1 && in_array('delete_resource',session('gright')))
	<a href="javascript:list_forbid('{{$type or ''}}','','0')" " class="btn btn-primary margin-bottom btn-bottom">禁用</a>
	@elseif(isset($mn) && $mn!='resource' && in_array('delete_'.$mn,session('gright')))
	<a href="javascript:list_forbid('{{$type or ''}}','','0')" " class="btn btn-primary margin-bottom btn-bottom">禁用</a>
	@endif
	@endif
	
	@if(session('guid') == 0 || session('guid') == 1)
		@if(isset($mn) && $mn=='resource' && session('gc_resource_delete')==1 && in_array('delete_resource',session('gright')))
		<a href="javascript:list_delete('{{$type or ''}}','','1')" " class="btn btn-primary margin-bottom btn-bottom hide">删除</a>
		@elseif(isset($mn) && $mn!='resource' && in_array('delete_'.$mn,session('gright')))
		<a href="javascript:list_delete('{{$type or ''}}','','1')" " class="btn btn-primary margin-bottom btn-bottom">删除</a>
		@endif
	@endif
	
	@endif
                  <a href="javascript:list_refresh('invest')" " class="btn btn-primary margin-bottom btn-bottom">刷新</a>
   @if(isset($mn) && $mn == 'resource')
       <button class="btn btn-primary margin-bottom btn-bottom" type="button" onclick="javascript:list_download('{{$type or ''}}')" >全部下载</button>
   @endif
   @if(isset($mn) && $mn == 'dict')
   <a href="{{ route('admin.dict.create').'/?pid='.$pid }}" class="btn btn-primary margin-bottom btn-bottom">新增</a>
   @endif           
</div>