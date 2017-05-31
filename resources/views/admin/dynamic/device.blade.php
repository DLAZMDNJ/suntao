@extends('admin.back')

@section('content-header')
@parent
          <h1>
            设备动态类型
            <small>列表</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">设备动态类型 - 列表</li>
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
                <div class="alert alert-success alert-dismissable cms-alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
                  {{ Session::get('message') }}
                </div>
              @endif

              
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">列表</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <!--tr-th start-->
                      <tr>
                        <th>编码</th>
                        <th>名称</th>
                        <th>排序</th>
                        <th>描述</th>
                        <th>操作</th>
                      </tr>
                      <!--tr-th end-->

                      @foreach ($list as $v)
                      <tr>
                        <td class="text-muted">{{ $v->code }}</td>
                        <td>
                            {{ $v->name }}
                        </td>
                         <td>
                            {{ $v->sort }}
                        </td>
                        <td class="text-green">
                          {{ $v->description }}
                        </td>
                        <td class="text-red">
                            <a href="{{ route('admin.dynamic.index') }}?pid={{ $v->id }}"><i class="fa fa-fw fa-link" title="查看"></i>详情</a>  
                            
                            
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				
                <!--分类一般来说较少，故移除分页-->


              </div>
              
     @include('block.delete')         
              
@stop


