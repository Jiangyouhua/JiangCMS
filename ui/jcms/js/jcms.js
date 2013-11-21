/*jcms*/

$(function() {
	
	/* 导航条 */
	$(".navbar li,.menu li").mouseover(function() {
		$(this).children("ul").show();
	});
	$(".navbar li,.menu li").mouseout(function() {
		$(this).children("ul").hide();
	});
	$(".navbar a,.menu a").click(function(event) {
		if ($(this).next().children().length) {
			event.preventDefault();
		}
	});

	/* 标签栏 */
	$('a.tab_item').click(function(event) {
		$('a.tab_item').removeClass('active');
		$(this).addClass('active');
		id = $(this).attr('href');
		$('.plane').hide();
		$(id).show();
		event.preventDefault();
	});
});

/* list eidt */
function edit_modify(id, name) {
	$("form [name='jcms_id']").val(id);
	$("form [name='jcms_name']").val(name);
	$("#li" + id + " > span[class!='edit']").each(function() {
		var key = $(this).attr('class');
		var value = $(this).html();
		$("form [name='" + key + "']").val(value);
	});
}