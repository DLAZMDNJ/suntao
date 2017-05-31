<form method="post" action="{{ route('admin.'.$mn.'.index')}}" accept-charset="utf-8" id="form_delete" name='dform'>
	<input name="_method" type="hidden" value="delete">
	<input name="type" id="type" type="hidden" value="">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input name="force" id="force" type="hidden" value="">
    <div id="form_delete_div" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">您确定要进行删除操作吗?</h4>
                </div>
                <div class="modal-body">
                    <p>删除操作后将不能恢复, 请谨慎处理.</p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit"><span id="force_name">提交</span></button>
                    <button class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
 </form>