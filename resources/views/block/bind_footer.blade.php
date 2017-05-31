<div class="box-footer clearfix text-right">
                  {!! $render !!}
<a href="javascript:history.go(-1)" class="btn btn-primary margin-bottom btn-bottom hide">返回</a>
<a href="javascript:list_choose('{{$mn}}')" class="btn btn-primary margin-bottom btn-bottom">全选</a>
<a href="javascript:list_bind('{{$mn}}','{{$type}}','{{$id}}','','1')" class="btn btn-primary margin-bottom btn-bottom">绑定</a>
<a href="javascript:list_bind('{{$mn}}','{{$type}}','{{$id}}','','-1')" class="btn btn-primary margin-bottom btn-bottom">解绑</a>
<a href="javascript:list_refresh('invest')" " class="btn btn-primary margin-bottom btn-bottom">刷新</a>
<a href="javascript:redirect_button()" class="btn btn-primary margin-bottom btn-bottom">返回</a>
                </div>