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
		$('#part_remove').remove();
		$('a.tab_item').removeClass('active');
		$(this).addClass('active');
		var id = $(this).attr('href');
		$('.plane').hide();
		$(id).show();
		event.preventDefault();
	});
	
	/*重置*/
	$('button[type="reset"]').click(function(){
		$('input[name="id"]').val('');
		$('form').find('[disabled="disabled"]').attr('disabled',false);
	});
	
});

/* list eidt */
function edit_modify(id, name) {
	$("form [name='id']").val(id);
	$("#li" + id + " > span[class!='edit']").each(function() {
		var array;
		var key = $(this).attr('class');
		array=key.split(' ');
		var value = $(this).html();
		$("form [name='" + array[0] + "']").val(value);
		if(array[0]=='name' && value=='index'){
			$("form [name='" + array[0] + "']").attr('disabled','disabled');
		}
	});
}
function edit_delete(id,handle,model,fun){
	$.post(handle,{
		jcms_handle:handle,
		jcms_model:model,
		jcms_function:fun,
		id:id
	},function(e){
		alert(e);
	})
}