@extends('admin.back')

@section('content-header')
@parent
          <h1>
            控制面板
            <small>概述</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">控制面板 - 概述</li>
          </ol>
@stop

@section('content')
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$ct_user or '0'}}<sup style="font-size: 20px">个</sup></h3>
                  <p>学生总数</p>
                </div>
                <div class="icon">
                  <i class="ion ion-chatboxes"></i>
                </div>
                <a href="{{route('admin.user.index')}}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$ct_channel or '0'}}<sup style="font-size: 20px">个</sup></h3>
                  <p>学生会总数</p>
                </div>
                <div class="icon">
                  <i class="ion ion-document"></i>
                </div>
                <a href="{{route('admin.channel.index')}}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$ct_device or '0'}}<sup style="font-size: 20px">个</sup></h3>
                  <p>设施总数</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.device.index')}}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$ct_role or '0'}}<sup style="font-size: 20px">个</sup></h3>
                  <p>职位总数</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('admin.role.index')}}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
@stop
