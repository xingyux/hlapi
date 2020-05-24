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

    $(".labels").click(function(){
    	var val = $('form input[name="sex"]:checked ').val();
    	$(".totalfee").text(val)
    });

	$(".icon1").click(function(){
		$(".head h3").animate({marginTop:"-37px"},300)
	});

	$(".maintext .space li").click(function(){
		$(".maintext .space li").removeClass("spaces");
		$(this).addClass("spaces")
	});

	$(".maintext .house li").click(function(){
		$(".maintext .house li").removeClass("houses");
		$(this).addClass("houses");
		$(".maintext .house li h3").removeClass("househ");
		$(this).find("h3").addClass("househ");
		$(".maintext .house li p").removeClass("housep");
		$(this).find("p").addClass("housep")
	});

	// $('[data-toggle="tooltip"]').tooltip();  //tooltip

	$(".activity").hover(function(){
		$(".award").css("display","block")
	},function(){
		$(".award").css("display","none")
	});

	$(".add-cdn").click(function(){
		if($(this).hasClass("cdns")){
			$(this).removeClass("cdns");
			$(this).removeClass("duigou");
			$(".orangebar").css("display","none");
			$(".x2").css("borderBottom","1px solid #eee");
			$(".num1").text("0元");
		}else{
			$(this).addClass("cdns");
			$(this).addClass("duigou");
			$(".orangebar").css("display","block");
			$(".x2").css("border","none");
			$(".num1").text("324.00元")
		}
	});

	$(".add-ip").click(function(){
		if($(this).hasClass("cdns")){
			$(this).removeClass("cdns");
			$(this).removeClass("duigou");
			$(".num2").text("0元")
		}else{
			$(this).addClass("cdns");
			$(this).addClass("duigou");
			$(".num2").text("10元")
		}
	});

	layui.use('form', function(){
  		// var form = layui.form;
  
		//自定义验证规则
		// form.verify({
		//     title: function(value){
		//       if(value.length < 5){
		//         return '标题也太短了吧';
		//       }
		//     }
		//     ,pass: [/(.+){6,12}$/, '密码必须6到12位']
		// });

  
		//事件监听
		// form.on('select', function(data){
		//     console.log('select: ', this, data);
		// });
		  
		// form.on('select(quiz)', function(data){
		//     console.log('select.quiz：', this, data);
		// });
		  
		// form.on('select(interest)', function(data){
		//     console.log('select.interest: ', this, data);
		// });
  
  
  
		// form.on('checkbox', function(data){
		//     console.log(this.checked, data.elem.checked);
		// });
		  
		// form.on('switch', function(data){
		//     console.log(data);
		// });
		  
		// form.on('radio', function(data){
		//     console.log(data);
		// });
		  
		//监听提交
		// form.on('submit(*)', function(data){
		//     console.log(data)
		//     return false;
		// });
  
    });

    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

        if (sTop >= 110) {  
            if (!$(".other").is(":visible")) {  
                try {  
                    $(".other").show();  
                } catch (e) {  
                    $(".other").show();  
                }                        
            }  
        }  
        else {  
            if ($(".other").is(":visible")) { 
                try {  
                    $(".other").hide(); 
                } catch (e) {  
                    $(".other").hide();
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

	$("#account").focus(function(){
		$(".hint").text("请牢记您的密码");
		$(".ipic").css("display","inline-block");
		$(".xpic").css("display","none")
	});
	$("#account").blur(function(){
		if($(this).val() == ""){
			$(".hint").text("字母或数字组成，不超过10位");
			$(".xpic").css("display","inline-block");
			$(".ipic").css("display","none")
		}else{
			$(".ipic").css("display","none");
			$(".xpic").css("display","none");
			$(".hint").text("");
		}
	});

	
	$("#code").keydown(function(){
		var val  = $("#code").val();
		var reg1 = /\d/;       //匹配一个数字字符。等价于 [0-9]。
		var reg2 = /[a-z]/;    //小写字母
		var reg3 = /[A-Z]/;    //大写字母 
		var reg4 = /[a-zA-Z]/; //大小写字母
		var reg5 = /[^\w\s]+/; //匹配非空 非字母 非数字
		if (reg1.test(val) || reg2.test(val) || reg3.test(val) ) { 
		    $(".g1").css("backgroundColor","#d40016");
		    $(".g2").css("backgroundColor","#d2d2d2");
		    $(".g3").css("backgroundColor","#d2d2d2")
		}
		if(reg1.test(val) && reg4.test(val)  ){
			$(".g1").css("backgroundColor","#ff6117");
			$(".g2").css("backgroundColor","#ff6117");
			$(".g3").css("backgroundColor","#d2d2d2")
		}
		if (reg5.test(val)  )  { 
		    $(".g1").css("backgroundColor","#87a51f");
		    $(".g2").css("backgroundColor","#87a51f");
		    $(".g3").css("backgroundColor","#87a51f")
		}
		if ( val == "")  { 
		    $(".g1").css("backgroundColor","#d2d2d2");
		    $(".g2").css("backgroundColor","#d2d2d2");
		    $(".g3").css("backgroundColor","#d2d2d2")
		}
		
	});
	$("#code").blur(function(){
		if($(this).val() == ""){
			$(".x1pic").css("display","inline-block");
			$(".codespan").text("密码不符合规范")
		}else{
			$(".x1pic").css("display","none");
			$(".codespan").text("")
		}
	});

	$( "#slider-range-max" ).slider({
      	range: "max",
      	min: 1,
      	max: 6,
      	value: 1,
      	step:1,
      	slide: function( event, ui ) {
      	  $( "#amount" ).val( ui.value );
      	}
    });
    //$( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );




	









})