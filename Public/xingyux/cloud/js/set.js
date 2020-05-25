$(function(){
	layui.use('carousel', function(){
        var carousel = layui.carousel;
            carousel.render({
            elem: '#test4'
            ,width: '100%'
            ,arrow:'hover'
            ,height: '440px'
            ,interval: 5000
            ,anim:'fade'
            ,trigger:'hover'
        });
    });

    // if( !('placeholder' in document.createElement('input')) ){     
    //     $('input[placeholder],textarea[placeholder]').each(function(){      
    //         var that = $(this),      
    //         text= that.attr('placeholder');      
    //         if(that.val()===""){      
    //         that.val(text).addClass('placeholder');      
    //     }      
    //     that.focus(function(){   
    //         if(that.val()===text){  
    //             that.val("").removeClass('placeholder');      
    //         }      
    //     })      
    //     .blur(function(){      
    //         if(that.val()===""){      
    //             that.val(text).addClass('placeholder');      
    //         }      
    //     })      
    //     .closest('form').submit(function(){      
    //         if(that.val() === text){      
    //             that.val('');      
    //         }      
    //     });      
    //     });    
    // };

    $(".shopcar").hover(function(){
    	$("#car").slideDown(300);
    	$(this).css("background","white");
    	$(".shopcar a span").css("color","black");
    	$(".shopcar a .icon3").css("color","black");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$("#login").css("display","none");
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    },function(){
    	$(this).css("background","#333");
    	$(".shopcar a .icon3").css("color","white");
    	$(".shopcar a span").css("color","white");
        $("#car").css("display","none")
    });

    $("#car").hover(function(){
    	$(".shopcar").css("background","white");
    	$(".shopcar a .icon3").css("color","black");
    	$(".shopcar a span").css("color","black");
    	$("#notice").css("display","none");
        $(this).css("display","block")
    }, function(){
    	$(".shopcar").css("background","#333");
    	$(this).slideUp(300);
    	$(".shopcar a span").css("color","white");
    	$(".shopcar a .icon3").css("color","white")
    });

    $(".secs").hover(function(){
    	$("#notice").slideDown(300);
    	$("#login").css("display","none");
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    },function(){
        $("#notice").css("display","none")
    });
    $("#notice").hover(function(){
    	$(".secs").css("background","white");
    	$(".secs span").css("color","black");
    	$(".secs .icon2").css("color","black");
    	$("#car").css("display","none");
        $(this).css("display","block")
    },function(){
    	$(this).slideUp(300);
    	$(".secs").css("background","#333");
    	$(".secs span").css("color","white");
    	$(".secs .icon2").css("color","white")
    });
    $(".secs").hover(function(){
    	$(this).css("background","white");
    	$(".secs span").css("color","black");
    	$(".secs .icon2").css("color","black");
    	$("#car").css("display","none");
    	$("#brand").css("display","none")
    },function(){
    	$(this).css("background","#333");
    	$(".secs span").css("color","white");
    	$(".secs .icon2").css("color","white")
    });

    $(".west").hover(function(){
    	$("#brand").slideDown(300);
    	$(this).css("background","white");
    	$(".west span").css("color","black");
    	$(".west .icon2").css("color","black");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#login").css("display","none");
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    },function(){
    	$(".west span").css("color","white");
    	$(this).css("background","#333");
    	$(".west .icon2").css("color","white");
        $("#brand").css("display","none")
    });
    $("#brand").hover(function(){
    	$(".west").css("background","white");
    	$(".west span").css("color","black");
    	$(".west .icon2").css("color","black");
        $(this).css("display","block")
    },function(){
    	$(this).slideUp(300);
    	$(".west span").css("color","white");
    	$(".west").css("background","#333");
    	$(".west .icon2").css("color","white")
    });

    $(".lastli").hover(function(){
    	$("#login").slideDown(200);
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$("#fh").css("color","black");
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    },function(){
    	$("#fh").css("color","white");
        $("#login").css("display","none")
    });
    $("#login").hover(function(){
    	$(".lastli").css("background","white");
    	$(".lo").css("color","black");
    	$(".re").css("color","black");
    	$("#fh").css("color","black");
        $(this).css("display","block")
    },function(){
    	$(this).slideUp(200);
    	$(".lastli").css("background","#333");
    	$(".lo").css("color","white");
    	$(".re").css("color","white");
    	$("#fh").css("color","white")
    });
    $(".lastli").hover(function(){
    	$(this).css("background","white");
    	$(".lo").css("color","black");
    	$(".re").css("color","black")
    },function(){
    	$(this).css("background","#333");
    	$(".lo").css("color","white");
    	$(".re").css("color","white")
    });

    $(".com").hover(function(){
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$("#login").css("display","none")
    });

    var liHeigth = $("#list .area .c12").innerHeight();
    var n =8;
    var len = $("#list .area .c12").length;
    var ulHeigth = liHeigth*len;
    $("#list .area").height(ulHeigth);
    var boxHeigth = liHeigth*n;
    $("#list").height(boxHeigth);
    $("#list .area .c12:lt("+ n +")").clone().insertAfter("#list .area .c12:last");
    var a;
    autoPlay();
    function autoPlay(){
        a = setInterval(function(){
            down();
        },2200)
    }
    $("#list").hover(function(){
        clearInterval(a);
    },function(){
        autoPlay();
    });

    function down(){
        var top = $("#list .area").css("top").replace("px",'');
        if (top<=-liHeigth*len) {
            $("#list .area").css({"top":0});
            $("#list .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list .area").animate({"top":"-="+liHeigth});
        }
    }

    function up(){
        var top = $("#list .area").css("top").replace("px",'');
        if (top == 0) {
            $("#list .area").css({"top":-liHeigth*len});
            $("#list .area").animate({"top":"+="+liHeigth});
        }else{
            $("#list .area").animate({"top":"+="+liHeigth});
        }
    }

    var liHeigth2 = $("#list2 .area .c12").innerHeight();
    var n2 =8;
    var len2 = $("#list2 .area .c12").length;
    var ulHeigth2 = liHeigth*len2;
    $("#list2 .area").height(ulHeigth2);
    var boxHeigth2 = liHeigth*n2;
    $("#list2").height(boxHeigth2);
    $("#list2 .area .c12:lt("+ n2 +")").clone().insertAfter("#list2 .area .c12:last");
    var a2;
    autoPlay2();
    function autoPlay2(){
        a2 = setInterval(function(){
            down2();
        },2200)
    }
    $("#list2").hover(function(){
        clearInterval(a2);
    },function(){
        autoPlay2();
    });

    function down2(){
        var top = $("#list2 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len2) {
            $("#list2 .area").css({"top":0});
            $("#list2 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list2 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth3 = $("#list3 .area .c12").innerHeight();
    var n3 =8;
    var len3 = $("#list3 .area .c12").length;
    var ulHeigth3 = liHeigth*len3;
    $("#list3 .area").height(ulHeigth3);
    var boxHeigth3 = liHeigth*n3;
    $("#list3").height(boxHeigth3);
    $("#list3 .area .c12:lt("+ n3 +")").clone().insertAfter("#list3 .area .c12:last");
    var a3;
    autoPlay3();
    function autoPlay3(){
        a3 = setInterval(function(){
            down3();
        },2200)
    }
    $("#list3").hover(function(){
        clearInterval(a3);
    },function(){
        autoPlay3();
    });

    function down3(){
        var top = $("#list3 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len3) {
            $("#list3 .area").css({"top":0});
            $("#list3 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list3 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth4 = $("#list4 .area .c12").innerHeight();
    var n4 =8;
    var len4 = $("#list4 .area .c12").length;
    var ulHeigth4 = liHeigth*len4;
    $("#list4 .area").height(ulHeigth4);
    var boxHeigth4 = liHeigth*n4;
    $("#list4").height(boxHeigth4);
    $("#list4 .area .c12:lt("+ n4 +")").clone().insertAfter("#list4 .area .c12:last");
    var a4;
    autoPlay4();
    function autoPlay4(){
        a4 = setInterval(function(){
            down4();
        },2200)
    }
    $("#list4").hover(function(){
        clearInterval(a4);
    },function(){
        autoPlay4();
    });

    function down4(){
        var top = $("#list4 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len4) {
            $("#list4 .area").css({"top":0});
            $("#list4 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list4 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth5 = $("#list5 .area .c12").innerHeight();
    var n5 =8;
    var len5 = $("#list5 .area .c12").length;
    var ulHeigth5 = liHeigth*len5;
    $("#list5 .area").height(ulHeigth5);
    var boxHeigth5 = liHeigth*n5;
    $("#list5").height(boxHeigth5);
    $("#list5 .area .c12:lt("+ n5 +")").clone().insertAfter("#list5 .area .c12:last");
    var a5;
    autoPlay5();
    function autoPlay5(){
        a5 = setInterval(function(){
            down5();
        },2200)
    }
    $("#list5").hover(function(){
        clearInterval(a5);
    },function(){
        autoPlay5();
    });

    function down5(){
        var top = $("#list5 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len5) {
            $("#list5 .area").css({"top":0});
            $("#list5 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list5 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth6 = $("#list6 .area .c12").innerHeight();
    var n6 =8;
    var len6 = $("#list6 .area .c12").length;
    var ulHeigth6 = liHeigth*len6;
    $("#list6 .area").height(ulHeigth6);
    var boxHeigth6 = liHeigth*n6;
    $("#list6").height(boxHeigth6);
    $("#list6 .area .c12:lt("+ n6 +")").clone().insertAfter("#list6 .area .c12:last");
    var a6;
    autoPlay6();
    function autoPlay6(){
        a6 = setInterval(function(){
            down6();
        },2200)
    }
    $("#list6").hover(function(){
        clearInterval(a6);
    },function(){
        autoPlay6();
    });

    function down6(){
        var top = $("#list6 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len6) {
            $("#list6 .area").css({"top":0});
            $("#list6 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list6 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth7 = $("#list7 .area .c12").innerHeight();
    var n7 =8;
    var len7 = $("#list7 .area .c12").length;
    var ulHeigth7 = liHeigth*len7;
    $("#list7 .area").height(ulHeigth7);
    var boxHeigth7 = liHeigth*n7;
    $("#list7").height(boxHeigth7);
    $("#list7 .area .c12:lt("+ n7 +")").clone().insertAfter("#list7 .area .c12:last");
    var a7;
    autoPlay7();
    function autoPlay7(){
        a7 = setInterval(function(){
            down7();
        },2200)
    }
    $("#list7").hover(function(){
        clearInterval(a7);
    },function(){
        autoPlay7();
    });

    function down7(){
        var top = $("#list7 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len7) {
            $("#list7 .area").css({"top":0});
            $("#list7 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list7 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth8 = $("#list8 .area .c12").innerHeight();
    var n8 =8;
    var len8 = $("#list8 .area .c12").length;
    var ulHeigth8 = liHeigth*len8;
    $("#list8 .area").height(ulHeigth8);
    var boxHeigth8 = liHeigth*n8;
    $("#list8").height(boxHeigth8);
    $("#list8 .area .c12:lt("+ n8 +")").clone().insertAfter("#list8 .area .c12:last");
    var a8;
    autoPlay8();
    function autoPlay8(){
        a8 = setInterval(function(){
            down8();
        },2200)
    }
    $("#list8").hover(function(){
        clearInterval(a8);
    },function(){
        autoPlay8();
    });

    function down8(){
        var top = $("#list8 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len8) {
            $("#list8 .area").css({"top":0});
            $("#list8 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list8 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth9 = $("#list9 .area .c12").innerHeight();
    var n9 =8;
    var len9 = $("#list9 .area .c12").length;
    var ulHeigth9 = liHeigth*len9;
    $("#list9 .area").height(ulHeigth9);
    var boxHeigth9 = liHeigth*n9;
    $("#list9").height(boxHeigth9);
    $("#list9 .area .c12:lt("+ n9 +")").clone().insertAfter("#list9 .area .c12:last");
    var a9;
    autoPlay9();
    function autoPlay9(){
        a9 = setInterval(function(){
            down9();
        },2200)
    }
    $("#list9").hover(function(){
        clearInterval(a9);
    },function(){
        autoPlay9();
    });

    function down9(){
        var top = $("#list9 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len9) {
            $("#list9 .area").css({"top":0});
            $("#list9 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list9 .area").animate({"top":"-="+liHeigth});
        }
    }

    var liHeigth10 = $("#list10 .area .c12").innerHeight();
    var n10 =8;
    var len10 = $("#list10 .area .c12").length;
    var ulHeigth10 = liHeigth*len10;
    $("#list10 .area").height(ulHeigth10);
    var boxHeigth10 = liHeigth*n10;
    $("#list10").height(boxHeigth10);
    $("#list10 .area .c12:lt("+ n10 +")").clone().insertAfter("#list10 .area .c12:last");
    var a10;
    autoPlay10();
    function autoPlay10(){
        a10 = setInterval(function(){
            down10();
        },2200)
    }
    $("#list10").hover(function(){
        clearInterval(a10);
    },function(){
        autoPlay10();
    });

    function down10(){
        var top = $("#list10 .area").css("top").replace("px",'');
        if (top<=-liHeigth*len10) {
            $("#list10 .area").css({"top":0});
            $("#list10 .area").animate({"top":"-="+liHeigth});
        }else{
            $("#list10 .area").animate({"top":"-="+liHeigth});
        }
    }

    $(".eachs").hover(function(){
    	$(this).addClass("acted");
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    },function(){
    	$(this).removeClass("acted")
    });

	$(".head .top").hover(function(){
		$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
	});    

    $("#e2").hover(function(){
    	$("#d2").slideDown(300);
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d2").hover(function(){
    	$("#e2").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e2").removeClass("acted")
    });

    $("#e3").hover(function(){
    	$("#d3").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d3").hover(function(){
    	$("#e3").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e3").removeClass("acted")
    });

    $("#e4").hover(function(){
    	$("#d4").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d4").hover(function(){
    	$("#e4").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e4").removeClass("acted")
    });

    $("#e5").hover(function(){
    	$("#d5").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d5").hover(function(){
    	$("#e5").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e5").removeClass("acted")
    });

    $("#e6").hover(function(){
    	$("#d6").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d6").hover(function(){
    	$("#e6").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e6").removeClass("acted")
    });

    $("#e7").hover(function(){
    	$("#d7").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d7").hover(function(){
    	$("#e7").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e7").removeClass("acted")
    });

    $("#e8").hover(function(){
    	$("#d8").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d8").hover(function(){
    	$("#e8").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e8").removeClass("acted")
    });

    $("#e9").hover(function(){
    	$("#d9").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d10").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d9").hover(function(){
    	$("#e9").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e9").removeClass("acted")
    });

    $("#e10").hover(function(){
    	$("#d10").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d11").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d10").hover(function(){
    	$("#e10").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e10").removeClass("acted")
    });

    $("#e11").hover(function(){
    	$("#d11").slideDown(300);
    	$("#d2").css("display","none");
    	$("#d3").css("display","none");
    	$("#d4").css("display","none");
    	$("#d5").css("display","none");
    	$("#d6").css("display","none");
    	$("#d7").css("display","none");
    	$("#d8").css("display","none");
    	$("#d9").css("display","none");
    	$("#d10").css("display","none");
    	$("#login").css("display","none");
    	$("#car").css("display","none");
    	$("#notice").css("display","none");
    	$("#brand").css("display","none");
    	$(this).addClass("acted")
    },function(){
    	$(this).removeClass("acted")
    });
    $("#d11").hover(function(){
    	$("#e11").addClass("acted");
    },function(){
    	$(this).slideUp(300);
    	$("#e11").removeClass("acted")
    });

    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

        if (sTop >= 500) {  
            if (!$("#ups").is(":visible")) {  
                try {  
                    $("#ups").fadeIn();  
                } catch (e) {  
                    $("#ups").show();  
                }                        
            }  
        }else{  
            if ($("#ups").is(":visible")) { 
                try {  
                    $("#ups").fadeOut(); 
                } catch (e) {  
                    $("#ups").hide();
                }                         
            }  
        } 
       
    });
    $('#ups').click(function(){
        $('html,body').animate({scrollTop: '0px'},300);
    });

    $("#disappear").click(function(){
    	$("#menubar").animate({right: "-40px"},300);
    	$("#appear").animate({right:"0"},300)
    });

    $("#appear").click(function(){
    	$("#menubar").animate({right: "0"},300);
    	$("#disappear").css("display","block");
    	$("#appear").animate({right:"-40px"},300)
    });

    $(".li1").hover(function(){
    	$(this).find("img").attr("src","images/c11.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c1.jpg")
    });
    $(".li2").hover(function(){
    	$(this).find("img").attr("src","images/c22.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c2.jpg")
    });
    $(".li3").hover(function(){
    	$(this).find('img').attr("src","images/c33.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c3.jpg")
    });
    $(".li4").hover(function(){
    	$(this).find("img").attr("src","images/c44.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c4.jpg")
    });
    $(".li5").hover(function(){
    	$(this).find("img").attr("src","images/c55.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c5.jpg")
    });
    $(".li6").hover(function(){
    	$(this).find("img").attr("src","images/c66.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c6.jpg")
    });
    $(".li7").hover(function(){
    	$(this).find("img").attr("src","images/c77.jpg")
    },function(){
    	$(this).find('img').attr("src","images/c7.jpg")
    })







})