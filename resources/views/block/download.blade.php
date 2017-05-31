<form method="post" action="{{ route('admin.'.$mn.'.index')}}" accept-charset="utf-8" id="form_download" name='dform'>
	<input name="_method" type="hidden" value="delete">
	<input name="type" id="type" type="hidden" value="">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input name="force" id="force" type="hidden" value="">
    <div id="form_download_div" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">下载列表</h4>
                </div>
                <div class="modal-body" id="download_div">
                    {!!session('download_url')!!}
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success hide" type="submit">删除</button>
                    <button class="btn btn-danger" data-dismiss="modal">确定</button>
                </div>
            </div>
        </div>
    </div>
 </form>