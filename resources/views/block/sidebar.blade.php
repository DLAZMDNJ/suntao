      {{-- widget.main-sidebar --}}

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ asset('dist/img/20150417113714.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
            <p class="hide">
				@foreach(session('switch_uids') as $k=>$v)
                <a href="{{ route('admin.user.switch') }}?uid={{$k}}">
                  {{$v}}
                </a>
              @endforeach
			</p>
			<p>{{session('guser')?session('guser')->nick:''}}</p>
              <!-- Status -->
              <a href="#"> @if(session('gchannel')){{session('gchannel')->name}}@endif</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form hide">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            
             @if(1||session('gr_manage_user'))
            <li class="treeview @if(isset($mn) && $mn=='user') active @endif">
              <a href="#"><i class='fa fa-user'></i>
                <span>学生管理</span>
                <small class="label pull-right bg-red hide">5</small>
              </a>
              <ul class="treeview-menu">
                <li class=" @if(isset($mn) && $mn=='user') active @endif"><a href="{{ route('admin.user.index') }}?is_delete=0"><i class="fa fa-circle-o"></i>学生列表</a></li>
                
              </ul>
            </li>
            @endif
            
            
            @if(1||session('gr_manage_channel'))
            <li class="treeview @if(isset($mn) && $mn=='channel') active @endif">
              <a href="#">
                <i class="fa fa-tasks"></i>
                <span>部门管理</span>
                <span class="label label-primary pull-right hide">4</span>
              </a>
              <ul class="treeview-menu">
                <li class=" @if(isset($mn) && $mn=='channel') active @endif"><a href="{{ route('admin.channel.index') }}?state=0"><i class="fa fa-file-o"></i>部门列表</a></li>
                
              </ul>
            </li>
            @endif
            @if(1||in_array('manage_device',session('gright')))
            <li class="treeview @if(isset($mn) && $mn=='device') active @endif">
              <a href="#">
                <i class="fa fa-cc"></i>
                <span>设施管理</span>
                <span class="label label-primary pull-right hide">4</span>
              </a>
              <ul class="treeview-menu">
                <li class=" @if(isset($mn) && $mn=='device') active @endif"><a href="{{ route('admin.device.index') }}?is_delete=0"><i class="fa fa-file-o"></i>设施列表</a></li>
                
              </ul>
            </li>
            @endif
            
            
            @if(1||in_array('manage_role',session('gright')))
			<li class="treeview @if(isset($mn) && ($mn=='role'||$mn=='permission')) active @endif">
              <a href="#"><i class='fa fa-puzzle-piece'></i>
                <span>职位管理</span>
                <small class="label pull-right bg-red hide">5</small>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('admin.role.index') }}"><i class="fa fa-circle-o"></i>职位列表</a></li>
                <li><a href="{{ route('admin.permission.index') }}"><i class="fa fa-circle-o"></i>权限列表</a></li>
              </ul>
            </li>
            @endif
            
            @if(0 && session('gr_manage_resource'))
            <li class="treeview @if(isset($mn) && $mn=='resource') active @endif">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>资源管理</span>
                <span class="label label-primary pull-right hide">4</span>
              </a>
              <ul class="treeview-menu">
              <li class="@if(isset($type) && $type=='source') active @endif"><a href="{{ route('admin.resource.index') }}?type=source"><i class="fa fa-square-o"></i>图片</a></li>
              <li class="@if(isset($type) && $type=='record') active @endif"><a href="{{ route('admin.resource.index') }}?type=record"><i class="fa fa-square-o"></i>视频1</a></li>
              <li class="@if(isset($type) && $type=='storfile') active @endif"><a href="{{ route('admin.resource.index') }}?type=storfile"><i class="fa fa-square-o"></i>视频2</a></li>
              <li class="@if(isset($type) && $type=='text_group') active @endif"><a href="{{ route('admin.resource.index') }}?type=text_group"><i class="fa fa-square-o"></i>文本群组</a></li>
              <li class="@if(isset($type) && $type=='text_single') active @endif"><a href="{{ route('admin.resource.index') }}?type=text_single"><i class="fa fa-square-o"></i>文本一对一</a></li>
                <li class="@if(isset($type) && $type=='audio_single') active @endif hide"><a href="{{ route('admin.resource.index') }}/index/audio_single"><i class="fa fa-square-o"></i>语音一对一</a></li>
                <li class="@if(isset($type) && $type=='audio_group') active @endif hide"><a href="{{ route('admin.resource.index') }}?type=audio_group"><i class="fa fa-square-o"></i>语音群组</a></li>
                
                
                
                
                
              </ul>
            </li>
            @endif
            
            
            <!--系统管理 treeview-->
            @if(session('gr_manage_system'))
            <li class="treeview @if(isset($mn) && $mn=='dynamic') active @endif">
              <a href="#"><i class='fa fa-cog'></i>
                <span>系统管理</span>
                
              </a>
              <ul class="treeview-menu">
                @if(session('guid')==0 && 0)
                <li><a href="{{ route('admin.config.index') }}"><i class="fa fa-square-o"></i>参数配置</a></li>
                
                <li><a href="{{ route('admin.dynamic.channel') }}"><i class="fa fa-square-o"></i>编组类型</a></li>
                <li><a href="{{ route('admin.dynamic.device') }}"><i class="fa fa-square-o"></i>设备类型</a></li>
                @endif
                <li><a href="{{ route('admin.dict.index') }}"><i class="fa fa-square-o"></i>数据字典</a></li>
                <li><a href="{{ route('admin.log.index') }}"><i class="fa fa-square-o"></i>操作日志</a></li>
                
              </ul>
            </li>
            @endif
            <!--//系统管理 treeview-->

          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
