$(function(){
	$(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

        if (sTop >= 100) {  
            if (!$(".nav2").is(":visible")) {  
                try {  
                    $(".nav2").show()
                } catch (e) {  
                    $(".nav2").show()
                }                        
            }  
        }  
        else {  
            if ($(".nav2").is(":visible")) { 
                try {  
                    $(".nav2").hide()
                } catch (e) {  
                    $(".nav2").hide()
                }                         
            }  
        } 
               
    });

	$(".standard").hover(function(){
		$(".c1").css("display","block")
	},function(){
		$(".c1").css("display","none")
	});
	$(".phone").hover(function(){
		$(".c2").css("display","block")
	},function(){
		$(".c2").css("display","none")
	});
	$(".cooperate").hover(function(){
		$(".c3").css("display","block")
	},function(){
		$(".c3").css("display","none")
	});
	$(".tips").hover(function(){
		$(".c4").css("display","block")
	},function(){
		$(".c4").css("display","none")
	});
    $(".standard").click(function(){
    	$(".text1").css("display","block");
    	$(".text2").css("display","none");
    	$(".text3").css("display","none")
    });
    $(".phone").click(function(){
    	$(".text1").css("display","none");
    	$(".text2").css("display","block");
    	$(".text3").css("display","none")
    });
    $(".cooperate").click(function(){
    	$(".text1").css("display","none");
    	$(".text2").css("display","none");
    	$(".text3").css("display","block");
    });

    $(".lev2").click(function(){
    	$(".lev2").removeClass("v2");
    	$(this).addClass("v2")
    });
    $(".lev3-1").click(function(){
    	$(".lev3-1").removeClass("v2");
    	$(this).addClass("v2")
    });
    $(".lev3-2").click(function(){
    	$(".lev3-2").removeClass("v2");
    	$(this).addClass("v2")
    });
    $(".lev3-3").click(function(){
    	$(".lev3-3").removeClass("v2");
    	$(this).addClass("v2")
    });

    $(".input").on("input",function(){
    	this.value = this.value.replace(/\D/g,"");
    });
    $(".add1").click(function(){
    	var value = $(".in1").val();
    	value++;
    	$(".in1").val(value)
    });
    $(".reduce1").click(function(){
    	var value = $(".in1").val();
    	if(value <= 3){
    		return;
    	}
    	value--;
    	$(".in1").val(value)
    });

    $(".add2").click(function(){
    	var value = $(".in2").val();
    	value++;
    	$(".in2").val(value)
    });
    $(".reduce2").click(function(){
    	var value = $(".in2").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".in2").val(value)
    });

    $(".add3").click(function(){
    	var value = $(".in3").val();
    	value++;
    	$(".in3").val(value)
    });
    $(".reduce3").click(function(){
    	var value = $(".in3").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".in3").val(value)
    });

    $(".add4").click(function(){
    	var value = $(".in4").val();
    	value++;
    	$(".in4").val(value)
    });
    $(".reduce4").click(function(){
    	var value = $(".in4").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".in4").val(value)
    });

    $(".add5").click(function(){
    	var value = $(".in5").val();
    	value = parseInt(value) + 10;
    	$(".in5").val(value);
    	console.log(value)
    });
    $(".reduce5").click(function(){
    	var value = $(".in5").val();
    	if(value <= 10){
    		return;
    	}
    	value = parseInt(value) - 10;
    	$(".in5").val(value)
    });

    $(".add6").click(function(){
    	var value = $(".in6").val();
    	value++;
    	$(".in6").val(value)
    });
    $(".reduce6").click(function(){
    	var value = $(".in6").val();
    	if(value <= 1){
    		return;
    	}
    	value--;
    	$(".in6").val(value)
    });

    $(".n1").hover(function(){
    	$(".page1").css("display","block")
    },function(){
    	$(".page1").css("display","none")
    });
    $(".page1").hover(function(){
    	$(this).css("display","block")
    },function(){
    	$(this).css("display","none")
    });

    $(".p1").hover(function(){
    	$(".pag1").css("display","block")
    },function(){
    	$(".pag1").css("display","none")
    });
    $(".pag1").hover(function(){
    	$(this).css("display","block")
    },function(){
    	$(this).css("display","none")
    });








})