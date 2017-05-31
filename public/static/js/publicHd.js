// JavaScript Document
$(function() {

	$(".hd ul li").click(
			function() {
				var i = $(this).index();

				$(this).siblings().removeClass("on");
				// $(".hd ul li").removeClass("on");

				$(this).addClass("on");
				// $(".hd .more a").removeClass("on");
				// $(".hd .more a").eq(i).addClass ("on");
				$(this).parent("ul").parent(".hd").children(".more").children(
						"a").removeClass("on");
				$(this).parent("ul").parent(".hd").children(".more").children(
						"a").eq(i).addClass("on");

				$(this).parent("ul").parent(".hd").siblings(".bd").children(
						".conWrap").children(".con").removeClass("on");
				$(this).parent("ul").parent(".hd").siblings(".bd").children(
						".conWrap").children(".con").eq(i).addClass("on");

			});
	//substring
	$("#hasMoreTab2 .con a").each(function() {
		txt = $(this).text();
		$(this).text(txt.substring(0, 18));
	});
});

// tab-pal
$(function() {

	$(".tab-hd ul li").click(
			function() {
				var i = $(this).index();

				$(this).siblings().removeClass("on");
				// $(".tab-hd ul li").removeClass("on");

				$(this).addClass("on");

				$(this).parent("ul").parent(".tab-hd").siblings(".tab-bd")
						.children(".tab-pal").removeClass("on");
				$(this).parent("ul").parent(".tab-hd").siblings(".tab-bd")
						.children(".tab-pal").eq(i).addClass("on");
			});

});
