var _int_town=function(obj_int,obj,arr,ob_jq,input){
	var oid=arr[0];
	var bid=arr[1];
			var j=bid[2];
				var k=bid[3];
				var o=arecode[j].list[k].list;	
	var arehtml="<li id='prv_0' rel='0'>返回上级区域</li><li id='prv_" + bid[1] + "' rel='" + arecode[j].are + "-" + obj.html() + "-全市'>选择所有区域</li>";
	
			for(i=0;i<o.length;i++){
					arehtml+="<li id='prv_" + o[i].code + "'' rel='" + arecode[j].are + "-" + obj.html() + "-"+o[i].are+"'>"+o[i].are+"</li>";
					}
					$(".arecode_prv div").html(arehtml);
					$(".arecode_prv div li").unbind("click");
					$(".arecode_prv div li").click(function(){
						var oid=$(this).attr("id");
						if(oid=="prv_0"){
							_int_city(obj_int,arr[2]);return false;
						}

					var isChecked=false;
				$("#arecodelist ul li").each(function(){
					if($(this).children(".arecode_int").val()==oid.replace("prv_","")){
						alert("此城市已选择");
						isChecked=true;
						return false;
					}
				});					
					if(isChecked){return false;}
						
					input.val(oid.replace("prv_",""));
					obj_int.val($(this).attr("rel"));
					ob_jq.fadeOut("slow");
					return false;					
					});
}
var _int_city=function(obj_int,obj,ob_jq,input){
		var oid=obj.attr("id");
			var bid=oid.split("_");
			var j=bid[2];
			var o=arecode[j].list;
			var arehtml="<li id='prv_0' rel='0'>返回上级区域</li><li id='prv_" + bid[1] + "' rel='" + obj.html() + "'>选择所有区域</li>";
		for(i=0;i<o.length;i++){
			arehtml+="<li id='prv_" + o[i].code + "_" + j + "_" + i + "' rel='"+o[i].are+"'>"+o[i].are+"</li>";
			}
			$(".arecode_prv div").html(arehtml);
			$(".arecode_prv div li").unbind("click");
		$(".arecode_prv div li").click(function(){
			var oid=$(this).attr("id");
			if(oid=="prv_0"){
				_int_prv(arecode,obj_int);return false;
			}
				var bid=oid.split("_");
				if(bid.length==2){
					var isChecked=false;
				$("#arecodelist ul li").each(function(){
					if($(this).children(".arecode_int").val()==oid.replace("prv_","")){
						alert("此城市已选择");
						isChecked=true;
						return false;
					}
				});					
					if(isChecked){return false;}
					obj_int.val($(this).attr("rel")+"-全省");
					input.val(oid.replace("prv_",""));
					ob_jq.fadeOut("slow");
					return false;
				}
				_int_town(obj_int,$(this),[oid,bid,obj],ob_jq,input);
		});
}
var _int_prv=function(txt,obj_int,ob_jq,input){
	$(".arecode_prv div li").unbind("click");
		var arehtml="<li id='prv_0' rel='全国'>全国</li>";
		for(i=0;i<txt.length;i++){
			arehtml+="<li id='prv_" + txt[i].code + "_" + i + "' rel='"+txt[i].are+"'>"+txt[i].are+"</li>";
			}
		$(".arecode_prv div").html(arehtml);
		$(".arecode_prv div li").unbind("click");
		$(".arecode_prv div li").click(function(){
			if($(this).attr("id")=="prv_0"){

				obj_int.val("全国");
				input.val("0");

				$("#arecodelist ul li").each(function(){
					if($(this).children(".arecode_int").val()!="0"){
						$(this).remove();
					}
				});
				
				ob_jq.hide();
				
				return false;
			}
			_int_city(obj_int,$(this),ob_jq,input);
		})
}
var int_arecode_str=function(v1,v2){

					var isChecked=false;
				$("#arecodelist ul li").each(function(){
					if($(this).children(".arecode_int").val()=="0"){
						alert("已有全国选项，不能再加其他地区");
						isChecked=true;
						return false;
					}
				});					
					if(isChecked){return false;}	
	
	$("#arecodelist ul").append('<li><input value="'+v1+'" type="search" class="input-sm arecodelist" placeholder="活动地区" readonly="readonly"><input type="text"  name="arcode[]" class="arecode_int" value="'+v2+'" readonly="readonly" /><a href="#" class="tooltip-error delarecode" data-rel="tooltip" title="" data-original-title="Delete"><span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>');

	$(".arecodelist,a.delarecode").unbind("click");
	$("a.delarecode").click(function(){
		$(this).closest("li").remove();
	});
	$(".arecodelist").click(function(){

	
					var isChecked=false;
				$("#arecodelist ul li").each(function(){
					if($(this).children(".arecode_int").val()=="0"){
						
						isChecked=true;
						return false;
					}
				});					
					if(isChecked&&$("#arecodelist ul li").size()!=1){alert("已有全国选项，不能再加其他地区");return false;}	
	
		var ob=$(".arecode_select");
		ob.fadeIn("slow");
		var obj_int=$(this);
		var otop=obj_int.position();
		ob.css({
			"left":otop.left,
			"top":otop.top+obj_int.height()*2
		});
		
		var input=$(this).next(".arecode_int");
		_int_prv(arecode,obj_int,ob,input);
		ob.mouseleave(function(){
			$(this).fadeOut("slow");
		})
		})	
	
	}
$(function(){
	for(i=0;i<array_arecode.length;i++){
		int_arecode_str(array_arecode[i].cn,array_arecode[i].code);
	}
	
	$("#arecodelist h4 a").click(function(){
		int_arecode_str("","");return false;
	});

	})