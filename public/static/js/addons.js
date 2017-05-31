

$(function(){
    //日历
    $("#datepicker").datepicker();
    //左边菜单
    $('.one').click(function () {
        $('.one').removeClass('one-hover');
        $(this).addClass('one-hover');
        $(this).parent().find('.kid').toggle();
    });
	$('.mNav li').hover(function(){
		$(this).addClass('selected');							  
	},function(){
		$(this).removeClass('selected');		
	})
	 $(".mNav li").click(function(){
			 $(".mNav li").removeClass("on");
			 $(this).addClass("on");
			 });	
	//最后一个元素没有边框
	$('.hasMoreTab .hd li:last-child').addClass('last');
	
 //影藏菜单

    var l = $('#siderBar');
    var r = $('#content');
    $('.nav-tip').click(function () {
	
        if ($(this).attr('is_show') == '0') {
            l.animate({
                left: 0
            }, 500);
            r.animate({
                left: 146
            }, 500);
            $(this).animate({
                "background-position-x": "-12"
            }, 300);
			$(this).attr('is_show',1); 
        } else {
            l.animate({
                left:-146
            }, 500);
            r.animate({
                left:0
            }, 500);
            $(this).animate({
                "background-position-x": "0"
            }, 300);
			$(this).attr('is_show',0); 
        };
    })   
})