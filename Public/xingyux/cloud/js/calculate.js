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

    $(window).bind("scroll", function () {  
        var wh = $(window).scrollTop();  
        var sTop = $(window).scrollTop();  
        var sTop = parseInt(sTop);  

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

    $(window).bind("scroll", function () {   
        var stop = $(window).scrollTop();
        var s = $(document).height(); //3114
        var d = $(window).height();  //672
        var sd = (s - d) * 0.75;     //122
        if( stop >= sd  ){
            $(".total_fee1").css("position","absolute");
        }else{
            $(".total_fee1").css("position","fixed");
        }

        
    });

    $(window).bind("scroll", function () {   
        var stop = $(window).scrollTop();
        var s = $(document).height(); //3114
        var d = $(window).height();  //672
        var sd = (s - d) * 0.87;     //122
        if( stop >= sd  ){
            $(".total_fee2").css("position","absolute");
        }else{
            $(".total_fee2").css("position","fixed");
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

    $(".feeway").click(function(){
        $(".feeway").removeClass("fee_cover");
        $(this).addClass("fee_cover")
    });

    $(".place_box").click(function(){
        $(".place_box").removeClass("place_cover");
        $(this).addClass("place_cover");
        var text = $(".place_cover p").text();
        $(".cur_pla").text(text)
    });

    // layui.use('form', function(){});
    layui.use(['layer', 'form'], function(){
        var layer = layui.layer
        ,form = layui.form;
        //获取layui select里面的内容 area 对应 lay-filter
        form.on('select(area)', function(data){

            var callback = data.select.data('callback');
            if( callback ){
                window[callback]( data.select );
            }


        });
        form.on('select(disk)', function(data){
            var callback = data.select.data('callback');
            if( callback ){
                window[callback]( data.select );
            }
        });
    });



    $(".quesicon2").hover(function(){
        $(".ques2").css("display","inline-block")
    },function(){
        $(".ques2").css("display","none")
    });

    $(".quesicon1").hover(function(){
        $(".ques1").css("display","block")
    },function(){
        $(".ques1").css("display","none")
    });
    $(".ques1").hover(function(){
        $(this).css("display","block")
    },function(){
        $(this).css("display","none")
    });

    //自定义购买slider  固定宽带
    $( "#slider-range-max" ).slider({
        range: "max",
        min: 0,
        max: 200,
        value: 1,
        step:1,
        slide: function( event, ui ) {
            $( "#amount" ).val( ui.value );
            $(".cur_key_num").text(ui.value);

            var callback = $(this).data('callback');
            if( callback ){
                window[callback]( ui.value );
            }

            var values = $("#amount").val();
            if( values == 0){
                $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上宽带。");
                $(".flowdown i").css("color","#ccc");
                $(".flowup i").css("color","#a3a1a1")
            }
            if( values == 200){
                $(".flowup i").css("color","#ccc");
                $(".flowdown i").css("color","#a3a1a1");
                $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            }
            if( values < 200 && values > 0){
                $(".flowup i").css("color","#a3a1a1");
                $(".flowdown i").css("color","#a3a1a1");
                $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            }
        }
    });

    $( "#slider-range-max" ).slider({ animate: "100" });
    $( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );
    $("#amount").on("input",function () {
        this.value = this.value.replace(/\D/g,"");
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 0;
        if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-max").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdown i").css("color","#ccc");
            $(".flowup i").css("color","#a3a1a1");
            $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }
        if( amount != 0){
            $(".flowdown i").css("color","#a3a1a1");
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( amount == 200){
            $(".flowup i").css("color","#ccc");
            $(".flowdown i").css("color","#a3a1a1")
        }
        if( amount != 200){
            $(".flowup i").css("color","#a3a1a1");
        }
        $(".cur_key_num").text(amount)
    });
    $("#amount").on("blur",function(){
        if( this.value == "" ){
            $("#amount").val(0)
        }
        var callback = $(this).data('callback');
        if( callback ){
            window[callback]( $(this).val() );
        }
    });
    $("#amount").on('keydown',function(event){
        // var value = $("#amount").val();
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 0;
        if( event.keyCode == 38){
            if( amount >= 200 ){
                return
            }else{
                amount++;
            }
            if( amount == 200){
                $(".flowup i").css("color","#ccc");
                $(".flowdown i").css("color","#a3a1a1")
            }else{
                $(".flowup i").css("color","#a3a1a1");
                $(".flowdown i").css("color","#a3a1a1")
            }
            if (amount < Mindxdk) {
                $("#slider-range-max").slider("value", Mindxdk  );
            }else{
                $("#slider-range-max").slider("value", amount  );
            }
            $("#amount").val(amount);
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( event.keyCode == 40){
            if( amount <= 0 ){
                return
            }else{
                amount--
            }
            if( amount == 0){
                $(".flowdown i").css("color","#ccc");
                $(".flowup i").css("color","#a3a1a1");
                $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
            }else{
                $(".flowdown i").css("color","#a3a1a1");
                $(".flowup i").css("color","#a3a1a1");
                $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
            }
            if (amount < Mindxdk) {
                $("#slider-range-max").slider("value", Mindxdk - 1);
            }else{
                $("#slider-range-max").slider("value", amount - 1 );
            }
            $("#amount").val(amount);
        }
        $(".cur_key_num").text(amount)
    })

    $(".public .flows").click(function(){
        $(".public .flows").removeClass("flow_active");
        $(this).addClass("flow_active")
    });
    $(".flow1").click(function(){
        $(".context1").css("display","block");
        $(".context2").css("display","none");
        var value = $("#amount").val();
        $(".cur_key_num").text(value)
    });
    $(".flow2").click(function(){
        $(".context1").css("display","none");
        $(".context2").css("display","block");
        var value = $("#amount2").val();
        $(".cur_key_num").text(value)
    });

    $(".mirror .flows").click(function(){
        $('.mirror .flows').removeClass("flow_active");
        $(this).addClass("flow_active")
    });

    $(".flowup").click(function(){
        // var value = $("#amount").val();
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
        if( amount >= 200 ){
            return
        }else{
            amount++;
        }
        if( amount == 200){
            $(".flowup i").css("color","#ccc");
            $(".flowdown i").css("color","#a3a1a1")
        }else{
            $(".flowup i").css("color","#a3a1a1");
            $(".flowdown i").css("color","#a3a1a1")
        }
        if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk  );
        }else{
            $("#slider-range-max").slider("value", amount  );
        }
        $("#amount").val(amount);
        $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        $(".cur_key_num").text(amount)
    });
    $(".flowdown").click(function(){
        // var value = $("#amount").val();
        var amount = $.trim(~~$("#amount").val());
        var Mindxdk = 1;
        if( amount <= 0 ){
            return
        }else{
            amount--
        }
        if( amount == 0){
            $(".flowdown i").css("color","#ccc");
            $(".flowup i").css("color","#a3a1a1");
            $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }else{
            $(".flowdown i").css("color","#a3a1a1");
            $(".flowup i").css("color","#a3a1a1");
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if (amount < Mindxdk) {
            $("#slider-range-max").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-max").slider("value", amount - 1 );
        }
        $("#amount").val(amount);
        $(".cur_key_num").text(amount)
    });

    //自定义购买slider  使用流量
    $( "#slider-range-max2" ).slider({
        range: "max",
        min: 0,
        max: 100,
        value: 5,
        step:1,
        slide: function( event, ui ) {
            $( "#amount2" ).val( ui.value );
            $(".cur_key_num").text(ui.value);
            var values = $("#amount2").val();
            if( values == 0){
                $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。");
                $(".flowdown2 i").css("color","#ccc");
                $(".flowup2 i").css("color","#a3a1a1")
            }else if( values == 100){
                $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
                $(".flowdown2 i").css("color","#a3a1a1");
                $(".flowup2 i").css("color","#ccc")
            }else{
                $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
                $(".flowdown2 i").css("color","#a3a1a1");
                $(".flowup2 i").css("color","#a3a1a1")
            }
        }
    });

    $( "#slider-range-max2" ).slider({ animate: "100" });
    $( "#amount2" ).val( $( "#slider-range-max2" ).slider( "value" ) );
    $("#amount2").on("input",function () {
        var amount = $.trim(~~$("#amount2").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if (amount < Mindxdk) {
            $("#slider-range-max2").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-max2").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdown2 i").css("color","#ccc");
            $(".flowup2 i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }
        if( amount != 0){
            $(".flowdown2 i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( amount == 100){
            $(".flowup2 i").css("color","#ccc");
            $(".flowdown2 i").css("color","#a3a1a1")
        }
        if( amount != 100){
            $(".flowup2 i").css("color","#a3a1a1");
        }
        $(".cur_key_num").text(amount)
    });
    $("#amount2").on("blur",function(){
        if( this.value == "" ){
            $("#amount2").val(0)
        }
    });
    $("#amount2").on('keydown',function(event){
        var amount = $.trim(~~$("#amount2").val());
        var Mindxdk = 1;
        if( event.keyCode == 38){
            if( amount >= 100 ){
                return
            }else{
                amount++;
            }
            if( amount == 100){
                $(".flowup2 i").css("color","#ccc");
                $(".flowdown2 i").css("color","#a3a1a1")
            }else{
                $(".flowup2 i").css("color","#a3a1a1");
                $(".flowdown2 i").css("color","#a3a1a1")
            }
            if (amount < Mindxdk) {
                $("#slider-range-max2").slider("value", Mindxdk  );
            }else{
                $("#slider-range-max2").slider("value", amount  );
            }
            $("#amount2").val(amount);
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( event.keyCode == 40){
            if( amount <= 0 ){
                return
            }else{
                amount--
            }
            if( amount == 0){
                $(".flowdown2 i").css("color","#ccc");
                $(".flowup2 i").css("color","#a3a1a1");
                $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
            }else{
                $(".flowdown2 i").css("color","#a3a1a1");
                $(".flowup2 i").css("color","#a3a1a1");
                $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
            }
            if (amount < Mindxdk) {
                $("#slider-range-max2").slider("value", Mindxdk - 1);
            }else{
                $("#slider-range-max2").slider("value", amount - 1 );
            }
            $("#amount2").val(amount);
        }
        $(".cur_key_num").text(amount)
    });

    $(".flowup2").click(function(){
        // var value = $("#amount2").val();
        var amount = $.trim(~~$("#amount2").val());
        var Mindxdk = 1;
        if( amount >= 100 ){
            return
        }else{
            amount++;
        }
        if( amount == 100){
            $(".flowup2 i").css("color","#ccc");
            $(".flowdown2 i").css("color","#a3a1a1")
        }else{
            $(".flowup2 i").css("color","#a3a1a1");
            $(".flowdown2 i").css("color","#a3a1a1")
        }
        if (amount < Mindxdk) {
            $("#slider-range-max2").slider("value", Mindxdk  );
        }else{
            $("#slider-range-max2").slider("value", amount  );
        }
        $("#amount2").val(amount);
        $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        $(".cur_key_num").text(amount)
    });
    $(".flowdown2").click(function(){
        // var value = $("#amount2").val();
        var amount = $.trim(~~$("#amount2").val());
        var Mindxdk = 1;
        if( amount <= 0 ){
            return
        }else{
            amount--
        }
        if( amount == 0){
            $(".flowdown2 i").css("color","#ccc");
            $(".flowup2 i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }else{
            $(".flowdown2 i").css("color","#a3a1a1");
            $(".flowup2 i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if (amount < Mindxdk) {
            $("#slider-range-max2").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-max2").slider("value", amount - 1 );
        }
        $("#amount2").val(amount);
        $(".cur_key_num").text(amount)
    });

    //一键购买slider  固定宽带
    $( "#slider-range-maxhome" ).slider({
        range: "max",
        min: 0,
        max: 200,
        value: 1,
        step:1,
        slide: function( event, ui ) {
            $( "#amounthome" ).val( ui.value );
            $(".pub_net_num").text( ui.value );
            var values = $("#amounthome").val();
            if( values == 0){
                $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。");
                $(".flowdownhome i").css("color","#ccc")
            }else{
                $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
                $(".flowdownhome i").css("color","#a3a1a1")
            }
            if( values == 200 ){
                $(".flowuphome i").css("color","#ccc")
            }else{
                $(".flowuphome i").css("color","#a3a1a1")
            }
        }
    });

    $( "#slider-range-maxhome" ).slider({ animate: "100" });
    $( "#amounthome" ).val( $( "#slider-range-maxhome" ).slider( "value" ) );
    $("#amounthome").on("input",function () {
        var amount = $.trim(~~$("#amounthome").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if (amount < Mindxdk) {
            $("#slider-range-maxhome").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-maxhome").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdown i").css("color","#ccc");
            $(".flowup i").css("color","#a3a1a1");
            $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。");
            $(".flowdownhome i").css("color","#ccc")
        }
        if( amount != 0){
            $(".flowdown i").css("color","#a3a1a1");
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            $(".flowdownhome i").css("color","#a3a1a1")
        }
        if( amount == 200){
            $(".flowup i").css("color","#ccc");
            $(".flowdown i").css("color","#a3a1a1");
            $(".flowuphome i").css("color","#ccc")
        }
        if( amount != 200){
            $(".flowup i").css("color","#a3a1a1");
        }
        $(".pub_net_num").text(amount)
    });
    $("#amounthome").on("blur",function(){
        if( this.value == "" ){
            $("#amounthome").val(0);
            $(".p2").text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            $(".flowdownhome i").css("color","#a3a1a1")
        }
    });

    $("#amounthome").on("keydown",function(event){
        var amount = $.trim(~~$("#amounthome").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if( event.keyCode == 38 ){   //上箭头
            if( amount == 200 ){
                return
            }else{
                amount++;
            }
        }
        if( event.keyCode == 40 ){  //下箭头
            // alert(0);
            if( amount == 0 ){
                return
            }else{
                amount--;
            }
        }
        if (amount < Mindxdk) {
            $("#slider-range-maxhome").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-maxhome").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdown i").css("color","#ccc");
            $(".flowup i").css("color","#a3a1a1");
            $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。");
            $(".flowdownhome i").css("color","#ccc")
        }
        if( amount != 0){
            $(".flowdown i").css("color","#a3a1a1");
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            $(".flowdownhome i").css("color","#a3a1a1")
        }
        if( amount == 200){
            $(".flowup i").css("color","#ccc");
            $(".flowdown i").css("color","#a3a1a1");
            $(".flowuphome i").css("color","#ccc")
        }
        if( amount != 200){
            $(".flowup i").css("color","#a3a1a1");
            $(".flowuphome i").css("color","#a3a1a1")
        }
        $("#amounthome").val(amount);
        $(".pub_net_num").text(amount)
        
    });

    $("#amounths").on("keydown",function(event){
        var amount = $.trim(~~$("#amounths").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if( event.keyCode == 38 ){   //上箭头
            if( amount == 100 ){
                return
            }else{
                amount++;
            }
        }
        if( event.keyCode == 40 ){  //下箭头
            if( amount == 0 ){
                return
            }else{
                amount--;
            }
        }

        if (amount < Mindxdk) {
            $("#slider-range-maxhs").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-maxhs").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdownhs i").css("color","#ccc");
            $(".flowuphs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }
        if( amount != 0){
            $(".flowdownhs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( amount == 100){
            $(".flowuphs i").css("color","#ccc");
            $(".flowdownhs i").css("color","#a3a1a1")
        }
        if( amount != 100){
            $(".flowuphs i").css("color","#a3a1a1");
        }
        $(".pub_net_num").text(amount);
        $("#amounths").val(amount)
        
    });

    $(".pub_net .flows").click(function(){
        $(".pub_net .flows").removeClass("flow_active");
        $(this).addClass("flow_active")
    });
    $(".flowh1").click(function(){
        $(".contexth1").css("display","block");
        $(".contexth2").css("display","none")
    });
    $(".flowh2").click(function(){
        $(".contexth1").css("display","none");
        $(".contexth2").css("display","block")
    });

    $(".flowuphome").click(function(){
        var value = $("#amounthome").val();
        var amount = $.trim(~~$("#amounthome").val());
        var Mindxdk = 1;
        if( value >= 200 ){
            return
        }else{
            value++;
        }
        if( value == 200){
            $(".flowuphome i").css("color","#ccc");
            $(".flowdownhome i").css("color","#a3a1a1")
        }else{
            $(".flowuphome i").css("color","#a3a1a1");
            $(".flowdownhome i").css("color","#a3a1a1")
        }
        if (amount < Mindxdk) {
            $("#slider-range-maxhome").slider("value", Mindxdk  );
        }else{
            $("#slider-range-maxhome").slider("value", amount  );
        }
        $("#amounthome").val(value);
        $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        $(".pub_net_num").text(value)
    });
    $(".flowdownhome").click(function(){
        var value = $("#amounthome").val();
        var amount = $.trim(~~$("#amounthome").val());
        var Mindxdk = 1;
        if( value <= 0 ){
            return
        }else{
            value--
        }
        if( value == 0){
            $(".flowdownhome i").css("color","#ccc");
            $(".flowuphome i").css("color","#a3a1a1");
            $(".p2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }else{
            $(".flowdownhome i").css("color","#a3a1a1");
            $(".flowuphome i").css("color","#a3a1a1");
            $(".p2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if (amount < Mindxdk) {
            $("#slider-range-maxhome").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-maxhome").slider("value", amount - 1 );
        }
        $("#amounthome").val(value);
        $(".pub_net_num").text(value)
    });

    //一键购买  slider 使用流量
    $( "#slider-range-maxhs" ).slider({
        range: "max",
        min: 0,
        max: 100,
        value: 5,
        step:1,
        slide: function( event, ui ) {
            $( "#amounths" ).val( ui.value );
            $(".pub_net_num").text( ui.value );
            var values = $("#amounths").val();
            
            if( values == 0){
                $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。");
                $(".flowdownhs i").css("color","#ccc")
            }else{
                $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
                $(".flowdownhs i").css("color","#a3a1a1");
            }
            if( values == 100 ){
                $(".flowuphs i").css("color","#ccc")
            }else{
               $(".flowuphs i").css("color","#a3a1a1") 
            }

        }
    });

    $( "#slider-range-maxhs" ).slider({ animate: "100" });
    $( "#amounths" ).val( $( "#slider-range-maxhs" ).slider( "value" ) );
    $("#amounths").on("input",function () {
        var amount = $.trim(~~$("#amounths").val());
        var Mindxdk = 1;
        this.value = this.value.replace(/\D/g,"");
        if (amount < Mindxdk) {
            $("#slider-range-maxhs").slider("value", Mindxdk - 1 );
        }else{
            $("#slider-range-maxhs").slider("value", amount - 1 );
        }
        if( amount == 0){
            $(".flowdownhs i").css("color","#ccc");
            $(".flowuphs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }
        if( amount != 0){
            $(".flowdownhs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if( amount == 100){
            $(".flowuphs i").css("color","#ccc");
            $(".flowdownhs i").css("color","#a3a1a1")
        }
        if( amount != 100){
            $(".flowuphs i").css("color","#a3a1a1");
        }
        $(".pub_net_num").text(amount);
    });
    $("#amounths").on("blur",function(){
        if( this.value == "" ){
            $("#amounths").val(0);
            $(".p2_2").text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。");
            $(".flowdownhs i").css("color","#a3a1a1")
        }
    });

    $(".flowuphs").click(function(){
        var value = $("#amounths").val();
        var amount = $.trim(~~$("#amounths").val());
        var Mindxdk = 1;
        if( value >= 100 ){
            return
        }else{
            value++;
        }
        if( value == 100){
            $(".flowuphs i").css("color","#ccc");
            $(".flowdownhs i").css("color","#a3a1a1")
        }else{
            $(".flowuphs i").css("color","#a3a1a1");
            $(".flowdownhs i").css("color","#a3a1a1")
        }
        if (amount < Mindxdk) {
            $("#slider-range-maxhs").slider("value", Mindxdk  );
        }else{
            $("#slider-range-maxhs").slider("value", amount  );
        }
        $("#amounths").val(value);
        $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        $(".pub_net_num").text(value)
    });
    $(".flowdownhs").click(function(){
        var value = $("#amounths").val();
        var amount = $.trim(~~$("#amounths").val());
        var Mindxdk = 1;
        if( value <= 0 ){
            return
        }else{
            value--
        }
        if( value == 0){
            $(".flowdownhs i").css("color","#ccc");
            $(".flowuphs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统不会分配公网 IP，若需要分配公网 IP，请选择 1M 及以上带宽。")
        }else{
            $(".flowdownhs i").css("color","#a3a1a1");
            $(".flowuphs i").css("color","#a3a1a1");
            $(".p2_2").empty().text("系统会分配公网 IP 。若无需分配 IP 或 单独购买弹性公网 IP 访问公网，请选择带宽值 0M。")
        }
        if (amount < Mindxdk) {
            $("#slider-range-maxhs").slider("value", Mindxdk - 1);
        }else{
            $("#slider-range-maxhs").slider("value", amount - 1 );
        }
        $("#amounths").val(value);
        $(".pub_net_num").text(value)
    });

    $(".layui-form-checkbox").click(function(){
        if( $(this).hasClass("layui-form-checked") ){
            $("security_ps").css("display","none")
        }else{
            $("security_ps").css("display","block")
        }
    });

    $(".pick_area1").click(function(){
        if( $(".security_rect1").hasClass("right") ){
            $(".security_rect1").removeClass("right");
            $(".security_result1").css("display","block")
        }else{
            $(".security_rect1").addClass("right");
            $(".security_result1").css("display","none")
        }
    });

    $(".pick_area2").click(function(){
        if( $(".security_rect2").hasClass("right") ){
            $(".security_rect2").removeClass("right");
            $(".security_result2").css("display","block")
        }else{
            $(".security_rect2").addClass("right");
            $(".security_result2").css("display","none")
        }
    });


    $(".add_input").blur(function(){
        var obj=$(this).prev('form').find('select');
        var callback = obj.data('callback');
        if( callback ){
            window[callback]( obj );
        }
    });

    $(".add_cancel").click(function(){
        var index = $(this).attr("index");
        $($(".storage_bar")[index]).remove();
        for(var i = 0 ; i < $(".storage_bar").length; i++){
            $($(".storage_bar")[i]).attr("index",i);
            $($(".add_cancel")[i]).attr("index",i);
        }
    });

    $(".add_check").on("click",function(){
        var index = $(this).children(".rect").attr("index");
        if($($(".rect")[index]).hasClass("rect_check")){
             $($(".rect")[index]).removeClass("rect_check");
        }else{
             $($(".rect")[index]).addClass("rect_check");
        }
    });

    $(".add_date").click(function(){
        var num = $(".date_surplus").text() * 1;
        var bars = $(".storage_bar");
        if( num == 0){
            return
        }else{
            num--;



            }
            $(".date_surplus").text(num)

    });
    $(".add_cancel").click(function(){
        console.log(123) 
    });

    




    $(".purchase_spebox1 span").click(function(){
        $(".purchase_spebox1 span").removeClass("purchase_cover");
        $(this).addClass("purchase_cover")
    });


/*
    $('.pur_month1').click(function(){
        var index = $(this).attr("index");
        $(".pur_month1").each(function(){
            $(this).text($(this).attr("index"))
        });
        $(this).text( index  + "个月");

        $(".month1").text( index );
        $(".date_num").empty().text("个月")
        
    });
    $('.pur_month2').click(function(){
        var index = $(this).attr("index");
        $(".pur_month2").each(function(){
            $(this).text($(this).attr("index"))
        });
        $(this).text( index  + "个月")
        
    });

    $(".other_time1").click(function(){
        $(".pur_month1").each(function(){
            $(this).text($(this).attr("index"));
        });
        
    });
    $(".other_time2").click(function(){
        $(".pur_month2").each(function(){
            $(this).text($(this).attr("index"))
        })
    });

    $(".discounts").click(function(){
        var we = $(this).attr("index");
        $(".month1").text(we);
        $(".date_num").empty().text("年")
    });
*/
    $(".week_pick").click(function(){
        $(".month1").text("1");
        $(".date_num").text("周")
    });

    $(".pur_auto1").click(function(){
        if($(".pur_rect1").hasClass("pur_cover")){
            $(".pur_rect1").removeClass("pur_cover")
        }else{
            $(".pur_rect1").addClass("pur_cover")
        }
    });
    $(".pur_auto2").click(function(){
        if($(".pur_rect2").hasClass("pur_cover")){
            $(".pur_rect2").removeClass("pur_cover")
        }else{
            $(".pur_rect2").addClass("pur_cover")
        }
    });

    $(".pur_numbox1 input").focus(function(){
        $(this).css("borderColor","#00c1de")
    });
    $(".pur_numbox1 input").on('keydown',function(event){
        if( event.keyCode == 13){
            $(this).blur()
        }
    });
    $(".pur_numbox1 input").blur(function(){
        $(this).css("borderColor","#ccc")
    });
    $(".pur_numbox1 input").on("input",function(){
        this.value = this.value.replace(/\D/g,"");
        var value = $(".pur_numbox1 input").val();
        if( value == 1){
            $(".pur_down1").css({"color":"#ddd","cursor":"default"});
            $(".pur_top1").css({"color":"#999","cursor":"pointer"});
        }
        if( value == 300){
            $(".pur_down1").css({"color":"#999","cursor":"pointer"});
            $(".pur_top1").css({"color":"#ddd","cursor":"default"});
        }
        if( value != 1 && value != 300){
            $(".pur_down1").css({"color":"#999","cursor":"pointer"});
            $(".pur_top1").css({"color":"#999","cursor":"pointer"});
        }
        
        $(".nums1").text(value);
    });
    $(".pur_numbox1 input").blur(function(){
        var value = $(".pur_numbox1 input").val();
        if( value == ""){
            $(this).val("1");
            $(".nums1").text("1");
            $(".pur_down1").css({"color":"#ccc","cursor":"default"})
        }
    });
    $(".pur_numbox1 input").on('keydown',function(event){
        var value = $(".pur_numbox1 input").val();
        if( event.keyCode == 38 ){
            value++;
            $(".pur_top1").css("color","#999");
            $(".pur_down1").css("color","#999");
        }
        if( event.keyCode == 40 ){
            if( value <= 1){
                return
            }else{
                value--;
                $(".pur_top1").css("color","#999");
                $(".pur_down1").css("color","#999");
            }
            if( value == 1){
                $(".pur_top1").css("color","#999");
                $(".pur_down1").css("color","#ccc");
            }
        }
        $(".pur_numbox1 input").val(value);
        $(".nums1").text(value)
    });

    $(".pur_top1").click(function(){
        var value = $(".pur_numbox1 input").val();
        if( value >=300){
            return
        }else{
            value++;
        }
        if( value == 300){
            $(".pur_top1").css({"color":"#ddd","cursor":"default"});
        }
        $(".pur_numbox1 input").val(value);
        $(".pur_down1").css({"color":"#999","cursor":"pointer"});
        $(".nums1").text(value);
    });

    $(".pur_down1").click(function(){
        var value = $(".pur_numbox1 input").val();
        if( value <= 1){
            return;
        }else{
            value--;
            $(".pur_down1").css("color","#999");
        }
        if( value == 1){
            $(".pur_down1").css({"color":"#ddd","cursor":"default"});
        }
        $(".pur_numbox1 input").val(value);
        $(".pur_top1").css({"color":"#999","cursor":"pointer"});
        $(".nums1").text(value);
        
    });
    //2
    $(".pur_numbox2 input").focus(function(){
        $(this).css("borderColor","#00c1de")
    });
    $(".pur_numbox2 input").blur(function(){
        $(this).css("borderColor","#ccc")
    });
    $(".pur_numbox2 input").on("input",function(){
        this.value = this.value.replace(/\D/g,"");
        var value = $(".pur_numbox2 input").val();
        if( value == 1){
            $(".pur_down2").css({"color":"#ddd","cursor":"default"});
            $(".pur_top2").css({"color":"#999","cursor":"pointer"});
        }
        if( value == 300){
            $(".pur_down2").css({"color":"#999","cursor":"pointer"});
            $(".pur_top2").css({"color":"#ddd","cursor":"default"});
        }
        if( value != 1 && value != 300){
            $(".pur_down2").css({"color":"#999","cursor":"pointer"});
            $(".pur_top2").css({"color":"#999","cursor":"pointer"});
        }
        $(".nums2").text(value)
    });
    $(".pur_numbox2 input").blur(function(){
        var value = $(".pur_numbox2 input").val();
        if( value == ""){
            value = 1
        }
        if( value < 1 ){
            value = 1
        }
        $(".pur_numbox2 input").val(value);
        $(".nums2").text(value)
    });
    $(".pur_numbox2 input").on('keydown',function(event){
        var value = $(".pur_numbox2 input").val();
        if( event.keyCode == 38){
            value++;
            $(".pur_top2").css("color","#999");
            $(".pur_down2").css("color","#999")
        }
        if( event.keyCode == 40){
            if( value <= 1 ){
                return;
            }else{
                value--
            }
            if( value == 1){
                $(".pur_top2").css("color","#999");
                $(".pur_down2").css("color","#ccc");
            }
        }
        if( event.keyCode == 13){
            $(".pur_numbox2 input").blur()
        }
        $(".pur_numbox2 input").val(value);
        $(".nums2").text(value)
    });

    $(".pur_top2").click(function(){
        var value = $(".pur_numbox2 input").val();
        if( value >=300){
            return
        }else{
            value++;
        }
        if( value == 300){
            $(".pur_top2").css({"color":"#ddd","cursor":"default"});
        }
        $(".pur_numbox2 input").val(value);
        $(".pur_down2").css({"color":"#999","cursor":"pointer"});
        $(".nums2").text(value)
    });

    $(".pur_down2").click(function(){
        var value = $(".pur_numbox2 input").val();
        if( value <= 1){
            return;
        }else{
            value--;
            $(".pur_down2").css("color","#999");
        }
        if( value == 1){
            $(".pur_down2").css({"color":"#ddd","cursor":"default"});
        }
        $(".pur_numbox2 input").val(value);
        $(".pur_top2").css({"color":"#999","cursor":"pointer"});
        $(".nums2").text(value)
        
    });

    $(".set_top a").click(function(){
        $(".set_top a").removeClass("set_title");
        $(this).addClass("set_title")
    });

    $(".set1").click(function(){
        $(".sets1").css("display","block");
        $(".sets2").css("display","none");
        $(".sets3").css("display","none");
    });
    $(".set2").click(function(){
        $(".sets1").css("display","none");
        $(".sets2").css("display","block");
        $(".sets3").css("display","none");
    });
    $(".set3").click(function(){
        $(".sets1").css("display","none");
        $(".sets2").css("display","none");
        $(".sets3").css("display","block");
    });

    $(".set_input").on("input",function(){
        $(this).css("borderColor","#090");
    });

    $(".log_code").blur(function(){
        var val  = $(".log_code").val();
        var length = val.length;
        var reg1 = /\d/;       //匹配一个数字字符。等价于 [0-9]。
        var reg2 = /[a-z]/;    //小写字母
        var reg3 = /[A-Z]/;    //大写字母 
        var reg4 = /[a-zA-Z]/; //大小写字母
        var reg5 = /[^\w\s]+/; //匹配非空 非字母 非数字
        if( reg1.test(val) && reg2.test(val) && reg5.test(val) && length >= 8 ){
            $(".log_code5").css("display","none")
        }else{
            $(".log_code5").css("display","block");
            $(".log_code").css("borderColor","red")
        }
    });

    $(".log_copycode").blur(function(){
        var val1 = $(".log_code").val();
        var val2 = $(".log_copycode").val();
        if( val1 == val2){
            $(".log_copycode5").css("display","none")
        }else{
            $(".log_copycode5").css("display","block");
            $(".log_copycode").css("borderColor","red")
        }
    });

    $(".homeplacea").click(function(){
        $(".homeplacea").removeClass("homeplace_cover");
        $(this).addClass("homeplace_cover");
        var text = $(this).find(".region").text();
        $(".place_distribution").text( text + "（随机分配）")
    });

    $(".exam_box").click(function(){
        $(".exam_box").removeClass("exam_box_cover");
        $(this).addClass("exam_box_cover");
        var context = $(".exam_box_cover").find(".title").text();
        $(".exam_size").text(context)
    });

    $(".body_box1 a").click(function(){
        $(".body_box1 a").removeClass("body_box_cover");
        $(this).addClass("body_box_cover")
    });
    $(".body_box2 a").click(function(){
        $(".body_box2 a").removeClass("body_box_cover");
        $(this).addClass("body_box_cover")
    });
    



    $(".exam_ques").hover(function(){
        $(".ex_qus").css("display","block")
    },function(){
        $(".ex_qus").css("display","none")
    });

    $(".net_bar em").hover(function(){
        $(".net_qus").css("display","block")
    },function(){
        $(".net_qus").css("display","none")
    });

    $(".fee_qus").hover(function(){
        $(".fee_qu").css("display","block")
    },function(){
        $(".fee_qu").css("display","none")
    });

    $(".flowh1").click(function(){
        $(".public_flowhome").css("display","none");
        var value = $("#amounthome").val();
        $(".pub_net_num").text(value)
    });
    $(".flowh2").click(function(){
        $(".public_flowhome").css("display","block");
        var value = $("#amounths").val();
        $(".pub_net_num").text(value)
    });

    $(".private_net").hover(function(){
        $(".pri_tip").css("display","block")
    },function(){
        $(".pri_tip").css("display","none")
    });

    $(".hui_title").click(function(){
        $(".useful_area").css("display","block")
    });
    $(".place_common").click(function(){
        $(".useful_area").css("display","none")
    });

    $(".storage_input").hover(function(){
        $(".sys_contains1").css("display","block")
    },function(){
        $(".sys_contains1").css("display","none")
    });
    $(".storage_input").on('input',function(){
        this.value = this.value.replace(/\D/g,"");
    });
    $(".storage_input").on('blur',function(){
        var value = $(this).val();
        if( value < 40 ){
            value = 40;
            $(".storage_tpye").text(1240)
        }
        if( value >= 334){
            $(".storage_tpye").text(3000)
        }
        if( value < 334){
            var num = ( value - 40 ) * 6;
            var total = 1240 + num;
            $(".storage_tpye").text(total)
        }
        if( value > 500){
            value = 500;
        }
        $(".storage_input").val(value);
        $(".cur_sys_num").text(value)
    });
    $(".storage_input").on('keydown',function(event){
        var value = $(this).val();
        if( event.keyCode == 38 ){
            if( value < 500){
                value++;
            }else{
                return
            }
        }
        if( event.keyCode == 40 ){
            if( value == 40 ){
                return
            }else{
                value--
            }
        }
        if( event.keyCode == 13){
            $(this).blur()
        }
        $(".storage_input").val(value);
        $(".cur_sys_num").text(value)
    });

    $(".add_input").on('input',function(){
        this.value = this.value.replace(/\D/g,"");
    });
    $(".add_input").blur(function(){
        var index = $(this).attr("index");
        var value = $($(".add_input")[index]).val();
        var num = ( value - 20 ) * 30;
        var total = num + 1800;
        if( value == "20-32768"){
            value = 20;
            $($(".iops_num")[index]).empty().text(1800)
        }
        if( value < 20){
            value = 20;
            $($(".iops_num")[index]).empty().text(1800)
        }
        if( value > 32768 ){
            value = 32768
        }
        if( value > 20 && value < 627){
            $($(".iops_num")[index]).empty().text(total)
        }
        if( value > 627){
            $($(".iops_num")[index]).empty().text(20000)
        }
        $($(".add_input")[index]).val(value);
        $($(".iops_num")[index]).css("display","block");

    });
    $(".add_input").on('keydown',function(event){
        var index = $(this).attr("index");
        var value = $($(".add_input")[index]).val();
        if( event.keyCode == 38){
            if( value >= 32768){
                return
            }else{
                value++
            }
        }
        if( event.keyCode == 40){
            if( value <= 20  ){
                return
            }else{
                value--
            }
        }
        $($(".add_input")[index]).val(value)
    });
    $(".add_input").hover(function(){
        var index = $(this).attr("index");
        $($(".sys_contains2")[index]).css("display","block")
    },function(){
        var index = $(this).attr("index");
        $($(".sys_contains2")[index]).css("display","none")
    });

    $(".feeway").click(function(){
        var text = $(".feeway.fee_cover").find(".key_titles").text();
        $(".cur_year").text(text)
    });
/*
    $(".pickyear").click(function(){
        var index = $(this).attr("index");
        $(".month2").text(index);
        $(".key_month").text("年")
    });

    $(".pur_month2").click(function(){
        var index = $(this).attr("index");
        $(".month2").text(index);
        $(".key_month").text("个月")
    });

    $(".pickweek").click(function(){
        $(".month2").text(1);
        $(".key_month").text("周")
    });
*/
    $(".mirror_tips").hover(function(){
        $(".mirror_tip").css("display","block")
    },function(){
        $(".mirror_tip").css("display","none")
    });
    $(".mirror_tips").click(function(){
        $(".mirror_pick_market").css("display","block");
        $(".mirror_pickes").css("display","none")
    });
    $(".mirror_mir").click(function(){
        $(".mirror_pick_market").css("display","none");
        $(".mirror_pickes").css("display","block")
    });

    $(".mir_p").click(function(){
        $(".mir_p img").removeClass("mir_cover");
        $(this).find("img").addClass("mir_cover")
    });

    $(".jing").click(function(){
        var status = $(this).attr("data-status");
        if( status == 0){
            $(".jing_img1").css("display","block");
            $(".jing_img2").css("display","none");
            $(this).attr("data-status","1");
            $(".mir_sty").css("display","none")
        }else{
            $(".jing_img1").css("display","none");
            $(".jing_img2").css("display","block");
            $(this).attr("data-status","0"); 
            $(".mir_sty").css("display","block")
        }
    });

    $(".mir_superb").click(function(){
        $(".modal_superb").css("display","block");
        $(".modal_sty").css("display","none");
    });
    $(".mir_sty p").click(function(){
        $(".modal_superb").css("display","none");
        $(".modal_sty").css("display","block");
    });

    $(".modal_seclect1 p").click(function(){
        var text = $(this).text();
        $(".modal_inside1").text(text)
    });
    $(".modal_seclect2 p").click(function(){
        var text = $(this).text();
        $(".modal_inside2").text(text)
    });
    $(".modal_seclect3 p").click(function(){
        var text = $(this).text();
        $(".modal_inside3").text(text)
    });

    $(".modal_sys1").click(function(){
        var statue = $(this).attr("data-status");
        if( statue == 0){
            $(this).find("img").attr("src","images/d1.png");
            $(".modal_seclect1").slideUp(200);
            $(this).attr("data-status","1");
        }else{
            $(this).find("img").attr("src","images/d2.png");
            $(".modal_seclect1").slideDown(200);
            $(this).attr("data-status","0");
        }
    });
    $(".modal_sys2").click(function(){
        var statue = $(this).attr("data-status");
        if( statue == 0){
            $(this).find("img").attr("src","images/d1.png");
            $(".modal_seclect2").slideUp(200);
            $(this).attr("data-status","1");
        }else{
            $(this).find("img").attr("src","images/d2.png");
            $(".modal_seclect2").slideDown(200);
            $(this).attr("data-status","0");
        }
    });
    $(".modal_sys3").click(function(){
        var statue = $(this).attr("data-status");
        if( statue == 0){
            $(this).find("img").attr("src","images/d1.png");
            $(".modal_seclect3").slideUp(200);
            $(this).attr("data-status","1");
        }else{
            $(this).find("img").attr("src","images/d2.png");
            $(".modal_seclect3").slideDown(200);
            $(this).attr("data-status","0");
        }
    });

    $(".right_tips1").hover(function(){
        var val = $(".right_two .select").val();
        $(".right_tip1").css("display","block");
        $(".right_tip1 i").text(val)
    },function(){
        $(".right_tip1").css("display","none");
    });
    $(".right_tips2").hover(function(){
        $(".right_tip2").css("display","block");
    },function(){
        $(".right_tip2").css("display","none");
    });
    $(".select2").click(function(){
        var val = $(this).val();
        if( val != "v1.4" && val != "v1.3"){
            $(".right_tips2").css("display","none")
        }else{
            $(".right_tips2").css("display","inline-block")
        }
    });
    $(".right_tips3").hover(function(){
        $(".right_tip3").css("display","block");
    },function(){
        $(".right_tip3").css("display","none");
    });
    $(".select3").click(function(){
        var val = $(this).val();
        if( val != "v1.2" ){
            $(".right_tips3").css("display","none")
        }else{
            $(".right_tips3").css("display","inline-block")
        }
    });

    $(".span_num").click(function(){
        var val = $(this).text();
        $(".span_num").removeClass("span_cover");
        $(this).addClass("span_cover");
        $(".page_number em").text(val)
    });









         

  
})


