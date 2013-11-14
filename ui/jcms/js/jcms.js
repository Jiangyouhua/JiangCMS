/*jcms*/
$(function() {
	/*导航条*/
	$(".navbar li,.menu li").mouseover(function() {
		$(this).children("ul").show();
	});
	$(".navbar li,.menu li").mouseout(function() {
		$(this).children("ul").hide();
	});
	$(".navbar a,.menu a").click(function() {
		if ($(this).next().children()[0]) {
			return false;
		}
	});
	
	/*标签栏*/
	$('.tabs a').click(function(){
		$('.tabs a').removeClass('active');
		$(this).addClass('active');
		id=$(this).attr('href');
		$('.plane').hide();
		$(id).show();	
		})
});
