$(function(){
	if( !('placeholder' in document.createElement('input')) ){     
        $('input[placeholder],textarea[placeholder]').each(function(){      
            var that = $(this),      
            text= that.attr('placeholder');      
            if(that.val()===""){      
            that.val(text).addClass('placeholder');      
        }      
        that.focus(function(){   
            if(that.val()===text){  
                that.val("").removeClass('placeholder');      
            }      
        })      
        .blur(function(){      
            if(that.val()===""){      
                that.val(text).addClass('placeholder');      
            }      
        })      
        .closest('form').submit(function(){      
            if(that.val() === text){      
                that.val('');      
            }      
        });      
        });    
    };

	$(".head_right input").hover(function(){
		$(this).css("border-color","white");
		$(".icon2").css("color","white")
	},function(){
		$(this).css("border-color","#706e6e");
		$(".icon2").css("color","#aaa")
	});

	$(".icon2").hover(function(){
		$(this).css("color","white");
		$(".head_right input").css("border-color","white")
	},function(){
		$(this).css("color","#706e6e");
		$(".head_right input").css("border-color","#aaa")
	});

	$(".place_down span").click(function(){
		$(".place_down span").removeClass("on");
		$(this).addClass("on")
	});

	$(".pur_re").hover(function(){
		$(".record").css("display","block")
	},function(){
		$(".record").css("display","none")
	});
	$(".record").hover(function(){
		$(".record").css("display","block")
	},function(){
		$(".record").css("display","none")
	});

	$(".machines li").click(function(){
		$(".machines li").removeClass("cover");
		$(this).addClass("cover")
	});
	$(".machines li:not(.ps)").hover(function(){
		$(this).css("background-color","#fafafa")
	},function(){
		$(this).css("background-color","#fff")
	});

	$(".inside_box").click(function(){
		$(".inside_box").removeClass("box_cover");
		$(this).addClass("box_cover")
	});

	$(".mirrors li").click(function(){
		$(".mirrors li").removeClass("mirror_cover");
		$(this).addClass("mirror_cover")
	});

	$( "#slider-range-max" ).slider({
      	range: "max",
      	min: 0,
      	max: 200,
      	value: 1,
      	step:1,
      	slide: function( event, ui ) {
      	  	$( "#amount" ).val( ui.value );
      	  	var values = $("#amount").val();
			if( values == 0 ){
				$(".net_msg").css("display","block");
			}else{
				$(".net_msg").css("display","none");
			}
      	}
    });
    

    $( "#slider-range-max" ).slider({ animate: "100" });
    $( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );
    $("#amount").on("input",function () {
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-max").slider("value", amount - 1);
        }
    });
    $("#amount").on("blur",function(){
    	if( this.value == "" ){
    		$("#amount").val(1)
    	}
    });

    $(".net_subtract").click(function(){
    	var value = $("#amount").val();
    	var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
    	if( value == 1 ){
    		$(".net_msg").css("display","block");
    		value--
    	}else if( value > 1){
    		value--;
    	}else if( value < 1){
    		return
    	}
    	if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-max").slider("value", amount - 1);
        }
    	$("#amount").val(value)
    });
    $(".net_add").click(function(){
    	var value = $("#amount").val();
    	var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
    	if( value >= 200 ){
    		return
    	}else{
    		value++;
    	}
    	$("#amount").val(value);
    	if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk );
        }else{
            $("#slider-range-max").slider("value", amount );
        }
        $(".net_msg").css("display","none")
    });

    $(".net_ps").click(function(){
    	if( $(".net_ps i").hasClass("blue") ){
    		$(".net_ps i").removeClass("blue")
    	}else{
    		$(".net_ps i").addClass("blue")
    	}
    });

    $(".pur_num").on("input",function(){
    	this.value = this.value.replace(/\D/g,"");
    	var value = $(".pur_num").val();
    	if( value > 1 ){
    		$(".pur_subtract").removeClass("pur_disable")
    	}
    });
    $(".pur_num").blur(function(){
    	var value = $(".pur_num").val();
    	if( value == "" ){
    		$(".pur_num").val(1)
    	}
    });
    $(".pur_subtract").click(function(){
    	var value = $(".pur_num").val();
    	if( value <= 1){
    		return
    	}else{
    		value--
    	}
    	if( value == "1"){
    		$(".pur_subtract").addClass("pur_disable")
    	}
    	$(".pur_num").val(value)
    });
    $(".pur_add").click(function(){
    	var value = $(".pur_num").val();
    	value++;
    	$(".pur_num").val(value);
    	$(".pur_subtract").removeClass("pur_disable")
    });

    $(".time_text span").click(function(){
    	$(".time_text span").removeClass("time_cover");
    	$(this).addClass("time_cover")
    });

    $(".pure1").click(function(){
    	var index = $(this).attr("index");
    	var value = $(this).attr("value");
    	// var a = $($(".pure")[index]).empty().text(value);
    	// var b = a.text();
    	// $(this).empty().text( index + "个月");
    	// $(".add_more").css("display","none");
    	$(this).text( 1 + "个月");
    	$(".pure2").empty().text(2);
    	$(".pure3").empty().text(3);
    });
    $(".pure2").click(function(){
    	$(this).text( 2 + "个月");
    	$(".pure1").empty().text(1);
    	$(".pure3").empty().text(3);
    });
    $(".pure3").click(function(){
    	$(this).empty().text( 3 + "个月");
    	$(".pure2").empty().text(2);
    	$(".pure1").empty().text(1);
    });
    $(".sup").click(function(){
    	$(".pure1").empty().text(1);
    	$(".pure2").empty().text(2);
    	$(".pure3").empty().text(3);
    });

    $(".time_ps").click(function(){
    	if( $(".time_ps i").hasClass("blue") ){
    		$(".time_ps i").removeClass("blue")
    	}else{
    		$(".time_ps i").addClass("blue")
    	}
    });

    $(".choice").hover(function(){
    	$(".choices").css("display","block")
    },function(){
    	$(".choices").css("display","none")
    });
    $(".choices").hover(function(){
    	$(this).css("display","block")
    },function(){
    	$(this).css("display","none")
    });

    $(".more_equipment").hover(function(){
    	$(".equipment").css("display","block")
    },function(){
    	$(".equipment").css("display","none")
    });
    $(".equipment").hover(function(){
    	$(this).css("display","block")
    },function(){
    	$(this).css("display","none")
    })






})