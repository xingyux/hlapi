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

 
    $(".drop").hover(function(){
        $(".dropdown").toggle()
    });

    $(".drop").on("mouseenter mouseleave",function(event){
        if(event.type == "mouseenter"){
            $(".drop").css("background-color","#5d6062")
        }else{
            $(".drop").css("background-color","#27282c")
        }
    });
    $(".ins").mouseover(function(){
        $(".icon-search").css("color","#00c1de");
        $(this).css({"width":"200px","border":"1px solid #00c1de"})                
    });
    $(".ins").mouseout(function(){
        $(".icon-search").css("color","#fff");
        $(this).css({"width":"150px","border":"1px solid transparent"})              
    });
    
    $(".icon-search").mouseover(function(){
        $(this).css("color","#00c1de");
        $(".ins").css({"width":"200px","border":"1px solid #00c1de"})               
    });
    $(".icon-search").mouseout(function(){
        $(this).css("color","#fff");
        $(".ins").css({"width":"150px","border":"1px solid transparent"})               
    });

    $(".navs li").on("mouseenter mouseleave",function(event){
        if(event.type == "mouseenter"){
            
            $(this).addClass("tips")
        }else{
            $(this).removeClass("tips")
            
        }
    });

    $("#g1").hover(function(){
        $("#nav1").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav1').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav1').hover(function(){
        $("#g1").addClass("tips");
    }, function(){
        $("#g1").removeClass("tips");
    });
    $(".top-head").hover(function(){
        $(".naves").css("display","none")
    });

    $("#g2").hover(function(){
        $("#nav2").slideDown(300);
        $("#nav1").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav2').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav2').hover(function(){
        $("#g2").addClass("tips");
    }, function(){
        $("#g2").removeClass("tips")
    });

    $("#g3").hover(function(){
        $("#nav3").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav1").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav3').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav3').hover(function(){
        $("#g3").addClass("tips");
    }, function(){
        $("#g3").removeClass("tips")
    });

    $("#g4").hover(function(){
        $("#nav4").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav1").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav4').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav4').hover(function(){
        $("#g4").addClass("tips");
    }, function(){
        $("#g4").removeClass("tips")
    });

    $("#g5").hover(function(){
        $("#nav5").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav1").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav5').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav5').hover(function(){
        $("#g5").addClass("tips");
    }, function(){
        $("#g5").removeClass("tips")
    });

    $("#g6").hover(function(){
        $("#nav6").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav1").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav8").slideUp(300)
    });
    $('#nav6').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav6').hover(function(){
        $("#g6").addClass("tips");
    }, function(){
        $("#g6").removeClass("tips")
    });

    $("#g7").hover(function(){
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav1").slideUp(300);
        $("#nav8").slideUp(300)
    });
    
    $('#nav7').hover(function(){
        $("#g7").addClass("tips");
    }, function(){
        $("#g7").removeClass("tips")
    });

    $("#g8").hover(function(){
        $("#nav8").slideDown(300);
        $("#nav2").slideUp(300);
        $("#nav3").slideUp(300);
        $("#nav4").slideUp(300);
        $("#nav5").slideUp(300);
        $("#nav6").slideUp(300);
        $("#nav7").slideUp(300);
        $("#nav1").slideUp(300)
    });
    $('#nav8').mouseleave(function(){
        $(this).slideUp(300);
    });
    $('#nav8').hover(function(){
        $("#g8").addClass("tips");
    }, function(){
        $("#g8").removeClass("tips")
    });

    layui.use('carousel', function(){
        var carousel = layui.carousel;
            carousel.render({
            elem: '#test4'
            ,width: '100%'
            ,arrow:'hover'
            ,height: '440px'
            ,interval: 5000
            ,anim:'fade'
        });
    });

    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  
        // if (sTop >= 500) {
        //     if ($("#up").css("display") == 'none') {  
        //         try {  
        //             $("#up").slideDown();  
        //         } catch (e) {  
        //             $("#up").show();  
        //         }                        
        //     }  
        // }  
        // else {  
        //     if ($("#up").css("display") == 'block') {  
        //         try {  
        //             $("#up").slideUp();
        //         } catch (e) {  
        //             $("#up").hide(); 
        //         }                         
        //     }  
        // } 

        if (sTop >= 500) {  
            if (!$("#up").is(":visible")) {  
                try {  
                    $("#up").slideDown();  
                } catch (e) {  
                    $("#up").show();  
                }                        
            }  
        }  
        else {  
            if ($("#up").is(":visible")) { 
                try {  
                    $("#up").slideUp(); 
                } catch (e) {  
                    $("#up").hide();
                }                         
            }  
        } 
       
        
    }); 

    $('#up').click(function(){
        $('html,body').animate({scrollTop: '0px'},300);
    });

    $(".secs").hover(function(){
        $(".code").css("display","block")
    },function(){
        $(".code").css("display","none")
    });

         

  
})