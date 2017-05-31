function del(href){
	if(confirm('确定要删除吗？')){
		//alert('dd');
		window.location.href=href;
	}
}
setTimeout(function() {
    alerts = $(".cms-alert"),
    alerts.addClass("bounceOut"),
    alerts.addClass("animated"),
    setTimeout(function() {
        alerts.slideUp(500,
        function() {
            alerts.remove()
        })
    },
    500)
},
2500);



function dynamic_type(type_id,record_id){
	$.ajax({  
		type:'get',      
		url:'/admin/dynamic/html/?type_id='+type_id+'&record_id='+record_id,  
		cache:false,  
		dataType:'json',  
		success:function(result){
			//alert(result);
			var html = result.html;
			//alert(html);
			$('#tab_2').html(html);
			//time 控件
			$('.datepicker').datepicker({
		        changeYear: true,
		        showButtonPanel: true,
		        dateFormat: 'yy-mm-dd'
		        
		    });
		}  
	});
	
}

function list_choose(div_id){
	//alert(div_id);
	var checked = $("input[name='ids']").prop("checked");
	//alert(checked);
	if(checked){
		$("input[name='ids']").prop("checked",false);
		
	}else{
		$("input[name='ids']").prop("checked",true);
		
	}
	
}
//force为1为真删
function list_delete(div_id,id,force){
	var ids = '';
	$("input[name='ids']").each(function() {
		//alert($(this).val());
		if($(this).is(":checked")){
			ids=ids+','+$(this).val();
		}
        
    }); 
	//alert(ids);
	ids = ids.substring(1);
	if(ids=='' && id!=undefined){
		ids = id;
	}
	
	
	
	if(ids==''){
		alert('请选择需要操作的记录');
	}else{
		var action = $('#form_delete').attr('action');
		$('#form_delete').attr('action',action+'/'+ids);
		$('#id').val(ids);
		$('#type').val(div_id);
		$('#force').val(force);
		$('#form_delete_div').modal();
	}
	
	//alert(ids);
}

function list_forbid(div_id,id,force){
	var ids = '';
	$("input[name='ids']").each(function() {
		//alert($(this).val());
		if($(this).is(":checked")){
			ids=ids+','+$(this).val();
		}
        
    }); 
	//alert(ids);
	ids = ids.substring(1);
	if(ids=='' && id!=undefined){
		ids = id;
	}
	
	
	
	if(ids==''){
		alert('请选择需要操作的记录');
	}else{
		var action = $('#form_forbid').attr('action');
		$('#form_forbid').attr('action',action+'/'+ids);
		$('#id').val(ids);
		$('#type').val(div_id);
		$('#force').val(force);
		$('#form_forbid_div').modal();
	}
	
	//alert(ids);
}

function list_download(div_id,id,force){
	var ids = '';
	var download_urls = '';
	$("input[name='ids']").each(function() {
		//alert($(this).val());
		if($(this).is(":checked")){
			ids=ids+','+$(this).val();
			var d_div = '#download_'+$(this).val();
			download_urls += '<p>'+$(d_div).val()+'</p>';
		}
        
    }); 
	//alert(ids);
	ids = ids.substring(1);
	if(ids=='' && id!=undefined){
		ids = id;
	}
	
	//if(ids==''){
		//alert('请选择需要下载的记录');
	//}else{
		var action = $('#form_download').attr('action');
		$('#form_download').attr('action',action+'/'+ids);
		//$('#download_div').html(download_urls);
		//$('#type').val(div_id);
		//$('#force').val(force);
		$('#form_download_div').modal();
	//}
}

function list_refresh(div_id){
	window.location.reload();
}
//高级搜索
function ad_search(div_id){
	$('#ad_search_div').toggle();
}

function restore(mn,id){
	$.ajax({  
		type:'get',      
		url:'/admin/'+mn+'/restore?id='+id,  
		cache:false,  
		dataType:'json',  
		success:function(result){
			//alert('dd');
			location.reload();
		}  
	});
}

function list_bind(mn,type,id,data,op){
	var ids = '';
	$("input[name='ids']").each(function() {
		//alert($(this).val());
		if($(this).is(":checked")){
			ids=ids+','+$(this).val();
		}
        
    }); 
	//alert(ids);
	ids = ids.substring(1);
	if(ids=='' && id!=undefined){
		ids = id;
	}
	//计算 default channel
	default_channel = '';
	$("input[name='default_channel']").each(function() {
		//alert($(this).val());
		if($(this).is(":checked")){
			default_channel=default_channel+','+$(this).val();
		}
        
    }); 
	//alert(default_channel);
	if(ids==''){
		alert('请选择需要操作的记录');
	}else{
		bind(mn,type,id,ids,op,default_channel);
		location.reload();
	}
}
function bind(mn,type,id,data,op,default_channel){
		$.ajax({  
		type:'get',      
		url:'/admin/'+mn+'/bind?mn='+mn+'&id='+id+'&type='+type+'&data='+data+'&op='+op+'&default='+default_channel,  
		cache:false,  
		dataType:'json',  
		success:function(result){
		
			var message = result.message;
			if(message){
				alert(message);
			}else{
				location.reload();
			}
			window.location.reload();
		}  
		
	});
//		alert('dd');
		
}

function list_sort(mn,name){
	var url = window.location.href;
	var orderby = getQueryStringByName('orderby');
	
	
	if(orderby){
		var ors = orderby.split('__');
		if(ors[0]==name){
			if(ors[1]=='asc'){
				new_orderby = ors[0]+'__desc';
			}else{
				new_orderby = ors[0]+'__asc';
			}
		}else{
			new_orderby = name+'__desc';
		}
		
		url_new = url.replace(orderby,new_orderby);
	}else{
		new_orderby = name+'__desc';
		if(url.indexOf('?')>0){
			url_new = url+'&orderby='+new_orderby;
		}else{
			url_new = url+'?orderby='+new_orderby;
		}
	}
	//alert(url_new);
	window.location.href = url_new;
	//this.html('dd');
}

function getQueryString() {
    var result = location.search.match(new RegExp("[\?\&][^\?\&]+=[^\?\&]+", "g"));
    for (var i = 0; i < result.length; i++) {
        result[i] = result[i].substring(1);
    }
    return result;
}
function getQueryStringByName(name) {
    var result = location.search.match(new RegExp("[\?\&]" + name + "=([^\&]+)", "i"));
    if (result == null || result.length < 1) {
        return "";
    }
    return result[1];
}

function div_alert(div_id,message){
	//$('#div_msg').html(message);
	//div_pop('error','');
	alert(message);
}
function check_unique_radio(div_id,arr){
	for(key in arr){
		var tip = '请选择'+arr[key];
		var val = $("input:radio[name='"+key+"']:checked").val();
		if(val==null){
			div_alert(div_id,tip);
			$("input[name='"+key+"']").focus();
			return false;
		}
	}
	return true;
}
function check_unique_input(div_id,arr){
	for(key in arr){
		var tip = '请输入'+arr[key];
		var val = $("input[name='"+key+"']").val();
		if(val==''){
			div_alert(div_id,tip);
			$("input[name='"+key+"']").focus();
			return false;
		}
	}
	return true;
}
function check_unique_select(div_id,arr){
	for(key in arr){
		var tip = '请选择'+arr[key];
		var val = $("select[name='"+key+"']").val();
		//alert(val);
		if(typeof(val)=='undefined' || val==''||val==null){
			div_alert(div_id,tip);
			$("select[name='"+key+"']").focus();
			return false;
		}
	}
	return true;
}
function check_unique_textarea(div_id,arr){
	for(key in arr){
		var tip = '请输入'+arr[key];
		var val = $("textarea[name='"+key+"']").val();
		if(val==''){
			div_alert(div_id,tip);
			$("textarea[name='"+key+"']").focus();
			return false;
		}
	}
	return true;
}

function check_unique_ajax(mn,op,col,val){
	//$('#form_logout').submit();
	var uid = $('#check_uid').val();
	var result = '';
	$.ajax({  
		type:'get',      
		url:'/admin/'+mn+'/unique?op='+op+'&col='+col+'&val='+val+'&uid='+uid,  
		cache:false,  
		async:false,
		dataType:'json',  
		success:function(data){
			var result = data.result;
			//alert(result);alert(data.debug);
			$('#check_pass').val(result);
			return result;
		}  
	});
	return result;
}

function form_check(mn){
	var input=new Array;
	var select=new Array;
	if(mn=='user'){
		input['name']='登录（用户）名';
		input['password']='密码';
		input['nick']='昵称';
	}else if(mn=='channel'){
		input['name']='名称';
		input['parent_id']='上级编组';
		select['type']='编组类型';
	}else if(mn=='device'){
		input['nickname']='名称';
		select['type']='设备类型';
	}else if(mn=='role'){
		input['name']='角色名';
		input['display_name']='角色(用户组)展示名';
	}
	
	if(!check_unique_input(mn,input)){
		return false;
	}
	if(!check_unique_select(mn,select)){
		return false;
	}
	
	if(mn=='user'){
		check_unique_ajax('user','register','name',$('#name').val());
		var c = $('#check_pass').val();
		//alert(c);
		if(c==0){
			alert('用户名重复');
			return false;
		}
		
	}
	
	return true;
}
function redirect_button(){
		window.history.back(-1); 		
	}


$(document).ready(function () {
	$.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }

    

    $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
	$('.datepicker').datepicker({
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd'
        
    });
	//channel type
	$('.channel_type').change(function(){
		var type_id=$(this).children('option:selected').val();
		var record_id = $('#id').val();
		dynamic_type(type_id,record_id);
	});
	
	$('.orderby').click(function(){
		var id = $(this).data('id');
		var txt = $(this).html();
		var ids = id.split('__');
		
		list_sort(ids[0],ids[1]);
		$(this).html(txt+'111');
	});

});