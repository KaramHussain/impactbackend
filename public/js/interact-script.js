
window.$ = jQuery;

function isTouchEnabled() {
	return (('ontouchstart' in window)
		|| (navigator.MaxTouchPoints > 0)
		|| (navigator.msMaxTouchPoints > 0));
}
$(document).ready(function(){
	$('.bck_base').hide().animate({'opacity':'0'}, 1000);
	$('.bck_base_female').hide().animate({'opacity':'0'}, 1000);


	$('.go_bck').on('click', function(){
		$('.frt_base').hide().animate({'opacity':'0'}, 1000);
		$('.bck_base').show().animate({'opacity':'1'}, 1000);
	});
	$('.go_frt').on('click', function(){
		$('.bck_base').hide().animate({'opacity':'0'}, 1000);
		$('.frt_base').show().animate({'opacity':'1'}, 1000);
	});

	$('.go_bck_female').on('click', function(){
		$('.frt_base_female').hide().animate({'opacity':'0'}, 1000);
		$('.bck_base_female').show().animate({'opacity':'1'}, 1000);
	});
	$('.go_frt_female').on('click', function(){
		$('.bck_base_female').hide().animate({'opacity':'0'}, 1000);
		$('.frt_base_female').show().animate({'opacity':'1'}, 1000);
	});

});


$(function(){
	frt_addEvent('frt_1');frt_addEvent('frt_2');frt_addEvent('frt_3');frt_addEvent('frt_4');frt_addEvent('frt_5');frt_addEvent('frt_6');frt_addEvent('frt_7');frt_addEvent('frt_8');frt_addEvent('frt_9');frt_addEvent('frt_10');frt_addEvent('frt_11');frt_addEvent('frt_12');frt_addEvent('frt_13');frt_addEvent('frt_14');frt_addEvent('frt_15');frt_addEvent('frt_16');frt_addEvent('frt_17');frt_addEvent('frt_18');frt_addEvent('frt_19');frt_addEvent('frt_20');frt_addEvent('frt_21');frt_addEvent('frt_22');frt_addEvent('frt_23');frt_addEvent('frt_24');frt_addEvent('frt_25');frt_addEvent('frt_26');frt_addEvent('frt_27');frt_addEvent('frt_28');frt_addEvent('frt_29');frt_addEvent('frt_30');frt_addEvent('frt_31');frt_addEvent('frt_32');frt_addEvent('frt_33');frt_addEvent('frt_34');frt_addEvent('frt_35');frt_addEvent('frt_36');frt_addEvent('frt_37');frt_addEvent('frt_38');frt_addEvent('frt_39');frt_addEvent('frt_40');frt_addEvent('frt_41');frt_addEvent('frt_42');frt_addEvent('frt_43');frt_addEvent('frt_44');frt_addEvent('frt_45');frt_addEvent('frt_46');frt_addEvent('frt_47');frt_addEvent('frt_48');frt_addEvent('frt_49');frt_addEvent('frt_50');frt_addEvent('frt_51');frt_addEvent('frt_52');frt_addEvent('frt_53');frt_addEvent('frt_54');frt_addEvent('frt_55');frt_addEvent('frt_56');frt_addEvent('frt_57');frt_addEvent('frt_58');frt_addEvent('frt_59');frt_addEvent('frt_60');frt_addEvent('frt_61');frt_addEvent('frt_62');frt_addEvent('frt_63');frt_addEvent('frt_64');frt_addEvent('frt_65');frt_addEvent('frt_66');frt_addEvent('frt_67');frt_addEvent('frt_68');frt_addEvent('frt_69');

	bck_addEvent('bck_1');bck_addEvent('bck_2');bck_addEvent('bck_3');bck_addEvent('bck_4');bck_addEvent('bck_5');bck_addEvent('bck_6');bck_addEvent('bck_7');bck_addEvent('bck_8');bck_addEvent('bck_9');bck_addEvent('bck_10');bck_addEvent('bck_11');bck_addEvent('bck_12');bck_addEvent('bck_13');bck_addEvent('bck_14');bck_addEvent('bck_15');bck_addEvent('bck_16');bck_addEvent('bck_17');bck_addEvent('bck_18');bck_addEvent('bck_19');bck_addEvent('bck_20');bck_addEvent('bck_21');bck_addEvent('bck_22');bck_addEvent('bck_23');bck_addEvent('bck_24');bck_addEvent('bck_25');bck_addEvent('bck_26');bck_addEvent('bck_27');bck_addEvent('bck_28');bck_addEvent('bck_29');bck_addEvent('bck_30');bck_addEvent('bck_31');bck_addEvent('bck_32');bck_addEvent('bck_33');bck_addEvent('bck_34');bck_addEvent('bck_35');bck_addEvent('bck_36');bck_addEvent('bck_37');bck_addEvent('bck_38');bck_addEvent('bck_39');bck_addEvent('bck_40');bck_addEvent('bck_41');bck_addEvent('bck_42');bck_addEvent('bck_43');bck_addEvent('bck_44');bck_addEvent('bck_45');bck_addEvent('bck_46');bck_addEvent('bck_47');bck_addEvent('bck_48');bck_addEvent('bck_49');bck_addEvent('bck_50');bck_addEvent('bck_51');bck_addEvent('bck_52');bck_addEvent('bck_53');bck_addEvent('bck_54');bck_addEvent('bck_55');bck_addEvent('bck_56');bck_addEvent('bck_57');bck_addEvent('bck_58');
})

function frt_addEvent(id,relationId){
	var _obj = $('#'+id);
	_obj.attr({'fill':frt_config[id]['upColor'],'fill-opacity':frt_config[id]['upOpacity'],'stroke':frt_config[id]['outlineUpColor'],'stroke-opacity':frt_config[id]['outlineUpOpacity']});
	_obj.attr({'cursor':'default'});
	if(frt_config[id]['enable'] == true){
		if (isTouchEnabled()) {
			_obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':frt_config[id]['overColor'],'fill-opacity':frt_config[id]['downOpacity'],'stroke':frt_config[id]['outlineDownColor'],'stroke-opacity':frt_config[id]['outlineDownOpacity']});
				$('.organs-tip').show().html(frt_config[id]['hover']);
				$('.organs-tip').css({left:x, top:y})
			})
			_obj.on('touchend', function(){
				$('#'+id).css({'fill':frt_config[id]['upColor'],'fill-opacity':frt_config[id]['upOpacity'],'stroke':frt_config[id]['outlineUpColor'],'stroke-opacity':frt_config[id]['outlineUpOpacity']});
				if(frt_config[id]['target'] == 'new_window'){
					window.open(frt_config[id]['url']);	
				}else if(frt_config[id]['target'] == 'same_window'){
					window.parent.location.href=frt_config[id]['url'];
				}
			})
		}
		_obj.attr({'cursor':'pointer'});
		_obj.hover(function(){
			$('.organs-tip').show().html(frt_config[id]['hover']);
			_obj.css({'fill':frt_config[id]['overColor'],'fill-opacity':frt_config[id]['overOpacity'],'stroke':frt_config[id]['outlineOverColor'],'stroke-opacity':frt_config[id]['outlineOverOpacity']})
		},function(){
			$('.organs-tip').hide();
			$('#'+id).css({'fill':frt_config[id]['upColor'],'fill-opacity':frt_config[id]['upOpacity'],'stroke':frt_config[id]['outlineUpColor'],'stroke-opacity':frt_config[id]['outlineUpOpacity']});
		})
		_obj.mousedown(function(){
			$('#'+id).css({'fill':frt_config[id]['downColor'],'fill-opacity':frt_config[id]['downOpacity'],'stroke':frt_config[id]['outlineDownColor'],'stroke-opacity':frt_config[id]['outlineDownOpacity']});
		})
		_obj.mouseup(function(){
			$('#'+id).css({'fill':frt_config[id]['overColor'],'fill-opacity':frt_config[id]['overOpacity'],'stroke':frt_config[id]['outlineOverColor'],'stroke-opacity':frt_config[id]['outlineOverOpacity']});
			if(frt_config[id]['target'] == 'new_window'){
				window.open(frt_config[id]['url']);	
			}else if(frt_config[id]['target'] == 'same_window'){
				window.parent.location.href=frt_config[id]['url'];
			}
		})
		_obj.mousemove(function(e){
			var x=e.pageX+10, y=e.pageY+15;
			var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
			x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
			y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
			$('.organs-tip').css({left:x, top:y})
		})
	}	
}
function bck_addEvent(id, relationId){
	var _obj = $('#'+id);
	_obj.attr({'fill':bck_config[id]['upColor'],'fill-opacity':bck_config[id]['upOpacity'],'stroke':bck_config[id]['outlineUpColor'],'stroke-opacity':bck_config[id]['outlineUpOpacity']});
	_obj.attr({'cursor':'default'});
	if(bck_config[id]['enable'] == true){
		if (isTouchEnabled()) {
			_obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':bck_config[id]['overColor'],'fill-opacity':bck_config[id]['downOpacity'],'stroke':bck_config[id]['outlineDownColor'],'stroke-opacity':bck_config[id]['outlineDownOpacity']});
				$('.organs-tip').show().html(bck_config[id]['hover']);
				$('.organs-tip').css({left:x, top:y})
			})
			_obj.on('touchend', function(){
				$('#'+id).css({'fill':bck_config[id]['upColor'],'fill-opacity':bck_config[id]['upOpacity'],'stroke':bck_config[id]['outlineUpColor'],'stroke-opacity':bck_config[id]['outlineUpOpacity']});
				if(bck_config[id]['target'] == 'new_window'){
					window.open(bck_config[id]['url']);	
				}else if(bck_config[id]['target'] == 'same_window'){
					window.parent.location.href=bck_config[id]['url'];
				}
			})
		}
		_obj.attr({'cursor':'pointer'});
		_obj.hover(function(){
			$('.organs-tip').show().html(bck_config[id]['hover']);
			_obj.css({'fill':bck_config[id]['overColor'],'fill-opacity':bck_config[id]['overOpacity'],'stroke':bck_config[id]['outlineOverColor'],'stroke-opacity':bck_config[id]['outlineOverOpacity']})
		},function(){
			$('.organs-tip').hide();
			$('#'+id).css({'fill':bck_config[id]['upColor'],'fill-opacity':bck_config[id]['upOpacity'],'stroke':bck_config[id]['outlineUpColor'],'stroke-opacity':bck_config[id]['outlineUpOpacity']});
		})
		_obj.click(function(){
			console.log("ok i am clicked");
			$('.organs-tip').show().html(bck_config[id]['hover']);
			_obj.css({'fill':bck_config[id]['overColor'],'fill-opacity':bck_config[id]['overOpacity'],'stroke':bck_config[id]['outlineOverColor'],'stroke-opacity':bck_config[id]['outlineOverOpacity']})
		})
		_obj.mousedown(function(){
			$('#'+id).css({'fill':bck_config[id]['downColor'],'fill-opacity':bck_config[id]['downOpacity'],'stroke':bck_config[id]['outlineDownColor'],'stroke-opacity':bck_config[id]['outlineDownOpacity']});
		})
		_obj.mouseup(function(){
			$('#'+id).css({'fill':bck_config[id]['overColor'],'fill-opacity':bck_config[id]['overOpacity'],'stroke':bck_config[id]['outlineOverColor'],'stroke-opacity':bck_config[id]['outlineOverOpacity']});
			if(bck_config[id]['target'] == 'new_window'){
				window.open(bck_config[id]['url']);	
			}else if(bck_config[id]['target'] == 'same_window'){
				window.parent.location.href=bck_config[id]['url'];
			}
		})
		_obj.mousemove(function(e){
			var x=e.pageX+10, y=e.pageY+15;
			var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
			x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
			y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
			$('.organs-tip').css({left:x, top:y})
		})
	}	
}

//The front spots code
$(function(){
	var points_len = frt_spots['spots'].length;
	if( points_len > 0){
		var xmlns = "http://www.w3.org/2000/svg";
		var tsvg_obj = document.getElementById("frt_spots");
		var svg_circle;
		for(var i=0; i<points_len; i++){
			svg_circle = document.createElementNS(xmlns, "circle");
			svg_circle.setAttributeNS(null, "cx", frt_spots['spots'][i]['pos_X']);
			svg_circle.setAttributeNS(null, "cy", frt_spots['spots'][i]['pos_Y']);
			svg_circle.setAttributeNS(null, "r", frt_spots['spots'][i]['diameter']/2);
			svg_circle.setAttributeNS(null, "fill", frt_spots['spots'][i]['upColor']);
			svg_circle.setAttributeNS(null, "fill-opacity", frt_spots['spots'][i]['upOpacity']);
			svg_circle.setAttributeNS(null, "stroke", frt_spots['spots'][i]['outlineUpColor']);
			svg_circle.setAttributeNS(null, "stroke-opacity", frt_spots['spots'][i]['outlineUpOpacity']);
			svg_circle.setAttributeNS(null, "id",'frt_spots_'+i);
			tsvg_obj.appendChild(svg_circle);
			dynamicfrt_addEvent(i);
		}
	}
});

function dynamicfrt_addEvent(id){
	var obj = $('#frt_spots_'+id);
	
	if(frt_spots['spots'][id]['enable'] == true){
		if (isTouchEnabled()) {
			obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+5, y=touch.pageY+5;
				var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(),
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':frt_spots['spots'][id]['downColor'],'fill-opacity':frt_spots['spots'][id]['downOpacity'],'stroke':frt_spots['spots'][id]['outlineDownColor'],'stroke-opacity':frt_spots['spots'][id]['outlineDownOpacity']});
				$('.organs-tip').show().html(frt_spots['spots'][id]['hover']);
				$('.organs-tip').css({left:x, top:y})
			})
			obj.on('touchend', function(){
				$('#'+id).css({'fill':frt_spots['spots'][id]['upColor'],'fill-opacity':frt_spots['spots'][id]['upOpacity'],'stroke':frt_spots['spots'][id]['outlineUpColor'],'stroke-opacity':frt_spots['spots'][id]['outlineUpOpacity']});
				if(frt_spots['spots'][id]['target'] == 'new_window'){
					window.open(frt_spots['spots'][id]['url']);
				}else if(frt_spots['spots'][id]['target'] == 'same_window'){
					window.parent.location.href=frt_spots['spots'][id]['url'];
				}
			})
		}
		obj.attr({'cursor':'pointer'});
		obj.hover(function(){
			$('.organs-tip').show().html(frt_spots['spots'][id]['hover']);
			obj.css({'fill':frt_spots['spots'][id]['overColor'],'fill-opacity':frt_spots['spots'][id]['overOpacity'],'stroke':frt_spots['spots'][id]['outlineOverColor'],'stroke-opacity':frt_spots['spots'][id]['outlineOverOpacity']})
		},function(){
			$('.organs-tip').hide();
			obj.css({'fill':frt_spots['spots'][id]['upColor'],'fill-opacity':frt_spots['spots'][id]['upOpacity'],'stroke':frt_spots['spots'][id]['outlineUpColor'],'stroke-opacity':frt_spots['spots'][id]['outlineUpOpacity']});
		})
		obj.mousedown(function(){
			obj.css({'fill':frt_spots['spots'][id]['downColor'],'fill-opacity':frt_spots['spots'][id]['downOpacity'],'stroke':frt_spots['spots'][id]['outlineDownColor'],'stroke-opacity':frt_spots['spots'][id]['outlineDownOpacity']});
		})
		obj.mouseup(function(){
			obj.css({'fill':frt_spots['spots'][id]['overColor'],'fill-opacity':frt_spots['spots'][id]['overOpacity'],'stroke':frt_spots['spots'][id]['outlineOverColor'],'stroke-opacity':frt_spots['spots'][id]['outlineOverOpacity']});
			if(frt_spots['spots'][id]['target'] == 'new_window'){
				window.open(frt_spots['spots'][id]['url']);	
			}else if(frt_spots['spots'][id]['target'] == 'same_window'){
				window.parent.location.href=frt_spots['spots'][id]['url'];
			}
		})
		obj.mousemove(function(e){
			var x=e.pageX+5, y=e.pageY+5;
			var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
			x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
			y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
			$('.organs-tip').css({left:x, top:y})
		})
	}	
}

//The back spots code
$(function(){
	var points_len = bck_spots['spots'].length;
	if( points_len > 0){
		var xmlns = "http://www.w3.org/2000/svg";
		var tsvg_obj = document.getElementById("bck_spots");
		var svg_circle;
		for(var i=0;i<points_len;i++){
			svg_circle = document.createElementNS(xmlns, "circle");
			svg_circle.setAttributeNS(null, "cx", bck_spots['spots'][i]['pos_X']);
			svg_circle.setAttributeNS(null, "cy", bck_spots['spots'][i]['pos_Y']);
			svg_circle.setAttributeNS(null, "r", bck_spots['spots'][i]['diameter']/2);
			svg_circle.setAttributeNS(null, "fill", bck_spots['spots'][i]['upColor']);
			svg_circle.setAttributeNS(null, "fill-opacity", bck_spots['spots'][i]['upOpacity']);
			svg_circle.setAttributeNS(null, "stroke", bck_spots['spots'][i]['outlineUpColor']);
			svg_circle.setAttributeNS(null, "stroke-opacity", bck_spots['spots'][i]['outlineUpOpacity']);
			svg_circle.setAttributeNS(null, "id",'bck_spots_'+i);
			tsvg_obj.appendChild(svg_circle);
			dynamicbck_addEvent(i);
		}
	}
});

function dynamicbck_addEvent(id){
	var obj = $('#bck_spots_'+id);

	if(bck_spots['spots'][id]['enable'] == true){
		if (isTouchEnabled()) {
			obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(),
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':bck_spots['spots'][id]['downColor'],'fill-opacity':bck_spots['spots'][id]['downOpacity'],'stroke':bck_spots['spots'][id]['outlineDownColor'],'stroke-opacity':bck_spots['spots'][id]['outlineDownOpacity']});
				$('.organs-tip').show().html(bck_spots['spots'][id]['hover']);
				$('.organs-tip').css({left:x, top:y})
			})
			obj.on('touchend', function(){
				$('#'+id).css({'fill':bck_spots['spots'][id]['upColor'],'fill-opacity':bck_spots['spots'][id]['upOpacity'],'stroke':bck_spots['spots'][id]['outlineUpColor'],'stroke-opacity':bck_spots['spots'][id]['outlineUpOpacity']});
				if(bck_spots['spots'][id]['target'] == 'new_window'){
					window.open(bck_spots['spots'][id]['url']);
				}else if(bck_spots['spots'][id]['target'] == 'same_window'){
					window.parent.location.href=bck_spots['spots'][id]['url'];
				}
			})
		}
		obj.attr({'cursor':'pointer'});
		obj.hover(function(){
			$('.organs-tip').show().html(bck_spots['spots'][id]['hover']);
			obj.css({'fill':bck_spots['spots'][id]['overColor'],'fill-opacity':bck_spots['spots'][id]['overOpacity'],'stroke':bck_spots['spots'][id]['outlineOverColor'],'stroke-opacity':bck_spots['spots'][id]['outlineOverOpacity']})
		},function(){
			$('.organs-tip').hide();
			obj.css({'fill':bck_spots['spots'][id]['upColor'],'fill-opacity':bck_spots['spots'][id]['upOpacity'],'stroke':bck_spots['spots'][id]['outlineUpColor'],'stroke-opacity':bck_spots['spots'][id]['outlineUpOpacity']});
		})
		obj.mousedown(function(){
			obj.css({'fill':bck_spots['spots'][id]['downColor'],'fill-opacity':bck_spots['spots'][id]['downOpacity'],'stroke':bck_spots['spots'][id]['outlineDownColor'],'stroke-opacity':bck_spots['spots'][id]['outlineDownOpacity']});
		})
		obj.mouseup(function(){
			obj.css({'fill':bck_spots['spots'][id]['overColor'],'fill-opacity':bck_spots['spots'][id]['overOpacity'],'stroke':bck_spots['spots'][id]['outlineOverColor'],'stroke-opacity':bck_spots['spots'][id]['outlineOverOpacity']});
			if(bck_spots['spots'][id]['target'] == 'new_window'){
				window.open(bck_spots['spots'][id]['url']);	
			}else if(bck_spots['spots'][id]['target'] == 'same_window'){
				window.parent.location.href=bck_spots['spots'][id]['url'];
			}
		})
		obj.mousemove(function(e){
				var x=e.pageX+10, y=e.pageY+15;
				var tipw=$('.organs-tip').outerWidth(), tiph=$('.organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('.organs-tip').css({left:x, top:y})
		})
	}	
}
