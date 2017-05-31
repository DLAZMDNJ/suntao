      {{-- widget.main-header --}}

      <!-- Main Header -->
      
      <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Mis</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>学生会信息管理</b>平台</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
			@foreach(session('switch_uids') as $k=>$v)
              <li>
                <a href="{{ route('admin.user.switch') }}?uid={{$k}}">
                  {{$v}}
                </a>
              </li>
              @endforeach
<!--               重启系统按钮 -->
             
              @if(session('guid') == 0 || session('guid') == 1)
             <li> 
            <a href=''> 重启系统</a>
              </li>
              @endif
              <li>
                <a href="{{ route('admin') }}">
                  <i class="fa fa-home" title="前台首页"></i>
                  <span class="label label-info">H</span>
                </a>
              </li>

              <!-- Messages: style can be found in dropdown.less-->
              

              <!-- Notifications Menu -->
              
              <!-- Tasks Menu -->
              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu hide">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="{{ asset('dist/img/20150417113714.jpg') }}" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{ user('realname') }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="{{ asset('dist/img/20150417113714.jpg') }}" class="img-circle" alt="User Image" />
                    <p>
                      {{ user('realname') }} - {{ user('nickname') }}
                      <small>{{ user('object')->ctime?user('object')->ctime->format('Y-m-d H:i'):'' }} 加入</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body hide">
                    <div class="col-xs-4 text-center">
                      <a href="#">消息</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">任务</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">好友</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('admin.profile.index') }}" class="btn btn-default btn-flat">个人资料</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ route('logout') }}" class="btn btn-default btn-flat">退出</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" >{{session('guser')?session('guser')->nick:''}}，您好</a>
              </li>
              <li>
                <a href="{{ route('logout') }}" >退出</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
