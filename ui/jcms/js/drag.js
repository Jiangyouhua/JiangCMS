/*jcms*/
$(function() {
	var b_drag = false;
	var it;
	var key = null;
	var y=null;

	/* 禁止选择 */
	$(document).bind("selectstart", function() {
		event.preventDefault();
	});

	/* 拖曳效果 */
	$('.drag').mouseover(function() {
		this.style.cursor = "move";
	});
	$("#jcms_editarea").on('mouseover', '.drag', function() {
		this.style.cursor = "move";

	});

	// 组件拖移添加
	$('.drag').mousedown(function() {
		it = this;
		key = $(it).attr('id');
		b_drag = drag_init(this, 0);
	});
	// 编辑区组件移动
	$("#jcms_editarea").on('mousedown', '.drag', function(event) {
		it = this;
		key = 'jcms_editarea';
		b_drag = drag_init(this, 1);
		y=event.pageY;
	});

	// 释放
	$(document).mouseup(function() {
		$(document).unbind("mousemove");
		$(it).css({
			top : '0',
			left : '0'
		});
		$(it).removeClass('dragging');
		$(it).find('.dragging').removeClass('dragging');
		if (b_drag) {
			b_drag = drag_delblock(key, it);
			b_drag = false;
		}
	});

	/* 在编辑区释放 */
	$('#jcms_editarea').mouseup(function(e) {
		if (b_drag) {
			b_drag = drag_block(key, this);
			b_drag = false;
		}
	});

	/* 在内容块释放或操作*/
	$('#jcms_editarea').on('mouseup', '.content', function(event) {
		if (b_drag) {
			b_drag = drag_part(key,it,this,y,event.pageY);
			b_drag = false;
		}
	});
});

/* 拖曳初始化 */
function drag_init(it, bool) {
	var p = $(it).position();
	var w = parseInt($(it).width() / 2);
	var h = parseInt($(it).height() / 2);
	if (bool) {
		$(it).find('.content').addClass("dragging");
	} else {
		$(it).addClass("dragging");
	}
	$(document).mousemove(function(e) {
		var ox = e.pageX - p.left - w;
		var oy = e.pageY - p.top + 2;
		$(it).css({
			top : oy,
			left : ox
		});
	});
	return true;
}

/* 拖曳行为 */
function drag_block(key, it) {
	var keys = key.split("_");
	if (keys[0] == 'span') {
		var div = null;
		div = getBlock(keys);
		$(it).append(div);
	}
	return false;
}

function drag_part(key, it,t,y,oy) {
	var keys = key.split("_");
	if (keys[0] == 'part') {
		var div = null;
		div = getPart(keys);
		$(t).append(div);
	}
	if (keys[0] == 'jcms') {
		if(y<oy){
			$(t).closest('.drag').after(it);
		}else{
			$(t).closest('.drag').before(it);
		}
	}
	return false;
}

function drag_delblock(key,it){
	var keys = key.split("_");
	if (keys[0] == 'jcms') {
		$(it).remove();
	}
	return false;
}

function drag_move(key,it,t){
	alert(123);
}
/* 格式化拖曳块 */
function getBlock(keys) {
	str = "<div class='drag span'>";
	for (x in keys) {
		if (x > 0) {
			str += "<div class='span" + keys[x]
					+ "'><div class=content></div></div>";
		}
	}
	str += "</div>";
	return str;
}
var i = 0;
function getPart(keys) {
	i++;
	var name = prompt("Unit's name", "default" + i);
	if (!name) {
		return;
	}
	return "<div class='part part_" + keys[1] + "'>" + name + "<br>(" + keys[1]
			+ ")</part>";
}