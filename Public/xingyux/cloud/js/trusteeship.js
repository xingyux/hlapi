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

	$(".icon1").click(function(){
		$(".head h3").animate({marginTop:"-37px"},300)
	});

	$(".layui-input").attr("disabled","disabled");

	// $('[data-toggle="tooltip"]').tooltip();  //tooltip

	$(".activity").hover(function(){
		$(".award").css("display","block")
	},function(){
		$(".award").css("display","none")
	});

	layui.use('form', function(){});

    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

        if (sTop >= 700) {  
            if (!$(".maches").is(":visible")) {  
                try {  
                    $(".maches").show();  
                } catch (e) {  
                    $(".maches").show();  
                }                        
            }  
        }  
        else {  
            if ($(".maches").is(":visible")) { 
                try {  
                    $(".maches").hide(); 
                } catch (e) {  
                    $(".maches").hide();
                }                         
            }  
        } 
       
        
    });
    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

        if (sTop >= 300) {  
            if (!$(".sidebar .up").is(":visible")) {  
                try {  
                    $(".sidebar .up").show()
                } catch (e) {  
                    $(".sidebar .up").show()
                }                        
            }  
        }  
        else {  
            if ($(".sidebar .up").is(":visible")) { 
                try {  
                    $(".sidebar .up").hide()
                } catch (e) {  
                    $(".sidebar .up").hide()
                }                         
            }  
        } 
               
    });
    $(".sidebar .up").click(function(){
    	$("html ,body").animate({scrollTop:"0"},300)
    });      

    $(".dials").hover(function(){
    	$(".dials-text").css("display","block")
    },function(){
    	$(".dials-text").css("display","none")
    });
    $(".dials-text").hover(function(){
    	$(".dials-text").css("display","block")
    },function(){
    	$(".dials-text").css("display","none")
    });
    
    $(".ser").hover(function(){
    	$(".ser-text").css("display","block")
    },function(){
    	$(".ser-text").css("display","none")
    });
    $(".ser-text").hover(function(){
    	$(this).css("display","block")
    },function(){
    	$(this).css("display","none")
    });

    $(".login").hover(function(){
    	$(".logins").css("display","block");
    	$(".login").css("color","#fb6800");
    	$(".tridown").css("color","#fb6800")
    },function(){
    	$(".logins").css("display","none");
    	$(".login").css("color","#333");
    	$(".tridown").css("color","#333")
    });
    $(".logins").hover(function(){
    	$(".logins").css("display","block");
    	$(".login").css("color","#fb6800");
    	$(".tridown").css("color","#fb6800")
    },function(){
    	$(".logins").css("display","none");
    	$(".login").css("color","#333");
    	$(".tridown").css("color","#333")
    });

    $(".chat").hover(function(){
    	$(this).attr("src","images/w2.jpg")
    },function(){
    	$(this).attr("src","images/w1.jpg")
    });

    var aa = document.querySelector("#vCode");
		var code1 = new vCode(aa,{
			len: 4,             //验证码字体数量
		    bgColor: "#b5f4f4", //验证码背景颜色
		    colors: [           //验证码字体颜色
		        '#DDDDDD',
		        '#DDFF77',
		        '#77DDFF',
		        '#99BBFF',
		        '#7700BB',
		        '#EEEE00',
		        '#000507',
		        '#980023',
		        '#50001a',
		    ]
	});

	$(".head .down").find(".menulist").hover(function(){
		$(this).addClass("has")
	},function(){
		$(this).removeClass("has")
	});

	$("#m2").hover(function(){
		$("#m22").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m22").css("display","none");
		$(this).css("color","#333")
	});
	$("#m22").hover(function(){
		$("#m22").css("display","block");
		$("#m2").css("color","#fb6800");
		$("#m2").addClass("has")
	},function(){
		$("#m22").css("display","none");
		$("#m2").css("color","#333");
		$("#m2").removeClass("has")
	});

	$("#m3").hover(function(){
		$("#m33").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m33").css("display","none");
		$(this).css("color","#333")
	});
	$("#m33").hover(function(){
		$("#m33").css("display","block");
		$("#m3").css("color","#fb6800");
		$("#m3").addClass("has")
	},function(){
		$("#m33").css("display","none");
		$("#m3").css("color","#333");
		$("#m3").removeClass("has")
	});

	$("#m4").hover(function(){
		$("#m44").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m44").css("display","none");
		$(this).css("color","#333")
	});
	$("#m44").hover(function(){
		$("#m44").css("display","block");
		$("#m4").css("color","#fb6800");
		$("#m4").addClass("has")
	},function(){
		$("#m44").css("display","none");
		$("#m4").css("color","#333");
		$("#m4").removeClass("has")
	});

	$("#m6").hover(function(){
		$("#m66").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m66").css("display","none");
		$(this).css("color","#333")
	});
	$("#m66").hover(function(){
		$("#m66").css("display","block");
		$("#m6").css("color","#fb6800");
		$("#m6").addClass("has")
	},function(){
		$("#m66").css("display","none");
		$("#m6").css("color","#333");
		$("#m6").removeClass("has")
	});

	$("#m7").hover(function(){
		$("#m77").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m77").css("display","none");
		$(this).css("color","#333")
	});
	$("#m77").hover(function(){
		$("#m77").css("display","block");
		$("#m7").css("color","#fb6800");
		$("#m7").addClass("has")
	},function(){
		$("#m77").css("display","none");
		$("#m7").css("color","#333");
		$("#m7").removeClass("has")
	});

	$("#m8").hover(function(){
		$("#m88").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m88").css("display","none");
		$(this).css("color","#333")
	});
	$("#m88").hover(function(){
		$("#m88").css("display","block");
		$("#m8").css("color","#fb6800");
		$("#m8").addClass("has")
	},function(){
		$("#m88").css("display","none");
		$("#m8").css("color","#333");
		$("#m8").removeClass("has")
	});

	$("#m9").hover(function(){
		$("#m99").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m99").css("display","none");
		$(this).css("color","#333")
	});
	$("#m99").hover(function(){
		$("#m99").css("display","block");
		$("#9").css("color","#fb6800");
		$("#m9").addClass("has")
	},function(){
		$("#m99").css("display","none");
		$("#m9").css("color","#333");
		$("#m9").removeClass("has")
	});
	
	$("#m10").hover(function(){
		$("#m100").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m100").css("display","none");
		$(this).css("color","#333")
	});
	$("#m100").hover(function(){
		$("#m100").css("display","block");
		$("#10").css("color","#fb6800");
		$("#m10").addClass("has")
	},function(){
		$("#m100").css("display","none");
		$("#m10").css("color","#333");
		$("#m10").removeClass("has")
	});
	
	$("#m11").hover(function(){
		$("#m111").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m111").css("display","none");
		$(this).css("color","#333")
	});
	$("#m111").hover(function(){
		$("#m111").css("display","block");
		$("#11").css("color","#fb6800");
		$("#m11").addClass("has")
	},function(){
		$("#m111").css("display","none");
		$("#m11").css("color","#333");
		$("#m11").removeClass("has")
	});

	$("#m12").hover(function(){
		$("#m122").css("display","block");
		$(this).css("color","#fb6800")
	},function(){
		$("#m122").css("display","none");
		$(this).css("color","#333")
	});
	$("#m122").hover(function(){
		$("#m122").css("display","block");
		$("#12").css("color","#fb6800");
		$("#m12").addClass("has")
	},function(){
		$("#m122").css("display","none");
		$("#m12").css("color","#333");
		$("#m12").removeClass("has")
	});	

	$( "#slider-range-max" ).slider({
      	range: "max",
      	min: 1,
      	max: 100,
      	value: 10,
      	step:1,
      	slide: function( event, ui ) {
      	  $( "#amount" ).val( ui.value );
      	}
    });
    $( "#slider-range-max" ).slider({ animate: "100" });
    $( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );
    $("#amount").on("input",function () {
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
        if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk - 1);
        } else {
            $("#slider-range-max").slider("value", amount - 1);
        }
    });

    $( "#slider-range-time" ).slider({
      	range: "max",
      	min: 1,
      	max: 10,
      	value: 2,
      	step:1,
      	slide: function( event, ui ) {
      	  $( "#amounts" ).val( ui.value );
      	}
    });
    
    $(".machine li a").click(function(){
    	$(".machine li a").removeClass("acts");
    	$(this).addClass("acts")
    });

    $(".f1").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri1").css("display","block")
    });
    $(".f2").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri2").css("display","block")
    });
    $(".f3").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri3").css("display","block")
    });
    $(".f4").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri4").css("display","block")
    });
    $(".f5").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri5").css("display","block")
    });
    $(".f6").click(function(){
    	$(".wtri").css("display","none");
    	$(".wtri6").css("display","block")
    });

    $(".rights a").click(function(){
    	$(".rights a").removeClass("act1");
    	$(this).addClass("act1")
    });
    
    $(".electric a").click(function(){
    	$(".electric a").removeClass("act1");
    	$(this).addClass("act1")
    });

    $(".ddos a").click(function(){
    	$(".ddos a").removeClass("act1");
    	$(this).addClass("act1")
    });

    $(".serverheight a").click(function(){
    	$(".serverheight a").removeClass("act1");
    	$(this).addClass("act1")
    });

    $(".plus1").click(function(){
    	var value = $(".input_number").val();
    	value++;
    	$(".input_number").val(value);
    });
    $(".sub1").click(function(){
    	var value = $(".input_number").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".input_number").val(value);
    });

    $(".plus2").click(function(){
    	var value = $(".purchase_number").val();
    	value++;
    	$(".purchase_number").val(value);
    });
    $(".sub2").click(function(){
    	var value = $(".purchase_number").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".purchase_number").val(value);
    });

    $(".inputnumber").on("input",function(){
    	this.value = this.value.replace(/\D/g,"");
    	if(this.value <= 1 ){
    	   this.value = 1;
    	}
    });
    // $(".inputnumber").attr("disabled","disabled");

    layui.use('carousel', function(){
		var carousel = layui.carousel;
			carousel.render({
			    elem: '#test4'
			    ,width: '100%'
			    ,arrow:'always'
			    ,height: '170px'
			    ,interval: 5000
			    ,anim:'default'
			    ,trigger:'hover'
		});
	});




})