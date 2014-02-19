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
function edit_modify(id, name, tag, it) {
	var form="form#"+tag;
	$(form+" [name='id']").val(id);
	$(form+" [disabled='disabled']").attr('disabled',false);
	$(it).closest('tr').find("input").each(function() {
		var key = $(this).attr('name');
		var value = $(this).val();
		locate_value(form,key,value);
		if(key=='metadata' && value>'0'){
			disabled_form(form);
		}
	});
}

/*定位表单值*/
function locate_value(form,key,value){
	$(form+" [name='" + key + "']").val(value);
	var arr=value.split(',');
	for(var x in arr){
		$(form+" [name='" + key + "[]']").val(arr[x]);
	}
	if(key=='level'){
		var level=value.split('.');
		level.pop();
		var associate=0;
		if(level.length){
			associate=level.join('.');
		}
		$(form+" [name='associate']").val(associate);
		$(form+" [name='option']").val('0');
	}
	
}

/*原数据编辑失效*/
function disabled_form(form){
	$(form+" [name='name']").attr('disabled','disabled');
	$(form+" [name='associate']").attr('disabled','disabled');
	$(form+" [name='option']").attr('disabled','disabled');
}

/*数据删除*/
function edit_delete(id,handle,model,fun){
	$.post(handle,{
		jcms_handle:handle,
		jcms_model:model,
		jcms_function:fun,
		id:id
	},function(e){
		if(e){
			history.go(-1);
		}else{
			alert(del_err);
		}
	})
}